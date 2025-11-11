<?php
/**
 * Delete Duplicate WordPress Menus
 * This script will remove all WordPress menus to prevent duplication
 */

// Include WordPress
require_once('wordpress/wp-config.php');

echo "<h2>Delete Duplicate Menus</h2>";

// 1. Get all WordPress menus
$menus = wp_get_nav_menus();

if (!empty($menus)) {
    echo "<h3>Found " . count($menus) . " WordPress menus:</h3>";
    echo "<ul>";
    foreach ($menus as $menu) {
        echo "<li><strong>{$menu->name}</strong> (ID: {$menu->term_id})";
        
        // Get menu items
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        if ($menu_items) {
            echo "<ul>";
            foreach ($menu_items as $item) {
                echo "<li>{$item->title}</li>";
            }
            echo "</ul>";
        }
        echo "</li>";
    }
    echo "</ul>";
    
    // Delete all menus
    echo "<h3>Deleting all WordPress menus...</h3>";
    foreach ($menus as $menu) {
        $result = wp_delete_nav_menu($menu->term_id);
        if ($result) {
            echo "<p style='color: green;'>✓ Deleted menu: {$menu->name}</p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to delete menu: {$menu->name}</p>";
        }
    }
} else {
    echo "<p style='color: green;'>No WordPress menus found.</p>";
}

// 2. Unassign all menu locations
echo "<h3>Unassigning menu locations...</h3>";
$locations = get_theme_mod('nav_menu_locations');
if ($locations) {
    foreach ($locations as $location => $menu_id) {
        echo "<p>Location: {$location} was assigned to menu ID: {$menu_id}</p>";
    }
    set_theme_mod('nav_menu_locations', array());
    echo "<p style='color: green;'>✓ All menu locations unassigned</p>";
} else {
    echo "<p style='color: green;'>No menu locations were assigned.</p>";
}

// 3. Check Virical database menu
echo "<h3>Virical Database Menu Status:</h3>";
global $wpdb;
$table_name = $wpdb->prefix . 'virical_navigation_menus';
$menus = $wpdb->get_results("SELECT * FROM {$table_name} WHERE menu_location = 'primary' ORDER BY sort_order ASC");

if ($menus) {
    echo "<p style='color: green;'>Found " . count($menus) . " Virical menu items (this is good - these should remain):</p>";
    echo "<ul>";
    foreach ($menus as $menu) {
        echo "<li>{$menu->item_title} - {$menu->item_url}</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color: red;'>No Virical database menu entries found.</p>";
}

echo "<h3>✅ Done!</h3>";
echo "<p><strong>Next steps:</strong></p>";
echo "<ol>";
echo "<li>Clear your browser cache (Ctrl+Shift+Delete)</li>";
echo "<li>Refresh the website</li>";
echo "<li>Only the custom Virical menu should appear now</li>";
echo "</ol>";
?>
