ifneq ("$(wildcard ./.env)","")
	include .env
endif

.PHONY: install up down

install:
	docker exec -ti mysql mysql -u ${DB_USERNAME} -e "CREATE DATABASE IF NOT EXISTS ${DB_DATABASE}" -p${DB_PASSWORD}

up:
	docker-compose up -d

down:
	docker-compose down