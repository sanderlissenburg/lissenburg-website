ifneq ("$(wildcard ./.env)","")
	include .env
endif

.PHONY: install build-dev build-prod up down

install:
	docker exec -ti mysql mysql -u ${DB_USERNAME} -e "CREATE DATABASE IF NOT EXISTS ${DB_DATABASE}" -p${DB_PASSWORD}

build-dev:
	docker-compose build

build-prod:
	docker build -f=admin/docker/php-fpm/Dockerfile -t lissenburg/admin-php-fpm --target php-fpm ./admin
	docker build -f=admin/docker/php-fpm/Dockerfile -t lissenburg/admin-nginx --target nginx ./admin


up:
	docker-compose up -d traefik mysql client admin_nginx admin_php-fpm

down:
	docker-compose down
