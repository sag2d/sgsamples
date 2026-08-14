# syntax=docker/dockerfile:1

# Comments are provided throughout this file to help you get started.
# If you need more help, visit the Dockerfile reference guide at
# https://docs.docker.com/go/dockerfile-reference/

# Want to help us make this template better? Share your feedback here: https://forms.gle/ybq9Krt8jtBL3iCk7

################################################################################

# Create a stage for installing app dependencies defined in Composer.
#FROM composer:lts as deps
FROM php:8.4-cli as deps

WORKDIR /app

# Install git and unzip for Composer
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# If your composer.json file defines scripts that run during dependency installation and
# reference your application source files, uncomment the line below to copy all the files
# into this layer.
# COPY . .
# Copy Composer from official image
COPY --from=composer:lts /usr/bin/composer /usr/bin/composer

# Download dependencies as a separate step to take advantage of Docker's caching.
# Leverage a bind mounts to composer.json and composer.lock to avoid having to copy them
# into this layer.
# Leverage a cache mount to /tmp/cache so that subsequent builds don't have to re-download packages.
RUN --mount=type=bind,source=composer.json,target=composer.json \
    --mount=type=bind,source=composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-dev --no-interaction --no-scripts --ignore-platform-req=ext-intl --ignore-platform-req=ext-zip
    
################################################################################

# Create a new stage for running the application that contains the minimal
# runtime dependencies for the application. This often uses a different base
# image from the install or build stage where the necessary files are copied
# from the install stage.
#
# The example below uses the PHP Apache image as the foundation for running the app.
# By specifying the "8.4-apache" tag, it will also use whatever happens to be the
# most recent version of that tag when you build your Dockerfile.
# If reproducibility is important, consider using a specific digest SHA, like
# php@sha256:99cede493dfd88720b610eb8077c8688d3cca50003d76d1d539b0efc8cca72b4.
FROM php:8.4-apache as final

# Install required PHP extensions for Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql zip intl \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Configure Apache to serve Laravel's public directory
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf

# Your PHP application may require additional PHP extensions to be installed
# manually. For detailed instructions for installing extensions can be found, see
# https://github.com/docker-library/docs/tree/master/php#how-to-install-more-php-extensions
# The following code blocks provide examples that you can edit and use.
#
# Add core PHP extensions, see
# https://github.com/docker-library/docs/tree/master/php#php-core-extensions
# This example adds the apt packages for the 'gd' extension's dependencies and then
# installs the 'gd' extension. For additional tips on running apt-get, see
# https://docs.docker.com/go/dockerfile-aptget-best-practices/
# RUN apt-get update && apt-get install -y \
#     libfreetype-dev \
#     libjpeg62-turbo-dev \
#     libpng-dev \
# && rm -rf /var/lib/apt/lists/* \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install -j$(nproc) gd
#
# Add PECL extensions, see
# https://github.com/docker-library/docs/tree/master/php#pecl-extensions
# This example adds the 'redis' and 'xdebug' extensions.
# RUN pecl install redis-5.3.7 \
#    && pecl install xdebug-3.2.1 \
#    && docker-php-ext-enable redis xdebug

# Use the default production configuration for PHP runtime arguments, see
# https://github.com/docker-library/docs/tree/master/php#configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install and enable the PCOV extension for Pest code coverage
RUN pecl install pcov && docker-php-ext-enable pcov

# Copy the app dependencies from the previous install stage.
COPY --from=deps app/vendor/ /var/www/html/vendor
# Copy the app files from the app directory.
COPY . /var/www/html

# Set up Laravel writable directories
RUN mkdir -p /var/www/html/storage/logs \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Switch to a non-privileged user (defined in the base image) that the app will run under.
# See https://docs.docker.com/go/dockerfile-user-best-practices/
USER www-data
