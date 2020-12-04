FROM php:7.4-fpm-alpine

RUN apk update && apk add libpng-dev libzip libzip-dev curl-dev && apk add autoconf g++ make zip gd zip curl \
    && pecl install xdebug-2.9.8 \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN apk add postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql gd zip json curl bcmath

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

ENV COMPOSER_ALLOW_SUPERUSER 1

ADD ./php.ini /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache

WORKDIR /var/www
