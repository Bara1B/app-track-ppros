#!/usr/bin/env bash
# exit on error
set -o errexit

# Install dependensi
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Generate APP_KEY kalo belom ada
php artisan key:generate --force

# Jalanin migrasi database
php artisan migrate --force