ENV TESTING
RUN apt-get update -y
RUN apt-get install -y software-properties-common
RUN add-apt-repository ppa:nginx/development
RUN apt-get update -y
RUN apt-get upgrade -y
RUN apt-get install -y git libcurl4-gnutls-dev libicu-dev libmcrypt-dev libvpx-dev libjpeg-dev libpng-dev libxpm-dev zlib1g-dev libfreetype6-dev libxml2-dev libexpat1-dev libbz2-dev libgmp3-dev libldap2-dev unixodbc-dev libpq-dev libsqlite3-dev libaspell-dev libsnmp-dev libpcre3-dev libtidy-dev -yqq zip unzip

RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install

RUN cp config/env/.env.testing .env
RUN php artisan key:generate
RUN php artisan jwt:secret
RUN php artisan config:cache

RUN php artisan migrate
RUN php artisan db:seed