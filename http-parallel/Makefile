.PHONY=server


export
UID=1000
COMPOSER=$(shell which composer)

build:
	cd server;$(COMPOSER) install;cd ../client/;$(COMPOSER) install

run-server:
	docker run --rm -u $(UID) \
		-v ./server/Caddyfile:/etc/frankenphp/Caddyfile \
		-v ./server:/app \
		-e APP_RUNTIME=Runtime\\FrankenPhpSymfony\\Runtime \
		--network host \
		dunglas/frankenphp:1-alpine

run-client:
	docker run --rm -u $(UID) \
		-v ./client:/app \
		-w /app \
		-e BATCH_SIZE=10 \
		-e BASE_URL=http://localhost:8080 \
		--network host  \
		php:8.4 php client.php

