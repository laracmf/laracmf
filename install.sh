#!/bin/sh
#############################################################################
# Installation
#
# Small installation script
#
#############################################################################
cp config/env/.env.vagrant .env
php artisan key:generate
php artisan jwt:secret -f
npm install
gulp
php artisan app:install