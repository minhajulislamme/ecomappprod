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
