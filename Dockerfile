FROM php:8.1-cli-alpine

WORKDIR /app

COPY . /app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN composer install

CMD composer start