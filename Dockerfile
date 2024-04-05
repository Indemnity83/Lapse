FROM node:21 AS assets
WORKDIR /src
COPY . .
RUN npm install && npm run build



FROM php:8.2-fpm-alpine

# Configure PHP
RUN echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

# Setup the container
RUN apk add --no-cache ffmpeg icu-dev libjpeg-turbo-dev libpng-dev libwebp-dev libzip-dev \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j "$(nproc)" bcmath exif gd intl mysqli zip \
    && apk del .build-deps

# Set up supervisor
COPY resources/docker/supervisord.conf /etc/supervisord.conf
COPY resources/docker/start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container \
    && apk add --no-cache supervisor

# Set some default environment variables
ENV APP_URL="http://localhost:80"
ENV TZ="UTC"
ENV QUEUE_CONNECTION="database"
ENV QUEUE_WORKERS=1
ENV SESSION_DRIVER="database"
ENV CACHE_STORE="database"
ENV LOG_CHANNEL="daily"
ENV DB_CONNECTION="sqlite"
ENV DB_DATABASE="/app/storage/database.sqlite"

# Copy the application code
WORKDIR /app
COPY . .
COPY --from=assets /src/public/build/ ./public/build/

# Install composer and dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --optimize-autoloader --no-ansi --no-interaction --no-plugins --no-progress --no-cache --no-dev

# Prepare Application
COPY .env.docker .env
RUN php artisan key:generate \
    && php artisan storage:link

# App presentation
EXPOSE 80
VOLUME ["/app/storage"]
HEALTHCHECK CMD curl --fail http://localhost/up || exit 1

CMD ["start-container"]
