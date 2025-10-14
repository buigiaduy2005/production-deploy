<?php
/**
 * Template Name: Test Products
 */

get_header();
?>

<div style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
    <h1>Test Sản phẩm từ Database</h1>
    
    <?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_products';
    
    // Kiểm tra bảng
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;
    echo "<p>Bảng $table_name: " . ($table_exists ? "Tồn tại ✓" : "Không tồn tại ✗") . "</p>";
    
    if ($table_exists) {
        // Đếm sản phẩm
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        echo "<p>Số sản phẩm trong database: $count</p>";
        
        // Lấy sản phẩm
        $products = $wpdb->get_results("SELECT * FROM $table_name WHERE status = 'publish' LIMIT 5");
        
        if ($products) {
            echo "<h2>Danh sách sản phẩm:</h2>";
            echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;'>";
            
            foreach ($products as $product) {
                ?>
                <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                    <?php if ($product->image_url): ?>
                        <img src="<?php echo esc_url($product->image_url); ?>" 
                             style="width: 100%; height: 150px; object-fit: cover; margin-bottom: 10px;">
                    <?php endif; ?>
                    <h3><?php echo esc_html($product->name); ?></h3>
                    <p><?php echo esc_html($product->short_description); ?></p>
                    <p><strong>Giá: <?php echo number_format($product->price); ?>đ</strong></p>
                    <p>ID: <?php echo $product->id; ?> | Slug: <?php echo $product->slug; ?></p>
                    <a href="<?php echo home_url('/?page_id=31&product=' . $product->slug); ?>" 
                       style="background: #667eea; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block;">
                        Xem chi tiết
                    </a>
                </div>
                <?php
            }
            
            echo "</div>";
        } else {
            echo "<p>Không tìm thấy sản phẩm nào.</p>";
        }
    }
    ?>
    
    <hr style="margin: 40px 0;">
    
    <h2>Test Shortcode</h2>
    <?php echo do_shortcode('[virical_product_detail]'); ?>
</div>

<?php get_footer(); ?>