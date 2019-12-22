.SILENT:
.PHONY: install run stop

build:
	docker-compose build

run:
	docker-compose up -d

stop:
	docker-compose down

.DEFAULT_GOAL := build
