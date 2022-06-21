# News App


This is a self-hosted laravel app that allows you to read news from different feed sources.
This is using autodiscovery to find the feeds.So when you add a new feed, it will automatically try to find new the feeds from the content itself.


# About

1. This project is a demo of a self-hosted laravel app that allows you to read news from different feed sources.
2. It comes with a simple admin panel that allows you to add new feeds and to manage the feeds.
3. It uses some NLP libraries to extract the most relevant news from the feed and to extract different keywords and sentiment.
4. It combines php and python to extract the news from the feed.
5. It uses event driven architecture to extract the news from the feed.
6. It comes with a list of tests to test the app.
7. The frontend is built using VueJS.

## Installation Normally
1. Clone this project
    ```bash
    git clone https://github.com/lzomedia/news.git
    ```
2. Move to the folder
   ```bash
    cd news
    ```

3. Install dependencies
    ```bash
    composer install
   yarn install    
    ```
4. Set up Laravel configurations
    ```bash
    copy .env.example .env
    php artisan key:generate
    ```

5. Set your database in .env by replacing the values of the following variables:
    ```bash
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ```

6. Migrate database
    ```bash
    php artisan migrate --seed
    ```

7. Serve the application
    ```bash
    php artisan serve
    ```

8. Login credentials

    ```bash
    Email: stefan@lzomedia.com
    Password: password
    ```
9. Configure Redis Database
    ```bash
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    ```

## Python Script
This project uses Python 3 for extracting the content from the feeds.
In order to use this script, you need to install the following packages:
```bash
su -c "pip3 install newspaper3k"
su -c "pip3 install pandas"
su -c "pip3 install simplejson"
su -c "pip3 install dotenv"
su -c "pip3 install spacy"
su -c "pip3 install supervisor"
su -c "pip3 install nltk"
su -c "pip3 install lxml"
su -c "pip3 install textblob"
su -c "pip3 install spacytextblob"
su -c "pip3 install vaderSentiment"
su -c "python3 -m spacy download en_core_web_md"
su -c "python3 -m nltk.downloader -d /usr/local/share/nltk_data punkt"
su -c "python3 -m nltk.downloader -d /usr/local/share/nltk_data stopwords"
su -c "python3 -m nltk.downloader -d /usr/local/share/nltk_data vader_lexicon"
su -c "python3 -m textblob.download_corpora"
```



## Contributing
Feel free to contribute and make a pull request.

