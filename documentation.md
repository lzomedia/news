# Documentation

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
pip3 install newspaper3k
pip3 install pandas
pip3 install simplejson
pip3 install minet
pip3 install spacy
pip3 install nltk
pip3 install lxml
pip3 install textblob
pip3 install spacytextblob
pip3 install vaderSentiment
python3 -m spacy download en_core_web_md
python3 -m nltk.downloader -d /usr/local/share/nltk_data punkt
python3 -m nltk.downloader -d /usr/local/share/nltk_data stopwords
python3 -m nltk.downloader -d /usr/local/share/nltk_data vader_lexicon
python3 -m textblob.download_corpora -d /usr/local/share/nltk_data
```

## Video Generation (This is still in construction)

This project uses AI to generate a video from an article.

In order to use this script, you need to install the following packages:

```bash
git clone https://github.com/coqui-ai/TTS
cd TTS
```
If you are on Ubuntu (Debian), you can also run following commands for installation.

```bash
make system-deps 
make install
```




## Contributing
Feel free to contribute and make a pull request.


## Badges
![Testing](https://github.com/lzomedia/news/actions/workflows/PHPUNIT/badge.svg)

