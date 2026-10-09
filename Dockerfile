FROM php:8.2-fpm-alpine

# Zarur kengaytmalarni o'rnatish
RUN docker-php-ext-install pdo pdo_mysql

# Loyihani nusxalash
WORKDIR /var/www
COPY . .

# Composer o'rnatish
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Portni sozlash va ishga tushirish
EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=8080