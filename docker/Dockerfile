FROM php:8.3-cli

# System dependencies
RUN apt update && apt install -y \
    git \
    curl \
    unzip \
    zip \
    nodejs \
    npm \
    sqlite3 \
    libsqlite3-dev

# PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["/entrypoint.sh"]
