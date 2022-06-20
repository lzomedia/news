#!/bin/sh
echo "Starting the python install process..."
pip3.9 install newspaper3k
pip3.9 install pandas
pip3.9 install sqlalchemy
pip3.9 install pymysql
pip3.9 install mysql.connector
pip3.9 install simplejson
pip3.9 install minet
pip3.9 install dotenv
pip3.9 install spacy
pip3.9 install supervisor
pip3.9 install nltk
pip3.9 install lxml
python3.9 -m spacy download en_core_web_md
python3.9 -m nltk.downloader -d /usr/local/share/nltk_data punkt
python3.9 -m nltk.downloader -d /usr/local/share/nltk_data stopwords
python3.9 -m nltk.downloader -d /usr/local/share/nltk_data vader_lexicon




echo "Starting the php install process..."
composer install
npm install
npm run production

php artisan key:generate
php artisan migrate:fresh --seed

echo "Install complete!"
