FROM php:8.1-fpm-alpine

LABEL maintainer="Stefan <stefan@lzomedia.com>"

WORKDIR /app



RUN apk update
RUN apk add --no-cache sqlite-libs
RUN apk add sqlite-dev
RUN apk add git
RUN apk add sudo
RUN apk add make
RUN apk add gcc
RUN apk add libsndfile-dev
RUN apk --no-cache add musl-dev linux-headers g++
RUN apk add --no-cache libffi-dev

#Add Python
RUN apk add python3
RUN apk add python3-dev
RUN apk add py3-pip

RUN pip3 install newspaper3k
RUN pip3 install pandas
RUN pip3 install simplejson
RUN pip3 install minet
RUN pip3 install spacy
RUN pip3 install nltk
RUN pip3 install lxml
RUN pip3 install textblob
RUN pip3 install spacytextblob
RUN pip3 install vaderSentiment
RUN python3 -m spacy download en_core_web_md
RUN python3 -m nltk.downloader -d /usr/local/share/nltk_data punkt
RUN python3 -m nltk.downloader -d /usr/local/share/nltk_data stopwords
RUN python3 -m nltk.downloader -d /usr/local/share/nltk_data vader_lexicon
RUN python3 -m textblob.download_corpora -d /usr/local/share/nltk_data




WORKDIR /app
# Install system packages
RUN apk add --no-cache \
        bash \
        git \
        curl \
        nano \
        g++ \
        sudo \
        freetds \
        freetype \
        icu \
        libintl \
        libldap \
        libjpeg \
        libpng \
        libpq \
        libwebp \
        libmemcached \
        supervisor \
        libzip \
        composer && \
    apk add --no-cache --virtual build-dependencies \
        curl-dev \
        freetds-dev \
        freetype-dev \
        gettext-dev \
        icu-dev \
        jpeg-dev \
        libpng-dev \
        libwebp-dev \
        libxml2-dev \
        libzip-dev \
        libmemcached-dev \
        openldap-dev \
        postgresql-dev \
        zlib-dev \
        autoconf \
        build-base
# Install PHP extensions
RUN docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ && \
    docker-php-ext-configure ldap --with-libdir=lib/ && \
    docker-php-ext-configure pdo_dblib --with-libdir=lib/ && \
    docker-php-ext-install \
        bcmath \
        curl \
        ctype \
        fileinfo \
        gettext \
        gd \
        exif \
        intl \
        ldap \
        opcache \
        pdo_mysql \
        pdo_sqlite \
        pdo_pgsql \
        soap \
        sockets \
        zip \
        xml \
        pcntl
# Install PECL extensions
RUN pecl install memcached && \
    docker-php-ext-enable memcached

RUN pecl install redis
RUN docker-php-ext-enable redis

RUN apk del build-dependencies

COPY .docker/config /tmp/config
# Download trusted certs
RUN mkdir -p /etc/ssl/certs && update-ca-certificates && \
# Copy php configuration
    cp /tmp/config/php.ini /usr/local/etc/php/php.ini && \
# Copy supervisor config
    mkdir /etc/supervisor.d && \
    cp /tmp/config/supervisord.conf /etc/supervisord.conf && \
    cp -r /tmp/config/supervisor.d /etc && \
# Copy cron job
    cp /tmp/config/crontab /etc/crontabs/www-data && \
    cp /tmp/config/entrypoint.sh /entrypoint.sh && \
    rm -rf /tmp/config && \
    chmod a+x /entrypoint.sh

ENV ENABLE_CRON_JOB=true
ENV ENABLE_LARAVEL_WORKER=true
ENV ENABLE_LARAVEL_HORIZON=true
ENV ENABLE_LARAVEL_WEBSOCKETS=true
ARG UID=1000
ARG USER='sputnick'
#Create non-root sudoer
RUN adduser -S -D -G www-data -u $UID -h /home/$USER $USER
RUN mkdir -p /home/$USER/.composer && \
    chown -R $USER:www-data /home/$USER
RUN chown -R $USER:www-data /app
EXPOSE 6001
ENTRYPOINT ["/entrypoint.sh"]

CMD ["php-fpm", "-F"]
