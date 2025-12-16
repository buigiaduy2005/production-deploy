<?php
/**
 * Homepage Promo Grid Admin Panel
 * Allows editing of promotional cards on the homepage
 */

// Add admin menu
add_action('admin_menu', 'virical_promo_grid_menu');
function virical_promo_grid_menu() {
    add_menu_page(
        'Quản lý Promo Grid',
        'Promo Grid',
        'manage_options',
        'virical-promo-grid',
        'virical_promo_grid_page',
        'dashicons-grid-view',
        30
    );
}

// Admin page content
function virical_promo_grid_page() {
    // Handle form submission
    if (isset($_POST['virical_promo_submit']) && check_admin_referer('virical_promo_save', 'virical_promo_nonce')) {
        virical_save_promo_data();
        echo '<div class="notice notice-success"><p>Đã lưu thành công!</p></div>';
    }
    
    // Get current promo data
    $promo_data = get_option('virical_promo_grid_data', virical_get_default_promo_data());
    
    ?>
    <div class="wrap">
        <h1>Quản lý Promo Grid - Trang chủ</h1>
        <p>Chỉnh sửa các card khuyến mãi hiển thị trên trang chủ</p>
        
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('virical_promo_save', 'virical_promo_nonce'); ?>
            
            <div class="promo-grid-admin">
                <?php
                $promo_items = [
                    'promo_highlight' => 'Card Khuyến Mãi Nổi Bật (Trái trên)',
                    'smart_lock' => 'Khóa Thông Minh (Phải trên)',
                    'aqara_hub' => 'Aqara Hub (Trái giữa)',
                    'doorbell' => 'Chuông Cửa Thông Minh (Phải giữa)',
                    'lighting' => 'Giải Pháp Chiếu Sáng (Trái dưới 1)',
                    'smart_switch' => 'Công Tắc Thông Minh (Phải dưới 1)',
                    'curtain' => 'Rèm Cửa Tự Động (Trái dưới 2)',
                    'sensor' => 'Cảm Biến An Ninh (Phải dưới 2)'
                ];
                
                foreach ($promo_items as $key => $label) {
                    $item = isset($promo_data[$key]) ? $promo_data[$key] : [];
                    virical_render_promo_item_form($key, $label, $item);
                }
                ?>
            </div>
            
            <p class="submit">
                <input type="submit" name="virical_promo_submit" class="button button-primary" value="Lưu thay đổi">
            </p>
        </form>
    </div>
    
    <style>
        .promo-grid-admin {
            background: #fff;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .promo-item-form {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            background: #f9f9f9;
            border-radius: 4px;
        }
        .promo-item-form h3 {
            margin-top: 0;
            color: #23282d;
            border-bottom: 2px solid #0073aa;
            padding-bottom: 10px;
        }
        .form-row {
            margin-bottom: 15px;
        }
        .form-row label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .form-row input[type="text"],
        .form-row textarea {
            width: 100%;
            max-width: 600px;
        }
        .form-row textarea {
            height: 80px;
        }
        .image-preview {
            margin-top: 10px;
            max-width: 300px;
        }
        .image-preview img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .upload-button {
            margin-top: 5px;
        }
        .badge-inputs {
            display: flex;
            gap: 10px;
        }
        .badge-inputs input {
            flex: 1;
        }
    </style>
    <?php
}

// Render individual promo item form
function virical_render_promo_item_form($key, $label, $item) {
    $title = isset($item['title']) ? $item['title'] : '';
    $description = isset($item['description']) ? $item['description'] : '';
    $image_url = isset($item['image_url']) ? $item['image_url'] : '';
    $video_url = isset($item['video_url']) ? $item['video_url'] : '';
    $link = isset($item['link']) ? $item['link'] : '';
    $badge1 = isset($item['badge1']) ? $item['badge1'] : '';
    $badge2 = isset($item['badge2']) ? $item['badge2'] : '';
    $terms = isset($item['terms']) ? $item['terms'] : '';
    $type = isset($item['type']) ? $item['type'] : 'content'; // 'content', 'image', or 'video'
    
    ?>
    <div class="promo-item-form">
        <h3><?php echo esc_html($label); ?></h3>
        
        <div class="form-row">
            <label>Loại hiển thị:</label>
            <select name="promo[<?php echo $key; ?>][type]" class="promo-type-select" data-key="<?php echo $key; ?>">
                <option value="content" <?php selected($type, 'content'); ?>>Chỉ có nội dung (Text)</option>
                <option value="image" <?php selected($type, 'image'); ?>>Có hình ảnh nền</option>
                <option value="video" <?php selected($type, 'video'); ?>>Có video nền</option>
            </select>
        </div>
        
        <div class="form-row">
            <label>Tiêu đề:</label>
            <input type="text" name="promo[<?php echo $key; ?>][title]" value="<?php echo esc_attr($title); ?>" class="regular-text">
        </div>
        
        <div class="form-row">
            <label>Mô tả:</label>
            <textarea name="promo[<?php echo $key; ?>][description]" class="regular-text"><?php echo esc_textarea($description); ?></textarea>
        </div>
        
        <div class="form-row image-row" style="<?php echo ($type === 'content' || $type === 'video') ? 'display:none;' : ''; ?>">
            <label>Hình ảnh nền:</label>
            <input type="text" name="promo[<?php echo $key; ?>][image_url]" value="<?php echo esc_url($image_url); ?>" class="regular-text image-url-input" id="image_url_<?php echo $key; ?>">
            <button type="button" class="button upload-button" data-target="image_url_<?php echo $key; ?>" data-type="image">Chọn hình ảnh</button>
            <?php if ($image_url): ?>
                <div class="image-preview">
                    <img src="<?php echo esc_url($image_url); ?>" alt="Preview">
                </div>
            <?php endif; ?>
        </div>
        
        <div class="form-row video-row" style="<?php echo $type !== 'video' ? 'display:none;' : ''; ?>">
            <label>Video nền (MP4, WebM, max 10MB):</label>
            <input type="text" name="promo[<?php echo $key; ?>][video_url]" value="<?php echo esc_url($video_url); ?>" class="regular-text video-url-input" id="video_url_<?php echo $key; ?>">
            <button type="button" class="button upload-button" data-target="video_url_<?php echo $key; ?>" data-type="video">Chọn video</button>
            <?php if ($video_url): ?>
                <div class="video-preview">
                    <video width="300" controls>
                        <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            <?php endif; ?>
            <p class="description">Khuyến nghị: Video ngắn 5-15 giây, định dạng MP4, kích thước dưới 10MB</p>
        </div>
        
        <div class="form-row">
            <label>Đường dẫn (Link):</label>
            <input type="text" name="promo[<?php echo $key; ?>][link]" value="<?php echo esc_url($link); ?>" class="regular-text" placeholder="https://...">
        </div>
        
        <?php if ($key === 'promo_highlight'): ?>
        <div class="form-row">
            <label>Badges (Nhãn khuyến mãi):</label>
            <div class="badge-inputs">
                <input type="text" name="promo[<?php echo $key; ?>][badge1]" value="<?php echo esc_attr($badge1); ?>" placeholder="Trị giá 5.500k">
                <input type="text" name="promo[<?php echo $key; ?>][badge2]" value="<?php echo esc_attr($badge2); ?>" placeholder="Trị giá 15.500k">
            </div>
        </div>
        
        <div class="form-row">
            <label>Điều khoản:</label>
            <input type="text" name="promo[<?php echo $key; ?>][terms]" value="<?php echo esc_attr($terms); ?>" class="regular-text" placeholder="Áp dụng từ: 01/12 đến 31/12/2025">
        </div>
        <?php endif; ?>
    </div>
    <?php
}

// Save promo data
function virical_save_promo_data() {
    if (!isset($_POST['promo']) || !is_array($_POST['promo'])) {
        return;
    }
    
    $promo_data = [];
    foreach ($_POST['promo'] as $key => $item) {
        $promo_data[$key] = [
            'type' => sanitize_text_field($item['type']),
            'title' => sanitize_text_field($item['title']),
            'description' => sanitize_textarea_field($item['description']),
            'image_url' => esc_url_raw($item['image_url']),
            'video_url' => isset($item['video_url']) ? esc_url_raw($item['video_url']) : '',
            'link' => esc_url_raw($item['link']),
            'badge1' => isset($item['badge1']) ? sanitize_text_field($item['badge1']) : '',
            'badge2' => isset($item['badge2']) ? sanitize_text_field($item['badge2']) : '',
            'terms' => isset($item['terms']) ? sanitize_text_field($item['terms']) : '',
        ];
    }
    
    update_option('virical_promo_grid_data', $promo_data);
}

// Get default promo data
function virical_get_default_promo_data() {
    return [
        'promo_highlight' => [
            'type' => 'content',
            'title' => 'CHƯƠNG TRÌNH KHUYẾN MẠI THÁNG 12',
            'description' => 'Tặng ngay Xiaomi Lockin & Aqara Smart Locks',
            'badge1' => 'Trị giá 5.500k',
            'badge2' => 'Trị giá 15.500k',
            'terms' => 'Áp dụng từ: 01/12 đến 31/12/2025',
            'link' => '',
            'image_url' => ''
        ],
        'smart_lock' => [
            'type' => 'image',
            'title' => 'KHÓA THÔNG MINH',
            'description' => 'A100 & D100 ZIGBEE - U50',
            'link' => '',
            'image_url' => ''
        ],
        'aqara_hub' => [
            'type' => 'image',
            'title' => 'AQARA HUB',
            'description' => 'M3 & M2 CENTER',
            'link' => '',
            'image_url' => ''
        ],
        'doorbell' => [
            'type' => 'image',
            'title' => 'CHUÔNG CỬA THÔNG MINH',
            'description' => 'G4 VIDEO DOORBELL',
            'link' => '',
            'image_url' => ''
        ],
        'lighting' => [
            'type' => 'content',
            'title' => 'GIẢI PHÁP CHIẾU SÁNG',
            'description' => 'Thiết kế ánh sáng chuyên nghiệp',
            'link' => '',
            'image_url' => ''
        ],
        'smart_switch' => [
            'type' => 'content',
            'title' => 'CÔNG TẮC THÔNG MINH',
            'description' => 'Điều khiển mọi thứ trong tầm tay',
            'link' => '',
            'image_url' => ''
        ],
        'curtain' => [
            'type' => 'content',
            'title' => 'RÈM CỬA TỰ ĐỘNG',
            'description' => 'Tiện nghi và sang trọng',
            'link' => '',
            'image_url' => ''
        ],
        'sensor' => [
            'type' => 'content',
            'title' => 'CẢM BIẾN AN NINH',
            'description' => 'Bảo vệ ngôi nhà bạn 24/7',
            'link' => '',
            'image_url' => ''
        ]
    ];
}

// Enqueue media uploader
add_action('admin_enqueue_scripts', 'virical_promo_admin_scripts');
function virical_promo_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_virical-promo-grid') {
        return;
    }
    
    wp_enqueue_media();
    wp_enqueue_script('virical-promo-admin', get_template_directory_uri() . '/js/promo-admin.js', ['jquery'], '1.0', true);
}
