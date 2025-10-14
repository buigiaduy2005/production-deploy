<?php
/**
 * Migration: Populate Indoor Page Data
 * Version: 1.0.0
 * Created: 2024-12-20
 */

if (!defined('ABSPATH')) {
    exit;
}

class Populate_Indoor_Data_Migration {
    
    public static function up() {
        global $wpdb;
        
        // 1. Insert Indoor Page Settings
        $table_settings = $wpdb->prefix . 'indoor_page_settings';
        $settings_data = [
            ['setting_key' => 'page_title', 'setting_value' => 'INDOOR LIGHTING', 'setting_type' => 'text'],
            ['setting_key' => 'page_subtitle', 'setting_value' => 'DOWNLIGHTS AND SPOTLIGHTS', 'setting_type' => 'text'],
            ['setting_key' => 'banner_image', 'setting_value' => 'https://auralighting.vn/wp-content/uploads/2022/04/image-2521-1.jpg', 'setting_type' => 'image'],
            ['setting_key' => 'meta_title', 'setting_value' => 'Indoor – Aura Lighting – Felling Light', 'setting_type' => 'text'],
            ['setting_key' => 'meta_description', 'setting_value' => 'Khám phá bộ sưu tập đèn LED Indoor chất lượng cao từ Aura Lighting', 'setting_type' => 'text']
        ];
        
        foreach ($settings_data as $setting) {
            $wpdb->replace($table_settings, $setting);
        }
        
        // 2. Insert Indoor Product Categories
        $table_categories = $wpdb->prefix . 'indoor_product_categories';
        $categories_data = [
            ['category_name' => 'Moon', 'category_slug' => 'moon', 'display_order' => 1],
            ['category_name' => 'Aries', 'category_slug' => 'aries', 'display_order' => 2],
            ['category_name' => 'Angelo', 'category_slug' => 'angelo', 'display_order' => 3],
            ['category_name' => 'Mini', 'category_slug' => 'mini', 'display_order' => 4],
            ['category_name' => 'Melbourne', 'category_slug' => 'melbourne', 'display_order' => 5],
            ['category_name' => 'Downlight Surface', 'category_slug' => 'downlight-surface', 'display_order' => 6],
            ['category_name' => 'Track Light', 'category_slug' => 'track-light', 'display_order' => 7]
        ];
        
        foreach ($categories_data as $category) {
            $wpdb->replace($table_categories, $category);
        }
        
        // Get category IDs
        $moon_id = $wpdb->get_var("SELECT id FROM $table_categories WHERE category_slug = 'moon'");
        $aries_id = $wpdb->get_var("SELECT id FROM $table_categories WHERE category_slug = 'aries'");
        $angelo_id = $wpdb->get_var("SELECT id FROM $table_categories WHERE category_slug = 'angelo'");
        $mini_id = $wpdb->get_var("SELECT id FROM $table_categories WHERE category_slug = 'mini'");
        $melbourne_id = $wpdb->get_var("SELECT id FROM $table_categories WHERE category_slug = 'melbourne'");
        $downlight_id = $wpdb->get_var("SELECT id FROM $table_categories WHERE category_slug = 'downlight-surface'");
        $track_id = $wpdb->get_var("SELECT id FROM $table_categories WHERE category_slug = 'track-light'");
        
        // 3. Insert Indoor Products
        $table_products = $wpdb->prefix . 'indoor_products';
        $products_data = [
            // Moon Category
            [
                'category_id' => $moon_id,
                'product_name' => 'Moon 2',
                'product_slug' => 'moon-2',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Moon-2-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/crown70/',
                'display_order' => 1
            ],
            [
                'category_id' => $moon_id,
                'product_name' => 'Moon ADJ',
                'product_slug' => 'moon-adj',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/MOON-ADJ-1-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/crown90/',
                'display_order' => 2
            ],
            
            // Aries Category
            [
                'category_id' => $aries_id,
                'product_name' => 'Crown 70',
                'product_slug' => 'crown-70',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Crown70-1-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/crown70/',
                'display_order' => 1
            ],
            [
                'category_id' => $aries_id,
                'product_name' => 'Crown 90-55',
                'product_slug' => 'crown-90-55',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Crown90-55-1-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/crown90/',
                'display_order' => 2
            ],
            [
                'category_id' => $aries_id,
                'product_name' => 'Luci 6',
                'product_slug' => 'luci-6',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Luci6-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/leo15/',
                'display_order' => 3
            ],
            [
                'category_id' => $aries_id,
                'product_name' => 'Luci 10-55',
                'product_slug' => 'luci-10-55',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Luci10-55-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/leo15/',
                'display_order' => 4
            ],
            
            // Angelo Category
            [
                'category_id' => $angelo_id,
                'product_name' => 'Angelo Fix',
                'product_slug' => 'angelo-fix',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Angelo-Fix-1024x1024.jpg',
                'product_link' => '#',
                'display_order' => 1
            ],
            [
                'category_id' => $angelo_id,
                'product_name' => 'Angelo C',
                'product_slug' => 'angelo-c',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Angelo-C-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/angelos/',
                'display_order' => 2
            ],
            
            // Mini Category
            [
                'category_id' => $mini_id,
                'product_name' => 'Mini B7',
                'product_slug' => 'mini-b7',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/MiniB7-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/gbeo7/',
                'display_order' => 1
            ],
            [
                'category_id' => $mini_id,
                'product_name' => 'Mini B3',
                'product_slug' => 'mini-b3',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/MiniB3-1024x1024.jpg',
                'product_link' => '#',
                'display_order' => 2
            ],
            [
                'category_id' => $mini_id,
                'product_name' => 'Tini',
                'product_slug' => 'tini',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Tini-1024x1024.jpg',
                'product_link' => '#',
                'display_order' => 3
            ],
            [
                'category_id' => $mini_id,
                'product_name' => 'Mini 5W IP44',
                'product_slug' => 'mini-5w-ip44',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Mini5wIP44-1024x1024.jpg',
                'product_link' => '#',
                'display_order' => 4
            ],
            [
                'category_id' => $mini_id,
                'product_name' => 'Spotlight 6',
                'product_slug' => 'spotlight-6',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Spotlight-6-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/gbeo7/',
                'display_order' => 5
            ],
            [
                'category_id' => $mini_id,
                'product_name' => 'Elian',
                'product_slug' => 'elian',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Elian-1024x1024.jpg',
                'product_link' => '#',
                'display_order' => 6
            ],
            
            // Melbourne Category
            [
                'category_id' => $melbourne_id,
                'product_name' => 'Linatt',
                'product_slug' => 'linatt',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Linatt-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/melbourne45/',
                'display_order' => 1
            ],
            [
                'category_id' => $melbourne_id,
                'product_name' => 'Melbourne 12',
                'product_slug' => 'melbourne-12',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Melbourne12-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/melbourne45/',
                'display_order' => 2
            ],
            [
                'category_id' => $melbourne_id,
                'product_name' => 'Melbourne 6',
                'product_slug' => 'melbourne-6',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Melbourne6-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/melbourne45/',
                'display_order' => 3
            ],
            
            // Downlight Surface Category
            [
                'category_id' => $downlight_id,
                'product_name' => 'Virgo W',
                'product_slug' => 'virgo-w',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/VirgoW-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/virgo/',
                'display_order' => 1
            ],
            [
                'category_id' => $downlight_id,
                'product_name' => 'Virgo B',
                'product_slug' => 'virgo-b',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/VirgoB-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/virgo/',
                'display_order' => 2
            ],
            [
                'category_id' => $downlight_id,
                'product_name' => 'Virgo B-S',
                'product_slug' => 'virgo-b-s',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/VirgoB-S-1024x1024.jpg',
                'product_link' => '#',
                'display_order' => 3
            ],
            
            // Track Light Category
            [
                'category_id' => $track_id,
                'product_name' => 'Track Light',
                'product_slug' => 'track-light',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/TrackLight-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/virgo/',
                'display_order' => 1
            ],
            [
                'category_id' => $track_id,
                'product_name' => 'Zoomable',
                'product_slug' => 'zoomable',
                'product_image' => 'https://auralighting.vn/wp-content/uploads/2024/08/Zoomable-1024x1024.jpg',
                'product_link' => 'https://auralighting.vn/virgo/',
                'display_order' => 2
            ]
        ];
        
        foreach ($products_data as $product) {
            $wpdb->replace($table_products, $product);
        }
        
        return true;
    }
    
    public static function down() {
        global $wpdb;
        
        $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}indoor_products");
        $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}indoor_product_categories");
        $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}indoor_page_settings");
        
        return true;
    }
}

// Auto-run migration if called directly
if (!function_exists('add_action')) {
    Populate_Indoor_Data_Migration::up();
}