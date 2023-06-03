FROM php:8.1-fpm-alpine

ENV XDEBUG_VERSION 3.1.3

RUN apk update && apk add --no-cache unzip git \
    && git clone --branch $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-install pdo pdo_mysql xdebug \
    && apk del git

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/development/php/conf.d /usr/local/etc/php/conf.d

COPY ./ ./

WORKDIR /app

COPY ./docker/development/php-fpm/entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint
