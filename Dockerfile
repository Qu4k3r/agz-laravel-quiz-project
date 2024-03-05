FROM php:8.1-fpm-alpine3.19

ARG user=1000
ARG uid=1000

RUN apk update; \
    apk --no-cache add postgresql-dev oniguruma-dev zlib-dev libpng-dev; \
    docker-php-ext-install pdo pdo_pgsql mbstring bcmath gd

WORKDIR /var/www

COPY .docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini
COPY ./src/ /var/www

RUN mkdir /var/log/nginx && chown ${user} /var/log/nginx

USER $user