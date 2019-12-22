.SILENT:
.PHONY: install setup test

install:
	@composer install

setup:
	@bin/console doctrine:database:create && bin/console doctrine:schema:create

test:
	@php ./bin/phpunit