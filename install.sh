#!/bin/sh
#############################################################################
# Installation
#
# Small installation script
#
#############################################################################
#composer install
php artisan migrate:refresh
php artisan db:seed
npm install
gulp
php artisan app:install