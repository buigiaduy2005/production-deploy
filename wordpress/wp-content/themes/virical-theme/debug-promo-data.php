<?php
/**
 * Debug script to check promo grid data
 * Access via: http://localhost:8080/wp-content/themes/virical-theme/debug-promo-data.php
 */

// Load WordPress
require_once('../../../wp-load.php');

// Get promo data
$promo_data = get_option('virical_promo_grid_data');

echo "<h1>Promo Grid Data Debug</h1>";
echo "<pre>";
print_r($promo_data);
echo "</pre>";

if (!$promo_data || !is_array($promo_data)) {
    echo "<p style='color: red;'><strong>NO DATA FOUND!</strong> Using default values.</p>";
    
    // Load default function
    if (!function_exists('virical_get_default_promo_data')) {
        require_once get_template_directory() . '/includes/homepage-promo-admin.php';
    }
    $default_data = virical_get_default_promo_data();
    
    echo "<h2>Default Data:</h2>";
    echo "<pre>";
    print_r($default_data);
    echo "</pre>";
} else {
    echo "<p style='color: green;'><strong>Data found!</strong> Total items: " . count($promo_data) . "</p>";
    
    // Check each item
    foreach ($promo_data as $key => $item) {
        echo "<h3>Item: $key</h3>";
        echo "<ul>";
        echo "<li>Type: " . (isset($item['type']) ? $item['type'] : 'NOT SET') . "</li>";
        echo "<li>Title: " . (isset($item['title']) ? $item['title'] : 'NOT SET') . "</li>";
        echo "<li>Image URL: " . (isset($item['image_url']) && $item['image_url'] ? $item['image_url'] : 'EMPTY') . "</li>";
        echo "<li>Video URL: " . (isset($item['video_url']) && $item['video_url'] ? $item['video_url'] : 'EMPTY') . "</li>";
        echo "</ul>";
    }
}
