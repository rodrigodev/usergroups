.SILENT:
.PHONY: install setup fixtures test

install:
	@composer install

setup:
	@bin/console doctrine:database:create && bin/console doctrine:schema:create

fixtures:
	@bin/console doctrine:fixtures:load --quiet

test:
	@php ./bin/phpunit --verbose