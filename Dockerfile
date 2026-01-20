# syntax=docker/dockerfile:1
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    ca-certificates \
    mariadb-client \
    netcat-openbsd \
    && docker-php-ext-install pdo_mysql bcmath zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js (for Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm -v && node -v \
    && rm -rf /var/lib/apt/lists/*

# Copy application source
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN npm install && npm run build

# Optimize Laravel
RUN php artisan key:generate --force || true \
    && php artisan optimize || true

# Copy entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose app port
EXPOSE 3000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Run Laravel on port 3000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=3000"]
