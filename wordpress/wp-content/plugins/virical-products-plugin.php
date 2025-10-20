<?php
/**
 * Plugin Name: Virical Products Manager
 * Plugin URI: https://virical.vn
 * Description: Quản lý sản phẩm đèn thông minh Virical
 * Version: 1.0.0
 * Author: Virical Team
 * Text Domain: virical-products
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Định nghĩa constants
define('VIRICAL_PRODUCTS_VERSION', '1.0.0');
define('VIRICAL_PRODUCTS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('VIRICAL_PRODUCTS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Kích hoạt plugin - tạo bảng database
register_activation_hook(__FILE__, 'virical_products_activate');
function virical_products_activate() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'virical_products';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) UNIQUE NOT NULL,
        description TEXT,
        short_description TEXT,
        price DECIMAL(10, 2),
        sale_price DECIMAL(10, 2),
        sku VARCHAR(100),
        stock_quantity INT DEFAULT 0,
        image_url VARCHAR(500),
        gallery TEXT,
        category VARCHAR(100),
        features TEXT,
        specifications TEXT,
        is_featured BOOLEAN DEFAULT FALSE,
        status VARCHAR(20) DEFAULT 'publish',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_slug (slug),
        INDEX idx_status (status),
        INDEX idx_featured (is_featured)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // Thêm option để lưu version
    add_option('virical_products_version', VIRICAL_PRODUCTS_VERSION);
}

// Thêm menu admin
// add_action('admin_menu', 'virical_products_admin_menu');
function virical_products_admin_menu() {
    add_menu_page(
        'Virical Products',
        'Virical Products',
        'manage_options',
        'virical-products',
        'virical_products_admin_page',
        'dashicons-lightbulb',
        30
    );
    
    add_submenu_page(
        'virical-products',
        'Thêm sản phẩm mới',
        'Thêm mới',
        'manage_options',
        'virical-products-add',
        'virical_products_add_page'
    );
}

// Trang danh sách sản phẩm
function virical_products_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_products';
    
    // Xử lý xóa sản phẩm
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $wpdb->delete($table_name, array('id' => intval($_GET['id'])));
        echo '<div class="notice notice-success"><p>Đã xóa sản phẩm!</p></div>';
    }
    
    $products = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    ?>
    <div class="wrap">
        <h1>Quản lý sản phẩm Virical <a href="?page=virical-products-add" class="page-title-action">Thêm mới</a></h1>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>SKU</th>
                    <th>Giá</th>
                    <th>Kho</th>
                    <th>Nổi bật</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product->id; ?></td>
                    <td>
                        <?php if ($product->image_url): ?>
                            <img src="<?php echo esc_url($product->image_url); ?>" width="50" height="50" style="object-fit: cover;">
                        <?php endif; ?>
                    </td>
                    <td><strong><?php echo esc_html($product->name); ?></strong></td>
                    <td><?php echo esc_html($product->sku); ?></td>
                    <td>
                        <?php if ($product->sale_price): ?>
                            <del><?php echo number_format($product->price); ?>đ</del><br>
                            <strong><?php echo number_format($product->sale_price); ?>đ</strong>
                        <?php else: ?>
                            <?php echo number_format($product->price); ?>đ
                        <?php endif; ?>
                    </td>
                    <td><?php echo $product->stock_quantity; ?></td>
                    <td><?php echo $product->is_featured ? '⭐' : ''; ?></td>
                    <td><?php echo $product->status; ?></td>
                    <td>
                        <a href="?page=virical-products-add&id=<?php echo $product->id; ?>" class="button button-small">Sửa</a>
                        <a href="?page=virical-products&action=delete&id=<?php echo $product->id; ?>" 
                           class="button button-small" 
                           onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

// Trang thêm/sửa sản phẩm
function virical_products_add_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_products';
    
    $product = null;
    if (isset($_GET['id'])) {
        $product = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", intval($_GET['id'])));
    }
    
    // Xử lý form submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $data = array(
            'name' => sanitize_text_field($_POST['name']),
            'slug' => sanitize_title($_POST['slug'] ?: $_POST['name']),
            'description' => wp_kses_post($_POST['description']),
            'short_description' => sanitize_textarea_field($_POST['short_description']),
            'price' => floatval($_POST['price']),
            'sale_price' => floatval($_POST['sale_price']),
            'sku' => sanitize_text_field($_POST['sku']),
            'stock_quantity' => intval($_POST['stock_quantity']),
            'image_url' => esc_url_raw($_POST['image_url']),
            'gallery' => sanitize_textarea_field($_POST['gallery']),
            'category' => sanitize_text_field($_POST['category']),
            'features' => sanitize_textarea_field($_POST['features']),
            'specifications' => sanitize_textarea_field($_POST['specifications']),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'status' => sanitize_text_field($_POST['status'])
        );
        
        if ($product) {
            $wpdb->update($table_name, $data, array('id' => $product->id));
            echo '<div class="notice notice-success"><p>Đã cập nhật sản phẩm!</p></div>';
        } else {
            $wpdb->insert($table_name, $data);
            echo '<div class="notice notice-success"><p>Đã thêm sản phẩm mới!</p></div>';
        }
    }
    ?>
    <div class="wrap">
        <h1><?php echo $product ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới'; ?></h1>
        
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th><label for="name">Tên sản phẩm *</label></th>
                    <td><input type="text" name="name" id="name" class="regular-text" required 
                               value="<?php echo $product ? esc_attr($product->name) : ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="slug">Slug (URL)</label></th>
                    <td><input type="text" name="slug" id="slug" class="regular-text" 
                               value="<?php echo $product ? esc_attr($product->slug) : ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="short_description">Mô tả ngắn</label></th>
                    <td><textarea name="short_description" id="short_description" rows="3" class="large-text"><?php echo $product ? esc_textarea($product->short_description) : ''; ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="description">Mô tả chi tiết</label></th>
                    <td>
                        <?php 
                        wp_editor(
                            $product ? $product->description : '', 
                            'description',
                            array('textarea_rows' => 10)
                        ); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="price">Giá gốc (VNĐ)</label></th>
                    <td><input type="number" name="price" id="price" class="regular-text" 
                               value="<?php echo $product ? $product->price : ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="sale_price">Giá khuyến mãi (VNĐ)</label></th>
                    <td><input type="number" name="sale_price" id="sale_price" class="regular-text" 
                               value="<?php echo $product ? $product->sale_price : ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="sku">Mã sản phẩm (SKU)</label></th>
                    <td><input type="text" name="sku" id="sku" class="regular-text" 
                               value="<?php echo $product ? esc_attr($product->sku) : ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="stock_quantity">Số lượng trong kho</label></th>
                    <td><input type="number" name="stock_quantity" id="stock_quantity" class="regular-text" 
                               value="<?php echo $product ? $product->stock_quantity : '0'; ?>"></td>
                </tr>
                <tr>
                    <th><label for="image_url">URL hình ảnh chính</label></th>
                    <td>
                        <input type="url" name="image_url" id="image_url" class="large-text" 
                               value="<?php echo $product ? esc_url($product->image_url) : ''; ?>">
                        <button type="button" class="button" onclick="wpMediaUploader('image_url')">Chọn ảnh</button>
                    </td>
                </tr>
                <tr>
                    <th><label for="category">Danh mục</label></th>
                    <td>
                        <select name="category" id="category">
                            <option value="">-- Chọn danh mục --</option>
                            <option value="smart-bulb" <?php echo ($product && $product->category == 'smart-bulb') ? 'selected' : ''; ?>>Bóng đèn thông minh</option>
                            <option value="led-strip" <?php echo ($product && $product->category == 'led-strip') ? 'selected' : ''; ?>>Dây LED</option>
                            <option value="smart-switch" <?php echo ($product && $product->category == 'smart-switch') ? 'selected' : ''; ?>>Công tắc thông minh</option>
                            <option value="ceiling-light" <?php echo ($product && $product->category == 'ceiling-light') ? 'selected' : ''; ?>>Đèn ốp trần</option>
                            <option value="sensor-light" <?php echo ($product && $product->category == 'sensor-light') ? 'selected' : ''; ?>>Đèn cảm biến</option>
                            <option value="smart-hub" <?php echo ($product && $product->category == 'smart-hub') ? 'selected' : ''; ?>>Hub điều khiển</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="features">Tính năng (JSON array)</label></th>
                    <td>
                        <textarea name="features" id="features" rows="4" class="large-text"><?php echo $product ? esc_textarea($product->features) : '["Tính năng 1", "Tính năng 2"]'; ?></textarea>
                        <p class="description">Ví dụ: ["16 triệu màu", "Điều khiển app", "Tiết kiệm điện"]</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="specifications">Thông số kỹ thuật (JSON)</label></th>
                    <td>
                        <textarea name="specifications" id="specifications" rows="4" class="large-text"><?php echo $product ? esc_textarea($product->specifications) : '{"power": "9W", "voltage": "220V"}'; ?></textarea>
                        <p class="description">Ví dụ: {"power": "9W", "voltage": "220V", "lumens": "800lm"}</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="is_featured">Sản phẩm nổi bật</label></th>
                    <td><input type="checkbox" name="is_featured" id="is_featured" value="1" 
                               <?php echo ($product && $product->is_featured) ? 'checked' : ''; ?>></td>
                </tr>
                <tr>
                    <th><label for="status">Trạng thái</label></th>
                    <td>
                        <select name="status" id="status">
                            <option value="publish" <?php echo ($product && $product->status == 'publish') ? 'selected' : ''; ?>>Đã xuất bản</option>
                            <option value="draft" <?php echo ($product && $product->status == 'draft') ? 'selected' : ''; ?>>Bản nháp</option>
                            <option value="pending" <?php echo ($product && $product->status == 'pending') ? 'selected' : ''; ?>>Chờ duyệt</option>
                        </select>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="submit" class="button button-primary" 
                       value="<?php echo $product ? 'Cập nhật sản phẩm' : 'Thêm sản phẩm'; ?>">
                <a href="?page=virical-products" class="button">Hủy</a>
            </p>
        </form>
    </div>
    
    <script>
    function wpMediaUploader(fieldId) {
        var frame = wp.media({
            title: 'Chọn hình ảnh',
            button: { text: 'Sử dụng ảnh này' },
            multiple: false
        });
        
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            document.getElementById(fieldId).value = attachment.url;
        });
        
        frame.open();
    }
    </script>
    <?php
}

// API để lấy sản phẩm
function virical_get_products($args = array()) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_products';

    $defaults = array(
        'status'   => 'publish',
        'limit'    => -1,
        'featured' => null,
        'category' => null,
    );
    $args = wp_parse_args($args, $defaults);

    $where  = array();
    $values = array();

    if ( ! empty( $args['status'] ) ) {
        $where[]  = 'status = %s';
        $values[] = $args['status'];
    }

    if ( null !== $args['featured'] ) {
        $where[]  = 'is_featured = %d';
        $values[] = $args['featured'] ? 1 : 0;
    }

    if ( ! empty( $args['category'] ) ) {
        $where[]  = 'category = %s';
        $values[] = $args['category'];
    }

    $where_clause = '';
    if ( ! empty( $where ) ) {
        $where_clause = 'WHERE ' . implode(' AND ', $where);
    }

    $query = "SELECT * FROM {$table_name} {$where_clause} ORDER BY created_at DESC";

    if ( $args['limit'] > 0 ) {
        $query   .= ' LIMIT %d';
        $values[] = (int) $args['limit'];
    }

    if ( empty( $values ) ) {
        return $wpdb->get_results( $query );
    }

    return $wpdb->get_results( $wpdb->prepare( $query, $values ) );
}

// Shortcode để hiển thị sản phẩm
add_shortcode('virical_products', 'virical_products_shortcode');
function virical_products_shortcode($atts) {
    $atts = shortcode_atts(array(
        'featured' => '',
        'category' => '',
        'limit' => 6
    ), $atts);
    
    $args = array(
        'limit' => intval($atts['limit'])
    );
    
    if ($atts['featured'] !== '') {
        $args['featured'] = $atts['featured'] === 'true';
    }
    
    if ($atts['category']) {
        $args['category'] = $atts['category'];
    }
    
    $products = virical_get_products($args);
    
    ob_start();
    ?>
    <div class="virical-products-grid">
        <?php foreach ($products as $product): ?>
            <div class="virical-product-card">
                <a href="<?php echo home_url('/san-pham/' . $product->slug); ?>">
                    <?php if ($product->image_url): ?>
                        <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->name); ?>">
                    <?php endif; ?>
                    <h3><?php echo esc_html($product->name); ?></h3>
                    <p><?php echo esc_html($product->short_description); ?></p>
                    <div class="price">
                        <?php if ($product->sale_price): ?>
                            <del><?php echo number_format($product->price); ?>đ</del>
                            <strong><?php echo number_format($product->sale_price); ?>đ</strong>
                        <?php else: ?>
                            <strong><?php echo number_format($product->price); ?>đ</strong>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
?>