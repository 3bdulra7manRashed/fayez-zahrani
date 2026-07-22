# --- Stage 1: Build frontend assets ---
FROM node:20-alpine AS asset-builder

WORKDIR /app

COPY package*.json ./
RUN --mount=type=cache,target=/root/.npm npm ci

COPY . .
RUN npm run build

# --- Stage 2: Production image ---
FROM php:8.4-apache

# Install system dependencies (including SQLite)
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_sqlite zip gd bcmath opcache intl pcntl

# Allow large PDF uploads
RUN echo "upload_max_filesize=64M\npost_max_size=64M" \
    > /usr/local/etc/php/conf.d/uploads.ini

# Enable Apache rewrite and set DocumentRoot to Laravel's public directory
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies (cached layer)
COPY composer.json composer.lock ./
ENV COMPOSER_MEMORY_LIMIT=-1
RUN --mount=type=cache,target=/root/.composer/cache \
    composer install --no-dev --no-interaction --no-scripts --no-autoloader

# Copy application source
COPY . /var/www/html

# Optimise autoloader now that all files are present
RUN composer dump-autoload --optimize --no-scripts

# Copy compiled frontend assets
COPY --from=asset-builder /app/public/build /var/www/html/public/build

# Set up storage directories, symlink, and permissions
RUN mkdir -p /var/www/html/database/data /var/www/html/storage/app/public \
    && php artisan storage:link \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

RUN chmod +x /var/www/html/docker-entrypoint.sh

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=3 \
    CMD curl -f http://localhost/ || exit 1

ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
