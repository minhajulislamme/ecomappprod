#!/bin/bash

# Production build steps
echo "Building for production..."
npm run build
composer install --optimize-autoloader --no-dev

# Pre-generate key and cache files
php artisan key:generate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Install database tools for schema dumps
echo "Installing database tools..."
composer require laravel/database-tools --dev

# Create database dump directory
mkdir -p database/dumps

# Create database dump
echo "Creating database dump..."
php artisan schema:dump > database/dumps/schema.sql
php artisan db:dump > database/dumps/full.sql

# Create root .htaccess for cPanel
echo "Creating root .htaccess..."
cat > .htaccess << EOL
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>

# Prevent directory listing
Options -Indexes

# Block access to sensitive files
<FilesMatch "^\.env|composer\.json|composer\.lock|package\.json|package-lock\.json|webpack\.mix\.js|yarn\.lock|README\.md|phpunit\.xml|docker-compose\.yml">
    Order allow,deny
    Deny from all
</FilesMatch>

# Protect against common vulnerabilities
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>
EOL

# Remove dev dependencies before creating zip
composer install --optimize-autoloader --no-dev

# Create production artifacts
echo "Creating deployment package..."
zip -r deploy.zip . \
    -x ".env" \
    -x "deploy.sh"

# Create deployment instructions for cPanel
cat > DEPLOY.md << EOL
# cPanel Deployment Instructions

1. Login to cPanel
2. Create a new MySQL database and database user
3. Go to File Manager in cPanel
4. Navigate to public_html (or your desired directory)
5. Upload deploy.zip
6. Extract deploy.zip
7. Rename .env.production to .env
8. Edit .env and update:
   - APP_URL=https://your-domain.com
   - DB_DATABASE=your_cpanel_database_name
   - DB_USERNAME=your_cpanel_database_user
   - DB_PASSWORD=your_cpanel_database_password

9. Using File Manager, set permissions:
   - storage/ directory: 755
   - bootstrap/cache directory: 755
   - All files inside storage/ and bootstrap/cache: 644

10. Database Setup in cPanel:
    - Go to phpMyAdmin
    - Import database/dumps/schema.sql for fresh installation
    - Or import database/dumps/full.sql if you want sample data

11. In cPanel PHP Selector:
    - Set PHP version to 8.2
    - Enable required extensions:
      - BCMath
      - Ctype
      - JSON
      - Mbstring
      - OpenSSL
      - PDO
      - PDO_MySQL
      - Tokenizer
      - XML

12. Setup SSL in cPanel if not already done

Note: If you see any errors, check:
- Storage directory permissions
- Database connection in .env
- PHP version and extensions
EOL

echo "Deployment package created successfully!"
echo "Please check DEPLOY.md for cPanel installation instructions."
