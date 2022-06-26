from feedfinder2 import find_feeds
import warnings
warnings.filterwarnings("ignore")
import sys
import json
website = sys.argv[1:][0]
feeds = find_feeds(website)
print(json.dumps(feeds))
