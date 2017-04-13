#!/bin/sh
#############################################################################
# Installation
#
# Small installation script
#
#############################################################################
php artisan migrate
php artisan db:seed
npm install
gulp
php artisan app:install