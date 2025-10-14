#!/bin/bash
# ============================================
# Virical Local Development Setup Script
# ============================================

echo ""
echo "============================================"
echo "VIRICAL LOCAL DEVELOPMENT SETUP"
echo "============================================"
echo ""

# Check if we're in the right directory
if [ ! -d "wordpress" ]; then
    echo "❌ Error: Please run this script from the production-deploy directory"
    exit 1
fi

# Create local database
echo "📦 Step 1: Creating local database..."
mysql -u root -e "CREATE DATABASE IF NOT EXISTS virical_local CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if [ $? -eq 0 ]; then
    echo "✅ Database 'virical_local' created successfully!"
else
    echo "❌ Database creation failed!"
    exit 1
fi

# Import production database
echo ""
echo "📦 Step 2: Importing production database..."
mysql -u root virical_local < database/production_database_backup.sql

if [ $? -eq 0 ]; then
    echo "✅ Database imported successfully!"
else
    echo "❌ Database import failed!"
    exit 1
fi

# Update URLs for localhost
echo ""
echo "🔄 Step 3: Updating URLs for localhost..."
mysql -u root virical_local < database/fix_urls_for_production.sql

if [ $? -eq 0 ]; then
    echo "✅ URLs updated successfully!"
else
    echo "⚠️  URL update failed! You may need to update URLs manually."
fi

# Create local config
echo ""
echo "⚙️  Step 4: Setting up local configuration..."
cd wordpress
cp wp-config-local.php wp-config.php
echo "✅ Local configuration created!"

# Set permissions
echo ""
echo "🔐 Step 5: Setting file permissions..."
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 600 wp-config.php
echo "✅ File permissions set!"

echo ""
echo "============================================"
echo "✅ LOCAL SETUP COMPLETED!"
echo "============================================"
echo ""
echo "Next steps:"
echo "1. Start the local server: cd wordpress && php -S localhost:8000"
echo "2. Visit: http://localhost:8000"
echo "3. Admin: http://localhost:8000/wp-admin"
echo "4. Login: nguyen / admin123"
echo ""
echo "To stop the server: Press Ctrl+C"
echo ""

