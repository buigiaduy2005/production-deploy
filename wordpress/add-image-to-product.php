<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

// --- Configuration ---
$product_slug = 'ray-nam-cham-magna-pro-48v';
$image_to_add = '<img src="http://localhost:8080/wp-content/uploads/2025/01/10.1.png" alt="Ray Nam Châm MAGNA Pro 48V">';
$placeholder_div = '<div class="no-image">Không có hình ảnh</div>';
// ---------------------

// Find the product by its slug
$args = [
    'name'        => $product_slug,
    'post_type'   => 'product', // Assuming WooCommerce or a similar plugin with 'product' post type
    'post_status' => 'publish',
    'numberposts' => 1
];

$posts = get_posts($args);

if (empty($posts)) {
    echo "Error: Product with slug '{$product_slug}' not found.\n";
    exit;
}

$product = $posts[0];

// Get current content
$original_content = $product->post_content;

// Check if the placeholder div exists in the content
if (strpos($original_content, $placeholder_div) === false) {
    echo "Notice: The placeholder '<div class=\"no-image\">...</div>' was not found in the product content. No changes made.\n";
    // Optional: You might still want to add the image at the end if the placeholder is missing.
    // $new_content = $original_content . "\n" . $image_to_add;
    exit;
}

// Replace the placeholder div with the image
$new_content = str_replace($placeholder_div, $image_to_add, $original_content);

// Prepare data for updating the post
$post_update_data = [
    'ID'           => $product->ID,
    'post_content' => $new_content,
];

// Update the post in the database
$result = wp_update_post($post_update_data, true); // Second param for WP_Error object on failure

if (is_wp_error($result)) {
    echo "Error updating product: " . $result->get_error_message() . "\n";
} else {
    echo "Success! The placeholder has been replaced with the image in product '{$product->post_title}'.\n";
    echo "You can view the updated page at: " . get_permalink($product->ID) . "\n";
}

?>