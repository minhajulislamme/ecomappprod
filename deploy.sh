#!/bin/bash

echo "🚀 Starting deployment process..."

# Navigate to the project directory
cd "$(dirname "$0")"

echo "🔑 Generating application key..."
docker-compose exec -T app php artisan key:generate --force

echo "🗄️ Caching configurations..."
docker-compose exec -T app php artisan config:cache
docker-compose exec -T app php artisan route:cache
docker-compose exec -T app php artisan view:cache

# Run database migrations
echo "🔄 Running database migrations..."
docker-compose exec -T app php artisan migrate --force

# Clear caches just to be sure
echo "🧹 Clearing caches..."
docker-compose exec -T app php artisan optimize:clear

# Create database dumps
echo "💾 Creating database dumps..."
docker-compose exec -T app php artisan schema:dump > database/dumps/schema.sql
docker-compose exec -T app php artisan db:dump > database/dumps/full.sql

echo "✅ Deployment completed successfully!"
