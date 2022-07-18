import json
import feedparser
import json
import sys
import datetime
from multiprocessing import Process, Queue
from spacytextblob.spacytextblob import SpacyTextBlob
from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer
from spacy.lang.en.stop_words import STOP_WORDS
from string import punctuation
from heapq import nlargest

import spacy
from lxml.html.clean import Cleaner
from newspaper import Article

cleaner = Cleaner(javascript=False, style=False, links=True, add_nofollow=True, page_structure=True,
                  safe_attrs_only=True, safe_attrs=['src', 'alt'], remove_tags=['script', 'iframe', 'style'],
                  allow_tags=['img', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'b', 'i', 'strong', 'em', 'span', 'ul',
                              'li', 'ol', 'br', 'hr', 'pre', 'code', 'blockquote'])

url = sys.argv[1:][0]


class Extractor:
    def __init__(self, url, feedparser):
        self.url = url
        self.feedparser = feedparser

    def summarize(text, per):
        nlp = spacy.load('en_core_web_md')
        doc = nlp(text)
        tokens = [token.text for token in doc]
        word_frequencies = {}
        for word in doc:
            if word.text.lower() not in list(STOP_WORDS):
                if word.text.lower() not in punctuation:
                    if word.text not in word_frequencies.keys():
                        word_frequencies[word.text] = 1
                    else:
                        word_frequencies[word.text] += 1
        max_frequency = max(word_frequencies.values())
        for word in word_frequencies.keys():
            word_frequencies[word] = word_frequencies[word] / max_frequency
        sentence_tokens = [sent for sent in doc.sents]
        sentence_scores = {}
        for sent in sentence_tokens:
            for word in sent:
                if word.text.lower() in word_frequencies.keys():
                    if sent not in sentence_scores.keys():
                        sentence_scores[sent] = word_frequencies[word.text.lower()]
                    else:
                        sentence_scores[sent] += word_frequencies[word.text.lower()]
        select_length = int(len(sentence_tokens) * per)
        summary = nlargest(select_length, sentence_scores, key=sentence_scores.get)
        final_summary = [word.text for word in summary]
        summary = ''.join(final_summary)
        return summary

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

        value = {
            "title": article.title,
            "date": article.publish_date,
            "content": content,
            "original_content": article.article_html,
            "excerpt": article.summary,
            "summary": Extractor.summarize(article.text, 0.5),
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
            proc = Process(target=Extractor.extractArticle, args=(item.link,))
            procs.append(proc)
            proc.start()
            proc.join()

    def extractFeeds(self):
        return Extractor.extractFeedLinks(self.url)


extract = Extractor(url, feedparser)
print(extract.extractFeeds())
