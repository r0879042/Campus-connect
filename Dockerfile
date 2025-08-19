# --- Build stage: install dependencies ---
FROM php:8.3-cli AS app

# System deps
RUN apt-get update && apt-get install -y git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# App code
WORKDIR /app
COPY . /app

# Install PHP deps (no dev)
RUN composer install --no-dev --optimize-autoloader

RUN npm ci && npm run build

# --- Runtime stage ---
FROM php:8.3-cli

# Needed PHP extensions again in final image
RUN apt-get update && apt-get install -y libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

WORKDIR /app
COPY --from=app /app /app

# Render will set PORT; artisan serve must listen on it
ENV PORT=10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
