FROM php:8.5-fpm

ARG UID=1000
ARG GID=1000

RUN apt-get update && apt-get install -y --no-install-recommends \
        libpq-dev \
        libicu-dev \
        libzip-dev \
        libfcgi-bin \
        unzip \
        cron \
    && docker-php-ext-install -j"$(nproc)" pdo_pgsql \
    && docker-php-ext-install -j"$(nproc)" intl \
    && docker-php-ext-install -j"$(nproc)" zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY crontab /etc/cron.d/trello
COPY trello-cron.sh /usr/local/bin/trello-cron
COPY cron-entrypoint.sh /usr/local/bin/cron-entrypoint.sh
RUN chmod 0644 /etc/cron.d/trello \
    && chmod 0755 /usr/local/bin/trello-cron /usr/local/bin/cron-entrypoint.sh

RUN groupmod -o -g "${GID}" www-data \
    && usermod -o -u "${UID}" -g "${GID}" www-data \
    && mkdir -p /var/www/.composer /var/www/html \
    && chown -R www-data:www-data /var/www

WORKDIR /var/www/html

USER www-data
