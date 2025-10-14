# ============================================
# Virical Docker Setup Script for Windows
# ============================================

Write-Host ""
Write-Host "============================================"
Write-Host "VIRICAL DOCKER SETUP (Windows)"
Write-Host "============================================"
Write-Host ""

# Check if Docker is running
try {
    docker info | Out-Null
    if ($LASTEXITCODE -ne 0) {
        throw "Docker not running"
    }
} catch {
    Write-Host "❌ Error: Docker is not running. Please start Docker Desktop first." -ForegroundColor Red
    exit 1
}

# Check if we're in the right directory
if (-not (Test-Path "wordpress")) {
    Write-Host "❌ Error: Please run this script from the production-deploy directory" -ForegroundColor Red
    exit 1
}

# Create Docker-specific config
Write-Host "⚙️  Step 1: Creating Docker configuration..." -ForegroundColor Yellow
Set-Location wordpress
Copy-Item wp-config-docker.php wp-config.php
Write-Host "✅ Docker configuration created!" -ForegroundColor Green

# Go back to project root
Set-Location ..

# Build and start containers
Write-Host ""
Write-Host "🐳 Step 2: Building and starting Docker containers..." -ForegroundColor Yellow
docker-compose down --remove-orphans
docker-compose build --no-cache
docker-compose up -d

# Wait for database to be ready
Write-Host ""
Write-Host "⏳ Step 3: Waiting for database to be ready..." -ForegroundColor Yellow
Start-Sleep -Seconds 30

# Import database
Write-Host ""
Write-Host "📦 Step 4: Importing production database..." -ForegroundColor Yellow
Get-Content database/production_database_backup.sql | docker-compose exec -T db mysql -u wordpress -pwordpress_password virical_db

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Database imported successfully!" -ForegroundColor Green
} else {
    Write-Host "⚠️  Database import failed, but containers are running." -ForegroundColor Yellow
}

# Update URLs for localhost
Write-Host ""
Write-Host "🔄 Step 5: Updating URLs for localhost..." -ForegroundColor Yellow
Get-Content database/fix_urls_for_production.sql | docker-compose exec -T db mysql -u wordpress -pwordpress_password virical_db

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ URLs updated successfully!" -ForegroundColor Green
} else {
    Write-Host "⚠️  URL update failed, but you can update manually later." -ForegroundColor Yellow
}

# Set proper permissions
Write-Host ""
Write-Host "🔐 Step 6: Setting file permissions..." -ForegroundColor Yellow
docker-compose exec wordpress chown -R www-data:www-data /var/www/html
docker-compose exec wordpress chmod -R 755 /var/www/html
docker-compose exec wordpress chmod 644 wp-config.php
Write-Host "✅ File permissions set!" -ForegroundColor Green

Write-Host ""
Write-Host "============================================"
Write-Host "✅ DOCKER SETUP COMPLETED!" -ForegroundColor Green
Write-Host "============================================"
Write-Host ""
Write-Host "🌐 Your WordPress site is now running at:" -ForegroundColor Cyan
Write-Host "   Website: http://localhost:8080" -ForegroundColor White
Write-Host "   Admin:   http://localhost:8080/wp-admin" -ForegroundColor White
Write-Host "   phpMyAdmin: http://localhost:8081" -ForegroundColor White
Write-Host ""
Write-Host "🔑 Login credentials:" -ForegroundColor Cyan
Write-Host "   Username: nguyen" -ForegroundColor White
Write-Host "   Password: admin123" -ForegroundColor White
Write-Host ""
Write-Host "📊 Database credentials:" -ForegroundColor Cyan
Write-Host "   Host: localhost:3306" -ForegroundColor White
Write-Host "   Database: virical_db" -ForegroundColor White
Write-Host "   Username: wordpress" -ForegroundColor White
Write-Host "   Password: wordpress_password" -ForegroundColor White
Write-Host ""
Write-Host "🛠️  Useful commands:" -ForegroundColor Cyan
Write-Host "   Stop:    docker-compose down" -ForegroundColor White
Write-Host "   Start:   docker-compose up -d" -ForegroundColor White
Write-Host "   Logs:    docker-compose logs -f" -ForegroundColor White
Write-Host "   Shell:   docker-compose exec wordpress bash" -ForegroundColor White
Write-Host ""
