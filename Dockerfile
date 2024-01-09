FROM ghcr.io/at-cloud-pro/caddy-php:3.0.0 AS app

ENV VERSION="3.0.0"

COPY ./app /app
RUN composer install

RUN chmod --recursive a+r /app \
&& chmod --recursive a+x /app/bin/* \
&& chown --recursive www-data:www-data /app/var/log \
&& chmod --recursive a+w /app/var/log

ENV APP_ENV="prod"

USER www-data:www-data

HEALTHCHECK CMD curl --fail http://localhost || exit 1
