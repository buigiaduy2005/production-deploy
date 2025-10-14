<?php
/**
 * WordPress Production Configuration
 *
 * IMPORTANT: Rename this file to wp-config.php after updating the values below
 *
 * @package Virical
 * @version 1.0.0
 */

// ============================================
// STEP 1: UPDATE DATABASE CREDENTIALS
// ============================================
// Get these from your hosting provider
define('DB_NAME', 'YOUR_DATABASE_NAME');        // Database name
define('DB_USER', 'YOUR_DATABASE_USER');        // Database username
define('DB_PASSWORD', 'YOUR_DATABASE_PASSWORD'); // Database password
define('DB_HOST', 'localhost');                  // Usually 'localhost' or IP address
define('DB_CHARSET', 'utf8mb4');                 // DO NOT CHANGE - Vietnamese support
define('DB_COLLATE', 'utf8mb4_unicode_ci');      // DO NOT CHANGE - Vietnamese support

// ============================================
// STEP 2: GENERATE NEW SECURITY KEYS
// ============================================
// Visit: https://api.wordpress.org/secret-key/1.1/salt/
// Copy and paste the generated keys below

define('AUTH_KEY',         'REPLACE_WITH_NEW_KEY_FROM_WORDPRESS_API');
define('SECURE_AUTH_KEY',  'REPLACE_WITH_NEW_KEY_FROM_WORDPRESS_API');
define('LOGGED_IN_KEY',    'REPLACE_WITH_NEW_KEY_FROM_WORDPRESS_API');
define('NONCE_KEY',        'REPLACE_WITH_NEW_KEY_FROM_WORDPRESS_API');
define('AUTH_SALT',        'REPLACE_WITH_NEW_KEY_FROM_WORDPRESS_API');
define('SECURE_AUTH_SALT', 'REPLACE_WITH_NEW_KEY_FROM_WORDPRESS_API');
define('LOGGED_IN_SALT',   'REPLACE_WITH_NEW_KEY_FROM_WORDPRESS_API');
define('NONCE_SALT',       'REPLACE_WITH_NEW_KEY_FROM_WORDPRESS_API');

// ============================================
// STEP 3: UPDATE SITE URL
// ============================================
// Your production domain (without trailing slash)
define('WP_HOME', 'https://virical.vn');
define('WP_SITEURL', 'https://virical.vn');

// ============================================
// WORDPRESS DATABASE TABLE PREFIX
// ============================================
$table_prefix = 'wp_';

// ============================================
// PRODUCTION SETTINGS
// ============================================
// Disable debug mode in production
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);

// Performance optimizations
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');
define('WP_CACHE', true);
define('COMPRESS_CSS', true);
define('COMPRESS_SCRIPTS', true);
define('CONCATENATE_SCRIPTS', true);
define('ENFORCE_GZIP', true);

// Security enhancements
define('DISALLOW_FILE_EDIT', true);  // Disable theme/plugin editor
define('DISALLOW_FILE_MODS', false); // Allow plugin/theme updates
define('FORCE_SSL_ADMIN', true);     // Force SSL for admin
define('WP_POST_REVISIONS', 5);      // Limit post revisions
define('AUTOSAVE_INTERVAL', 300);    // Autosave every 5 minutes
define('EMPTY_TRASH_DAYS', 30);      // Empty trash after 30 days

// Cookie settings for better security
define('COOKIE_DOMAIN', 'virical.vn');
define('COOKIEPATH', '/');
define('SITECOOKIEPATH', '/');
define('ADMIN_COOKIE_PATH', '/wp-admin');

// ============================================
// OPTIONAL: FTP/SFTP SETTINGS (if needed)
// ============================================
// Uncomment and configure if your host requires FTP for updates
// define('FS_METHOD', 'direct'); // or 'ftpext', 'ftpsockets', 'ssh2'
// define('FTP_HOST', 'ftp.virical.vn');
// define('FTP_USER', 'your_ftp_username');
// define('FTP_PASS', 'your_ftp_password');
// define('FTP_SSL', true);

// ============================================
// MULTISITE (if needed in future)
// ============================================
// define('WP_ALLOW_MULTISITE', false);

// ============================================
// DO NOT EDIT BELOW THIS LINE
// ============================================
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

require_once(ABSPATH . 'wp-settings.php');
