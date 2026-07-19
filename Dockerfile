# --- Stage 1: Build frontend assets ---
FROM node:20-alpine AS asset-builder
WORKDIR /app
COPY package*.json ./
RUN --mount=type=cache,target=/root/.npm npm ci
COPY . .
RUN npm run build

# --- Stage 2: Final production image ---
FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
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
    && docker-php-ext-install pdo_sqlite zip gd bcmath opcache intl mbstring

# Enable apache rewrite module
RUN a2enmod rewrite

# Configure Apache DocumentRoot to point to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first to leverage Docker layer cache
COPY composer.json composer.lock ./

# Install PHP dependencies without autoloader and scripts
ENV COMPOSER_MEMORY_LIMIT=-1
RUN --mount=type=cache,target=/root/.composer/cache \
    composer install --no-dev --no-interaction --no-scripts --no-autoloader

# Copy the rest of the application source code
COPY . /var/www/html

# Generate the optimized autoloader now that all files are present
RUN composer dump-autoload --optimize --no-scripts

# Copy compiled Vite assets from the first stage
COPY --from=asset-builder /app/public/build /var/www/html/public/build

# Set permissions for Laravel directories
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/database

# Make docker-entrypoint script executable
RUN chmod +x /var/www/html/docker-entrypoint.sh

# Expose port 80
EXPOSE 80

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=30s --retries=3 \
    CMD curl -f http://localhost/ || exit 1

# Set entrypoint
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
