
import newspaper
import warnings
import sys
import json
import spacy

warnings.filterwarnings("ignore")
from multiprocessing import Process
from newspaper import Article
from spacytextblob.spacytextblob import SpacyTextBlob
from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer
from lxml.html.clean import Cleaner

articleUrl = sys.argv[1:][0]

cleaner = Cleaner(javascript=False, style=False, links=True, add_nofollow=True, page_structure=True,
                  safe_attrs_only=True, safe_attrs=['src', 'alt'], remove_tags=['script', 'iframe', 'style'],
                  allow_tags=['img', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'b', 'i', 'strong', 'em', 'span', 'ul',
                              'li', 'ol', 'br', 'hr', 'pre', 'code', 'blockquote'])

article = Article(articleUrl, keep_article_html=True)
article.download()
article.parse()
article.nlp()
nlp = spacy.load("en_core_web_md")
nlp.add_pipe('spacytextblob')
doc = nlp(article.text)
words = len([token.text for token in doc if token.is_stop != True and token.is_punct != True])
timetoread = words / 200
sid_obj = SentimentIntensityAnalyzer()

entities = {"text": [], "type": []}
for ent in doc.ents:
    entities["text"].append(ent.text)
    entities["type"].append(ent.label_)
content = cleaner.clean_html(article.article_html)

value = {
    "title": article.title,
    "date": article.publish_date,
    "content": content,
    "original_content": article.article_html,
    "excerpt": article.summary,
    "cover": article.top_image,
    "images": article.images,
    "keywords": article.keywords,
    "authors": article.authors,
    "entities": entities,
    "timetoread": round(timetoread),
    "polarity": doc._.blob.polarity,
    "subjectivity": doc._.blob.subjectivity,
    "source": articleUrl,
    "vader": (sid_obj.polarity_scores(article.text))
}
print(
    json.dumps(value, indent=4, sort_keys=True, default=str)
)
