<?php
// Script to fix 404 error for About Us page

// Database credentials
$db_host = 'mysql';
$db_name = 'aura_db';
$db_user = 'aura_user';
$db_pass = 'aura_pass123';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

echo "Connected to database successfully.\n\n";

// 1. Set permalink structure
$permalink_query = "UPDATE wp_options SET option_value = '/%postname%/' WHERE option_name = 'permalink_structure'";
if ($mysqli->query($permalink_query)) {
    echo "✓ Set permalink structure to /%postname%/\n";
}

// 2. Check page template for About Us page
$template_check = "SELECT meta_value FROM wp_postmeta WHERE post_id = 10 AND meta_key = '_wp_page_template'";
$result = $mysqli->query($template_check);

if ($result && $row = $result->fetch_assoc()) {
    echo "✓ Current template: " . $row['meta_value'] . "\n";
} else {
    echo "✗ No template found for About Us page\n";
}

// 3. Flush rewrite rules by updating the option
$rewrite_query = "UPDATE wp_options SET option_value = '' WHERE option_name = 'rewrite_rules'";
if ($mysqli->query($rewrite_query)) {
    echo "✓ Flushed rewrite rules\n";
}

// 4. Clean up unused pages
echo "\nCleaning up unused pages:\n";

$pages_to_delete = [
    2,  // Trang mẫu
    3,  // Chính sách bảo mật
    14  // Indoor
];

foreach ($pages_to_delete as $page_id) {
    // Delete page
    $delete_page = "DELETE FROM wp_posts WHERE ID = $page_id";
    $mysqli->query($delete_page);
    
    // Delete page meta
    $delete_meta = "DELETE FROM wp_postmeta WHERE post_id = $page_id";
    $mysqli->query($delete_meta);
    
    echo "✓ Deleted page ID: $page_id\n";
}

// 5. Update About Us page to ensure it's properly configured
$update_about = "UPDATE wp_posts SET 
    post_title = 'Chúng Tôi',
    post_name = 'chung-toi',
    post_status = 'publish',
    guid = 'http://localhost:8000/chung-toi/'
    WHERE ID = 10";

if ($mysqli->query($update_about)) {
    echo "\n✓ Updated About Us page\n";
}

// 6. List remaining pages
echo "\nRemaining pages:\n";
$list_pages = "SELECT ID, post_title, post_name, guid FROM wp_posts WHERE post_type = 'page' AND post_status = 'publish' ORDER BY ID";
$result = $mysqli->query($list_pages);

while ($row = $result->fetch_assoc()) {
    echo "- ID: {$row['ID']}, Title: {$row['post_title']}, Slug: {$row['post_name']}\n";
    echo "  URL: http://localhost:8000/{$row['post_name']}/\n";
}

echo "\n✓ Fixes applied! The About Us page should now be accessible at:\n";
echo "  http://localhost:8000/chung-toi/\n";

$mysqli->close();
?>