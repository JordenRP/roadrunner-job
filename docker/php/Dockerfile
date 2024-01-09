FROM ghcr.io/roadrunner-server/roadrunner:2023.3.8 AS roadrunner
FROM php:8.3-cli-alpine

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
COPY --chown=www-data:www-data docker/php/config/15-xdebug.ini $PHP_INI_DIR/conf.d
COPY --chown=www-data:www-data . /application

WORKDIR /application

RUN apk add --update linux-headers

RUN docker-php-ext-install sockets

RUN set -eux; \
	apk add --no-cache --virtual .build-deps $PHPIZE_DEPS; \
	pecl install xdebug-3.3.1; \
	docker-php-ext-enable xdebug; \
	apk del .build-deps

CMD rr serve -c .rr.yaml