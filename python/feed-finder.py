from feedfinder2 import find_feeds
import sys
website = sys.argv[1:][0]
print (website)
feeds = find_feeds(website)
print(feeds)
