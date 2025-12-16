<?php
/**
 * Slider Video Meta Box
 * Adds video upload capability to aura_slider post type
 */

// Add meta box
add_action('add_meta_boxes', 'virical_slider_video_meta_box');
function virical_slider_video_meta_box() {
    add_meta_box(
        'slider_video_meta',
        'Slider Video (Optional)',
        'virical_slider_video_meta_callback',
        'aura_slider',
        'normal',
        'high'
    );
}

// Meta box callback
function virical_slider_video_meta_callback($post) {
    wp_nonce_field('slider_video_meta_nonce', 'slider_video_nonce');
    
    $video_url = get_post_meta($post->ID, '_slide_video_url', true);
    ?>
    <div class="slider-video-meta-box">
        <p>
            <label for="slide_video_url"><strong>Video URL (MP4, WebM):</strong></label><br>
            <input type="text" id="slide_video_url" name="slide_video_url" value="<?php echo esc_url($video_url); ?>" style="width: 70%;">
            <button type="button" class="button upload-video-button" data-target="slide_video_url">Choose Video</button>
        </p>
        
        <?php if ($video_url): ?>
        <div class="video-preview-container">
            <p><strong>Video Preview:</strong></p>
            <video width="400" controls>
                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <?php endif; ?>
        
        <p class="description">
            <strong>Note:</strong> If a video is uploaded, it will be used instead of the featured image for this slide.<br>
            Recommended: Video duration 5-15 seconds, file size under 20MB, MP4 format.<br>
            Video will autoplay, loop, and be muted for best user experience.
        </p>
    </div>
    
    <style>
        .slider-video-meta-box {
            padding: 10px 0;
        }
        .slider-video-meta-box label {
            display: block;
            margin-bottom: 5px;
        }
        .slider-video-meta-box input[type="text"] {
            margin-bottom: 10px;
        }
        .upload-video-button {
            margin-left: 10px;
        }
        .video-preview-container {
            margin-top: 15px;
            padding: 15px;
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .video-preview-container video {
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
        }
    </style>
    <?php
}

// Save meta box data
add_action('save_post', 'virical_save_slider_video_meta');
function virical_save_slider_video_meta($post_id) {
    // Check nonce
    if (!isset($_POST['slider_video_nonce']) || !wp_verify_nonce($_POST['slider_video_nonce'], 'slider_video_meta_nonce')) {
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
    if (get_post_type($post_id) !== 'aura_slider') {
        return;
    }
    
    // Save video URL
    if (isset($_POST['slide_video_url'])) {
        update_post_meta($post_id, '_slide_video_url', esc_url_raw($_POST['slide_video_url']));
    }
}

// Enqueue media uploader script
add_action('admin_enqueue_scripts', 'virical_slider_video_admin_scripts');
function virical_slider_video_admin_scripts($hook) {
    global $post_type;
    
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        if ($post_type === 'aura_slider') {
            wp_enqueue_media();
            wp_enqueue_script('slider-video-admin', get_template_directory_uri() . '/js/slider-video-admin.js', array('jquery'), '1.0', true);
        }
    }
}
