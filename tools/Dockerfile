FROM node:14-alpine as nodejs
WORKDIR /var/app-nodejs
COPY package.json .
COPY package-lock.json .
RUN npm install

FROM php:7.4-fpm-buster
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

WORKDIR /var/www

COPY --chown=www-data:www-data . .
# COPY --chown=www-data:www-data .env.example .env
RUN composer install --optimize-autoloader --no-dev
RUN composer dump-autoload -o

# Assume APP_KEY is exist in .env file
# RUN php artisan key:generate
# RUN php artisan jwt:secret
RUN php artisan cache:clear
RUN php artisan config:clear

COPY --from=nodejs /var/app-nodejs ./
# RUN rm .env
