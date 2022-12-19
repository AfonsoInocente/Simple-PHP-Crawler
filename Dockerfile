FROM php:8.1-cli-alpine

WORKDIR /app

COPY . /app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install

RUN composer test

CMD composer start