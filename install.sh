#!/bin/bash

# Clean up first
sudo chmod -R 777 .
docker-compose down -v
docker system prune -a --volumes -f

# Create necessary directories and set permissions
mkdir -p docker/{nginx/conf.d,php,data/{mysql,redis}} vendor storage/framework/{sessions,views,cache} bootstrap/cache node_modules
chmod -R 777 docker/data/{mysql,redis} vendor storage bootstrap/cache node_modules

# Build and start containers
docker-compose up -d --build

# Wait for containers to be ready
sleep 10

# Install composer dependencies first
echo "Installing Composer dependencies..."
docker-compose exec -T app composer install --no-scripts
docker-compose exec -T app composer dump-autoload

# Set proper permissions
docker-compose exec -T app chown -R www-data:www-data /var/www
docker-compose exec -T app chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Generate environment file
docker-compose exec -T app bash -c 'cat > .env << EOL
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=your_password

SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=redis

CACHE_STORE=redis
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=predis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="\${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="\${APP_NAME}"
EOL'

# Generate app key and clear config
docker-compose exec -T app php artisan key:generate
docker-compose exec -T app php artisan config:clear

# Function to check MySQL connection
check_mysql_connection() {
    docker-compose exec -T mysql mysqladmin ping -h localhost -u root -p"${DB_PASSWORD:-your_password}" --silent
    return $?
}

# Function to initialize database
initialize_database() {
    echo "Initializing database..."
    docker-compose exec -T mysql mysql -u root -p"${DB_PASSWORD:-your_password}" -e "
        CREATE DATABASE IF NOT EXISTS laravel_db;
        CREATE USER IF NOT EXISTS 'laravel_user'@'%' IDENTIFIED BY 'your_password';
        GRANT ALL PRIVILEGES ON laravel_db.* TO 'laravel_user'@'%';
        FLUSH PRIVILEGES;
    "
}

# Wait for MySQL with timeout
echo "Waiting for MySQL to be ready..."
TIMEOUT=120
ELAPSED=0
until check_mysql_connection || [ $ELAPSED -gt $TIMEOUT ]; do
    sleep 5
    ELAPSED=$((ELAPSED + 5))
    echo "Still waiting for MySQL... ($ELAPSED seconds)"
done

if [ $ELAPSED -gt $TIMEOUT ]; then
    echo "Error: MySQL connection timeout"
    exit 1
fi

echo "MySQL is ready!"
initialize_database

# Install Redis and other dependencies
docker-compose exec -T app composer require predis/predis

# Create cache tables first
echo "Creating cache tables..."
docker-compose exec -T app php artisan config:cache
docker-compose exec -T app php artisan cache:table
docker-compose exec -T app php artisan session:table
docker-compose exec -T app php artisan queue:table
docker-compose exec -T app php artisan migrate --force

# Clear all caches with file driver
docker-compose exec -T app bash -c '
sed -i "s/CACHE_DRIVER=.*/CACHE_DRIVER=file/" .env
sed -i "s/SESSION_DRIVER=.*/SESSION_DRIVER=file/" .env
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Switch back to Redis
sed -i "s/CACHE_DRIVER=.*/CACHE_DRIVER=redis/" .env
sed -i "s/SESSION_DRIVER=.*/SESSION_DRIVER=redis/" .env
'

# Run remaining migrations
docker-compose exec -T app php artisan migrate --force

# Setup frontend with proper permissions
echo "Setting up frontend..."
docker-compose exec -T app bash -c '
mkdir -p /var/www/node_modules
chown -R node:node /var/www/node_modules
npm install
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
npm run build
'

echo "Setup completed successfully!"
