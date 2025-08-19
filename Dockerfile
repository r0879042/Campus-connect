# ---------------------------
# 1) PHP deps build stage
# ---------------------------
FROM php:8.3-cli AS phpdeps

# system deps for PDO + ZIP
RUN apt-get update && apt-get install -y git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# copy only composer files first (cache layer)
COPY composer.json composer.lock ./

# install PHP deps WITHOUT scripts (avoid artisan during build)
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-scripts

# then copy the rest of the app
COPY . ./

# ---------------------------
# 2) Node build stage (Vite)
# ---------------------------
FROM node:20-alpine AS nodebuild
WORKDIR /app

# cache node_modules
COPY package.json package-lock.json* pnpm-lock.yaml* yarn.lock* ./
RUN if [ -f package-lock.json ]; then npm ci; \
    elif [ -f pnpm-lock.yaml ]; then corepack enable && pnpm i --frozen-lockfile; \
    elif [ -f yarn.lock ]; then yarn install --frozen-lockfile; \
    else npm i; fi

# copy only what Vite needs
COPY resources ./resources
COPY vite.config.* .
COPY public ./public

# build assets (Laravel Vite -> public/build)
RUN npm run build

# ---------------------------
# 3) Final runtime image
# ---------------------------
FROM php:8.3-cli

RUN apt-get update && apt-get install -y libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# bring in vendor/ and app code from phpdeps
COPY --from=phpdeps /app /app

# bring in built assets from node
COPY --from=nodebuild /app/public/build /app/public/build

# Render injects PORT; artisan must listen on it
ENV PORT=10000

# You can run artisan optimize in the real container (not during composer install)
# Avoids needing .env at build time
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
