# build composer dependencies
FROM composer:latest as composer_build
COPY ./composer.json /app/
RUN composer install --no-dev --no-autoloader --no-scripts
COPY . /app
RUN composer install --no-dev --optimize-autoloader

FROM php:8.1-fpm
WORKDIR /var/www
RUN apt-get update && apt-get install -y \
    curl \
    nginx \
    supervisor
RUN apt-get clean && rm -rf /var/lib/apt/lists

# Copy code
COPY --chown=www:www-data . /var/www

# Copy configs
RUN cp .docker/nginx.conf /etc/nginx/sites-enabled/default
RUN cp .docker/php.ini /usr/local/etc/php/conf.d/app.ini
RUN cp .docker/supervisord.conf /etc/supervisor/supervisord.conf

# PHP error logs
RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

# Copy composer build
COPY --chown=www-data --from=composer_build /app/ /var/www/

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
