FROM php:8.5-cli-alpine

RUN apk add --no-cache sqlite libsqlite-dev && docker-php-ext-install pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

CMD php artisan serve --host=0.0.0.0 --port=$PORT
