<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

header('Content-Type: text/plain; charset=utf-8');

// --- Configuration ---
$page_slug = 'giai-phap-thong-minh';
// ---------------------

echo "Searching for page with slug: '{$page_slug}'\n\n";

$page = get_page_by_path($page_slug, OBJECT, 'page');

if (!$page) {
    echo "ERROR: No page found with that slug.";
} else {
    $template = get_post_meta($page->ID, '_wp_page_template', true);

    echo "--- PAGE FOUND ---\\n";
    echo str_pad("[ID]", 20) . ": " . $page->ID . "\n";
    echo str_pad("[Title]", 20) . ": " . $page->post_title . "\n";
    echo str_pad("[Status]", 20) . ": " . $page->post_status . "\n";
    
    if (empty($template)) {
        echo str_pad("[Template]", 20) . ": Default Page Template\n";
    } else {
        echo str_pad("[Template]", 20) . ": " . $template . "\n";
    }
    echo "------------------\n";
}

?>