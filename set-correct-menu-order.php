<?php
/**
 * Set Correct Menu Order - Đặt thứ tự menu theo yêu cầu
 */

require_once('wordpress/wp-config.php');

echo "<h1>🎯 Set Correct Menu Order</h1>";
echo "<hr>";

global $wpdb;
$table_name = $wpdb->prefix . 'virical_navigation_menus';

// Define the desired order based on the image
$desired_order = array(
    'Trang chủ' => 1,
    'Sản phẩm' => 2,
    'Giới thiệu' => 3,
    'Giải pháp thông minh' => 4,
    'Liên hệ' => 5,
);

// Get all primary menu items
$menus = $wpdb->get_results("SELECT * FROM {$table_name} WHERE menu_location = 'primary' AND parent_id IS NULL ORDER BY id ASC");

echo "<h2>📋 Thứ tự menu mong muốn:</h2>";
echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
echo "<tr style='background: #f0f0f0;'><th>Thứ tự</th><th>Tiêu đề</th><th>Status</th></tr>";

foreach ($desired_order as $title => $order) {
    echo "<tr>";
    echo "<td style='text-align: center; font-weight: bold; font-size: 18px;'>{$order}</td>";
    echo "<td><strong>{$title}</strong></td>";
    
    // Check if exists
    $exists = false;
    foreach ($menus as $menu) {
        if (stripos($menu->item_title, $title) !== false || stripos($title, $menu->item_title) !== false) {
            $exists = true;
            break;
        }
    }
    
    if ($exists) {
        echo "<td style='color: green;'>✓ Tồn tại</td>";
    } else {
        echo "<td style='color: red;'>✗ Không tìm thấy</td>";
    }
    echo "</tr>";
}
echo "</table>";

// Show current menu items
echo "<h2>📊 Menu items hiện tại:</h2>";
echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Tiêu đề</th><th>Current Order</th><th>New Order</th></tr>";

foreach ($menus as $menu) {
    $new_order = null;
    foreach ($desired_order as $title => $order) {
        if (stripos($menu->item_title, $title) !== false || stripos($title, $menu->item_title) !== false) {
            $new_order = $order;
            break;
        }
    }
    
    if ($new_order === null) {
        $new_order = 99; // Put unknown items at the end
    }
    
    $color = $menu->sort_order != $new_order ? 'color: red;' : 'color: green;';
    
    echo "<tr>";
    echo "<td>{$menu->id}</td>";
    echo "<td><strong>{$menu->item_title}</strong></td>";
    echo "<td>{$menu->sort_order}</td>";
    echo "<td style='{$color} font-weight: bold;'>{$new_order}</td>";
    echo "</tr>";
}
echo "</table>";

// Fix button
if (!isset($_POST['apply_fix'])) {
    echo "<form method='post'>";
    echo "<p><strong>Click nút bên dưới để áp dụng thứ tự mới</strong></p>";
    echo "<input type='hidden' name='apply_fix' value='1'>";
    echo "<button type='submit' style='background: #4CAF50; color: white; padding: 15px 30px; border: none; cursor: pointer; font-size: 18px; border-radius: 5px;'>✓ Áp dụng thứ tự mới</button>";
    echo "</form>";
} else {
    echo "<h2>🔧 Đang cập nhật thứ tự...</h2>";
    
    foreach ($menus as $menu) {
        $new_order = null;
        foreach ($desired_order as $title => $order) {
            if (stripos($menu->item_title, $title) !== false || stripos($title, $menu->item_title) !== false) {
                $new_order = $order;
                break;
            }
        }
        
        if ($new_order === null) {
            $new_order = 99;
        }
        
        $wpdb->update(
            $table_name,
            array('sort_order' => $new_order),
            array('id' => $menu->id),
            array('%d'),
            array('%d')
        );
        
        echo "<p style='color: green;'>✓ Updated <strong>{$menu->item_title}</strong> (ID: {$menu->id}) to sort_order = {$new_order}</p>";
    }
    
    echo "<hr>";
    echo "<h2>✅ Hoàn thành!</h2>";
    echo "<p style='font-size: 18px;'><strong>Thứ tự menu đã được cập nhật thành công!</strong></p>";
    echo "<p><a href='/' target='_blank' style='display: inline-block; margin: 10px; padding: 15px 30px; background: #2196F3; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;'>👁️ Xem Website</a></p>";
    echo "<p><a href='http://localhost:8080/wp-admin/admin.php?page=virical-menu-manager' style='display: inline-block; margin: 10px; padding: 15px 30px; background: #FF9800; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;'>⚙️ Quản lý Menu</a></p>";
    
    echo "<hr>";
    echo "<h3>🔄 Nếu menu vẫn chưa đúng:</h3>";
    echo "<ol>";
    echo "<li>Clear browser cache (Ctrl+Shift+Delete)</li>";
    echo "<li>Refresh trang web (F5)</li>";
    echo "<li>Kiểm tra lại trong Quản lý Menu</li>";
    echo "</ol>";
}
?>
