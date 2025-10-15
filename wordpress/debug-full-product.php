<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

global $wpdb;

header('Content-Type: text/plain; charset=utf-8');

// --- Configuration ---
$table_name = 'wp_virical_products';
$product_slug = 'ray-nam-cham-magna-pro-48v';
// ---------------------

$query = $wpdb->prepare(
    "SELECT * FROM {$table_name} WHERE slug = %s", 
    $product_slug
);

$product_data = $wpdb->get_row($query, ARRAY_A); // Get row as an associative array

if (empty($product_data)) {
    echo "ERROR: Product with slug '{$product_slug}' not found in table '{$table_name}'.";
} else {
    echo "--- FULL PRODUCT DATA FOR SLUG: {$product_slug} ---

";
    foreach ($product_data as $key => $value) {
        echo str_pad("[" . $key . "]", 20) . ": " . $value . "\n";
    }
    echo "\n--- END OF DATA ---";
}

?>