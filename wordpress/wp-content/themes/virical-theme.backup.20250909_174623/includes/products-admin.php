<?php
/**
 * Products Admin Interface
 */

// Add admin menu
add_action('admin_menu', 'virical_add_products_menu');

function virical_add_products_menu() {
    add_menu_page(
        'Quản lý Sản phẩm',
        'Sản phẩm Virical',
        'manage_options',
        'virical-products',
        'virical_products_page',
        'dashicons-cart',
        30
    );
    
    add_submenu_page(
        'virical-products',
        'Danh mục sản phẩm',
        'Danh mục',
        'manage_options',
        'virical-categories',
        'virical_categories_page'
    );
}

// Products management page
function virical_products_page() {
    global $wpdb;
    
    // Handle actions
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add_product' && check_admin_referer('virical_add_product')) {
            virical_add_product($_POST);
        } elseif ($_POST['action'] === 'update_product' && check_admin_referer('virical_update_product')) {
            virical_update_product($_POST);
        }
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        if (check_admin_referer('delete_product_' . $_GET['id'])) {
            virical_delete_product($_GET['id']);
        }
    }
    
    // Get products
    $products = $wpdb->get_results("
        SELECT p.*, c.name as category_name 
        FROM {$wpdb->prefix}virical_products p
        LEFT JOIN {$wpdb->prefix}virical_product_categories c ON p.category = c.slug
        ORDER BY p.sort_order, p.id DESC
    ");
    
    $categories = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virical_product_categories ORDER BY sort_order");
    
    // Edit mode
    $edit_product = null;
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $edit_product = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}virical_products WHERE id = %d",
            $_GET['id']
        ));
    }
    ?>
    
    <style>
    .virical-admin-wrap {
        max-width: 1400px;
    }
    .virical-admin-wrap .card {
        max-width: none;
        margin-top: 20px;
        padding: 20px 30px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .virical-admin-wrap .form-table th {
        width: 200px;
        font-weight: 600;
    }
    .virical-admin-wrap .form-table td {
        padding: 15px 10px;
    }
    .virical-admin-wrap .regular-text,
    .virical-admin-wrap .large-text {
        width: 100%;
        max-width: 600px;
    }
    .virical-admin-wrap textarea.large-text {
        width: 100%;
        max-width: 800px;
    }
    .virical-admin-wrap .button-primary {
        height: 40px;
        padding: 0 20px;
        font-size: 14px;
    }
    .virical-admin-wrap .wp-editor-wrap {
        max-width: 800px;
    }
    .virical-product-image-preview {
        max-width: 200px;
        margin-top: 10px;
        border: 1px solid #ddd;
        padding: 5px;
        background: #f5f5f5;
    }
    .virical-product-image-preview img {
        max-width: 100%;
        height: auto;
    }
    .virical-features-hint {
        color: #666;
        font-style: italic;
        font-size: 13px;
        margin-top: 5px;
    }
    .virical-admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .virical-admin-header h1 {
        margin: 0;
    }
    .virical-stats {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    .virical-stat-box {
        background: #fff;
        padding: 15px 20px;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        text-align: center;
    }
    .virical-stat-box .stat-number {
        font-size: 24px;
        font-weight: 600;
        color: #2271b1;
    }
    .virical-stat-box .stat-label {
        color: #666;
        font-size: 13px;
    }
    </style>
    
    <div class="wrap virical-admin-wrap">
        <div class="virical-admin-header">
            <h1>Quản lý Sản phẩm</h1>
            <?php if (!$edit_product): ?>
                <a href="#product-form" class="button button-primary">+ Thêm sản phẩm mới</a>
            <?php endif; ?>
        </div>
        
        <!-- Statistics -->
        <div class="virical-stats">
            <div class="virical-stat-box">
                <div class="stat-number"><?php echo count($products); ?></div>
                <div class="stat-label">Tổng sản phẩm</div>
            </div>
            <div class="virical-stat-box">
                <div class="stat-number"><?php echo count(array_filter($products, function($p) { return $p->is_featured; })); ?></div>
                <div class="stat-label">Sản phẩm nổi bật</div>
            </div>
            <div class="virical-stat-box">
                <div class="stat-number"><?php echo count($categories); ?></div>
                <div class="stat-label">Danh mục</div>
            </div>
        </div>
        
        <!-- Add/Edit Product Form -->
        <div class="card" id="product-form">
            <h2><?php echo $edit_product ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới'; ?></h2>
            <form method="post" action="">
                <?php 
                if ($edit_product) {
                    wp_nonce_field('virical_update_product');
                    echo '<input type="hidden" name="action" value="update_product">';
                    echo '<input type="hidden" name="id" value="' . esc_attr($edit_product->id) . '">';
                } else {
                    wp_nonce_field('virical_add_product');
                    echo '<input type="hidden" name="action" value="add_product">';
                }
                ?>
                
                <table class="form-table">
                    <tr>
                        <th><label for="name">Tên sản phẩm</label></th>
                        <td><input type="text" id="name" name="name" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->name) : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="slug">Slug</label></th>
                        <td><input type="text" id="slug" name="slug" class="regular-text" value="<?php echo $edit_product ? esc_attr($edit_product->slug) : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="category">Danh mục</label></th>
                        <td>
                            <select id="category" name="category" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo esc_attr($cat->slug); ?>" <?php echo ($edit_product && $edit_product->category === $cat->slug) ? 'selected' : ''; ?>>
                                        <?php echo esc_html($cat->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="description">Mô tả ngắn</label></th>
                        <td>
                            <textarea id="description" name="description" rows="3" cols="50" class="large-text" placeholder="Mô tả ngắn về sản phẩm (hiển thị trong danh sách)"><?php echo $edit_product ? esc_textarea($edit_product->description) : ''; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="content">Nội dung chi tiết</label></th>
                        <td>
                            <?php 
                            $content = $edit_product ? $edit_product->content : '';
                            $editor_id = 'product_content';
                            $settings = array(
                                'textarea_name' => 'content',
                                'textarea_rows' => 15,
                                'media_buttons' => true,
                                'teeny' => false,
                                'quicktags' => true
                            );
                            wp_editor($content, $editor_id, $settings);
                            ?>
                            <p class="description">Nội dung chi tiết sẽ hiển thị ở trang chi tiết sản phẩm</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="price">Giá</label></th>
                        <td><input type="number" id="price" name="price" step="1000" value="<?php echo $edit_product ? esc_attr($edit_product->price) : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="image_url">Hình ảnh sản phẩm</label></th>
                        <td>
                            <input type="url" id="image_url" name="image_url" class="large-text" value="<?php echo $edit_product ? esc_attr($edit_product->image_url) : ''; ?>" placeholder="URL hình ảnh hoặc chọn từ thư viện">
                            <button type="button" class="button" onclick="virical_media_upload('image_url')">
                                <span class="dashicons dashicons-upload" style="vertical-align: middle;"></span> Chọn từ thư viện
                            </button>
                            <div id="image_preview" class="virical-product-image-preview" style="<?php echo ($edit_product && $edit_product->image_url) ? '' : 'display:none;'; ?>">
                                <?php if ($edit_product && $edit_product->image_url): ?>
                                    <img src="<?php echo esc_url($edit_product->image_url); ?>" alt="Product preview">
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="features">Tính năng</label></th>
                        <td>
                            <textarea id="features" name="features" rows="4" cols="50" placeholder="Mỗi tính năng một dòng"><?php 
                                if ($edit_product && $edit_product->features) {
                                    $features = json_decode($edit_product->features, true);
                                    echo is_array($features) ? implode("\n", $features) : '';
                                }
                            ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="is_featured">Sản phẩm nổi bật</label></th>
                        <td><input type="checkbox" id="is_featured" name="is_featured" value="1" <?php echo ($edit_product && $edit_product->is_featured) ? 'checked' : ''; ?>></td>
                    </tr>
                    <tr>
                        <th><label for="is_active">Kích hoạt</label></th>
                        <td><input type="checkbox" id="is_active" name="is_active" value="1" <?php echo (!$edit_product || $edit_product->is_active) ? 'checked' : ''; ?>></td>
                    </tr>
                    <tr>
                        <th><label for="sort_order">Thứ tự</label></th>
                        <td><input type="number" id="sort_order" name="sort_order" value="<?php echo $edit_product ? esc_attr($edit_product->sort_order) : '0'; ?>"></td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php echo $edit_product ? 'Cập nhật' : 'Thêm mới'; ?>">
                    <?php if ($edit_product): ?>
                        <a href="?page=virical-products" class="button">Hủy</a>
                    <?php endif; ?>
                </p>
            </form>
        </div>
        
        <!-- Products List -->
        <h2>Danh sách sản phẩm</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th style="width: 80px;">Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Nổi bật</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product->id; ?></td>
                    <td>
                        <?php if ($product->image_url): ?>
                            <img src="<?php echo esc_url($product->image_url); ?>" style="width: 60px; height: 60px; object-fit: cover;">
                        <?php endif; ?>
                    </td>
                    <td><strong><?php echo esc_html($product->name); ?></strong></td>
                    <td><?php echo esc_html($product->category_name); ?></td>
                    <td><?php echo $product->price ? number_format($product->price, 0, ',', '.') . ' VNĐ' : '-'; ?></td>
                    <td><?php echo $product->is_featured ? '<span class="dashicons dashicons-star-filled" style="color: #f0ad4e;"></span>' : '-'; ?></td>
                    <td><?php echo $product->is_active ? '<span style="color: green;">✓ Kích hoạt</span>' : '<span style="color: red;">✗ Tắt</span>'; ?></td>
                    <td>
                        <a href="?page=virical-products&action=edit&id=<?php echo $product->id; ?>" class="button button-small">Sửa</a>
                        <a href="<?php echo wp_nonce_url("?page=virical-products&action=delete&id={$product->id}", 'delete_product_' . $product->id); ?>" 
                           class="button button-small" 
                           onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script>
    function virical_media_upload(target_id) {
        var mediaUploader;
        
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Chọn hình ảnh',
            button: {
                text: 'Chọn hình ảnh'
            },
            multiple: false
        });
        
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            document.getElementById(target_id).value = attachment.url;
            
            // Show image preview
            if (target_id === 'image_url') {
                var preview = document.getElementById('image_preview');
                preview.innerHTML = '<img src="' + attachment.url + '" alt="Product preview">';
                preview.style.display = 'block';
            }
        });
        
        mediaUploader.open();
    }
    
    // Auto generate slug
    document.getElementById('name').addEventListener('blur', function() {
        var slug_field = document.getElementById('slug');
        if (!slug_field.value) {
            slug_field.value = this.value.toLowerCase()
                .replace(/[àáảãạâầấẩẫậăằắẳẵặ]/g, 'a')
                .replace(/[èéẻẽẹêềếểễệ]/g, 'e')
                .replace(/[ìíỉĩị]/g, 'i')
                .replace(/[òóỏõọôồốổỗộơờớởỡợ]/g, 'o')
                .replace(/[ùúủũụưừứửữự]/g, 'u')
                .replace(/[ỳýỷỹỵ]/g, 'y')
                .replace(/đ/g, 'd')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });
    
    // Preview image on URL change
    document.getElementById('image_url').addEventListener('blur', function() {
        var url = this.value;
        var preview = document.getElementById('image_preview');
        
        if (url) {
            preview.innerHTML = '<img src="' + url + '" alt="Product preview" onerror="this.style.display=\'none\'">';
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });
    </script>
    <?php
}

// Add product function
function virical_add_product($data) {
    global $wpdb;
    
    $features = isset($data['features']) ? array_filter(array_map('trim', explode("\n", $data['features']))) : [];
    
    $result = $wpdb->insert(
        $wpdb->prefix . 'virical_products',
        array(
            'name' => sanitize_text_field($data['name']),
            'slug' => sanitize_title($data['slug'] ?: $data['name']),
            'description' => wp_kses_post($data['description']),
            'content' => wp_kses_post($data['content']),
            'category' => sanitize_text_field($data['category']),
            'price' => floatval($data['price']),
            'image_url' => esc_url_raw($data['image_url']),
            'features' => json_encode($features),
            'is_featured' => isset($data['is_featured']) ? 1 : 0,
            'is_active' => isset($data['is_active']) ? 1 : 0,
            'sort_order' => intval($data['sort_order'])
        )
    );
    
    if ($result) {
        echo '<div class="notice notice-success"><p>Sản phẩm đã được thêm thành công!</p></div>';
    }
}

// Update product function
function virical_update_product($data) {
    global $wpdb;
    
    $features = isset($data['features']) ? array_filter(array_map('trim', explode("\n", $data['features']))) : [];
    
    $result = $wpdb->update(
        $wpdb->prefix . 'virical_products',
        array(
            'name' => sanitize_text_field($data['name']),
            'slug' => sanitize_title($data['slug'] ?: $data['name']),
            'description' => wp_kses_post($data['description']),
            'content' => wp_kses_post($data['content']),
            'category' => sanitize_text_field($data['category']),
            'price' => floatval($data['price']),
            'image_url' => esc_url_raw($data['image_url']),
            'features' => json_encode($features),
            'is_featured' => isset($data['is_featured']) ? 1 : 0,
            'is_active' => isset($data['is_active']) ? 1 : 0,
            'sort_order' => intval($data['sort_order'])
        ),
        array('id' => intval($data['id']))
    );
    
    if ($result !== false) {
        echo '<div class="notice notice-success"><p>Sản phẩm đã được cập nhật!</p></div>';
    }
}

// Delete product function
function virical_delete_product($id) {
    global $wpdb;
    
    $result = $wpdb->delete(
        $wpdb->prefix . 'virical_products',
        array('id' => intval($id))
    );
    
    if ($result) {
        echo '<div class="notice notice-success"><p>Sản phẩm đã được xóa!</p></div>';
    }
}

// Categories management page
function virical_categories_page() {
    global $wpdb;
    
    // Handle form submission
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add_category' && check_admin_referer('virical_add_category')) {
            virical_add_category($_POST);
        }
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        if (check_admin_referer('delete_category_' . $_GET['id'])) {
            virical_delete_category($_GET['id']);
        }
    }
    
    $categories = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virical_product_categories ORDER BY sort_order");
    ?>
    
    <div class="wrap">
        <h1>Danh mục sản phẩm</h1>
        
        <div class="card">
            <h2>Thêm danh mục mới</h2>
            <form method="post" action="">
                <?php wp_nonce_field('virical_add_category'); ?>
                <input type="hidden" name="action" value="add_category">
                
                <table class="form-table">
                    <tr>
                        <th><label for="cat_name">Tên danh mục</label></th>
                        <td><input type="text" id="cat_name" name="name" class="regular-text" required></td>
                    </tr>
                    <tr>
                        <th><label for="cat_slug">Slug</label></th>
                        <td><input type="text" id="cat_slug" name="slug" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="cat_description">Mô tả</label></th>
                        <td><textarea id="cat_description" name="description" rows="3" cols="50"></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="cat_sort_order">Thứ tự</label></th>
                        <td><input type="number" id="cat_sort_order" name="sort_order" value="0"></td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" class="button-primary" value="Thêm danh mục">
                </p>
            </form>
        </div>
        
        <h2>Danh sách danh mục</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Mô tả</th>
                    <th>Thứ tự</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?php echo $cat->id; ?></td>
                    <td><strong><?php echo esc_html($cat->name); ?></strong></td>
                    <td><?php echo esc_html($cat->slug); ?></td>
                    <td><?php echo esc_html($cat->description); ?></td>
                    <td><?php echo $cat->sort_order; ?></td>
                    <td>
                        <a href="<?php echo wp_nonce_url("?page=virical-categories&action=delete&id={$cat->id}", 'delete_category_' . $cat->id); ?>" 
                           class="button button-small" 
                           onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script>
    document.getElementById('cat_name').addEventListener('blur', function() {
        var slug_field = document.getElementById('cat_slug');
        if (!slug_field.value) {
            slug_field.value = this.value.toLowerCase()
                .replace(/[àáảãạâầấẩẫậăằắẳẵặ]/g, 'a')
                .replace(/[èéẻẽẹêềếểễệ]/g, 'e')
                .replace(/[ìíỉĩị]/g, 'i')
                .replace(/[òóỏõọôồốổỗộơờớởỡợ]/g, 'o')
                .replace(/[ùúủũụưừứửữự]/g, 'u')
                .replace(/[ỳýỷỹỵ]/g, 'y')
                .replace(/đ/g, 'd')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });
    </script>
    <?php
}

// Add category function
function virical_add_category($data) {
    global $wpdb;
    
    $result = $wpdb->insert(
        $wpdb->prefix . 'virical_product_categories',
        array(
            'name' => sanitize_text_field($data['name']),
            'slug' => sanitize_title($data['slug'] ?: $data['name']),
            'description' => sanitize_textarea_field($data['description']),
            'sort_order' => intval($data['sort_order']),
            'is_active' => 1
        )
    );
    
    if ($result) {
        echo '<div class="notice notice-success"><p>Danh mục đã được thêm thành công!</p></div>';
    }
}

// Delete category function
function virical_delete_category($id) {
    global $wpdb;
    
    // Check if category has products
    $count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}virical_products WHERE category = 
        (SELECT slug FROM {$wpdb->prefix}virical_product_categories WHERE id = %d)",
        $id
    ));
    
    if ($count > 0) {
        echo '<div class="notice notice-error"><p>Không thể xóa danh mục đang có sản phẩm!</p></div>';
        return;
    }
    
    $result = $wpdb->delete(
        $wpdb->prefix . 'virical_product_categories',
        array('id' => intval($id))
    );
    
    if ($result) {
        echo '<div class="notice notice-success"><p>Danh mục đã được xóa!</p></div>';
    }
}

// Enqueue media uploader
add_action('admin_enqueue_scripts', 'virical_enqueue_media_uploader');
function virical_enqueue_media_uploader() {
    if (isset($_GET['page']) && ($_GET['page'] === 'virical-products' || $_GET['page'] === 'virical-categories')) {
        wp_enqueue_media();
    }
}
?>