<?php
/**
 * Company Settings Page
 * Manage company information like contact, address, social media
 */

// Add settings menu
add_action('admin_menu', 'virical_add_company_settings_menu');

function virical_add_company_settings_menu() {
    add_submenu_page(
        'virical-products',
        'Cài đặt thông tin',
        'Thông tin công ty',
        'manage_options',
        'virical-company-settings',
        'virical_company_settings_page'
    );
}

// Register settings
add_action('admin_init', 'virical_register_company_settings');

function virical_register_company_settings() {
    // Register settings group
    register_setting('virical_company_settings', 'virical_company_info');
    
    // Add sections
    add_settings_section(
        'virical_contact_section',
        'Thông tin liên hệ',
        'virical_contact_section_callback',
        'virical-company-settings'
    );
    
    add_settings_section(
        'virical_social_section',
        'Mạng xã hội',
        'virical_social_section_callback',
        'virical-company-settings'
    );
    
    // Contact fields
    add_settings_field(
        'company_name',
        'Tên công ty',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'company_name', 'default' => 'Virical Lighting')
    );
    
    add_settings_field(
        'tagline',
        'Tagline',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'tagline', 'default' => 'Feeling Light')
    );
    
    add_settings_field(
        'company_description',
        'Mô tả công ty',
        'virical_textarea_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'company_description', 'default' => 'Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.')
    );
    
    add_settings_field(
        'hotline',
        'Hotline',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'hotline', 'default' => '1900 xxxx')
    );
    
    add_settings_field(
        'phone',
        'Số điện thoại',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'phone', 'default' => '024.6656.2688')
    );
    
    add_settings_field(
        'mobile',
        'Di động',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'mobile', 'default' => '0963.954.969')
    );
    
    add_settings_field(
        'email',
        'Email',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'email', 'default' => 'info@virical.vn')
    );
    
    add_settings_field(
        'address',
        'Địa chỉ',
        'virical_textarea_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'address', 'default' => 'Số 8 Tôn Thất Thuyết, Cầu Giấy, Hà Nội')
    );
    
    add_settings_field(
        'working_hours',
        'Giờ làm việc',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'working_hours', 'default' => 'Thứ 2 - Thứ 6: 8:00 - 17:30')
    );
    
    add_settings_field(
        'copyright_text',
        'Copyright Text',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'copyright_text', 'default' => '© {year} Virical. All Rights Reserved. | Designed by Virical Team')
    );
    
    add_settings_field(
        'google_maps_url',
        'Google Maps URL',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_contact_section',
        array('field' => 'google_maps_url', 'placeholder' => 'https://maps.google.com/...')
    );
    
    // Social media fields
    add_settings_field(
        'facebook',
        'Facebook',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_social_section',
        array('field' => 'facebook', 'placeholder' => 'https://facebook.com/virical')
    );
    
    add_settings_field(
        'youtube',
        'YouTube',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_social_section',
        array('field' => 'youtube', 'placeholder' => 'https://youtube.com/@virical')
    );
    
    add_settings_field(
        'zalo',
        'Zalo',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_social_section',
        array('field' => 'zalo', 'placeholder' => 'https://zalo.me/virical')
    );
    
    add_settings_field(
        'instagram',
        'Instagram',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_social_section',
        array('field' => 'instagram', 'placeholder' => 'https://instagram.com/virical')
    );
    
    add_settings_field(
        'linkedin',
        'LinkedIn',
        'virical_text_field_callback',
        'virical-company-settings',
        'virical_social_section',
        array('field' => 'linkedin', 'placeholder' => 'https://linkedin.com/company/virical')
    );
}

// Section callbacks
function virical_contact_section_callback() {
    echo '<p>Cấu hình thông tin liên hệ của công ty. Thông tin này sẽ được hiển thị trên website.</p>';
}

function virical_social_section_callback() {
    echo '<p>Liên kết mạng xã hội của công ty.</p>';
}

// Field callbacks
function virical_text_field_callback($args) {
    $options = get_option('virical_company_info');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : (isset($args['default']) ? $args['default'] : '');
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    ?>
    <input type="text" 
           name="virical_company_info[<?php echo $args['field']; ?>]" 
           value="<?php echo esc_attr($value); ?>"
           placeholder="<?php echo esc_attr($placeholder); ?>"
           class="regular-text" />
    <?php
}

function virical_textarea_field_callback($args) {
    $options = get_option('virical_company_info');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : (isset($args['default']) ? $args['default'] : '');
    ?>
    <textarea name="virical_company_info[<?php echo $args['field']; ?>]" 
              rows="3" 
              cols="50"
              class="large-text"><?php echo esc_textarea($value); ?></textarea>
    <?php
}

// Settings page
function virical_company_settings_page() {
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
            <h1>Thông tin công ty</h1>
            <p>Quản lý thông tin liên hệ và mạng xã hội hiển thị trên website</p>
        </div>
        
        <?php settings_errors(); ?>
        
        <form method="post" action="options.php">
            <?php
            settings_fields('virical_company_settings');
            do_settings_sections('virical-company-settings');
            submit_button('Lưu thay đổi');
            ?>
        </form>
        
        <hr style="margin: 40px 0;">
        
        <h3>Hướng dẫn sử dụng</h3>
        <p>Để hiển thị thông tin công ty trong theme, sử dụng function:</p>
        <pre style="background: #f5f5f5; padding: 15px; border-radius: 4px;">
&lt;?php echo virical_get_company_info('hotline'); ?&gt;
&lt;?php echo virical_get_company_info('email'); ?&gt;
&lt;?php echo virical_get_company_info('address'); ?&gt;</pre>
    </div>
    <?php
}

// Helper function to get company info
function virical_get_company_info($field, $default = '') {
    $options = get_option('virical_company_info');
    
    // Default values
    $defaults = array(
        'company_name' => 'Virical Lighting',
        'tagline' => 'Feeling Light',
        'company_description' => 'Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.',
        'hotline' => '1900 xxxx',
        'phone' => '024.6656.2688',
        'mobile' => '0963.954.969',
        'email' => 'info@virical.vn',
        'address' => 'Số 8 Tôn Thất Thuyết, Cầu Giấy, Hà Nội',
        'working_hours' => 'Thứ 2 - Thứ 6: 8:00 - 17:30',
        'copyright_text' => '© {year} Virical. All Rights Reserved. | Designed by Virical Team',
        'google_maps_url' => '',
        'facebook' => 'https://www.facebook.com/virical',
        'youtube' => '',
        'zalo' => '',
        'instagram' => '',
        'linkedin' => ''
    );
    
    if (isset($options[$field]) && !empty($options[$field])) {
        return $options[$field];
    } elseif (isset($defaults[$field])) {
        return $defaults[$field];
    }
    
    return $default;
}

// Initialize default company settings
function virical_init_company_settings() {
    $options = get_option('virical_company_info');
    
    // If options don't exist, create with defaults
    if (!$options) {
        $defaults = array(
            'company_name' => 'Virical Lighting',
            'tagline' => 'Feeling Light',
            'company_description' => 'Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.',
            'hotline' => '1900 xxxx',
            'phone' => '024.6656.2688',
            'mobile' => '0963.954.969',
            'email' => 'info@virical.vn',
            'address' => 'Số 8 Tôn Thất Thuyết, Cầu Giấy, Hà Nội',
            'working_hours' => 'Thứ 2 - Thứ 6: 8:00 - 17:30',
            'copyright_text' => '© {year} Virical. All Rights Reserved. | Designed by Virical Team',
            'google_maps_url' => '',
            'facebook' => 'https://www.facebook.com/virical',
            'youtube' => '',
            'zalo' => '',
            'instagram' => '',
            'linkedin' => ''
        );
        
        update_option('virical_company_info', $defaults);
    }
}

// Run initialization on theme activation
add_action('after_switch_theme', 'virical_init_company_settings');

// Also run on admin_init to ensure it's set
add_action('admin_init', function() {
    if (!get_option('virical_company_info')) {
        virical_init_company_settings();
    }
});