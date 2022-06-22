import json
import feedparser
import json
import sys
import datetime
from multiprocessing import Process, Queue
from spacytextblob.spacytextblob import SpacyTextBlob
from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer

import spacy
from lxml.html.clean import Cleaner
from newspaper import Article

cleaner = Cleaner(javascript=False, style=False, links=True, add_nofollow=True, page_structure=True,
                  safe_attrs_only=True, safe_attrs=['src', 'alt'], remove_tags=['script', 'iframe' , 'style'],
                  allow_tags=['img', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'b', 'i', 'strong', 'em', 'span', 'ul',
                              'li', 'ol', 'br', 'hr', 'pre', 'code', 'blockquote'])


url = sys.argv[1:][0]


def extractArticle(url):
    article = Article(url, keep_article_html=True)
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

    published_date = article.publish_date

    now = datetime.datetime.now()

    if published_date is None:
        publish_date = now

    value = {
        "title": article.title,
        "date": article.publish_date,
        "content": content,
        "excerpt": article.summary,
        "images": article.top_image,
        "keywords": article.keywords,
        "authors": article.authors,
        "entities": entities,
        "timetoread": round(timetoread),
        "polarity": doc._.blob.polarity,
        "subjectivity": doc._.blob.subjectivity,
        "source": url,
        "vader": (sid_obj.polarity_scores(article.text))
    }
    print(
        json.dumps(value, indent=4, sort_keys=True, default=str)
    )
    return


def extractFeedLinks(url):
    d = feedparser.parse(url)
    procs = []
    for item in d['items']:
        proc = Process(target=extractArticle, args=(item.link,))
        procs.append(proc)
        proc.start()
        proc.join()


def extractFeeds(feed):
    return extractFeedLinks(feed)


print(extractFeeds(url))
