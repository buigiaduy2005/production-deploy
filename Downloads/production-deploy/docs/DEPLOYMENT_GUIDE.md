# 🚀 VIRICAL PRODUCTION DEPLOYMENT GUIDE

**Version:** 1.0.0  
**Date:** 2025-09-30  
**Status:** Ready for Production

---

## 📦 PACKAGE CONTENTS

```
production-deploy/
├── database/
│   ├── production_database_backup.sql    # Full database dump (188KB)
│   └── fix_urls_for_production.sql       # URL update script
├── wordpress/                             # Complete WordPress installation (2.4GB)
│   ├── wp-config-production.php          # Production config template
│   ├── wp-content/                       # Themes, plugins, uploads
│   └── [all WordPress core files]
├── scripts/
│   └── import-database.sh                # Automated database import script
└── docs/
    └── DEPLOYMENT_GUIDE.md               # This file
```

---

## ⚡ QUICK START (5 MINUTES)

### 1️⃣ Upload Files to Hosting
```bash
# Using FTP/SFTP
# Upload contents of 'wordpress/' folder to your web root
# Example: public_html/ or www/ or htdocs/
```

### 2️⃣ Create Database
```sql
-- In your hosting control panel (phpMyAdmin, cPanel, etc.)
CREATE DATABASE virical_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3️⃣ Import Database
```bash
# Option A: Using script (Linux/Mac)
cd scripts/
./import-database.sh

# Option B: Manual import via phpMyAdmin
# 1. Open phpMyAdmin
# 2. Select your database
# 3. Click "Import"
# 4. Upload production_database_backup.sql
# 5. Click "Go"
# 6. Run fix_urls_for_production.sql the same way
```

### 4️⃣ Configure WordPress
```bash
# 1. Rename wp-config-production.php to wp-config.php
mv wp-config-production.php wp-config.php

# 2. Edit wp-config.php and update:
#    - Database credentials (lines 15-18)
#    - Security keys (lines 26-33) - Get from https://api.wordpress.org/secret-key/1.1/salt/
#    - Site URL if different from virical.vn (lines 39-40)
```

### 5️⃣ Test Website
```
Visit: https://virical.vn
Admin: https://virical.vn/wp-admin
```

---

## 🔧 DETAILED DEPLOYMENT STEPS

### Step 1: Pre-Deployment Checklist

- [ ] **Hosting Requirements Met**
  - PHP 8.2 or higher
  - MySQL 8.0 or MariaDB 10.5+
  - Apache 2.4+ or Nginx
  - mod_rewrite enabled (Apache)
  - HTTPS/SSL certificate installed
  - Minimum 512MB PHP memory_limit
  - Max execution time 300 seconds

- [ ] **Domain Configuration**
  - DNS A record pointing to hosting IP
  - SSL certificate valid
  - Domain resolving correctly

- [ ] **Database Ready**
  - Database created with utf8mb4_unicode_ci collation
  - Database user created with full privileges
  - Database credentials noted

- [ ] **Backup Plan**
  - Backup existing site (if migrating)
  - Document rollback procedures

### Step 2: File Upload

**Method A: FTP/SFTP (Recommended for large files)**
```bash
# Using FileZilla or similar FTP client
1. Connect to your hosting via FTP/SFTP
2. Navigate to web root (usually public_html/ or www/)
3. Upload entire contents of wordpress/ folder
4. Wait for upload to complete (may take 30-60 minutes)
5. Verify all files uploaded (2.4GB total)
```

**Method B: SSH/SCP (Fastest for VPS/Dedicated)**
```bash
# Compress the package first
tar -czf virical-deploy.tar.gz wordpress/

# Upload to server
scp virical-deploy.tar.gz user@yourserver.com:/path/to/webroot/

# On server: extract
ssh user@yourserver.com
cd /path/to/webroot/
tar -xzf virical-deploy.tar.gz
mv wordpress/* .
rmdir wordpress
rm virical-deploy.tar.gz
```

**Method C: Hosting Control Panel (cPanel/Plesk)**
```bash
1. Create virical-deploy.zip from wordpress/ folder
2. Upload via cPanel File Manager
3. Extract using File Manager's extract feature
4. Move files from wordpress/ to root if needed
```

### Step 3: Database Import

**Method A: Automated Script (Linux/Mac hosting with SSH)**
```bash
# Upload scripts/ folder to your server
cd scripts/
chmod +x import-database.sh
./import-database.sh

# Follow prompts:
# - Database name
# - Database user
# - Database password
# - Database host (usually localhost)
```

**Method B: Manual via phpMyAdmin**
```
1. Log into phpMyAdmin from hosting control panel
2. Select your database from left sidebar
3. Click "Import" tab
4. Choose file: production_database_backup.sql
5. Scroll down and click "Go"
6. Wait for import to complete (should take 5-10 seconds)
7. Success message should appear
8. Repeat steps 3-7 with fix_urls_for_production.sql
9. Verify URLs updated by running:
   SELECT option_value FROM wp_options WHERE option_name IN ('siteurl', 'home');
```

**Method C: Command Line (SSH access)**
```bash
cd database/
mysql -u YOUR_USER -p YOUR_DATABASE < production_database_backup.sql
mysql -u YOUR_USER -p YOUR_DATABASE < fix_urls_for_production.sql

# Verify
mysql -u YOUR_USER -p YOUR_DATABASE -e "SELECT option_value FROM wp_options WHERE option_name='home';"
```

### Step 4: WordPress Configuration

**4.1 Generate New Security Keys**
```bash
# Visit: https://api.wordpress.org/secret-key/1.1/salt/
# Copy the 8 lines generated
```

**4.2 Update wp-config.php**
```bash
# Rename the production config
mv wp-config-production.php wp-config.php

# Edit wp-config.php
nano wp-config.php  # or use your preferred editor
```

**4.3 Update These Sections:**

**Database Credentials (Lines 15-18):**
```php
define('DB_NAME', 'your_actual_database_name');
define('DB_USER', 'your_actual_database_user');
define('DB_PASSWORD', 'your_actual_database_password');
define('DB_HOST', 'localhost'); // or your DB host
```

**Security Keys (Lines 26-33):**
```php
// Paste the 8 lines from WordPress API here
define('AUTH_KEY',         'paste-your-unique-key-here');
define('SECURE_AUTH_KEY',  'paste-your-unique-key-here');
define('LOGGED_IN_KEY',    'paste-your-unique-key-here');
define('NONCE_KEY',        'paste-your-unique-key-here');
define('AUTH_SALT',        'paste-your-unique-key-here');
define('SECURE_AUTH_SALT', 'paste-your-unique-key-here');
define('LOGGED_IN_SALT',   'paste-your-unique-key-here');
define('NONCE_SALT',       'paste-your-unique-key-here');
```

**Site URL (Lines 39-40):**
```php
// If using custom domain or subdomain, update:
define('WP_HOME', 'https://virical.vn');
define('WP_SITEURL', 'https://virical.vn');
```

**4.4 Set File Permissions**
```bash
# Recommended permissions for security
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 600 wp-config.php
```

### Step 5: Web Server Configuration

**For Apache (.htaccess - already included)**
```apache
# The .htaccess file is already included in the package
# Verify it exists and mod_rewrite is enabled

# If permalinks don't work, add to .htaccess:
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
```

**For Nginx (Add to server block)**
```nginx
server {
    listen 80;
    server_name virical.vn www.virical.vn;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name virical.vn www.virical.vn;
    
    root /path/to/wordpress;
    index index.php index.html;
    
    # SSL certificates
    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    
    location / {
        try_files $uri $uri/ /index.php?$args;
    }
    
    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

### Step 6: Testing & Verification

**6.1 Homepage Test**
```
✓ Visit: https://virical.vn
✓ Check all sections load
✓ Verify images display
✓ Test navigation menu
✓ Check Vietnamese text renders correctly
```

**6.2 Admin Panel Test**
```
✓ Visit: https://virical.vn/wp-admin
✓ Login with: nguyen / admin123
✓ Change admin password immediately!
✓ Verify dashboard loads
✓ Check all menu items accessible
```

**6.3 Pages Test**
```
✓ Homepage: https://virical.vn/
✓ Smart Solutions: https://virical.vn/giai-phap-thong-minh/
✓ Contact: https://virical.vn/lien-he/
✓ Products: https://virical.vn/san-pham/
✓ Projects: https://virical.vn/cong-trinh/
```

**6.4 Functionality Test**
```
✓ Contact form submission
✓ Product search
✓ Menu navigation
✓ Responsive design (mobile/tablet)
✓ Page load speed < 3 seconds
✓ SSL certificate valid
```

**6.5 Security Test**
```
✓ wp-admin accessible only via HTTPS
✓ Theme editor disabled
✓ No PHP errors displayed
✓ File permissions correct
✓ Database credentials secure
```

---

## 🔐 POST-DEPLOYMENT SECURITY

### Immediate Actions (Do These First!)

1. **Change Admin Password**
```
Dashboard → Users → Edit nguyen
Set strong password (20+ characters, mixed case, numbers, symbols)
```

2. **Create New Admin User (Recommended)**
```
Dashboard → Users → Add New
Username: your_username (NOT "admin")
Email: your_secure_email
Role: Administrator
```

3. **Delete Default Admin (Optional)**
```
# After creating new admin user
Dashboard → Users → Delete nguyen
Attribute posts to new admin
```

4. **Update Company Information**
```
# WordPress options are now centralized (Phase 2)
# To update phone, email, address, etc.:

Dashboard → Virical Settings (future feature)
OR
Run SQL queries:
UPDATE wp_options SET option_value='new_phone' WHERE option_name='virical_company_phone';
UPDATE wp_options SET option_value='new_email' WHERE option_name='virical_company_email';
```

5. **Install Security Plugins (Recommended)**
```
- Wordfence Security
- iThemes Security
- All In One WP Security
- Limit Login Attempts Reloaded
```

6. **Enable Automatic Backups**
```
- UpdraftPlus
- BackWPup
- VaultPress (Jetpack)
Configure daily database backups
Configure weekly file backups
```

---

## 🐛 TROUBLESHOOTING

### Issue 1: "Error Establishing Database Connection"

**Cause:** Wrong database credentials or database not accessible

**Solution:**
```php
// Verify wp-config.php credentials
define('DB_NAME', 'correct_name');
define('DB_USER', 'correct_user');
define('DB_PASSWORD', 'correct_password');
define('DB_HOST', 'localhost'); // try 127.0.0.1 if localhost fails

// Test database connection
mysql -u YOUR_USER -p -h localhost YOUR_DATABASE
```

### Issue 2: White Screen / 500 Error

**Cause:** PHP errors, memory limit, or permission issues

**Solution:**
```bash
# Check error logs
tail -f /var/log/apache2/error.log  # Apache
tail -f /var/log/nginx/error.log    # Nginx

# Increase PHP memory limit in wp-config.php
define('WP_MEMORY_LIMIT', '512M');

# Fix file permissions
chmod 755 wp-content/
chmod 644 wp-config.php
```

### Issue 3: 404 on Pages (Except Homepage)

**Cause:** Permalink structure not working

**Solution:**
```bash
# Apache: Enable mod_rewrite
sudo a2enmod rewrite
sudo service apache2 restart

# Verify .htaccess exists and is readable
ls -la .htaccess

# Regenerate permalinks
Dashboard → Settings → Permalinks → Save Changes (without changing anything)
```

### Issue 4: Images Not Loading

**Cause:** Wrong URLs or missing files

**Solution:**
```sql
-- Verify URLs in database
SELECT option_value FROM wp_options WHERE option_name='home';

-- Should show: https://virical.vn

-- Check wp-content/uploads/ directory exists
ls -la wp-content/uploads/

-- Fix permissions
chmod 755 wp-content/uploads/
```

### Issue 5: Admin Panel Redirect Loop

**Cause:** SSL/HTTPS configuration mismatch

**Solution:**
```php
// Add to wp-config.php (before "require_once(ABSPATH...")
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
```

### Issue 6: Vietnamese Characters Display as ��

**Cause:** Database charset not utf8mb4

**Solution:**
```sql
-- Convert database to utf8mb4
ALTER DATABASE your_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Convert all tables
ALTER TABLE wp_posts CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE wp_postmeta CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- Repeat for all tables

-- Verify wp-config.php
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');
```

---

## 📊 DEPLOYMENT VERIFICATION CHECKLIST

Use this checklist to verify successful deployment:

### Pre-Deployment
- [ ] Backup existing site (if applicable)
- [ ] DNS propagation complete (if new domain)
- [ ] SSL certificate installed and valid
- [ ] Hosting meets requirements (PHP 8.2+, MySQL 8.0+)
- [ ] Database created with utf8mb4 charset
- [ ] FTP/SSH access verified

### During Deployment
- [ ] All WordPress files uploaded (2.4GB)
- [ ] Database backup imported (188KB)
- [ ] URL update script executed
- [ ] wp-config.php configured correctly
- [ ] Security keys generated and added
- [ ] File permissions set correctly

### Post-Deployment
- [ ] Homepage loads successfully
- [ ] All pages accessible (no 404s)
- [ ] Images display correctly
- [ ] Vietnamese text renders properly
- [ ] Admin panel accessible via HTTPS
- [ ] Contact forms work
- [ ] Navigation menus work
- [ ] Product pages load
- [ ] Project pages load
- [ ] Responsive design works (mobile/tablet)
- [ ] SSL certificate shows valid
- [ ] Page load speed < 3 seconds

### Security
- [ ] Admin password changed
- [ ] New admin user created (optional)
- [ ] Default "nguyen" user deleted (optional)
- [ ] Theme/plugin editor disabled
- [ ] Security plugin installed
- [ ] Automatic backups configured
- [ ] File permissions verified (755/644)
- [ ] wp-config.php permissions set to 600
- [ ] Database credentials secure

### Performance
- [ ] Caching enabled
- [ ] Images optimized
- [ ] Unused plugins deactivated
- [ ] Database optimized
- [ ] CDN configured (optional)

---

## 📈 MONITORING & MAINTENANCE

### Daily Tasks
- Monitor uptime and performance
- Check for security alerts
- Review error logs

### Weekly Tasks
- Verify automatic backups ran successfully
- Check for WordPress/plugin/theme updates
- Review site analytics
- Test contact forms
- Scan for malware

### Monthly Tasks
- Update WordPress core
- Update plugins and themes
- Optimize database
- Review security logs
- Test backup restoration
- Check SSL certificate expiry
- Review user accounts

---

## 🆘 SUPPORT & RESOURCES

### Official Documentation
- WordPress Codex: https://codex.wordpress.org/
- WordPress Support: https://wordpress.org/support/
- Theme Documentation: /wordpress/wp-content/themes/virical-theme/README.md

### Security Resources
- WordPress Security Keys: https://api.wordpress.org/secret-key/1.1/salt/
- WPScan Vulnerability Database: https://wpscan.com/
- Sucuri Security Blog: https://blog.sucuri.net/

### Performance Tools
- GTmetrix: https://gtmetrix.com/
- Pingdom: https://tools.pingdom.com/
- Google PageSpeed: https://pagespeed.web.dev/

### Hosting Support
- Consult your hosting provider's documentation
- Contact hosting support for server-specific issues
- Check hosting control panel (cPanel/Plesk) for tools

---

## 📝 REVISION HISTORY

| Version | Date | Changes |
|---------|------|---------|
| 1.0.0 | 2025-09-30 | Initial production deployment package |
| | | - Phase 1: Security & Production Preparation completed |
| | | - Phase 2: Company Information Centralization completed |
| | | - Full database backup (188KB) |
| | | - Complete WordPress files (2.4GB) |
| | | - Automated deployment scripts |

---

## ✅ DEPLOYMENT COMPLETE!

Congratulations! Your Virical website is now live in production.

**Important reminders:**
1. Change default admin password immediately
2. Set up automatic backups
3. Install security monitoring
4. Enable SSL for entire site
5. Test all functionality thoroughly

**Next steps:**
- Monitor site performance for first 24 hours
- Review error logs daily for first week
- Ensure all contact forms deliver emails
- Set up Google Analytics (if not already)
- Configure CDN for better performance (optional)

**Production URLs:**
- Website: https://virical.vn
- Admin: https://virical.vn/wp-admin
- phpMyAdmin: (provided by hosting)

---

**🤖 Generated with [Claude Code](https://claude.com/claude-code)**

**Co-Authored-By: Claude <noreply@anthropic.com>**
