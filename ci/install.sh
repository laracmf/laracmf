#!/bin/bash

[[ ! -e /.dockerenv ]] && [[ ! -e /.dockerinit ]] && exit 0
set -xe

# Update packages and install composer and PHP dependencies.
apt-get update -yqq
apt-get install git libcurl4-gnutls-dev libicu-dev libmcrypt-dev libvpx-dev libjpeg-dev libpng-dev libxpm-dev zlib1g-dev libfreetype6-dev libxml2-dev libexpat1-dev libbz2-dev libgmp3-dev libldap2-dev unixodbc-dev libpq-dev libsqlite3-dev libaspell-dev libsnmp-dev libpcre3-dev libtidy-dev -yqq zip unzip

# Install Composer and project dependencies.
curl -sS https://getcomposer.org/installer | php
php composer.phar install

# Install phpunit, the tool that we will use for testing
curl --location --output /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar
chmod +x /usr/local/bin/phpunit
# Install phpcs, the tool that we will use for Code Sniffing
curl --location --output /usr/local/bin/phpcs https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
chmod +x /usr/local/bin/phpcs
# Install phpmd, the tool that we will use for Mess Detecting
curl --location --output /usr/local/bin/phpmd  http://static.phpmd.org/php/latest/phpmd.phar
chmod +x /usr/local/bin/phpmd

# Install mysql driver Here you can install any other extension that you need
docker-php-ext-install pdo_mysql

# Copy over testing configuration.
cp config/env/.env.testing .env

# Generate an application key. Re-cache.
php artisan key:generate
php artisan jwt:secret
php artisan config:cache

# Run database migrations.
php artisan migrate
php artisan db:seed