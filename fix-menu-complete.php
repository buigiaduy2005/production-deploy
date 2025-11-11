<?php
/**
 * Complete Menu Fix - Xóa hoàn toàn duplicate menus
 */

// Include WordPress
require_once('wordpress/wp-config.php');

echo "<h1>🔧 Complete Menu Fix</h1>";
echo "<p>This script will completely fix the duplicate menu issue.</p>";
echo "<hr>";

global $wpdb;
$fixed = array();

// ============================================
// STEP 1: Clean WordPress Menus
// ============================================
echo "<h2>STEP 1: Clean WordPress Menus</h2>";

$menus = wp_get_nav_menus();
if (!empty($menus)) {
    echo "<p>Found " . count($menus) . " WordPress menus. Deleting all...</p>";
    foreach ($menus as $menu) {
        wp_delete_nav_menu($menu->term_id);
        echo "<p style='color: green;'>✓ Deleted WordPress menu: {$menu->name}</p>";
        $fixed[] = "Deleted WordPress menu: {$menu->name}";
    }
} else {
    echo "<p style='color: green;'>✓ No WordPress menus found</p>";
}

// Unassign all menu locations
set_theme_mod('nav_menu_locations', array());
echo "<p style='color: green;'>✓ Unassigned all menu locations</p>";
$fixed[] = "Unassigned menu locations";

// ============================================
// STEP 2: Clean Virical Database Menu Duplicates
// ============================================
echo "<hr><h2>STEP 2: Clean Virical Database Menu Duplicates</h2>";

$table_name = $wpdb->prefix . 'virical_navigation_menus';
$menus = $wpdb->get_results("SELECT * FROM {$table_name} WHERE menu_location = 'primary' ORDER BY sort_order ASC");

echo "<p>Found " . count($menus) . " Virical menu items</p>";

// Group by title to find duplicates
$title_groups = array();
foreach ($menus as $menu) {
    if (!isset($title_groups[$menu->item_title])) {
        $title_groups[$menu->item_title] = array();
    }
    $title_groups[$menu->item_title][] = $menu;
}

// Delete duplicates (keep first occurrence)
$deleted_count = 0;
foreach ($title_groups as $title => $group) {
    if (count($group) > 1) {
        echo "<p style='color: orange;'><strong>'{$title}'</strong> has " . count($group) . " duplicates</p>";
        // Keep first, delete rest
        for ($i = 1; $i < count($group); $i++) {
            $wpdb->delete($table_name, array('id' => $group[$i]->id), array('%d'));
            echo "<p style='color: green;'>✓ Deleted duplicate ID {$group[$i]->id}: {$title}</p>";
            $deleted_count++;
            $fixed[] = "Deleted duplicate menu item: {$title}";
        }
    }
}

if ($deleted_count > 0) {
    echo "<p style='color: green;'><strong>✓ Deleted {$deleted_count} duplicate menu items</strong></p>";
} else {
    echo "<p style='color: green;'>✓ No duplicates found in database</p>";
}

// ============================================
// STEP 3: Verify Final State
// ============================================
echo "<hr><h2>STEP 3: Verify Final State</h2>";

$final_menus = $wpdb->get_results("SELECT * FROM {$table_name} WHERE menu_location = 'primary' ORDER BY sort_order ASC");
echo "<h3>Final Menu Items (" . count($final_menus) . " items):</h3>";
echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Title</th><th>URL</th><th>Sort Order</th></tr>";
foreach ($final_menus as $menu) {
    echo "<tr>";
    echo "<td>{$menu->id}</td>";
    echo "<td><strong>{$menu->item_title}</strong></td>";
    echo "<td>{$menu->item_url}</td>";
    echo "<td>{$menu->sort_order}</td>";
    echo "</tr>";
}
echo "</table>";

// ============================================
// STEP 4: Summary & Next Steps
// ============================================
echo "<hr><h2>✅ Fix Summary</h2>";
echo "<ol>";
foreach ($fixed as $fix) {
    echo "<li>{$fix}</li>";
}
echo "</ol>";

echo "<hr><h2>📋 Next Steps:</h2>";
echo "<ol>";
echo "<li><strong>Clear browser cache:</strong> Press Ctrl+Shift+Delete</li>";
echo "<li><strong>Clear WordPress cache:</strong> If using caching plugin</li>";
echo "<li><strong>Refresh website:</strong> Press F5</li>";
echo "<li><strong>Check result:</strong> Menu should appear only once</li>";
echo "</ol>";

echo "<hr>";
echo "<div style='background: #e7f3ff; padding: 20px; border-left: 4px solid #2196F3;'>";
echo "<h3>⚠️ If menu still appears twice:</h3>";
echo "<p>The issue is likely in the header.php or theme template calling the render function multiple times.</p>";
echo "<p>Check browser console (F12) for error logs showing which menu renders are being prevented.</p>";
echo "</div>";

echo "<hr>";
echo "<p style='text-align: center;'><a href='/' style='padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>GO TO HOMEPAGE</a></p>";
?>
