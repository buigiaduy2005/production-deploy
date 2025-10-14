# ============================================
# Fix Docker WordPress Configuration
# ============================================

Write-Host ""
Write-Host "============================================"
Write-Host "FIXING DOCKER CONFIGURATION"
Write-Host "============================================"
Write-Host ""

# Stop containers
Write-Host "🛑 Stopping containers..." -ForegroundColor Yellow
docker-compose down

# Rebuild containers with fixed configuration
Write-Host "🔧 Rebuilding containers with fixed configuration..." -ForegroundColor Yellow
docker-compose build --no-cache

# Start containers
Write-Host "🚀 Starting containers..." -ForegroundColor Yellow
docker-compose up -d

# Wait for services to be ready
Write-Host "⏳ Waiting for services to be ready..." -ForegroundColor Yellow
Start-Sleep -Seconds 30

Write-Host ""
Write-Host "✅ Configuration fixed! Your WordPress site should now work at:" -ForegroundColor Green
Write-Host "   Website: http://localhost:8080" -ForegroundColor White
Write-Host "   Admin:   http://localhost:8080/wp-admin" -ForegroundColor White
Write-Host ""
