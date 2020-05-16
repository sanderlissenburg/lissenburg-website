FROM composer:1.9 as build-backend

WORKDIR /app

COPY ./composer.json /app/composer.json
COPY ./composer.lock /app/composer.lock

RUN composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress --no-suggest

FROM node:13.13.0-alpine as build-frontend

WORKDIR /app

COPY ./package.json /app/package.json
COPY ./package-lock.json /app/package-lock.json
COPY --from=build-backend /app/public /app/public

RUN npm install

COPY ./assets   /app/assets
COPY ./webpack.config.js /app/webpack.config.js

RUN npm run build

FROM php:7.4.5-fpm-alpine as php-fpm

WORKDIR /app

RUN docker-php-ext-install \
  pdo \
  pdo_mysql

COPY --from=build-frontend /app/public /app/public
COPY --from=build-backend /app/vendor /app/vendor
COPY --from=build-backend /app/bin /app/bin
COPY ./src /app/src
COPY ./templates /app/templates
COPY ./translations /app/translations
COPY ./config /app/config

COPY .env /app/.env

RUN composer dump-autoload --optimize --classmap-authoritative --no-dev

#RUN bin/console cache:clear

FROM nginx:1.17.10-alpine as nginx

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=build-frontend /app/public /app/public
