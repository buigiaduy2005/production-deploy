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
    "SELECT description FROM {$table_name} WHERE slug = %s", 
    $product_slug
);

$description = $wpdb->get_var($query);

if ($description === null) {
    echo "ERROR: Product with slug '{$product_slug}' not found in table '{$table_name}'.";
} else {
    echo "--- START OF 'description' CONTENT ---\\n\\n";
    echo $description;
    echo "\\n\\n--- END OF 'description' CONTENT ---";
}

?>