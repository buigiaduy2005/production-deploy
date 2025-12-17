<?php
/**
 * Register Slider Custom Post Type
 */

function virical_register_slider_post_type() {
    $labels = array(
        'name'                  => 'Hero Sliders',
        'singular_name'         => 'Slider',
        'menu_name'             => 'Hero Sliders',
        'add_new'               => 'Thêm Slider',
        'add_new_item'          => 'Thêm Slider Mới',
        'edit_item'             => 'Chỉnh Sửa Slider',
        'new_item'              => 'Slider Mới',
        'view_item'             => 'Xem Slider',
        'search_items'          => 'Tìm Slider',
        'not_found'             => 'Không tìm thấy slider',
        'not_found_in_trash'    => 'Không có slider trong thùng rác',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-images-alt2',
        'supports'              => array('title', 'thumbnail'),
        'has_archive'           => false,
        'rewrite'               => false,
        'capability_type'       => 'post',
        'menu_position'         => 20,
    );

    register_post_type('aura_slider', $args);
}
add_action('init', 'virical_register_slider_post_type');

// Add meta boxes for slider
function virical_slider_meta_boxes() {
    add_meta_box(
        'slider_details',
        'Thông Tin Slider',
        'virical_slider_details_callback',
        'aura_slider',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'virical_slider_meta_boxes');

// Meta box callback
function virical_slider_details_callback($post) {
    wp_nonce_field('slider_details_nonce', 'slider_details_nonce_field');
    
    $subtitle = get_post_meta($post->ID, '_slide_subtitle', true);
    $link = get_post_meta($post->ID, '_slide_link', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="slide_subtitle">Tiêu đề hiển thị</label></th>
            <td>
                <input type="text" id="slide_subtitle" name="slide_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="large-text" />
                <p class="description">Text hiển thị trên slide (để trống nếu không cần)</p>
            </td>
        </tr>
        <tr>
            <th><label for="slide_link">Đường dẫn (Link)</label></th>
            <td>
                <input type="url" id="slide_link" name="slide_link" value="<?php echo esc_url($link); ?>" class="large-text" placeholder="https://..." />
                <p class="description">URL khi click vào slide (để trống nếu không cần)</p>
            </td>
        </tr>
    </table>
    
    <div style="margin-top: 20px; padding: 15px; background: #f0f0f1; border-left: 4px solid #2271b1;">
        <h4 style="margin-top: 0;">Hướng dẫn:</h4>
        <ol style="margin: 0;">
            <li><strong>Tiêu đề</strong>: Nhập tiêu đề bài viết (dùng để quản lý)</li>
            <li><strong>Hình ảnh đại diện</strong>: Click "Đặt hình đại diện" ở sidebar bên phải để upload hình slider</li>
            <li><strong>Tiêu đề hiển thị</strong>: Text sẽ hiển thị trên slide</li>
            <li><strong>Đường dẫn</strong>: URL khi người dùng click vào slide</li>
            <li><strong>Thứ tự</strong>: Kéo thả để sắp xếp thứ tự slides trong danh sách</li>
        </ol>
    </div>
    <?php
}

// Save meta box data
function virical_save_slider_meta($post_id) {
    if (!isset($_POST['slider_details_nonce_field']) || 
        !wp_verify_nonce($_POST['slider_details_nonce_field'], 'slider_details_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['slide_subtitle'])) {
        update_post_meta($post_id, '_slide_subtitle', sanitize_text_field($_POST['slide_subtitle']));
    }

    if (isset($_POST['slide_link'])) {
        update_post_meta($post_id, '_slide_link', esc_url_raw($_POST['slide_link']));
    }
}
add_action('save_post_aura_slider', 'virical_save_slider_meta');

// Add custom columns to slider list
function virical_slider_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['image'] = 'Hình ảnh';
    $new_columns['title'] = 'Tiêu đề';
    $new_columns['subtitle'] = 'Tiêu đề hiển thị';
    $new_columns['link'] = 'Link';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_aura_slider_posts_columns', 'virical_slider_columns');

// Display custom column content
function virical_slider_column_content($column, $post_id) {
    switch ($column) {
        case 'image':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(80, 80));
            } else {
                echo '<span style="color: #999;">Chưa có hình</span>';
            }
            break;
        case 'subtitle':
            $subtitle = get_post_meta($post_id, '_slide_subtitle', true);
            echo $subtitle ? esc_html($subtitle) : '<span style="color: #999;">—</span>';
            break;
        case 'link':
            $link = get_post_meta($post_id, '_slide_link', true);
            if ($link) {
                echo '<a href="' . esc_url($link) . '" target="_blank">' . esc_html($link) . '</a>';
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
    }
}
add_action('manage_aura_slider_posts_custom_column', 'virical_slider_column_content', 10, 2);

// Make columns sortable
function virical_slider_sortable_columns($columns) {
    $columns['subtitle'] = 'subtitle';
    return $columns;
}
add_filter('manage_edit-aura_slider_sortable_columns', 'virical_slider_sortable_columns');
