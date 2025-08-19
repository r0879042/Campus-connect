# ---------------------------
# 1) PHP deps build stage
# ---------------------------
FROM php:8.3-cli AS phpdeps

# System deps for PDO + ZIP
RUN apt-get update && apt-get install -y git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader


COPY . ./
# (Optional) 
# RUN php artisan config:clear && php artisan route:clear && php artisan view:clear

# ---------------------------
# 2) Node build stage (Vite)
# ---------------------------
FROM node:20-alpine AS nodebuild
WORKDIR /app

# Cache node_modules by copying lockfile first
COPY package.json package-lock.json* pnpm-lock.yaml* yarn.lock* ./
RUN if [ -f package-lock.json ]; then npm ci; \
    elif [ -f pnpm-lock.yaml ]; then corepack enable && pnpm i --frozen-lockfile; \
    elif [ -f yarn.lock ]; then yarn install --frozen-lockfile; \
    else npm i; fi

# Copy only what Vite needs
COPY resources ./resources
COPY vite.config.* .
COPY public ./public

# Build front-end assets (Laravel Vite -> public/build)
RUN npm run build

# ---------------------------
# 3) Final runtime image
# ---------------------------
FROM php:8.3-cli

# PHP extensions again in runtime image
RUN apt-get update && apt-get install -y libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Bring in the full app (includes vendor/ from phpdeps stage)
COPY --from=phpdeps /app /app

# Bring in built assets from node stage
COPY --from=nodebuild /app/public/build /app/public/build

# Render injects PORT; artisan serve 
ENV PORT=10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
