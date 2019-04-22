# See https://github.com/docker-library/php/blob/master/7.3/fpm/Dockerfile
FROM php:7.3-fpm
ARG TIMEZONE

RUN apt-get update && apt-get install -y \
    apt-utils \
    openssl \
    git \
    unzip \
    zlib1g \
    zlib1g-dev \
    libzip-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www