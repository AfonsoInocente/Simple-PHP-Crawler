FROM php:8.1-cli-alpine

COPY . /app

CMD php -S 0.0.0.0:80 -t /app