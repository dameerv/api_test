FROM php:8.3-fpm

RUN apt update \
    && apt-get install -y libpq-dev wget unzip \
    && apt install -y zlib1g-dev g++ libicu-dev zip libzip-dev zip  \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >>  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

WORKDIR /var/www/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl https://deb.nodesource.com/setup_12.x | bash
RUN curl https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN apt-get update && apt-get install -y postgresql-client

user www-data