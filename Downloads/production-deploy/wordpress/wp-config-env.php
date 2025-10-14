<?php
/**
 * WordPress Configuration using Environment Variables
 * Production-ready configuration for Virical
 * 
 * @package Virical
 * @version 2.0.0
 */

// Load environment helper if available
if (file_exists(__DIR__ . '/wp-env-loader.php')) {
    require_once __DIR__ . '/wp-env-loader.php';
}

// ===================================
// DATABASE CONFIGURATION
// ===================================

/** The name of the database for WordPress */
define('DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'virical_production');

/** Database username */
define('DB_USER', getenv('WORDPRESS_DB_USER') ?: 'virical_user');

/** Database password */
define('DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: '');

/** Database hostname */
define('DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'localhost');

/** Database charset to use in creating database tables */
define('DB_CHARSET', getenv('WORDPRESS_DB_CHARSET') ?: 'utf8mb4');

/** The database collate type */
define('DB_COLLATE', getenv('WORDPRESS_DB_COLLATE') ?: '');

// ===================================
// AUTHENTICATION KEYS AND SALTS
// ===================================

define('AUTH_KEY',         getenv('AUTH_KEY') ?: 'put your unique phrase here');
define('SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY') ?: 'put your unique phrase here');
define('LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY') ?: 'put your unique phrase here');
define('NONCE_KEY',        getenv('NONCE_KEY') ?: 'put your unique phrase here');
define('AUTH_SALT',        getenv('AUTH_SALT') ?: 'put your unique phrase here');
define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT') ?: 'put your unique phrase here');
define('LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT') ?: 'put your unique phrase here');
define('NONCE_SALT',       getenv('NONCE_SALT') ?: 'put your unique phrase here');

// ===================================
// TABLE PREFIX
// ===================================

$table_prefix = getenv('WORDPRESS_TABLE_PREFIX') ?: 'wp_';

// ===================================
// ENVIRONMENT SETTINGS
// ===================================

$environment = getenv('ENVIRONMENT') ?: 'production';

// Site URLs
if (getenv('WORDPRESS_URL')) {
    define('WP_HOME', getenv('WORDPRESS_URL'));
    define('WP_SITEURL', getenv('WORDPRESS_URL'));
} else {
    // Auto-detect URL if not set
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $site_url = $protocol . '://' . $host;
    define('WP_HOME', $site_url);
    define('WP_SITEURL', $site_url);
}

// Debug settings based on environment
switch ($environment) {
    case 'production':
        define('WP_DEBUG', false);
        define('WP_DEBUG_LOG', false);
        define('WP_DEBUG_DISPLAY', false);
        define('SCRIPT_DEBUG', false);
        define('DISALLOW_FILE_EDIT', true);
        define('AUTOMATIC_UPDATER_DISABLED', true);
        break;
    
    case 'staging':
        define('WP_DEBUG', true);
        define('WP_DEBUG_LOG', true);
        define('WP_DEBUG_DISPLAY', false);
        define('SCRIPT_DEBUG', false);
        define('DISALLOW_FILE_EDIT', true);
        break;
    
    case 'development':
    default:
        define('WP_DEBUG', getenv('WP_DEBUG') === 'true');
        define('WP_DEBUG_LOG', getenv('WP_DEBUG_LOG') === 'true');
        define('WP_DEBUG_DISPLAY', getenv('WP_DEBUG_DISPLAY') === 'true');
        define('SCRIPT_DEBUG', true);
        define('SAVEQUERIES', true);
        break;
}

// ===================================
// MEMORY LIMITS
// ===================================

define('WP_MEMORY_LIMIT', getenv('WP_MEMORY_LIMIT') ?: '256M');
define('WP_MAX_MEMORY_LIMIT', getenv('WP_MAX_MEMORY_LIMIT') ?: '512M');

// ===================================
// SSL CONFIGURATION
// ===================================

if ($environment === 'production' || getenv('FORCE_SSL_ADMIN') === 'true') {
    define('FORCE_SSL_ADMIN', true);
    define('FORCE_SSL_LOGIN', true);
}

// ===================================
// FILE SYSTEM
// ===================================

define('FS_METHOD', getenv('FS_METHOD') ?: 'direct');

// Windows hosting specific
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    define('WP_TEMP_DIR', ABSPATH . 'wp-content/temp/');
}

if (getenv('FS_CHMOD_DIR')) {
    define('FS_CHMOD_DIR', octdec(getenv('FS_CHMOD_DIR')));
}

if (getenv('FS_CHMOD_FILE')) {
    define('FS_CHMOD_FILE', octdec(getenv('FS_CHMOD_FILE')));
}

// ===================================
// AUTO UPDATES
// ===================================

if (getenv('AUTOMATIC_UPDATER_DISABLED') === 'true') {
    define('AUTOMATIC_UPDATER_DISABLED', true);
}

if (getenv('WP_AUTO_UPDATE_CORE')) {
    define('WP_AUTO_UPDATE_CORE', getenv('WP_AUTO_UPDATE_CORE'));
}

// ===================================
// MULTISITE
// ===================================

if (getenv('WP_ALLOW_MULTISITE') === 'true') {
    define('WP_ALLOW_MULTISITE', true);
}

// ===================================
// CUSTOM CONSTANTS
// ===================================

// Content directories
define('WP_CONTENT_DIR', __DIR__ . '/wp-content');
define('WP_CONTENT_URL', WP_HOME . '/wp-content');

// Upload directory
define('UPLOADS', 'wp-content/uploads');

// Plugin directory
define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');
define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');

// Theme directory
define('WP_DEFAULT_THEME', 'virical-theme');

// ===================================
// PERFORMANCE
// ===================================

// Limit post revisions
define('WP_POST_REVISIONS', $environment === 'production' ? 5 : true);

// Autosave interval
define('AUTOSAVE_INTERVAL', 300); // 5 minutes

// Empty trash
define('EMPTY_TRASH_DAYS', 30);

// ===================================
// SECURITY
// ===================================

// Cookie settings
define('COOKIE_DOMAIN', getenv('COOKIE_DOMAIN') ?: '');
define('COOKIEPATH', '/');
define('SITECOOKIEPATH', '/');

// Admin cookie path
define('ADMIN_COOKIE_PATH', SITECOOKIEPATH . 'wp-admin');

// Disable XML-RPC if not needed (set via constant instead of filter)
if ($environment === 'production') {
    // XML-RPC will be disabled via plugin or functions.php
    define('XMLRPC_REQUEST', false);
}

// ===================================
// ABSOLUTE PATH
// ===================================

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

// ===================================
// CUSTOM FUNCTIONS
// ===================================

/**
 * Get environment variable with fallback
 */
if (!function_exists('wp_get_env')) {
    function wp_get_env($key, $default = null) {
        $value = getenv($key);
        return $value !== false ? $value : $default;
    }
}

/**
 * Check if running in container
 */
if (!function_exists('is_container')) {
    function is_container() {
        return file_exists('/.dockerenv') || getenv('KUBERNETES_SERVICE_HOST');
    }
}

/**
 * Get container path or local path
 */
if (!function_exists('get_runtime_path')) {
    function get_runtime_path() {
        return is_container() ? '/var/www/html' : ABSPATH;
    }
}

// ===================================
// LOAD WORDPRESS
// ===================================

/** Sets up WordPress vars and included files */
require_once ABSPATH . 'wp-settings.php';