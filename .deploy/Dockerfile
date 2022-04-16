# COMPOSER STAGE
ARG COMPOSER_VERSION=2.2.5
FROM composer:${COMPOSER_VERSION} as composer-dev
WORKDIR /app
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist
COPY . .

# BASE STAGE
FROM php:8.1-fpm-alpine as base

RUN apk --no-cache --update add  \
    ca-certificates  \
    libpq  \
    freetype  \
    libjpeg-turbo  \
    freetype-dev  \
    libpng-dev  \
    libjpeg-turbo-dev  \
    ffmpeg  \
    supervisor \
    && apk add --no-cache --virtual  \
    build-dependencies  \
    autoconf  \
    build-base  \
    g++  \
    make \
    && pecl install redis \
    && docker-php-ext-install bcmath opcache pdo_mysql pcntl \
    && docker-php-ext-enable bcmath opcache redis \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN chown -R www-data:www-data /var/www/html \
    && mkdir -p /var/log/supervisor

COPY .deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]


# LOCAL STAGE
ARG XDEBUG_VERSION=3.1.4
FROM base as local
RUN apk --no-cache --update add  \
    bash \
    git \
    && pecl install xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug \
    && apk del --purge autoconf build-dependencies g++ make

RUN cd /usr/bin && curl -Os https://uploader.codecov.io/latest/alpine/codecov && chmod +x ./codecov
#RUN codecov --rootDir /var/www/html/api --token b297e7df-8c76-4ab4-aeb2-69201acae7ef -f /var/www/html/tests/coverage/index.xml
COPY .deploy/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY .deploy/php/php.ini-development /usr/local/etc/php/php.ini-development

WORKDIR /var/www/html

COPY --chown=www-data:www-data --from=composer-dev /app/vendor/ ./vendor/
COPY --chown=www-data:www-data --from=composer-dev /usr/bin/composer /usr/bin/composer
