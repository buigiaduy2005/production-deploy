<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

global $wpdb;

header('Content-Type: text/plain; charset=utf-8');

// --- Configuration ---
$table_name = 'wp_virical_products';
$product_slug = 'den-pha-led-stadium-500w';
$new_image_url = 'http://localhost:8082/wp-content/uploads/2025/01/25.1.jpg';
// ---------------------

// Update the image_url for the specified product
$result = $wpdb->update(
    $table_name,
    [ 'image_url' => $new_image_url ], // Data to update
    [ 'slug' => $product_slug ],      // WHERE clause
    [ '%s' ],                         // Data format
    [ '%s' ]                          // WHERE format
);

if ($result === false) {
    echo "ERROR: Could not execute the update query.\n";
    echo "Database Error: " . $wpdb->last_error;
} else if ($result === 0) {
    echo "NOTICE: The query ran successfully, but no rows were updated.\n";
    echo "This could mean the product was not found OR the image URL was already set to this value.";
} else {
    echo "SUCCESS! The image_url for product '{$product_slug}' has been updated.\n";
    echo "Please clear your browser cache and refresh the product page to see the change.";
}

?>