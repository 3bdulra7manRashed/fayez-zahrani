#!/bin/sh
set -e

# Copy or merge .env.example to .env
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
    echo "Creating .env file..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Wait for MySQL if DB_CONNECTION is mysql
if [ "$DB_CONNECTION" = "mysql" ]; then
    echo "Waiting for MySQL database connection..."
    php -r '
    $host = getenv("DB_HOST") ?: "db";
    $db = getenv("DB_DATABASE") ?: "laravel";
    $user = getenv("DB_USERNAME") ?: "root";
    $pass = getenv("DB_PASSWORD") ?: "";
    for ($i = 0; $i < 30; $i++) {
        try {
            new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            echo "Connected successfully to MySQL.\n";
            exit(0);
        } catch (PDOException $e) {
            echo "Waiting for MySQL database connection ($i/30)...\n";
            sleep(2);
        }
    }
    exit(1);
    '
fi

# Ensure database directory and SQLite file exist with correct permissions
mkdir -p /var/www/html/database/data
if [ ! -f "/var/www/html/database/data/database.sqlite" ]; then
    echo "Creating database.sqlite file..."
    touch /var/www/html/database/data/database.sqlite
fi

# Ensure uploads directory exists
mkdir -p /var/www/html/public/uploads

# Set initial permissions for database so migrations can run
chown -R www-data:www-data /var/www/html/database
chmod -R 775 /var/www/html/database
chmod 664 /var/www/html/database/data/database.sqlite

# Generate key if not set
if ! grep -q "APP_KEY=base64:" /var/www/html/.env || [ -z "$(grep APP_KEY /var/www/html/.env | cut -d '=' -f2)" ]; then
    echo "Generating app key..."
    php artisan key:generate --force
fi

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed database if no admin users exist
echo "Checking if database needs seeding..."
if ADMIN_COUNT=$(php artisan tinker --execute="echo DB::table('admin_users')->count();" 2>/dev/null); then
    ADMIN_COUNT=$(echo "$ADMIN_COUNT" | tr -d '[:space:]')
else
    ADMIN_COUNT=0
fi

if [ "$ADMIN_COUNT" = "0" ]; then
    echo "No admin users found. Seeding database..."
    php artisan db:seed --force
else
    echo "Database already contains admin users ($ADMIN_COUNT). Skipping seed."
fi

# Optimize Laravel application (package discovery, caching config, routes, views)
echo "Running package discovery..."
php artisan package:discover --ansi

echo "Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set final permissions for runtime
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/database
chown -R www-data:www-data /var/www/html/public/uploads
chown www-data:www-data /var/www/html/.env
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/database
chmod -R 775 /var/www/html/public/uploads
chmod 664 /var/www/html/database/data/database.sqlite
chmod 664 /var/www/html/.env

# Execute CMD (starts apache2-foreground)
echo "Starting Apache..."
exec apache2-foreground
