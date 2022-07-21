FROM ubuntu:22.04

RUN apt-get update
RUN apt-get -y install software-properties-common
RUN add-apt-repository ppa:ondrej/php

ENV DEBIAN_FRONTEND=nointeractive
RUN apt-get -y update && apt-get install -y \
php8.1 \
php8.1-fpm \
php8.1-curl \
php8.1-common 

RUN mkdir -p /run/php

RUN [ "php-fpm8.1" ]


RUN apt-get -y install nginx
EXPOSE 80
RUN rm /etc/nginx/sites-enabled/default
COPY ./nginx.conf /etc/nginx/sites-enabled/

VOLUME /var/www/app

COPY ./app /var/www/app



CMD php-fpm8.1 && nginx -g "daemon off;"






