#! /bin/sh
set -e

CONTAINER_ALREADY_STARTED="var/CONTAINER_ALREADY_STARTED_PLACEHOLDER"
if [ ! -e $CONTAINER_ALREADY_STARTED ]; then
    echo "-- First container startup --"
    make install
    make setup
    make fixtures
    touch $CONTAINER_ALREADY_STARTED
else
    echo "-- Not first container startup --"
fi

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"