.PHONY=server


export
UID=$(shell id -u nobody)
COMPOSER=$(shell which composer)

build:
	cd server;$(COMPOSER) install;cd ../client/;$(COMPOSER) install

run-server:
	docker run --rm -u $(UID) \
		-v ./server/Caddyfile:/etc/frankenphp/Caddyfile \
		-v ./server:/app \
		-e APP_RUNTIME=Runtime\\FrankenPhpSymfony\\Runtime \
		-e API_TOTAL_RESULTS=999 \
		--network host \
		dunglas/frankenphp:1-alpine

run-client:
	docker run --rm -u $(UID) \
		-v ./client:/app \
		-w /app \
		-e BASE_URL=http://localhost:8080 \
		--network host  \
		php:8.4 php client.php

