<?php
// Load WordPress
require_once('/var/www/html/wp-load.php');

echo "Flushing WordPress cache and permalinks...\n";

// Flush object cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "✓ Object cache flushed\n";
}

// Flush rewrite rules
flush_rewrite_rules();
echo "✓ Rewrite rules flushed\n";

// Update permalinks
update_option('permalink_structure', '/%postname%/');
echo "✓ Permalink structure updated\n";

// Clear transients
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_%'");
echo "✓ Transients cleared\n";

// Check if About Us page is accessible
$about_page = get_page_by_path('chung-toi');
if ($about_page) {
    echo "\n✓ About Us page found:\n";
    echo "  - ID: " . $about_page->ID . "\n";
    echo "  - Title: " . $about_page->post_title . "\n";
    echo "  - Status: " . $about_page->post_status . "\n";
    echo "  - URL: " . get_permalink($about_page->ID) . "\n";
    
    // Check template
    $template = get_page_template_slug($about_page->ID);
    echo "  - Template: " . ($template ?: 'default') . "\n";
} else {
    echo "\n✗ About Us page not found by slug\n";
}

echo "\nAll caches flushed! Please try accessing the page again.\n";
?>