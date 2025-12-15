<?php
/**
 * Plugin Name: Gemini Product Manager
 * Description: A modern, single-page application for managing products and images within the WordPress admin.
 * Version: 2.2
 * Author: Gemini
 */

if (!defined('ABSPATH')) exit;

define('GPM_PLUGIN_URL', plugin_dir_url(__FILE__));

class GeminiProductManager_Complete {

    public function __construct() {
        add_action('init', [$this, 'gpm_register_product_post_type']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_ajax_gpm_get_products', [$this, 'gpm_get_products_ajax']);
        add_action('wp_ajax_gpm_get_single_product', [$this, 'gpm_get_single_product_ajax']);
        add_action('wp_ajax_gpm_save_product', [$this, 'gpm_save_product_ajax']);
        add_action('wp_ajax_gpm_delete_product', [$this, 'gpm_delete_product_ajax']);

        if (false === get_transient('gpm_pages_created')) {
            $this->create_classification_pages();
            set_transient('gpm_pages_created', true, DAY_IN_SECONDS);
        }
    }

    public function create_classification_pages() {
        $pages = ['Indoor', 'Outdoor'];
        foreach ($pages as $page_title) {
            $page = get_page_by_title($page_title, OBJECT, 'page');
            if ($page) {
                update_post_meta($page->ID, '_wp_page_template', 'page-templates/product-classification.php');
            } else {
                $page_id = wp_insert_post([
                    'post_title' => $page_title,
                    'post_status' => 'publish',
                    'post_type' => 'page',
                ]);
                if ($page_id) {
                    update_post_meta($page_id, '_wp_page_template', 'page-templates/product-classification.php');
                }
            }
        }
    }

    public function gpm_register_product_post_type() {
        $labels = ['name' => 'Products', 'singular_name' => 'Product'];
        $args = [
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'san-pham'],
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-store',
            'taxonomies' => array('category', 'post_tag', 'product_tag'),
        ];
        register_post_type('product', $args);

        register_taxonomy(
            'product_tag',
            'product',
            array(
                'label' => __( 'Product Tags' ),
                'rewrite' => array( 'slug' => 'product-tag' ),
                'hierarchical' => false,
            )
        );
    }

    public function add_admin_menu() {
        add_menu_page('Quản lý sản phẩm', 'Quản lý Sản phẩm', 'manage_options', 'gemini-product-manager', [$this, 'render_admin_page'], 'dashicons-store', 20);
    }

    public function render_admin_page() {
        ?>
        <div class="wrap gpm-wrap">
            <div class="gpm-header">
                <h1>Quản lý sản phẩm</h1>
                <div class="gpm-header-actions">
                    <button id="gpm-add-new-btn" class="button button-primary">Thêm sản phẩm mới</button>
                    <a href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=category')); ?>" class="button">Quản lý Danh mục</a>
                </div>
            </div>
            <div class="gpm-main-content">
                <div class="gpm-product-list-container">
                    <table id="gpm-product-table" class="wp-list-table widefat fixed striped">
                        <thead><tr><th>Ảnh</th><th>Tên sản phẩm</th><th>Nổi bật</th><th>Phân loại</th><th>Danh mục</th><th>Tình trạng kho</th><th>Trạng thái</th><th>Ngày cập nhật</th><th>Hành động</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div id="gpm-edit-form-container" class="gpm-edit-form-container" style="display: none;">
                    <h2 id="gpm-form-title"></h2>
                    <form id="gpm-product-form">
                        <input type="hidden" id="gpm-product-id" value="">
                        <div class="form-field">
                            <label for="gpm-product-name">Tên sản phẩm</label>
                            <input type="text" id="gpm-product-name" required>
                        </div>
                        <div class="form-field">
                            <label for="gpm-product-description">Mô tả</label>
                            <textarea id="gpm-product-description" rows="5"></textarea>
                        </div>
                        <div class="form-field">
                            <label for="gpm-product-price">Giá</label>
                            <input type="number" id="gpm-product-price" step="0.01">
                        </div>
                        <div class="form-field">
                            <label for="gpm-product-category">Danh mục</label>
                            <select id="gpm-product-category"><option value="">Chọn danh mục</option>
                            <?php
                                $categories = get_terms(['taxonomy' => 'category', 'hide_empty' => false]);
                                if (!is_wp_error($categories)) {
                                    foreach ($categories as $category) {
                                        echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                                    }
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="gpm-product-classification">Phân loại</label>
                            <select id="gpm-product-classification">
                                <option value="">Chọn phân loại</option>
                                <option value="indoor">Indoor</option>
                                <option value="outdoor">Outdoor</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="gpm-product-status">Trạng thái</label>
                            <select id="gpm-product-status">
                                <option value="publish">Đang bán (Publish)</option>
                                <option value="draft">Nháp (Draft)</option>
                                <option value="pending">Chờ duyệt (Pending)</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="gpm-stock-status">Tình trạng kho</label>
                            <select id="gpm-stock-status">
                                <option value="instock">Còn hàng</option>
                                <option value="outofstock">Hết hàng</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="gpm-is-featured">Sản phẩm tiêu biểu</label>
                            <input type="checkbox" id="gpm-is-featured">
                        </div>
                        <div class="form-field">
                            <label>Thư viện ảnh</label>
                            <div id="gpm-gallery-container" class="gpm-gallery-container"></div>
                            <input type="hidden" id="gpm-product-gallery-ids" value="">
                            <button type="button" id="gpm-add-gallery-images-btn" class="button">Thêm ảnh</button>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="button button-primary">Lưu thay đổi</button>
                            <button type="button" id="gpm-cancel-btn" class="button">Hủy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_gemini-product-manager' != $hook) return;
        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_style('gpm-admin-styles', GPM_PLUGIN_URL . 'css/admin-styles.css', [], '2.2');
        wp_enqueue_script('gpm-main-app', GPM_PLUGIN_URL . 'js/main-app.js', ['jquery', 'jquery-ui-sortable'], '2.2', true);
        wp_localize_script('gpm-main-app', 'gpm_ajax', ['ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('gpm_nonce')]);
    }

    public function gpm_get_products_ajax() {
        check_ajax_referer('gpm_nonce', 'nonce');
        $products_query = new WP_Query(['post_type' => 'product', 'posts_per_page' => -1, 'post_status' => 'any']);
        $products_data = [];
        if ($products_query->have_posts()) {
            while ($products_query->have_posts()) {
                $products_query->the_post();
                $product_id = get_the_ID();
                $categories = get_the_terms($product_id, 'category');
                $category_names = !is_wp_error($categories) && !empty($categories) ? wp_list_pluck($categories, 'name') : [];
                $products_data[] = [
                    'id' => $product_id,
                    'name' => get_the_title(),
                    'thumbnail' => get_the_post_thumbnail_url($product_id, 'thumbnail') ?: GPM_PLUGIN_URL . 'img/placeholder.png',
                    'is_featured' => get_post_meta($product_id, '_is_featured', true) == '1',
                    'classification' => get_post_meta($product_id, '_product_classification', true),
                    'categories' => implode(', ', $category_names),
                    'stock_status' => get_post_meta($product_id, '_stock_status', true) == 'instock' ? 'Còn hàng' : 'Hết hàng',
                    'status' => get_post_status(),
                    'updated_date' => get_the_modified_date('Y-m-d H:i:s')
                ];
            }
        }
        wp_reset_postdata();
        wp_send_json_success($products_data);
    }
    
    public function gpm_get_single_product_ajax() {
        check_ajax_referer('gpm_nonce', 'nonce');
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        if (!$product_id || get_post_type($product_id) !== 'product') wp_send_json_error(['message' => 'Product not found']);
        $post = get_post($product_id);
        $categories = get_the_terms($product_id, 'category');
        $category_id = (!empty($categories) && !is_wp_error($categories)) ? $categories[0]->term_id : 0;
        $gallery_ids_str = get_post_meta($product_id, '_product_image_gallery', true);
        $gallery_images = [];
        if (!empty($gallery_ids_str)) {
            foreach (explode(',', $gallery_ids_str) as $id) {
                $url = wp_get_attachment_image_url($id, 'thumbnail');
                if ($url) $gallery_images[$id] = $url;
            }
        }
        wp_send_json_success([
            'id' => $post->ID,
            'name' => $post->post_title,
            'description' => $post->post_content,
            'price' => get_post_meta($product_id, '_price', true),
            'status' => $post->post_status,
            'category_id' => $category_id,
            'is_featured' => get_post_meta($product_id, '_is_featured', true) == '1',
            'classification' => get_post_meta($product_id, '_product_classification', true),
            'stock_status' => get_post_meta($product_id, '_stock_status', true),
            'gallery_images' => $gallery_images
        ]);
    }

    public function gpm_save_product_ajax() {
        check_ajax_referer('gpm_nonce', 'nonce');
        $product_id = isset($_POST['product_id']) && !empty($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $post_data = [
            'post_title' => sanitize_text_field($_POST['name']),
            'post_content' => sanitize_textarea_field($_POST['description']),
            'post_type' => 'product',
            'post_status' => isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 'publish'
        ];
        if ($product_id) $post_data['ID'] = $product_id;
        $result = $product_id ? wp_update_post($post_data, true) : wp_insert_post($post_data, true);
        if (is_wp_error($result)) {
            error_log('GPM Save Error: ' . $result->get_error_message());
            wp_send_json_error(['message' => $result->get_error_message()]);
        } else {
            error_log('GPM Save POST data: ' . print_r($_POST, true));
            if (isset($_POST['price'])) update_post_meta($result, '_price', sanitize_text_field($_POST['price']));
            if (isset($_POST['stock_status'])) update_post_meta($result, '_stock_status', sanitize_text_field($_POST['stock_status']));
            if (isset($_POST['is_featured'])) update_post_meta($result, '_is_featured', $_POST['is_featured'] === 'true' ? '1' : '0');
            if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
                $category_ids = is_array($_POST['category_id']) ? array_map('intval', $_POST['category_id']) : array(intval($_POST['category_id']));
                $term_exists = term_exists($category_ids[0], 'category');
                if ($term_exists) {
                    wp_set_post_terms($result, $category_ids, 'category');
                } else {
                    error_log('GPM Save Error: Term does not exist: ' . $category_ids[0]);
                }
            }
            if (isset($_POST['classification'])) update_post_meta($result, '_product_classification', sanitize_text_field($_POST['classification']));
            if (isset($_POST['gallery_ids'])) {
                $gallery_ids = sanitize_text_field($_POST['gallery_ids']);
                $ids_array = array_filter(explode(',', $gallery_ids));
                if (!empty($ids_array)) { set_post_thumbnail($result, $ids_array[0]); } else { delete_post_thumbnail($result); }
                update_post_meta($result, '_product_image_gallery', $gallery_ids);
            }
            wp_send_json_success(['message' => 'Product saved successfully!']);
        }
    }

    public function gpm_delete_product_ajax() {
        check_ajax_referer('gpm_nonce', 'nonce');
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        if (!$product_id) wp_send_json_error(['message' => 'Invalid Product ID']);
        $result = wp_delete_post($product_id, true);
        if ($result) wp_send_json_success(['message' => 'Product deleted successfully.']);
        else wp_send_json_error(['message' => 'Error deleting product.']);
    }
}

new GeminiProductManager_Complete();
