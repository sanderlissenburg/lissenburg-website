FROM composer:2 as build-backend

WORKDIR /app

COPY ./composer.json /app/composer.json
COPY ./composer.lock /app/composer.lock

RUN composer install --no-dev --optimize-autoloader

FROM node:15.2.1-alpine3.10 as build-frontend

WORKDIR /app

COPY ./package.json /app/package.json
COPY ./package-lock.json /app/package-lock.json
COPY ./public /app/public
COPY ./src/assets /app/src/assets

RUN npm install

COPY ./webpack.config.js /app/webpack.config.js

RUN npm run production

FROM php:8.0.3-fpm-alpine as php-fpm

WORKDIR /app

RUN docker-php-ext-install \
  pdo \
  pdo_mysql

COPY ./docker/php-fpm/php.ini $PHP_INI_DIR/php.ini

COPY --from=build-frontend /app/public /app/public
COPY --from=build-backend /app/vendor /app/vendor
COPY ./config /app/config
COPY ./src/App /app/src/App
COPY ./templates /app/templates
COPY ./migrations.yaml /app/migrations.yaml

RUN mkdir -p \
        data/cache \
    && chown -R www-data data \
    && touch .env

FROM nginx:1.17.10-alpine as nginx

COPY ./docker/nginx/default.prod.conf /etc/nginx/conf.d/default.conf
COPY --from=build-frontend /app/public /app/public
