FROM php:8.1-cli-alpine AS builder

RUN docker-php-ext-install pdo pdo_mysql sockets opcache

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis.so

RUN apk add --no-cache unzip

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

RUN apk add --no-cache libpng libpng-dev && docker-php-ext-install gd && apk del libpng-dev

RUN apk add --no-cache zip libzip-dev && docker-php-ext-configure zip && docker-php-ext-install zip

WORKDIR /app

COPY ./composer.json ./composer.lock ./

RUN composer install --no-dev --prefer-dist --no-progress --no-suggest --optimize-autoloader \
    && rm -rf /root/.composer/cache

### FPM ###

FROM php:8.1-fpm-alpine

RUN apk add --no-cache fcgi libpng libpng-dev \
    && docker-php-ext-install gd && apk del libpng-dev \
    && docker-php-ext-install pdo pdo_mysql sockets opcache

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis.so

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/production/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /app

COPY --from=builder /app ./
COPY ./ ./

RUN chown www-data:www-data ./api/runtime -R
RUN chown www-data:www-data ./var
