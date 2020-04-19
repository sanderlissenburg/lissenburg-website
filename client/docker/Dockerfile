FROM node:13.13.0-alpine as build

WORKDIR /app

COPY ./package.json /app/package.json
COPY ./package-lock.json /app/package-lock.json 

RUN npm install

COPY ./webpack.config.js /app/webpack.config.js
COPY ./public/index.html /app/public/index.html
COPY ./src /app/src

RUN npm run production

FROM nginx:1.17.10-alpine as production
COPY --from=build /app/public /usr/share/nginx/html