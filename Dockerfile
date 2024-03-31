FROM node as assets
WORKDIR /src
COPY . .
RUN npm install && npm run build



FROM php:8.2-fpm-alpine

# Setup the container
RUN apk add --no-cache icu-dev libjpeg-turbo-dev libpng-dev libwebp-dev libzip-dev \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j "$(nproc)" bcmath exif gd intl mysqli zip \
    && apk del .build-deps

# Set up supervisor
RUN apk add --no-cache supervisor
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
