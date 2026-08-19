# syntax=docker/dockerfile:1

# Create a stage for installing app dependencies defined in Composer.
FROM composer:2 as deps

WORKDIR /app

# Download dependencies as a separate step to take advantage of Docker's caching.
RUN --mount=type=bind,source=composer.json,target=composer.json \
    --mount=type=bind,source=composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-dev --no-interaction --no-scripts --ignore-platform-req=ext-zip --ignore-platform-req=ext-intl

################################################################################

# Create a new stage for running the application
FROM php:8.3-apache as final

# Install PHP extensions required by CodeIgniter
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev \
    && docker-php-ext-install intl mysqli \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/* \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"


# Install and enable the PCOV extension for PHPUnit code coverage
RUN pecl install pcov && docker-php-ext-enable pcov

# Configure Apache to use public directory as root
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf \
    && printf '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>\n' > /etc/apache2/conf-available/team-manager.conf \
    && a2enconf team-manager

# Copy the app dependencies from the previous install stage.
COPY --from=deps app/vendor/ /var/www/html/vendor

# Copy the app files
COPY . /var/www/html

# Set up writable directories
RUN mkdir -p /var/www/html/writable/cache /var/www/html/writable/logs /var/www/html/writable/session /var/www/html/writable/uploads \
    && chown -R www-data:www-data /var/www/html/writable

# Switch to non-privileged user
USER www-data
