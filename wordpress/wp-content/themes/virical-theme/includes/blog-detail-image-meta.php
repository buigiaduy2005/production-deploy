<?php
/**
 * Blog Post Detail Image Meta Box
 * Adds a separate detail image field for blog posts
 */

// Add meta box for detail image
add_action('add_meta_boxes', 'virical_blog_detail_image_meta_box', 10);
function virical_blog_detail_image_meta_box() {
    add_meta_box(
        'blog_detail_image_meta',
        'Hình ảnh chi tiết (Hiển thị trong bài viết)',
        'virical_blog_detail_image_callback',
        'blog_post',
        'side',
        'default'
    );
}

// Meta box callback
function virical_blog_detail_image_callback($post) {
    wp_nonce_field('blog_detail_image_nonce', 'blog_detail_image_nonce_field');
    
    $detail_image_id = get_post_meta($post->ID, '_blog_detail_image_id', true);
    $detail_image_url = $detail_image_id ? wp_get_attachment_url($detail_image_id) : '';
    ?>
    <div class="blog-detail-image-wrapper">
        <input type="hidden" id="blog_detail_image_id" name="blog_detail_image_id" value="<?php echo esc_attr($detail_image_id); ?>">
        
        <div id="blog_detail_image_preview" style="margin-bottom: 10px;">
            <?php if ($detail_image_url): ?>
                <img src="<?php echo esc_url($detail_image_url); ?>" style="max-width: 100%; height: auto; display: block; border: 1px solid #ddd; padding: 5px;">
            <?php else: ?>
                <p style="color: #666; font-style: italic;">Chưa có hình ảnh chi tiết</p>
            <?php endif; ?>
        </div>
        
        <p>
            <button type="button" class="button button-primary" id="upload_blog_detail_image_button">
                <?php echo $detail_image_url ? 'Thay đổi hình ảnh' : 'Chọn hình ảnh chi tiết'; ?>
            </button>
            <?php if ($detail_image_url): ?>
                <button type="button" class="button" id="remove_blog_detail_image_button">Xóa hình ảnh</button>
            <?php endif; ?>
        </p>
        
        <p class="description">
            <strong>Lưu ý:</strong><br>
            - <strong>Hình đại diện</strong> (Featured Image): Hiển thị trong danh sách bài viết<br>
            - <strong>Hình chi tiết</strong> (ở đây): Hiển thị bên trong bài viết
        </p>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        $('#upload_blog_detail_image_button').on('click', function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: 'Chọn hình ảnh chi tiết',
                button: {
                    text: 'Sử dụng hình này'
                },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#blog_detail_image_id').val(attachment.id);
                $('#blog_detail_image_preview').html('<img src="' + attachment.url + '" style="max-width: 100%; height: auto; display: block; border: 1px solid #ddd; padding: 5px;">');
                $('#upload_blog_detail_image_button').text('Thay đổi hình ảnh');
                
                if ($('#remove_blog_detail_image_button').length === 0) {
                    $('#upload_blog_detail_image_button').after(' <button type="button" class="button" id="remove_blog_detail_image_button">Xóa hình ảnh</button>');
                }
            });
            
            mediaUploader.open();
        });
        
        $(document).on('click', '#remove_blog_detail_image_button', function(e) {
            e.preventDefault();
            $('#blog_detail_image_id').val('');
            $('#blog_detail_image_preview').html('<p style="color: #666; font-style: italic;">Chưa có hình ảnh chi tiết</p>');
            $('#upload_blog_detail_image_button').text('Chọn hình ảnh chi tiết');
            $(this).remove();
        });
    });
    </script>
    <?php
}

// Save meta box data
add_action('save_post', 'virical_save_blog_detail_image');
function virical_save_blog_detail_image($post_id) {
    // Check nonce
    if (!isset($_POST['blog_detail_image_nonce_field']) || !wp_verify_nonce($_POST['blog_detail_image_nonce_field'], 'blog_detail_image_nonce')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Check post type
    if (get_post_type($post_id) !== 'blog_post') {
        return;
    }
    
    // Save detail image ID
    if (isset($_POST['blog_detail_image_id'])) {
        update_post_meta($post_id, '_blog_detail_image_id', sanitize_text_field($_POST['blog_detail_image_id']));
    } else {
        delete_post_meta($post_id, '_blog_detail_image_id');
    }
}

// Enqueue media uploader
add_action('admin_enqueue_scripts', 'virical_blog_detail_image_scripts');
function virical_blog_detail_image_scripts($hook) {
    global $post_type;
    
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        if ($post_type === 'blog_post') {
            wp_enqueue_media();
        }
    }
}
