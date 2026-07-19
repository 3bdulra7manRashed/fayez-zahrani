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

# Ensure uploads directory exists
mkdir -p /var/www/html/public/uploads

# Generate key if not set
if ! grep -q "APP_KEY=base64:" /var/www/html/.env || [ -z "$(grep APP_KEY /var/www/html/.env | cut -d '=' -f2)" ]; then
    echo "Generating app key..."
    php artisan key:generate --force
fi

# Wait for MySQL to be ready (if connection is mysql)
DB_CONN=$(grep "^DB_CONNECTION=" /var/www/html/.env | cut -d '=' -f2 | tr -d '[:space:]')
if [ "$DB_CONN" = "mysql" ]; then
    echo "Waiting for MySQL database connection..."
    until php -r "
        try {
            \$env = [];
            if (file_exists('.env')) {
                \$lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach (\$lines as \$line) {
                    if (strpos(trim(\$line), '#') === 0) continue;
                    \$parts = explode('=', \$line, 2);
                    if (count(\$parts) === 2) {
                        \$env[trim(\$parts[0])] = trim(\$parts[1], '\"\' ');
                    }
                }
            }
            \$host = \$env['DB_HOST'] ?? '127.0.0.1';
            \$port = \$env['DB_PORT'] ?? '3306';
            \$db   = \$env['DB_DATABASE'] ?? 'laravel';
            \$user = \$env['DB_USERNAME'] ?? 'root';
            \$pass = \$env['DB_PASSWORD'] ?? '';
            
            new PDO(\"mysql:host=\$host;port=\$port;dbname=\$db\", \$user, \$pass);
            exit(0);
        } catch (Exception \$e) {
            exit(1);
        }
    " 2>/dev/null; do
        echo "MySQL is unavailable - sleeping..."
        sleep 2
    done
    echo "MySQL is up and running!"
fi

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed database if no admin users exist
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
chown -R www-data:www-data /var/www/html/public/uploads
chown www-data:www-data /var/www/html/.env
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/public/uploads
chmod 664 /var/www/html/.env

# Execute CMD (starts apache2-foreground)
echo "Starting Apache..."
exec apache2-foreground
