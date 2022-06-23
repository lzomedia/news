#!/bin/sh
echo "Starting the python install process..."
pip3 install newspaper3k
pip3 install pandas
pip3 install sqlalchemy
pip3 install pymysql
pip3 install simplejson
pip3 install minet
pip3 install dotenv
pip3 install spacy
pip3 install supervisor
pip3 install nltk
pip3 install lxml
pip3 install textblob
pip3 install spacytextblob

python3 -m spacy download en_core_web_md
python3 -m nltk.downloader -d /usr/local/share/nltk_data punkt
python3 -m nltk.downloader -d /usr/local/share/nltk_data stopwords
python3 -m nltk.downloader -d /usr/local/share/nltk_data vader_lexicon
python3 -m textblob.download_corpora



echo "Starting the php install process..."
composer install
npm install
npm run production

php artisan key:generate
php artisan migrate:fresh --seed

echo "Install complete!"
