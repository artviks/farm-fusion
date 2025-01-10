FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libxml2-dev \
    libonig-dev \
    libssl-dev

# Install PHP extensions
RUN docker-php-ext-install \
    intl \
    pdo_pgsql \
    zip \
    opcache \
    mbstring \
    xml

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html