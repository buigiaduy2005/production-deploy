# 🐳 Virical WordPress Docker Setup

This guide will help you run the Virical WordPress project locally using Docker.

## 🚀 Quick Start

### Prerequisites
- Docker Desktop installed and running
- Git (optional, for cloning)

### 1. Run the Setup Script
```bash
chmod +x docker-setup.sh
./docker-setup.sh
```

### 2. Access Your Site
- **Website**: http://localhost:8080
- **Admin Panel**: http://localhost:8080/wp-admin
- **phpMyAdmin**: http://localhost:8081

### 3. Login Credentials
- **Username**: nguyen
- **Password**: admin123

## 🛠️ Manual Setup (Alternative)

If the script doesn't work, you can run the commands manually:

```bash
# 1. Create Docker config
cd wordpress
cp wp-config-docker.php wp-config.php
cd ..

# 2. Build and start containers
docker-compose up -d --build

# 3. Wait for database to be ready (30 seconds)
sleep 30

# 4. Import database
docker-compose exec -T db mysql -u wordpress -pwordpress_password virical_db < database/production_database_backup.sql

# 5. Update URLs
docker-compose exec -T db mysql -u wordpress -pwordpress_password virical_db < database/fix_urls_for_production.sql
```

## 📊 Services Included

| Service | Port | Description |
|---------|------|-------------|
| WordPress | 8080 | Main website |
| MySQL | 3306 | Database |
| phpMyAdmin | 8081 | Database management |

## 🔧 Useful Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Access WordPress container
docker-compose exec wordpress bash

# Access database
docker-compose exec db mysql -u wordpress -pwordpress_password virical_db

# Rebuild containers
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

## 🗄️ Database Information

- **Host**: localhost:3306
- **Database**: virical_db
- **Username**: wordpress
- **Password**: wordpress_password
- **Root Password**: root_password

## 🐛 Troubleshooting

### Containers won't start
```bash
# Check Docker is running
docker info

# Check for port conflicts
lsof -i :8080
lsof -i :8081
lsof -i :3306
```

### Database connection issues
```bash
# Check database container
docker-compose logs db

# Test database connection
docker-compose exec db mysql -u wordpress -pwordpress_password -e "SELECT 1;"
```

### WordPress not loading
```bash
# Check WordPress container
docker-compose logs wordpress

# Check file permissions
docker-compose exec wordpress ls -la /var/www/html/
```

### Reset everything
```bash
# Stop and remove everything
docker-compose down -v
docker system prune -f

# Start fresh
./docker-setup.sh
```

## 📁 Project Structure

```
production-deploy/
├── docker-compose.yml          # Docker services configuration
├── Dockerfile                  # WordPress container definition
├── docker-setup.sh              # Automated setup script
├── .dockerignore              # Files to ignore in Docker build
├── database/                   # Database files
│   ├── production_database_backup.sql
│   └── fix_urls_for_production.sql
└── wordpress/                  # WordPress files
    ├── wp-config-docker.php   # Docker-specific config
    └── [WordPress core files]
```

## 🎯 What's Included

- **WordPress 6.4** with PHP 8.2
- **MySQL 8.0** database
- **phpMyAdmin** for database management
- **Production database** with all content
- **Custom Virical theme**
- **All plugins and uploads**
- **Vietnamese language support**

## 🔐 Security Notes

This setup is for **local development only**. For production:

1. Change all default passwords
2. Generate new security keys
3. Use environment variables for secrets
4. Enable SSL/HTTPS
5. Set up proper file permissions
6. Configure firewall rules

## 📞 Support

If you encounter issues:

1. Check Docker Desktop is running
2. Ensure ports 8080, 8081, 3306 are available
3. Try rebuilding containers: `docker-compose down && docker-compose up -d --build`
4. Check logs: `docker-compose logs -f`

---

**Happy coding! 🚀**

