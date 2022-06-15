from newspaper import Article
import json
import sys
import spacy

from lxml.html.clean import Cleaner
cleaner = Cleaner(javascript=False, style=False, links=True, add_nofollow=True, page_structure=False, safe_attrs_only=True, safe_attrs=['src', 'alt'], remove_tags=['script', 'a', 'style'], allow_tags=['img', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'b', 'i', 'strong', 'em', 'span', 'ul', 'li', 'ol', 'br', 'hr', 'pre', 'code', 'blockquote'])
url = sys.argv[1:][0]

def extractor(url):
    article = Article(url, keep_article_html=True)
    article.download()
    article.parse()
    article.nlp()
    nlp = spacy.load("en_core_web_md")
    doc = nlp(article.text)
    value = {
        "title": article.title,
        "date": article.publish_date,
        "content": cleaner.clean_html(article.article_html),
        "excerpt": article.summary,
        "images": article.top_image,
        "keywords": article.keywords,
        "authors": article.authors,
        "entities": doc.ents,
        "source": url
    }

    return json.dumps(value, indent=4, sort_keys=True, default=str)

print(extractor(url))
