<?php
/**
 * Fix Menu Sort Order - Đặt lại thứ tự menu đúng
 */

require_once('wordpress/wp-config.php');

echo "<h1>🔧 Fix Menu Sort Order</h1>";
echo "<hr>";

global $wpdb;
$table_name = $wpdb->prefix . 'virical_navigation_menus';

// Get current menu items
$menus = $wpdb->get_results("SELECT * FROM {$table_name} WHERE menu_location = 'primary' ORDER BY sort_order ASC, id ASC");

echo "<h2>Current Menu Order:</h2>";
echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Title</th><th>Current Sort Order</th><th>New Sort Order</th></tr>";

$new_order = 1;
foreach ($menus as $menu) {
    echo "<tr>";
    echo "<td>{$menu->id}</td>";
    echo "<td><strong>{$menu->item_title}</strong></td>";
    echo "<td>{$menu->sort_order}</td>";
    echo "<td style='color: green; font-weight: bold;'>{$new_order}</td>";
    echo "</tr>";
    $new_order++;
}
echo "</table>";

// Ask for confirmation
if (!isset($_POST['confirm_fix'])) {
    echo "<form method='post'>";
    echo "<p><strong>Thứ tự menu sẽ được đặt lại từ 1 đến " . count($menus) . " theo thứ tự hiện tại trong database.</strong></p>";
    echo "<input type='hidden' name='confirm_fix' value='1'>";
    echo "<button type='submit' style='background: #0073aa; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 16px;'>✓ Xác nhận và Fix</button>";
    echo "</form>";
} else {
    // Fix the sort order
    echo "<h2>Fixing Sort Order...</h2>";
    
    $new_order = 1;
    foreach ($menus as $menu) {
        $wpdb->update(
            $table_name,
            array('sort_order' => $new_order),
            array('id' => $menu->id),
            array('%d'),
            array('%d')
        );
        echo "<p style='color: green;'>✓ Updated ID {$menu->id} ({$menu->item_title}) to sort_order = {$new_order}</p>";
        $new_order++;
    }
    
    echo "<hr>";
    echo "<h2>✅ Done! Thứ tự menu đã được fix</h2>";
    echo "<p><a href='/' target='_blank' style='padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>👁️ Xem Website</a></p>";
    echo "<p><a href='http://localhost:8080/wp-admin/admin.php?page=virical-menu-manager' style='padding: 10px 20px; background: #2196F3; color: white; text-decoration: none; border-radius: 5px;'>⚙️ Quản lý Menu</a></p>";
}

// Show desired order
echo "<hr>";
echo "<h2>📋 Thứ tự menu bạn muốn:</h2>";
echo "<p>Nếu bạn muốn thứ tự khác, hãy vào trang <strong>Quản lý Menu</strong> và sắp xếp lại:</p>";
echo "<ol>";
echo "<li><strong>Trang chủ</strong> - Thứ tự 1</li>";
echo "<li><strong>Sản phẩm</strong> - Thứ tự 2</li>";
echo "<li><strong>Giới thiệu</strong> - Thứ tự 3</li>";
echo "<li><strong>Giải pháp thông minh</strong> - Thứ tự 4</li>";
echo "<li><strong>Liên hệ</strong> - Thứ tự 5</li>";
echo "</ol>";

echo "<hr>";
echo "<h3>💡 Hướng dẫn sắp xếp menu:</h3>";
echo "<ol>";
echo "<li>Vào <strong>WordPress Admin > Quản lý Menu</strong></li>";
echo "<li>Thay đổi số trong cột <strong>Thứ tự</strong></li>";
echo "<li>Hoặc click nút <strong>▲</strong> (lên) / <strong>▼</strong> (xuống)</li>";
echo "<li>Thứ tự sẽ tự động lưu</li>";
echo "<li>Refresh website để xem kết quả</li>";
echo "</ol>";
?>
