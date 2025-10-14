<?php
/**
 * Migration: Create Indoor Page Tables
 * Version: 1.0.0
 * Created: 2024-12-20
 */

if (!defined('ABSPATH')) {
    exit;
}

class Create_Indoor_Tables_Migration {
    
    public static function up() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        
        // 1. Indoor Page Settings Table
        $table_indoor_settings = $wpdb->prefix . 'indoor_page_settings';
        $sql_settings = "CREATE TABLE IF NOT EXISTS $table_indoor_settings (
            id int(11) NOT NULL AUTO_INCREMENT,
            setting_key varchar(100) NOT NULL,
            setting_value longtext,
            setting_type varchar(50) DEFAULT 'text',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY setting_key (setting_key)
        ) $charset_collate;";
        
        // 2. Indoor Product Categories Table
        $table_indoor_categories = $wpdb->prefix . 'indoor_product_categories';
        $sql_categories = "CREATE TABLE IF NOT EXISTS $table_indoor_categories (
            id int(11) NOT NULL AUTO_INCREMENT,
            category_name varchar(255) NOT NULL,
            category_slug varchar(255) NOT NULL,
            display_order int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY category_slug (category_slug)
        ) $charset_collate;";
        
        // 3. Indoor Products Table
        $table_indoor_products = $wpdb->prefix . 'indoor_products';
        $sql_products = "CREATE TABLE IF NOT EXISTS $table_indoor_products (
            id int(11) NOT NULL AUTO_INCREMENT,
            category_id int(11) NOT NULL,
            product_name varchar(255) NOT NULL,
            product_slug varchar(255) NOT NULL,
            product_image varchar(500),
            product_link varchar(500),
            display_order int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY category_id (category_id),
            UNIQUE KEY product_slug (product_slug)
        ) $charset_collate;";
        
        // Execute table creation
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_settings);
        dbDelta($sql_categories);
        dbDelta($sql_products);
        
        return true;
    }
    
    public static function down() {
        global $wpdb;
        
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}indoor_products");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}indoor_product_categories");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}indoor_page_settings");
        
        return true;
    }
}

// Auto-run migration if called directly
if (!function_exists('add_action')) {
    Create_Indoor_Tables_Migration::up();
}