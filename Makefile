ifneq ("$(wildcard ./.env)","")
	include .env
endif

.PHONY: install build up down

install:
	docker exec -ti mysql mysql -u ${DB_USERNAME} -e "CREATE DATABASE IF NOT EXISTS ${DB_DATABASE}" -p${DB_PASSWORD}

build:
	docker-compose build


up:
	docker-compose up -d traefik mysql client admin_nginx admin_php-fpm

down:
	docker-compose down
