<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

global $wpdb;

header('Content-Type: text/plain; charset=utf-8');

// --- Configuration ---
$table_name = 'wp_virical_products';
$product_slug = 'ray-nam-cham-magna-pro-48v';
$image_to_add = 'http://localhost:8080/wp-content/uploads/2025/01/10.1.png';
// ---------------------

// 1. Get the current gallery data
$query = $wpdb->prepare(
    "SELECT gallery_images FROM {$table_name} WHERE slug = %s", 
    $product_slug
);
$current_gallery_json = $wpdb->get_var($query);

if ($current_gallery_json === null) {
    echo "ERROR: Product with slug '{$product_slug}' not found.";
    exit;
}

// 2. Decode the JSON and add the new image
$gallery_array = json_decode($current_gallery_json, true);
if (!is_array($gallery_array)) {
    // If data is not valid JSON or is empty, start a new array
    $gallery_array = [];
}

// 3. Check if the image already exists to prevent duplicates
if (in_array($image_to_add, $gallery_array)) {
    echo "NOTICE: This image already exists in the gallery. No changes made.";
    exit;
}

// 4. Add the new image to the beginning of the array
array_unshift($gallery_array, $image_to_add);

// 5. Encode the array back to JSON
$new_gallery_json = json_encode($gallery_array);

// 6. Update the database
$result = $wpdb->update(
    $table_name,
    [ 'gallery_images' => $new_gallery_json ], // Data to update
    [ 'slug' => $product_slug ],             // WHERE clause
    [ '%s' ],                                // Data format
    [ '%s' ]                                 // WHERE format
);

if ($result === false) {
    echo "ERROR: Could not execute the update query for gallery_images.\n";
    echo "Database Error: " . $wpdb->last_error;
} else if ($result === 0) {
    echo "NOTICE: The query ran, but no rows were updated. This is unexpected.";
} else {
    echo "SUCCESS! The gallery_images field has been updated for product '{$product_slug}'.\n";
    echo "Please clear your browser cache (Ctrl+F5) and refresh the product page.";
}

?>