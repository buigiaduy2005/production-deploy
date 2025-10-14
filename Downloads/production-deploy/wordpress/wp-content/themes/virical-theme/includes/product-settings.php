<?php
/**
 * Product Settings Page
 * Manage product-related settings like warranty, support, commitments
 */

// Add settings menu
// add_action('admin_menu', 'virical_add_product_settings_menu');

function virical_add_product_settings_menu() {
    add_submenu_page(
        'virical-products',
        'Cài đặt sản phẩm',
        'Cài đặt sản phẩm',
        'manage_options',
        'virical-product-settings',
        'virical_product_settings_page'
    );
}

// Register settings
add_action('admin_init', 'virical_register_product_settings');

function virical_register_product_settings() {
    // Register settings group
    register_setting('virical_product_settings', 'virical_product_info');
    
    // Add sections
    add_settings_section(
        'virical_warranty_section',
        'Thông tin bảo hành & hỗ trợ',
        'virical_warranty_section_callback',
        'virical-product-settings'
    );
    
    add_settings_section(
        'virical_commitment_section',
        'Cam kết chất lượng',
        'virical_commitment_section_callback',
        'virical-product-settings'
    );
    
    add_settings_section(
        'virical_default_content_section',
        'Nội dung mặc định',
        'virical_default_content_section_callback',
        'virical-product-settings'
    );
    
    // Warranty fields
    add_settings_field(
        'warranty_period',
        'Thời gian bảo hành',
        'virical_product_text_field_callback',
        'virical-product-settings',
        'virical_warranty_section',
        array('field' => 'warranty_period', 'default' => '5 năm')
    );
    
    add_settings_field(
        'support_hours',
        'Giờ hỗ trợ',
        'virical_product_text_field_callback',
        'virical-product-settings',
        'virical_warranty_section',
        array('field' => 'support_hours', 'default' => '24/7')
    );
    
    add_settings_field(
        'warranty_description',
        'Mô tả bảo hành',
        'virical_product_textarea_field_callback',
        'virical-product-settings',
        'virical_warranty_section',
        array('field' => 'warranty_description', 'default' => 'Bảo hành chính hãng với chế độ 1 đổi 1 trong thời gian bảo hành')
    );
    
    // Commitment fields
    add_settings_field(
        'quality_commitment_title',
        'Tiêu đề cam kết',
        'virical_product_text_field_callback',
        'virical-product-settings',
        'virical_commitment_section',
        array('field' => 'quality_commitment_title', 'default' => 'Cam kết chất lượng từ Virical')
    );
    
    add_settings_field(
        'quality_commitment_intro',
        'Giới thiệu cam kết',
        'virical_product_textarea_field_callback',
        'virical-product-settings',
        'virical_commitment_section',
        array('field' => 'quality_commitment_intro', 'default' => 'Virical tự hào là thương hiệu đèn LED hàng đầu tại Việt Nam với cam kết:')
    );
    
    add_settings_field(
        'commitments',
        'Danh sách cam kết',
        'virical_product_textarea_field_callback',
        'virical-product-settings',
        'virical_commitment_section',
        array(
            'field' => 'commitments', 
            'default' => "Sản phẩm chính hãng 100% với chất lượng được kiểm định nghiêm ngặt\nBảo hành chính hãng lên đến 5 năm\nĐội ngũ tư vấn chuyên nghiệp, hỗ trợ 24/7\nDịch vụ lắp đặt tận nơi bởi đội ngũ kỹ thuật viên giàu kinh nghiệm\nChính sách đổi trả linh hoạt, đảm bảo quyền lợi khách hàng",
            'description' => 'Mỗi cam kết một dòng'
        )
    );
    
    // Default content fields
    add_settings_field(
        'default_product_intro',
        'Giới thiệu sản phẩm mặc định',
        'virical_product_textarea_field_callback',
        'virical-product-settings',
        'virical_default_content_section',
        array(
            'field' => 'default_product_intro',
            'default' => '{product_name} là một trong những sản phẩm đèn LED cao cấp được thiết kế với công nghệ hiện đại, mang đến giải pháp chiếu sáng hoàn hảo cho không gian của bạn. Với thiết kế sang trọng và hiệu suất vượt trội, sản phẩm này không chỉ đáp ứng nhu cầu chiếu sáng mà còn tạo điểm nhấn thẩm mỹ cho mọi công trình.',
            'description' => 'Sử dụng {product_name} để thay thế tên sản phẩm'
        )
    );
    
    add_settings_field(
        'product_benefits',
        'Lợi ích sản phẩm',
        'virical_product_textarea_field_callback',
        'virical-product-settings',
        'virical_default_content_section',
        array(
            'field' => 'product_benefits',
            'default' => "Tiết kiệm năng lượng lên đến 80% so với đèn truyền thống\nTuổi thọ cao lên đến 50,000 giờ\nÁnh sáng chất lượng cao, không nhấp nháy\nThân thiện với môi trường\nDễ dàng lắp đặt và bảo trì",
            'description' => 'Mỗi lợi ích một dòng'
        )
    );
    
    add_settings_field(
        'cta_text',
        'Lời kêu gọi hành động',
        'virical_product_textarea_field_callback',
        'virical-product-settings',
        'virical_default_content_section',
        array(
            'field' => 'cta_text',
            'default' => 'Để được tư vấn chi tiết về {product_name} và nhận báo giá tốt nhất, vui lòng liên hệ với chúng tôi:'
        )
    );
}

// Section callbacks
function virical_warranty_section_callback() {
    echo '<p>Cấu hình thông tin bảo hành và hỗ trợ khách hàng.</p>';
}

function virical_commitment_section_callback() {
    echo '<p>Quản lý các cam kết chất lượng hiển thị trên trang sản phẩm.</p>';
}

function virical_default_content_section_callback() {
    echo '<p>Nội dung mặc định cho các sản phẩm chưa có mô tả chi tiết.</p>';
}

// Field callbacks (reuse from company settings)
function virical_product_text_field_callback($args) {
    $options = get_option('virical_product_info');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : (isset($args['default']) ? $args['default'] : '');
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    ?>
    <input type="text" 
           name="virical_product_info[<?php echo $args['field']; ?>]" 
           value="<?php echo esc_attr($value); ?>"
           placeholder="<?php echo esc_attr($placeholder); ?>"
           class="regular-text" />
    <?php if (isset($args['description'])): ?>
        <p class="description"><?php echo $args['description']; ?></p>
    <?php endif;
}

function virical_product_textarea_field_callback($args) {
    $options = get_option('virical_product_info');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : (isset($args['default']) ? $args['default'] : '');
    ?>
    <textarea name="virical_product_info[<?php echo $args['field']; ?>]" 
              rows="5" 
              cols="50"
              class="large-text"><?php echo esc_textarea($value); ?></textarea>
    <?php if (isset($args['description'])): ?>
        <p class="description"><?php echo $args['description']; ?></p>
    <?php endif;
}

// Settings page
function virical_product_settings_page() {
    ?>
    <style>
    .virical-settings-wrap {
        max-width: 800px;
        margin-top: 20px;
    }
    .virical-settings-wrap .form-table th {
        width: 200px;
    }
    .virical-settings-wrap h2 {
        margin-top: 30px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ccc;
    }
    .virical-settings-header {
        background: #fff;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
    }
    .virical-settings-header h1 {
        margin: 0 0 10px 0;
    }
    .virical-settings-header p {
        margin: 0;
        color: #666;
    }
    .submit {
        margin-top: 20px;
    }
    </style>
    
    <div class="wrap virical-settings-wrap">
        <div class="virical-settings-header">
            <h1>Cài đặt sản phẩm</h1>
            <p>Quản lý thông tin bảo hành, cam kết chất lượng và nội dung mặc định cho sản phẩm</p>
        </div>
        
        <?php settings_errors(); ?>
        
        <form method="post" action="options.php">
            <?php
            settings_fields('virical_product_settings');
            do_settings_sections('virical-product-settings');
            submit_button('Lưu thay đổi');
            ?>
        </form>
        
        <hr style="margin: 40px 0;">
        
        <h3>Hướng dẫn sử dụng</h3>
        <p>Để hiển thị thông tin sản phẩm trong theme, sử dụng function:</p>
        <pre style="background: #f5f5f5; padding: 15px; border-radius: 4px;">
&lt;?php echo virical_get_product_setting('warranty_period'); ?&gt;
&lt;?php echo virical_get_product_setting('support_hours'); ?&gt;
&lt;?php 
// Lấy danh sách cam kết
$commitments = virical_get_product_commitments();
?&gt;</pre>
    </div>
    <?php
}

// Helper function to get product settings
function virical_get_product_setting($field, $default = '') {
    $options = get_option('virical_product_info');
    
    // Default values
    $defaults = array(
        'warranty_period' => '5 năm',
        'support_hours' => '24/7',
        'warranty_description' => 'Bảo hành chính hãng với chế độ 1 đổi 1 trong thời gian bảo hành',
        'quality_commitment_title' => 'Cam kết chất lượng từ Virical',
        'quality_commitment_intro' => 'Virical tự hào là thương hiệu đèn LED hàng đầu tại Việt Nam với cam kết:',
        'commitments' => "Sản phẩm chính hãng 100% với chất lượng được kiểm định nghiêm ngặt\nBảo hành chính hãng lên đến 5 năm\nĐội ngũ tư vấn chuyên nghiệp, hỗ trợ 24/7\nDịch vụ lắp đặt tận nơi bởi đội ngũ kỹ thuật viên giàu kinh nghiệm\nChính sách đổi trả linh hoạt, đảm bảo quyền lợi khách hàng",
        'default_product_intro' => '{product_name} là một trong những sản phẩm đèn LED cao cấp được thiết kế với công nghệ hiện đại, mang đến giải pháp chiếu sáng hoàn hảo cho không gian của bạn. Với thiết kế sang trọng và hiệu suất vượt trội, sản phẩm này không chỉ đáp ứng nhu cầu chiếu sáng mà còn tạo điểm nhấn thẩm mỹ cho mọi công trình.',
        'product_benefits' => "Tiết kiệm năng lượng lên đến 80% so với đèn truyền thống\nTuổi thọ cao lên đến 50,000 giờ\nÁnh sáng chất lượng cao, không nhấp nháy\nThân thiện với môi trường\nDễ dàng lắp đặt và bảo trì",
        'cta_text' => 'Để được tư vấn chi tiết về {product_name} và nhận báo giá tốt nhất, vui lòng liên hệ với chúng tôi:'
    );
    
    if (isset($options[$field]) && !empty($options[$field])) {
        return $options[$field];
    } elseif (isset($defaults[$field])) {
        return $defaults[$field];
    }
    
    return $default;
}

// Helper function to get commitments as array
function virical_get_product_commitments() {
    $commitments_text = virical_get_product_setting('commitments');
    return array_filter(array_map('trim', explode("\n", $commitments_text)));
}

// Helper function to get benefits as array
function virical_get_product_benefits() {
    $benefits_text = virical_get_product_setting('product_benefits');
    return array_filter(array_map('trim', explode("\n", $benefits_text)));
}

// Initialize default product settings
function virical_init_product_settings() {
    $options = get_option('virical_product_info');
    
    // If options don't exist, create with defaults
    if (!$options) {
        $defaults = array(
            'warranty_period' => '5 năm',
            'support_hours' => '24/7',
            'warranty_description' => 'Bảo hành chính hãng với chế độ 1 đổi 1 trong thời gian bảo hành',
            'quality_commitment_title' => 'Cam kết chất lượng từ Virical',
            'quality_commitment_intro' => 'Virical tự hào là thương hiệu đèn LED hàng đầu tại Việt Nam với cam kết:',
            'commitments' => "Sản phẩm chính hãng 100% với chất lượng được kiểm định nghiêm ngặt\nBảo hành chính hãng lên đến 5 năm\nĐội ngũ tư vấn chuyên nghiệp, hỗ trợ 24/7\nDịch vụ lắp đặt tận nơi bởi đội ngũ kỹ thuật viên giàu kinh nghiệm\nChính sách đổi trả linh hoạt, đảm bảo quyền lợi khách hàng",
            'default_product_intro' => '{product_name} là một trong những sản phẩm đèn LED cao cấp được thiết kế với công nghệ hiện đại, mang đến giải pháp chiếu sáng hoàn hảo cho không gian của bạn. Với thiết kế sang trọng và hiệu suất vượt trội, sản phẩm này không chỉ đáp ứng nhu cầu chiếu sáng mà còn tạo điểm nhấn thẩm mỹ cho mọi công trình.',
            'product_benefits' => "Tiết kiệm năng lượng lên đến 80% so với đèn truyền thống\nTuổi thọ cao lên đến 50,000 giờ\nÁnh sáng chất lượng cao, không nhấp nháy\nThân thiện với môi trường\nDễ dàng lắp đặt và bảo trì",
            'cta_text' => 'Để được tư vấn chi tiết về {product_name} và nhận báo giá tốt nhất, vui lòng liên hệ với chúng tôi:'
        );
        
        update_option('virical_product_info', $defaults);
    }
}

// Run initialization
add_action('after_switch_theme', 'virical_init_product_settings');
add_action('admin_init', function() {
    if (!get_option('virical_product_info')) {
        virical_init_product_settings();
    }
});