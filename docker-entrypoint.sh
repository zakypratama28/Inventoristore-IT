#!/bin/bash
set -e

echo "==> Starting IGGStore Laravel Application..."

# Clear and cache config
echo "==> Caching configuration..."
php artisan config:clear
php artisan config:cache

# Run database migrations
echo "==> Running database migrations..."
php artisan migrate --force || true

# Create storage symlink (ignore error if already exists)
echo "==> Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

# Fix storage permissions
echo "==> Setting storage permissions..."
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Cache routes and views
echo "==> Caching routes and views..."
php artisan route:cache
php artisan view:cache

# Tail Laravel log to Render output (for debugging)
echo "==> Tailing Laravel log for debug..."
touch /var/www/html/storage/logs/laravel.log
tail -f /var/www/html/storage/logs/laravel.log &

echo "==> Application ready! Starting Apache..."

# Start Apache in foreground
exec apache2-foreground
