ifneq ("$(wildcard ./.env)","")
	include .env
endif

build-prod:
	docker build -f=frontend/docker/production/Dockerfile \
		-t lissenburg/website-frontend-nginx \
		--target nginx \
		./frontend
