<?php
/**
 * WordPress Local Development Configuration
 *
 * This file is for local development only.
 * Based on the production config but optimized for localhost.
 *
 * @package Virical
 * @version 1.0.0
 */

// ============================================
// LOCAL DATABASE CREDENTIALS
// ============================================
define('DB_NAME', 'virical_local');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

// ============================================
// LOCAL SECURITY KEYS (Development Only)
// ============================================
define('AUTH_KEY',         'local-dev-key-1');
define('SECURE_AUTH_KEY',  'local-dev-key-2');
define('LOGGED_IN_KEY',    'local-dev-key-3');
define('NONCE_KEY',        'local-dev-key-4');
define('AUTH_SALT',        'local-dev-salt-1');
define('SECURE_AUTH_SALT', 'local-dev-salt-2');
define('LOGGED_IN_SALT',   'local-dev-salt-3');
define('NONCE_SALT',       'local-dev-salt-4');

// ============================================
// LOCAL SITE URL
// ============================================
define('WP_HOME', 'http://localhost:8000');
define('WP_SITEURL', 'http://localhost:8000');

// ============================================
// WORDPRESS DATABASE TABLE PREFIX
// ============================================
$table_prefix = 'wp_';

// ============================================
// LOCAL DEVELOPMENT SETTINGS
// ============================================
// Enable debug mode for local development
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);
@ini_set('display_errors', 1);

// Performance settings for local development
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// Security settings (relaxed for local development)
define('DISALLOW_FILE_EDIT', false);  // Allow theme/plugin editor
define('DISALLOW_FILE_MODS', false);  // Allow plugin/theme updates
define('FORCE_SSL_ADMIN', false);     // Don't force SSL for localhost

// Cookie settings for localhost
define('COOKIE_DOMAIN', 'localhost');
define('COOKIEPATH', '/');
define('SITECOOKIEPATH', '/');
define('ADMIN_COOKIE_PATH', '/wp-admin');

// ============================================
// DO NOT EDIT BELOW THIS LINE
// ============================================
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

require_once(ABSPATH . 'wp-settings.php');

