# ---------------------
#  Build PHP
# ---------------------
FROM php:7.4-fpm-buster as php-fmt-base
# # Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# ---------------------
# NPM install
# ---------------------
FROM node:14-alpine as nodejs
WORKDIR /var/app-nodejs
COPY package.json package-lock.json ./
RUN npm install

# ---------------------
# Final Docker image
# ---------------------
FROM php-fmt-base

WORKDIR /var/www

COPY --chown=www-data:www-data . .
RUN composer install --optimize-autoloader --no-dev
# RUN php artisan config:cache
# RUN php artisan route:cache
# RUN php artisan view:cache

# RUN php artisan config:clear
# RUN php artisan cache:clear 

# RUN composer dump-autoload -o

# COPY --chown=www-data:www-data .env.example .env
# RUN php artisan key:generate && php artisan jwt:secret


COPY --from=nodejs /var/app-nodejs ./
