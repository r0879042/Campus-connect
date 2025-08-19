# ---------------------------
# 1) PHP deps build stage
# ---------------------------
FROM php:8.3-cli AS phpdeps

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        git unzip ca-certificates \
        libpq-dev libzip-dev zlib1g-dev \
        libonig-dev pkg-config \
    ; \
    update-ca-certificates; \
    docker-php-ext-configure zip; \
    docker-php-ext-install -j"$(nproc)" pdo pdo_mysql pdo_pgsql zip mbstring; \
    rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app

# cache composer layers
COPY composer.json composer.lock ./
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-scripts

# now copy the rest of your app
COPY . ./

# ---------------------------
# 2) Node build stage (Vite)
# ---------------------------
FROM node:20-alpine AS nodebuild
WORKDIR /app
COPY package.json package-lock.json* pnpm-lock.yaml* yarn.lock* ./
RUN if [ -f package-lock.json ]; then npm ci; \
    elif [ -f pnpm-lock.yaml ]; then corepack enable && pnpm i --frozen-lockfile; \
    elif [ -f yarn.lock ]; then yarn install --frozen-lockfile; \
    else npm i; fi
COPY resources ./resources
COPY vite.config.* .
COPY public ./public
RUN npm run build

# ---------------------------
# 3) Final runtime image
# ---------------------------
FROM php:8.3-cli

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        ca-certificates \
        libpq-dev libzip-dev zlib1g-dev \
        libonig-dev pkg-config \
    ; \
    update-ca-certificates; \
    docker-php-ext-configure zip; \
    docker-php-ext-install -j"$(nproc)" pdo pdo_mysql pdo_pgsql zip mbstring; \
    rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY --from=phpdeps /app /app
COPY --from=nodebuild /app/public/build /app/public/build

ENV PORT=10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
