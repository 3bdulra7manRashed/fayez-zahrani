#!/bin/sh
set -e

# =============================================================================
# Merge .env.example into .env (add missing keys without overwriting existing)
# =============================================================================
if [ -f "/var/www/html/.env" ]; then
    echo "Merging existing .env with .env.example..."
    while IFS= read -r line || [ -n "$line" ]; do
        case "$line" in
            ""|"#"*) continue ;;
        esac
        key=$(echo "$line" | cut -d '=' -f 1)
        if ! grep -q "^${key}=" /var/www/html/.env; then
            echo "$line" >> /var/www/html/.env
        fi
    done < /var/www/html/.env.example
else
    echo "Creating .env file from .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# =============================================================================
# SQLite — ensure the database directory and file exist
# =============================================================================
mkdir -p /var/www/html/database/data
if [ ! -f "/var/www/html/database/data/database.sqlite" ]; then
    echo "Creating database.sqlite file..."
    touch /var/www/html/database/data/database.sqlite
fi

# Set permissions early so migrations can write to the DB file
chown -R www-data:www-data /var/www/html/database
chmod -R 775 /var/www/html/database
chmod 664 /var/www/html/database/data/database.sqlite

# =============================================================================
# Generate APP_KEY if not already set
# =============================================================================
if ! grep -q "APP_KEY=base64:" /var/www/html/.env || \
   [ -z "$(grep 'APP_KEY' /var/www/html/.env | cut -d '=' -f2)" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# =============================================================================
# Run database migrations
# =============================================================================
echo "Running database migrations..."
php artisan migrate --force

# Re-create the storage symlink in case the volume mount replaced it
php artisan storage:link --quiet 2>/dev/null || true

# =============================================================================
# Seed database only when no admin users exist (idempotent)
# =============================================================================
echo "Checking if database needs seeding..."
if ADMIN_COUNT=$(php artisan tinker --execute="echo DB::table('users')->count();" 2>/dev/null); then
    ADMIN_COUNT=$(echo "$ADMIN_COUNT" | tr -d '[:space:]')
else
    ADMIN_COUNT=0
fi

if [ "$ADMIN_COUNT" = "0" ]; then
    echo "No admin users found. Seeding database..."
    php artisan db:seed --force
else
    echo "Database already has admin users ($ADMIN_COUNT). Skipping seed."
fi

# =============================================================================
# Optimize for production
# =============================================================================
echo "Running package discovery..."
php artisan package:discover --ansi

echo "Caching configuration, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# =============================================================================
# Set final runtime permissions
# =============================================================================
echo "Setting final permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/database
chown www-data:www-data /var/www/html/.env
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/database
chmod 664 /var/www/html/database/data/database.sqlite
chmod 664 /var/www/html/.env

# =============================================================================
# Start Apache
# =============================================================================
echo "Starting Apache..."
exec apache2-foreground
