FROM node:14.16.0-alpine3.10 as build-frontend

WORKDIR /app

COPY ./package.json /app/package.json
COPY ./package-lock.json /app/package-lock.json
COPY ./tailwind.config.js /app/tailwind.config.js
COPY ./public /app/public
COPY ./src /app/src/

RUN npm install

ENV NODE_ENV=production

RUN npm run build-css

FROM nginx:1.17.10-alpine as nginx

COPY ./docker/production/default.conf /etc/nginx/conf.d/default.conf
COPY --from=build-frontend /app/public /app/public
