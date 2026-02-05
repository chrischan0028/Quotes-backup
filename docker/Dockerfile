FROM php:8.3-cli

# Install system dependencies
RUN apt update && apt install -y \
   git \
   zip \ 
   unzip \
   curl \
   nodejs \
   npm \
   sqlite3 \
   libsqlite3-dev

# Install PHP SQLite extension
RUN docker-php-ext-install pdo pdo_sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/test

# Copy entrypoint script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["/entrypoint.sh"]
