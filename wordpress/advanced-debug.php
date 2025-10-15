<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

global $wpdb;

// --- Configuration ---
$search_slug = 'ray-nam-cham-magna-pro-48v';
// ---------------------

header('Content-Type: text/plain; charset=utf-8');

echo "Searching for posts with slug LIKE '%{$search_slug}%'\n";
echo "-----------------------------------------------------\n\n";

$query = $wpdb->prepare(
    "SELECT ID, post_name, post_title, post_status, post_type, guid FROM {$wpdb->posts} WHERE post_name LIKE %s", 
    '%' . $wpdb->esc_like($search_slug) . '%'
);

$results = $wpdb->get_results($query);

if (empty($results)) {
    echo "No posts found matching that slug fragment.\n";
} else {
    echo "Found " . count($results) . " matching post(s):\n\n";
    foreach ($results as $post) {
        echo "- ID:          " . $post->ID . "\n";
        echo "  Title:       " . $post->post_title . "\n";
        echo "  Slug (post_name): " . $post->post_name . "\n";
        echo "  Status:      " . $post->post_status . "\n";
        echo "  Type:        " . $post_type . "\n";
        echo "  URL (guid):    " . $post->guid . "\n\n";
    }
}

?>