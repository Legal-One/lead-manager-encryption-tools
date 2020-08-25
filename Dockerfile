FROM php:7.4-alpine

LABEL maintainer="Legal One GmbH"
LABEL Description="Docker image for lead-manager Key Generator"


# user build args
ARG PHP_USER_ID=1000
ARG PHP_GROUP_ID=1000

RUN set -x \
	&& addgroup -g $PHP_GROUP_ID -S php \
	&& adduser -u $PHP_USER_ID -D -S -G php php

RUN apk add --no-cache \
        libressl \
        libsodium \
    && apk add --update --no-cache --virtual .ext-deps \
        autoconf \
        libsodium-dev \
        icu-dev \
        libzip-dev \
        zlib-dev \
        g++ \
        make \
        openssl-dev \
        ${PHPIZE_DEPS} \
    && pecl install libsodium \
    && docker-php-ext-enable \
        sodium \
    && apk del .ext-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY --chown=php . /app/
WORKDIR /app
USER php
RUN composer install -n -o -a
