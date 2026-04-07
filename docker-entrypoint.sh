#!/bin/bash
set -e

echo "==> Starting IGGStore Laravel Application..."

# Clear and cache config
echo "==> Caching configuration..."
php artisan config:clear
php artisan config:cache

# Run database migrations
echo "==> Running database migrations..."
php artisan migrate --force

# Create storage symlink (ignore error if already exists)
echo "==> Creating storage symlink..."
php artisan storage:link || true

# Cache routes and views
echo "==> Caching routes and views..."
php artisan route:cache
php artisan view:cache

echo "==> Application ready! Starting Apache..."

# Start Apache in foreground
exec apache2-foreground
