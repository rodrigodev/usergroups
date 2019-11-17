.SILENT:
.PHONY: install setup

install:
	@composer install

setup:
	@bin/console doctrine:database:create && bin/console doctrine:schema:create

test:
	@php ./bin/phpunit