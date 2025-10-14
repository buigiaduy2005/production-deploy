<?php
// Script to fix menu links

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

// First, let's check all menu items
echo "Checking all menu items:\n";
$menu_query = "SELECT p.ID, p.post_title, p.post_status, pm.meta_value as object_id 
               FROM wp_posts p 
               LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id 
               WHERE p.post_type = 'nav_menu_item' 
               AND pm.meta_key = '_menu_item_object_id' 
               ORDER BY p.menu_order";

$result = $mysqli->query($menu_query);

while ($row = $result->fetch_assoc()) {
    echo "Menu Item ID: {$row['ID']}, Title: {$row['post_title']}, Links to Page ID: {$row['object_id']}\n";
}

// Update menu item titles based on linked pages
echo "\nUpdating menu item titles:\n";

$update_queries = [
    // Update Chúng Tôi menu item
    "UPDATE wp_posts p 
     JOIN wp_postmeta pm ON p.ID = pm.post_id 
     SET p.post_title = 'Chúng Tôi', p.post_name = CONCAT('menu-item-', p.ID)
     WHERE p.post_type = 'nav_menu_item' 
     AND pm.meta_key = '_menu_item_object_id' 
     AND pm.meta_value = '10'",
    
    // Update other menu items
    "UPDATE wp_posts p 
     JOIN wp_postmeta pm ON p.ID = pm.post_id 
     JOIN wp_posts linked ON pm.meta_value = linked.ID
     SET p.post_title = linked.post_title, p.post_name = CONCAT('menu-item-', p.ID)
     WHERE p.post_type = 'nav_menu_item' 
     AND pm.meta_key = '_menu_item_object_id'"
];

foreach ($update_queries as $query) {
    if ($mysqli->query($query)) {
        echo "✓ Updated menu titles\n";
    }
}

// Check for any custom links with about-us
echo "\nChecking for custom menu links:\n";
$custom_links = "SELECT p.ID, p.post_title, pm.meta_value as url 
                 FROM wp_posts p 
                 JOIN wp_postmeta pm ON p.ID = pm.post_id 
                 WHERE p.post_type = 'nav_menu_item' 
                 AND pm.meta_key = '_menu_item_url' 
                 AND pm.meta_value LIKE '%about%'";

$result = $mysqli->query($custom_links);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Found custom link: ID {$row['ID']}, URL: {$row['url']}\n";
        
        // Update the URL
        $new_url = str_replace('about-us', 'chung-toi', $row['url']);
        $update_url = "UPDATE wp_postmeta SET meta_value = '$new_url' 
                       WHERE post_id = {$row['ID']} AND meta_key = '_menu_item_url'";
        
        if ($mysqli->query($update_url)) {
            echo "✓ Updated URL to: $new_url\n";
        }
    }
} else {
    echo "No custom links with 'about' found.\n";
}

// Clear menu cache
$clear_cache = "DELETE FROM wp_options WHERE option_name LIKE '_transient_menu_%'";
$mysqli->query($clear_cache);
echo "\n✓ Menu cache cleared\n";

// Display final menu structure
echo "\nFinal menu structure:\n";
$final_menu = "SELECT p.ID, p.post_title, p.menu_order,
               pm1.meta_value as object_id,
               pm2.meta_value as url,
               pm3.meta_value as type
               FROM wp_posts p 
               LEFT JOIN wp_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_menu_item_object_id'
               LEFT JOIN wp_postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_menu_item_url'
               LEFT JOIN wp_postmeta pm3 ON p.ID = pm3.post_id AND pm3.meta_key = '_menu_item_type'
               WHERE p.post_type = 'nav_menu_item' 
               AND p.post_status = 'publish'
               ORDER BY p.menu_order";

$result = $mysqli->query($final_menu);

while ($row = $result->fetch_assoc()) {
    echo "- {$row['post_title']}";
    if ($row['type'] == 'custom') {
        echo " (Custom URL: {$row['url']})";
    } else {
        echo " (Links to page ID: {$row['object_id']})";
    }
    echo "\n";
}

echo "\n✓ Menu links have been fixed!\n";

$mysqli->close();
?>