FROM php:7

MAINTAINER Rodrigo Carneiro <rodrigo_carneiro@mail.com>

ENV DEBIAN_FRONTEND noninteractive
RUN echo "Europe/Lisbon" > /etc/timezone; dpkg-reconfigure tzdata

RUN apt-get update -y
RUN apt-get install --no-install-recommends -y libpng-dev zlib1g-dev git ca-certificates

RUN docker-php-ext-install gd
RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install pcntl

WORKDIR /var/www

#RUN "bin/console doctrine:database:create"
#RUN "bin/console doctrune:schema:create"

EXPOSE 8000