FROM node as assets
WORKDIR /src
COPY . .
RUN npm install && npm run build



FROM php:8.2-fpm-alpine

# Setup the container
RUN apk add --no-cache supervisor icu-dev
RUN docker-php-ext-configure intl &&  \
    docker-php-ext-install exif intl
COPY resources/docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY resources/docker/start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

# Copy the application code
WORKDIR /app
COPY . .
COPY --from=assets /src/public/build/ ./public/build/

# Install composer and dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --optimize-autoloader --no-ansi --no-interaction --no-plugins --no-progress --no-scripts --no-cache --no-dev

# Prepare Application
RUN ls -la
COPY .env.docker .env
RUN php artisan key:generate
RUN php artisan storage:link

EXPOSE 80
VOLUME ["/app/storage"]
HEALTHCHECK CMD curl --fail http://localhost/up || exit 1

CMD ["start-container"]
