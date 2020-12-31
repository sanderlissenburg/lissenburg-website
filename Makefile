ifneq ("$(wildcard ./.env)","")
	include .env
endif

.PHONY: install up down watch build-prod-website up-prod

install:
	docker-compose run --rm website_node npm install
	docker-compose run --rm website_composer install
	docker exec -ti lissenburg-website_mysql_1 mysql -u ${DB_USERNAME} -e "CREATE DATABASE IF NOT EXISTS ${DB_DATABASE}" -p${DB_PASSWORD}
	docker-compose run --rm website_php-fpm vendor/bin/doctrine-module migrations:migrate

up:
	docker-compose up -d traefik mysql website_php-fpm website_nginx

up-prod:
	docker-compose up -d traefik mysql website_php-fpm_prod website_nginx_prod

down:
	docker-compose down

watch:
	docker-compose run --rm website_node npm run watch

build-prod:
	docker build -f=website/docker/Dockerfile	\
		-t lissenburg/website-php-fpm \
		--target php-fpm \
		./website
	docker build -f=website/docker/Dockerfile	\
		-t lissenburg/website-nginx \
		--target nginx \
		./website
