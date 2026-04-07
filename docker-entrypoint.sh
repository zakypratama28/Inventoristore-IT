#!/bin/bash
set -e

echo "==> Starting IGGStore Laravel Application..."

# Clear and cache config
echo "==> Caching configuration..."
php artisan config:clear
php artisan config:cache

# Run database migrations (skip errors for already-existing tables)
echo "==> Running database migrations..."
php artisan migrate --force || {
    echo "==> Migration encountered an error. Attempting to continue..."
    # Check if app can still connect to DB
    php artisan db:show --json > /dev/null 2>&1 || {
        echo "==> ERROR: Cannot connect to database. Exiting."
        exit 1
    }
    echo "==> DB connection OK. Continuing startup despite migration warning..."
}

# Create storage symlink (ignore error if already exists)
echo "==> Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

# Cache routes and views
echo "==> Caching routes and views..."
php artisan route:cache
php artisan view:cache

echo "==> Application ready! Starting Apache..."

# Start Apache in foreground
exec apache2-foreground
