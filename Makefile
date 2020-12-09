ifneq ("$(wildcard ./.env)","")
	include .env
endif

.PHONY: install up down watch

install:
	docker-compose run --rm website_node npm install
	docker-compose run --rm website_composer install
	docker exec -ti lissenburg-website_mysql_1 mysql -u ${DB_USERNAME} -e "CREATE DATABASE IF NOT EXISTS ${DB_DATABASE}" -p${DB_PASSWORD}

up:
	docker-compose up -d traefik mysql website_php-fpm website_nginx

down:
	docker-compose down

watch:
	docker-compose run --rm website_node npm run watch
