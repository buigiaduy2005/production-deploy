<?php
/**
 * WordPress Docker Configuration
 *
 * This file is optimized for Docker development environment.
 *
 * @package Virical
 * @version 1.0.0
 */
// ============================================
// DOCKER HELPER FUNCTION
// ============================================
if (!function_exists('getenv_docker')) {
    function getenv_docker($env, $default) {
        if ($fileEnv = getenv($env . '_FILE')) {
            return rtrim(file_get_contents($fileEnv), "\r\n");
        } else if (($val = getenv($env)) !== false) {
            return $val;
        } else {
            return $default;
        }
    }
}

// ============================================
// DOCKER DATABASE CREDENTIALS
// ============================================
define('DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'virical_db'));
define('DB_USER', getenv_docker('WORDPRESS_DB_USER', 'wordpress'));
define('DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'wordpress_password'));
define('DB_HOST', getenv_docker('WORDPRESS_DB_HOST', 'db:3306'));
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

// ============================================
// DOCKER SECURITY KEYS
// ============================================
define('AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         'docker-auth-key-1'));
define('SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  'docker-secure-auth-key-2'));
define('LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    'docker-logged-in-key-3'));
define('NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        'docker-nonce-key-4'));
define('AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        'docker-auth-salt-1'));
define('SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', 'docker-secure-auth-salt-2'));
define('LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   'docker-logged-in-salt-3'));
define('NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       'docker-nonce-salt-4'));

// ============================================
// DOCKER SITE URL
// ============================================
define('WP_HOME', 'http://localhost:8080');
define('WP_SITEURL', 'http://localhost:8080');

// ============================================
// WORDPRESS DATABASE TABLE PREFIX
// ============================================
$table_prefix = 'wp_';

// ============================================
// DOCKER DEVELOPMENT SETTINGS
// ============================================
define('WP_DEBUG', getenv_docker('WORDPRESS_DEBUG', '1') === '1');
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);
@ini_set('display_errors', 1);

// Performance settings
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// Security settings (relaxed for Docker development)
define('DISALLOW_FILE_EDIT', false);
define('DISALLOW_FILE_MODS', false);
define('FORCE_SSL_ADMIN', false);

// Cookie settings for Docker
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

