#!/bin/bash
# ============================================
# Virical Docker Setup Script
# ============================================

echo ""
echo "============================================"
echo "VIRICAL DOCKER SETUP"
echo "============================================"
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Error: Docker is not running. Please start Docker Desktop first."
    exit 1
fi

# Check if we're in the right directory
if [ ! -d "wordpress" ]; then
    echo "❌ Error: Please run this script from the production-deploy directory"
    exit 1
fi

# Create Docker-specific config
echo "⚙️  Step 1: Creating Docker configuration..."
cd wordpress
cp wp-config-docker.php wp-config.php
echo "✅ Docker configuration created!"

# Go back to project root
cd ..

# Build and start containers
echo ""
echo "🐳 Step 2: Building and starting Docker containers..."
docker-compose down --remove-orphans
docker-compose build --no-cache
docker-compose up -d

# Wait for database to be ready
echo ""
echo "⏳ Step 3: Waiting for database to be ready..."
sleep 30

# Import database
echo ""
echo "📦 Step 4: Importing production database..."
docker-compose exec -T db mysql -u wordpress -pwordpress_password virical_db < database/production_database_backup.sql

if [ $? -eq 0 ]; then
    echo "✅ Database imported successfully!"
else
    echo "⚠️  Database import failed, but containers are running."
fi

# Update URLs for localhost
echo ""
echo "🔄 Step 5: Updating URLs for localhost..."
docker-compose exec -T db mysql -u wordpress -pwordpress_password virical_db < database/fix_urls_for_production.sql

if [ $? -eq 0 ]; then
    echo "✅ URLs updated successfully!"
else
    echo "⚠️  URL update failed, but you can update manually later."
fi

# Set proper permissions
echo ""
echo "🔐 Step 6: Setting file permissions..."
docker-compose exec wordpress chown -R www-data:www-data /var/www/html
docker-compose exec wordpress chmod -R 755 /var/www/html
docker-compose exec wordpress chmod 644 wp-config.php
echo "✅ File permissions set!"

echo ""
echo "============================================"
echo "✅ DOCKER SETUP COMPLETED!"
echo "============================================"
echo ""
echo "🌐 Your WordPress site is now running at:"
echo "   Website: http://localhost:8080"
echo "   Admin:   http://localhost:8080/wp-admin"
echo "   phpMyAdmin: http://localhost:8081"
echo ""
echo "🔑 Login credentials:"
echo "   Username: nguyen"
echo "   Password: admin123"
echo ""
echo "📊 Database credentials:"
echo "   Host: localhost:3306"
echo "   Database: virical_db"
echo "   Username: wordpress"
echo "   Password: wordpress_password"
echo ""
echo "🛠️  Useful commands:"
echo "   Stop:    docker-compose down"
echo "   Start:   docker-compose up -d"
echo "   Logs:    docker-compose logs -f"
echo "   Shell:   docker-compose exec wordpress bash"
echo ""

