#!/bin/bash

# Update packages and install composer and PHP dependencies.
apt-get update -yqq
apt-get install git libcurl4-gnutls-dev libicu-dev libmcrypt-dev libvpx-dev libjpeg-dev libpng-dev libxpm-dev zlib1g-dev libfreetype6-dev libxml2-dev libexpat1-dev libbz2-dev libgmp3-dev libldap2-dev unixodbc-dev libpq-dev libsqlite3-dev libaspell-dev libsnmp-dev libpcre3-dev libtidy-dev -yqq

# Install Composer and project dependencies.
curl -sS https://getcomposer.org/installer | php
composer install

# Copy over testing configuration.
cp config/env/.env.testing .env

# Generate an application key. Re-cache.
php artisan key:generate
php artisan jwt:secret
php artisan config:cache

# Run database migrations.
php artisan migrate
php artisan db:seed