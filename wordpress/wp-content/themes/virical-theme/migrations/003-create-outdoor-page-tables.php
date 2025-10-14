<?php
/**
 * Migration: Create Outdoor Page Tables
 * Version: 1.0.0
 * Created: 2025-01-10
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create tables for outdoor page content
 */
function create_outdoor_page_tables() {
    global $wpdb;
    
    $charset_collate = $wpdb->get_charset_collate();
    
    // Table for outdoor sections
    $table_outdoor_sections = $wpdb->prefix . 'outdoor_sections';
    $sql_sections = "CREATE TABLE IF NOT EXISTS $table_outdoor_sections (
        id INT(11) NOT NULL AUTO_INCREMENT,
        section_name VARCHAR(100) NOT NULL,
        section_title VARCHAR(255),
        section_subtitle VARCHAR(255),
        section_order INT(11) DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_section_order (section_order),
        KEY idx_is_active (is_active)
    ) $charset_collate;";
    
    // Table for outdoor page products (renamed to avoid conflict)
    $table_outdoor_products = $wpdb->prefix . 'outdoor_page_products';
    $sql_products = "CREATE TABLE IF NOT EXISTS $table_outdoor_products (
        id INT(11) NOT NULL AUTO_INCREMENT,
        section_id INT(11) NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        product_image VARCHAR(500),
        product_description TEXT,
        product_order INT(11) DEFAULT 0,
        is_featured TINYINT(1) DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_section_id (section_id),
        KEY idx_product_order (product_order),
        KEY idx_is_active (is_active)
    ) $charset_collate;";
    
    // Table for outdoor page settings
    $table_outdoor_settings = $wpdb->prefix . 'outdoor_page_settings';
    $sql_settings = "CREATE TABLE IF NOT EXISTS $table_outdoor_settings (
        id INT(11) NOT NULL AUTO_INCREMENT,
        setting_key VARCHAR(100) NOT NULL UNIQUE,
        setting_value TEXT,
        setting_type VARCHAR(50) DEFAULT 'text',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY idx_setting_key (setting_key)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    // Execute table creation
    dbDelta($sql_sections);
    dbDelta($sql_products);
    dbDelta($sql_settings);
    
    return true;
}

/**
 * Insert initial data for outdoor page
 */
function populate_outdoor_data() {
    global $wpdb;
    
    $sections_table = $wpdb->prefix . 'outdoor_sections';
    $products_table = $wpdb->prefix . 'outdoor_page_products';
    $settings_table = $wpdb->prefix . 'outdoor_page_settings';
    
    // Check if data already exists
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $sections_table");
    if ($count > 0) {
        return true; // Data already populated
    }
    
    // Insert sections
    $sections = [
        [
            'section_name' => 'banner',
            'section_title' => 'OUTDOOR LIGHTING',
            'section_subtitle' => 'SPOTLIGHTS AND BOLLARDS',
            'section_order' => 1,
            'is_active' => 1
        ],
        [
            'section_name' => 'spotlight_garden',
            'section_title' => 'Spotlight garden',
            'section_subtitle' => '',
            'section_order' => 2,
            'is_active' => 1
        ],
        [
            'section_name' => 'inground',
            'section_title' => 'Inground',
            'section_subtitle' => '',
            'section_order' => 3,
            'is_active' => 1
        ],
        [
            'section_name' => 'bollard',
            'section_title' => 'Bollard',
            'section_subtitle' => '',
            'section_order' => 4,
            'is_active' => 1
        ],
        [
            'section_name' => 'linear',
            'section_title' => 'Linear',
            'section_subtitle' => '',
            'section_order' => 5,
            'is_active' => 1
        ]
    ];
    
    foreach ($sections as $section) {
        $wpdb->insert($sections_table, $section);
    }
    
    // Get section IDs
    $spotlight_id = $wpdb->get_var("SELECT id FROM $sections_table WHERE section_name = 'spotlight_garden'");
    $inground_id = $wpdb->get_var("SELECT id FROM $sections_table WHERE section_name = 'inground'");
    $bollard_id = $wpdb->get_var("SELECT id FROM $sections_table WHERE section_name = 'bollard'");
    $linear_id = $wpdb->get_var("SELECT id FROM $sections_table WHERE section_name = 'linear'");
    
    // Insert products
    $products = [
        // Spotlight Garden products
        [
            'section_id' => $spotlight_id,
            'product_name' => 'Spotlight HI-00125',
            'product_image' => '/wp-content/uploads/outdoor/HI_00125-1024x1024.png',
            'product_description' => 'High quality spotlight for garden illumination',
            'product_order' => 1,
            'is_featured' => 1,
            'is_active' => 1
        ],
        [
            'section_id' => $spotlight_id,
            'product_name' => 'Spot Garden 2',
            'product_image' => '/wp-content/uploads/outdoor/Spotgarden2.jpg',
            'product_description' => 'Premium garden spotlight with adjustable beam',
            'product_order' => 2,
            'is_featured' => 0,
            'is_active' => 1
        ],
        [
            'section_id' => $spotlight_id,
            'product_name' => 'Spot 2',
            'product_image' => '/wp-content/uploads/outdoor/spot2.jpg',
            'product_description' => 'Compact spotlight for accent lighting',
            'product_order' => 3,
            'is_featured' => 0,
            'is_active' => 1
        ],
        
        // Inground products
        [
            'section_id' => $inground_id,
            'product_name' => 'Inground Light 1',
            'product_image' => '/wp-content/uploads/outdoor/Inground1.jpg',
            'product_description' => 'Durable inground light for pathways',
            'product_order' => 1,
            'is_featured' => 1,
            'is_active' => 1
        ],
        [
            'section_id' => $inground_id,
            'product_name' => 'Inground Light 3',
            'product_image' => '/wp-content/uploads/outdoor/Inground3-1024x1024.jpg',
            'product_description' => 'High power inground uplight',
            'product_order' => 2,
            'is_featured' => 0,
            'is_active' => 1
        ],
        [
            'section_id' => $inground_id,
            'product_name' => 'Inground Light 9',
            'product_image' => '/wp-content/uploads/outdoor/Inground9.jpg',
            'product_description' => 'Decorative inground light with RGB options',
            'product_order' => 3,
            'is_featured' => 0,
            'is_active' => 1
        ],
        
        // Bollard products
        [
            'section_id' => $bollard_id,
            'product_name' => 'Bollard Light 1',
            'product_image' => '/wp-content/uploads/outdoor/bollard1.png',
            'product_description' => 'Modern bollard light for pathways',
            'product_order' => 1,
            'is_featured' => 1,
            'is_active' => 1
        ],
        [
            'section_id' => $bollard_id,
            'product_name' => 'Bollard Light 2',
            'product_image' => '/wp-content/uploads/outdoor/bollard2.png',
            'product_description' => 'Classic bollard design with LED technology',
            'product_order' => 2,
            'is_featured' => 0,
            'is_active' => 1
        ],
        [
            'section_id' => $bollard_id,
            'product_name' => 'Bollard Light 3',
            'product_image' => '/wp-content/uploads/outdoor/bollard3.png',
            'product_description' => 'Architectural bollard light',
            'product_order' => 3,
            'is_featured' => 0,
            'is_active' => 1
        ],
        [
            'section_id' => $bollard_id,
            'product_name' => 'Bollard Light 4',
            'product_image' => '/wp-content/uploads/outdoor/bollard4.png',
            'product_description' => 'Energy efficient bollard with solar option',
            'product_order' => 4,
            'is_featured' => 0,
            'is_active' => 1
        ],
        
        // Linear products
        [
            'section_id' => $linear_id,
            'product_name' => 'Linear Light System',
            'product_image' => '/wp-content/uploads/outdoor/Linear-1024x1024.jpg',
            'product_description' => 'Flexible linear lighting system for architectural applications',
            'product_order' => 1,
            'is_featured' => 1,
            'is_active' => 1
        ]
    ];
    
    foreach ($products as $product) {
        $wpdb->insert($products_table, $product);
    }
    
    // Insert page settings
    $settings = [
        [
            'setting_key' => 'banner_image',
            'setting_value' => '/wp-content/uploads/outdoor/post_gal_0029_r1.jpg',
            'setting_type' => 'image'
        ],
        [
            'setting_key' => 'page_title',
            'setting_value' => 'Outdoor Lighting - Virical',
            'setting_type' => 'text'
        ],
        [
            'setting_key' => 'page_slug',
            'setting_value' => 'outdoor',
            'setting_type' => 'text'
        ],
        [
            'setting_key' => 'meta_description',
            'setting_value' => 'Explore our premium outdoor lighting solutions including spotlights, bollards, inground lights and linear systems',
            'setting_type' => 'text'
        ],
        [
            'setting_key' => 'show_cta_button',
            'setting_value' => '1',
            'setting_type' => 'boolean'
        ],
        [
            'setting_key' => 'cta_button_text',
            'setting_value' => 'Xem Catalog',
            'setting_type' => 'text'
        ],
        [
            'setting_key' => 'cta_button_link',
            'setting_value' => '/catalog/outdoor',
            'setting_type' => 'url'
        ]
    ];
    
    foreach ($settings as $setting) {
        $wpdb->insert($settings_table, $setting);
    }
    
    return true;
}

// Run migration
function run_outdoor_migration() {
    try {
        // Create tables
        if (!create_outdoor_page_tables()) {
            throw new Exception('Failed to create outdoor tables');
        }
        
        // Populate data
        if (!populate_outdoor_data()) {
            throw new Exception('Failed to populate outdoor data');
        }
        
        // Log success
        error_log('[Outdoor Migration] Successfully created tables and populated data');
        
        return [
            'success' => true,
            'message' => 'Outdoor page tables created and data populated successfully'
        ];
        
    } catch (Exception $e) {
        error_log('[Outdoor Migration Error] ' . $e->getMessage());
        
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

// Execute if called directly
if (defined('WP_CLI') || (defined('DOING_AJAX') && DOING_AJAX)) {
    $result = run_outdoor_migration();
    
    if (defined('WP_CLI')) {
        if ($result['success']) {
            WP_CLI::success($result['message']);
        } else {
            WP_CLI::error($result['message']);
        }
    } else {
        echo json_encode($result);
    }
}