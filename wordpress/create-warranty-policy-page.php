<?php
// Include WordPress
define('WP_USE_THEMES', false);
require('./wp-load.php');

// Page details
$page_title = 'Chính Sách Bảo Hành';
$page_content = '
    <h2>Chính Sách Bảo Hành</h2>
    <p>Sản phẩm chính hãng 100% với chất lượng được kiểm định nghiêm ngặt</p>
    <h3>Thời gian bảo hành: 5 năm kể từ ngày mua hàng</h3>
    <h3>Điều kiện bảo hành:</h3>
    <ul>
        <li>Sản phẩm còn trong thời hạn bảo hành</li>
        <li>Có hóa đơn mua hàng và phiếu bảo hành</li>
        <li>Sản phẩm bị lỗi do nhà sản xuất</li>
        <li>Không tự ý sửa chữa hoặc thay đổi cấu trúc sản phẩm</li>
    </ul>
';
$page_slug = 'chinh-sach-bao-hanh';

// Check if page already exists
$page_check = get_page_by_path($page_slug);

// If page doesn't exist, create it
if(!isset($page_check->ID)){
    $new_page = array(
        'post_type' => 'page',
        'post_title' => $page_title,
        'post_content' => $page_content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_name' => $page_slug
    );
    $page_id = wp_insert_post($new_page);
    if($page_id){
        echo 'Page "'.$page_title.'" created successfully with ID: '.$page_id;
    } else {
        echo 'Error creating page.';
    }
} else {
    echo 'Page "'.$page_title.'" already exists.';
}
?>