#!/bin/bash
# ============================================
# Virical Database Import Script
# ============================================
# This script imports the database and updates URLs
# 
# Usage: ./import-database.sh
#

echo ""
echo "============================================"
echo "VIRICAL DATABASE IMPORT SCRIPT"
echo "============================================"
echo ""

# Check if database credentials are provided
if [ -z "$1" ]; then
    read -p "Database name: " DB_NAME
    read -p "Database user: " DB_USER
    read -sp "Database password: " DB_PASS
    echo ""
    read -p "Database host (default: localhost): " DB_HOST
    DB_HOST=${DB_HOST:-localhost}
else
    DB_NAME=$1
    DB_USER=$2
    DB_PASS=$3
    DB_HOST=${4:-localhost}
fi

# Path to database files
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
DB_DIR="$SCRIPT_DIR/../database"
BACKUP_FILE="$DB_DIR/production_database_backup.sql"
URL_UPDATE_FILE="$DB_DIR/fix_urls_for_production.sql"

echo ""
echo "Database: $DB_NAME"
echo "User: $DB_USER"
echo "Host: $DB_HOST"
echo ""

# Check if backup file exists
if [ ! -f "$BACKUP_FILE" ]; then
    echo "❌ Error: Database backup file not found!"
    echo "   Expected: $BACKUP_FILE"
    exit 1
fi

# Step 1: Import database
echo "📦 Step 1: Importing database backup..."
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$BACKUP_FILE"

if [ $? -eq 0 ]; then
    echo "✅ Database imported successfully!"
else
    echo "❌ Database import failed!"
    exit 1
fi

# Step 2: Update URLs
echo ""
echo "🔄 Step 2: Updating URLs from localhost to production..."
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$URL_UPDATE_FILE"

if [ $? -eq 0 ]; then
    echo "✅ URLs updated successfully!"
else
    echo "⚠️  URL update failed! You may need to run fix_urls_for_production.sql manually."
fi

# Step 3: Verify
echo ""
echo "🔍 Step 3: Verifying database..."
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" -e "SELECT option_value FROM wp_options WHERE option_name IN ('siteurl', 'home');"

echo ""
echo "============================================"
echo "✅ DATABASE IMPORT COMPLETED!"
echo "============================================"
echo ""
echo "Next steps:"
echo "1. Update wp-config.php with database credentials"
echo "2. Generate new security keys"
echo "3. Test the website"
echo ""
