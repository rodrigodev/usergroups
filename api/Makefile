.SILENT:
.PHONY: install setup fixtures test

install:
	@composer install

setup:
	@bin/console doctrine:database:create --if-not-exists && bin/console doctrine:schema:update --force

fixtures:
	@bin/console doctrine:fixtures:load --quiet

test:
	@php ./bin/phpunit --verbose