<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

// --- Configuration ---
$product_slug = 'ray-nam-cham-magna-pro-48v';
// ---------------------

header('Content-Type: text/plain; charset=utf-8');

// Find the product by its slug
$args = [
    'name'        => $product_slug,
    'post_type'   => 'product', 
    'post_status' => 'publish',
    'numberposts' => 1
];

$posts = get_posts($args);

if (empty($posts)) {
    echo "ERROR: Product with slug '{$product_slug}' not found.\n";
    exit;
}

$product = $posts[0];

// Get current content and print it
echo "--- START OF POST CONTENT ---\\n\n";
echo $product->post_content;
echo "\\n\\n--- END OF POST CONTENT ---";

?>