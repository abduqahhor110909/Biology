FROM php:8.2-fpm-alpine

# SQLite va MySQL uchun zarur kengaytmalar
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www
COPY . .

# Composer o'rnatish va paketlarni yuklash
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

# SQLite faylini yaratish, huquqlarni berish, migratsiyani ishga tushirish va serverni yoqish
CMD touch database/database.sqlite && chmod 777 database/database.sqlite && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080