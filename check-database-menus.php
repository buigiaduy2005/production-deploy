<?php
/**
 * Check Database for Duplicate Menu Items
 */

// Include WordPress
require_once('wordpress/wp-config.php');

echo "<h2>Check Database Menu Items</h2>";

global $wpdb;
$table_name = $wpdb->prefix . 'virical_navigation_menus';

// Get all primary menu items
$menus = $wpdb->get_results("SELECT * FROM {$table_name} WHERE menu_location = 'primary' ORDER BY sort_order ASC");

echo "<h3>Total menu items found: " . count($menus) . "</h3>";

if ($menus) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'>";
    echo "<th>ID</th><th>Parent ID</th><th>Title</th><th>URL</th><th>Sort Order</th><th>Active</th><th>Action</th>";
    echo "</tr>";
    
    $title_count = array();
    $duplicate_ids = array();
    
    foreach ($menus as $menu) {
        // Count duplicates by title
        if (!isset($title_count[$menu->item_title])) {
            $title_count[$menu->item_title] = array();
        }
        $title_count[$menu->item_title][] = $menu->id;
        
        $is_duplicate = count($title_count[$menu->item_title]) > 1;
        $row_color = $is_duplicate ? 'background: #ffcccc;' : '';
        
        echo "<tr style='{$row_color}'>";
        echo "<td>{$menu->id}</td>";
        echo "<td>" . ($menu->parent_id ? $menu->parent_id : '-') . "</td>";
        echo "<td><strong>{$menu->item_title}</strong></td>";
        echo "<td>{$menu->item_url}</td>";
        echo "<td>{$menu->sort_order}</td>";
        echo "<td>" . ($menu->is_active ? 'Yes' : 'No') . "</td>";
        echo "<td>";
        if ($is_duplicate) {
            echo "<a href='?delete_id={$menu->id}' style='color: red;'>DELETE</a>";
            $duplicate_ids[] = $menu->id;
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Show summary
    echo "<h3>Duplicate Summary:</h3>";
    $has_duplicates = false;
    foreach ($title_count as $title => $ids) {
        if (count($ids) > 1) {
            $has_duplicates = true;
            echo "<p style='color: red;'><strong>'{$title}'</strong> appears " . count($ids) . " times (IDs: " . implode(', ', $ids) . ")</p>";
        }
    }
    
    if (!$has_duplicates) {
        echo "<p style='color: green;'>✓ No duplicates found in database</p>";
    } else {
        echo "<hr>";
        echo "<h3>Delete All Duplicates:</h3>";
        echo "<p>The following IDs will be deleted (keeping the first occurrence of each menu item):</p>";
        echo "<ul>";
        foreach ($title_count as $title => $ids) {
            if (count($ids) > 1) {
                // Keep first, delete rest
                $to_delete = array_slice($ids, 1);
                foreach ($to_delete as $id) {
                    echo "<li>ID {$id} - {$title}</li>";
                }
            }
        }
        echo "</ul>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='delete_duplicates' value='1'>";
        echo "<button type='submit' style='background: red; color: white; padding: 10px 20px; border: none; cursor: pointer;'>DELETE ALL DUPLICATES</button>";
        echo "</form>";
    }
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $wpdb->delete($table_name, array('id' => $id), array('%d'));
    echo "<script>alert('Deleted menu item ID: {$id}'); window.location.href = window.location.pathname;</script>";
}

if (isset($_POST['delete_duplicates'])) {
    $menus = $wpdb->get_results("SELECT * FROM {$table_name} WHERE menu_location = 'primary' ORDER BY sort_order ASC");
    $title_count = array();
    $deleted_count = 0;
    
    foreach ($menus as $menu) {
        if (!isset($title_count[$menu->item_title])) {
            $title_count[$menu->item_title] = true; // Mark first as kept
        } else {
            // This is a duplicate, delete it
            $wpdb->delete($table_name, array('id' => $menu->id), array('%d'));
            $deleted_count++;
        }
    }
    
    echo "<script>alert('Deleted {$deleted_count} duplicate menu items'); window.location.href = window.location.pathname;</script>";
}
?>
