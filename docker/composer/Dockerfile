FROM composer/composer:2-bin AS composer-bin

FROM php:8.5-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer-bin /composer /usr/local/bin/composer

WORKDIR /app
