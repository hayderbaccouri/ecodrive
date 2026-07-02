FROM php:8.1-apache

# Install extensions needed (mysqli, pdo_mysql) and some tooling
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
 && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
 && docker-php-ext-install gd mysqli pdo pdo_mysql zip

RUN a2enmod rewrite

WORKDIR /var/www/html