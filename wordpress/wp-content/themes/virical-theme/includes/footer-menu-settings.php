<?php
/**
 * Footer Menu Settings Page
 * Manage footer menu items and links
 */

// Add settings menu
// add_action('admin_menu', 'virical_add_footer_menu_settings_menu');

function virical_add_footer_menu_settings_menu() {
    add_submenu_page(
        'virical-products',
        'Cài đặt Footer Menu',
        'Footer Menu',
        'manage_options',
        'virical-footer-menu-settings',
        'virical_footer_menu_settings_page'
    );
}

// Register settings
add_action('admin_init', 'virical_register_footer_menu_settings');

function virical_register_footer_menu_settings() {
    // Register settings group
    register_setting('virical_footer_menu_settings', 'virical_footer_menus');
    
    // Add sections
    add_settings_section(
        'virical_product_menu_section',
        'Menu Sản phẩm',
        'virical_product_menu_section_callback',
        'virical-footer-menu-settings'
    );
    
    add_settings_section(
        'virical_resource_menu_section',
        'Menu Tài nguyên',
        'virical_resource_menu_section_callback',
        'virical-footer-menu-settings'
    );
    
    // Product menu fields
    for ($i = 1; $i <= 5; $i++) {
        add_settings_field(
            'product_menu_item_' . $i,
            'Mục menu ' . $i,
            'virical_menu_item_field_callback',
            'virical-footer-menu-settings',
            'virical_product_menu_section',
            array(
                'field' => 'product_menu_item_' . $i,
                'index' => $i,
                'type' => 'product'
            )
        );
    }
    
    // Resource menu fields
    for ($i = 1; $i <= 3; $i++) {
        add_settings_field(
            'resource_menu_item_' . $i,
            'Mục menu ' . $i,
            'virical_menu_item_field_callback',
            'virical-footer-menu-settings',
            'virical_resource_menu_section',
            array(
                'field' => 'resource_menu_item_' . $i,
                'index' => $i,
                'type' => 'resource'
            )
        );
    }
}

// Section callbacks
function virical_product_menu_section_callback() {
    echo '<p>Cấu hình các mục menu sản phẩm hiển thị ở footer.</p>';
}

function virical_resource_menu_section_callback() {
    echo '<p>Cấu hình các mục menu tài nguyên hiển thị ở footer.</p>';
}

// Field callback for menu items
function virical_menu_item_field_callback($args) {
    $options = get_option('virical_footer_menus');
    $field = $args['field'];
    
    // Default values
    $defaults = virical_get_default_footer_menus();
    $default = isset($defaults[$field]) ? $defaults[$field] : array('title' => '', 'url' => '');
    
    $title = isset($options[$field]['title']) ? $options[$field]['title'] : $default['title'];
    $url = isset($options[$field]['url']) ? $options[$field]['url'] : $default['url'];
    ?>
    <div style="margin-bottom: 10px;">
        <label style="display: inline-block; width: 80px;">Tiêu đề:</label>
        <input type="text" 
               name="virical_footer_menus[<?php echo $field; ?>][title]" 
               value="<?php echo esc_attr($title); ?>"
               placeholder="Tên menu"
               style="width: 250px;" />
    </div>
    <div>
        <label style="display: inline-block; width: 80px;">Liên kết:</label>
        <input type="text" 
               name="virical_footer_menus[<?php echo $field; ?>][url]" 
               value="<?php echo esc_attr($url); ?>"
               placeholder="/duong-dan-trang/"
               style="width: 250px;" />
        <span class="description">Để trống để ẩn mục menu này</span>
    </div>
    <?php
}

// Settings page
function virical_footer_menu_settings_page() {
    ?>
    <style>
    .virical-settings-wrap {
        max-width: 900px;
        margin-top: 20px;
    }
    .virical-settings-wrap .form-table th {
        width: 150px;
        vertical-align: top;
        padding-top: 20px;
    }
    .virical-settings-wrap .form-table td {
        padding: 15px 10px;
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
    .menu-preview {
        background: #f5f5f5;
        padding: 20px;
        border-radius: 4px;
        margin: 20px 0;
    }
    .menu-preview h4 {
        margin: 0 0 10px 0;
    }
    .menu-preview ul {
        margin: 0;
        padding-left: 20px;
    }
    .menu-preview li {
        margin: 5px 0;
    }
    </style>
    
    <div class="wrap virical-settings-wrap">
        <div class="virical-settings-header">
            <h1>Cài đặt Footer Menu</h1>
            <p>Quản lý các menu hiển thị ở footer website</p>
        </div>
        
        <?php settings_errors(); ?>
        
        <form method="post" action="options.php">
            <?php
            settings_fields('virical_footer_menu_settings');
            do_settings_sections('virical-footer-menu-settings');
            submit_button('Lưu thay đổi');
            ?>
        </form>
        
        <hr style="margin: 40px 0;">
        
        <h3>Xem trước Footer Menu</h3>
        <?php
        $menus = get_option('virical_footer_menus');
        if (!$menus) {
            $menus = virical_get_default_footer_menus();
        }
        ?>
        <div class="menu-preview">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                <div>
                    <h4>Menu Sản phẩm</h4>
                    <ul>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php 
                            $item = isset($menus['product_menu_item_' . $i]) ? $menus['product_menu_item_' . $i] : array();
                            if (!empty($item['title'])): 
                            ?>
                                <li><?php echo esc_html($item['title']); ?> → <?php echo esc_html($item['url']); ?></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </ul>
                </div>
                <div>
                    <h4>Menu Tài nguyên</h4>
                    <ul>
                        <?php for ($i = 1; $i <= 3; $i++): ?>
                            <?php 
                            $item = isset($menus['resource_menu_item_' . $i]) ? $menus['resource_menu_item_' . $i] : array();
                            if (!empty($item['title'])): 
                            ?>
                                <li><?php echo esc_html($item['title']); ?> → <?php echo esc_html($item['url']); ?></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <hr style="margin: 40px 0;">
        
        <h3>Hướng dẫn sử dụng</h3>
        <p>Để hiển thị footer menu trong theme, sử dụng function:</p>
        <pre style="background: #f5f5f5; padding: 15px; border-radius: 4px;">
&lt;?php 
// Lấy menu sản phẩm
$product_menus = virical_get_footer_menu('product');
foreach ($product_menus as $menu) {
    echo '&lt;li&gt;&lt;a href="' . esc_url($menu['url']) . '"&gt;' . esc_html($menu['title']) . '&lt;/a&gt;&lt;/li&gt;';
}

// Lấy menu tài nguyên
$resource_menus = virical_get_footer_menu('resource');
?&gt;</pre>
    </div>
    <?php
}

// Helper function to get default footer menus
function virical_get_default_footer_menus() {
    return array(
        'product_menu_item_1' => array('title' => 'Đèn Indoor', 'url' => '/san-pham/den-indoor/'),
        'product_menu_item_2' => array('title' => 'Đèn Outdoor', 'url' => '/san-pham/den-outdoor/'),
        'product_menu_item_3' => array('title' => 'Đèn Downlight', 'url' => '/san-pham/den-downlight/'),
        'product_menu_item_4' => array('title' => 'Đèn Spotlight', 'url' => '/san-pham/den-spotlight/'),
        'product_menu_item_5' => array('title' => 'Đèn Ray', 'url' => '/san-pham/den-ray/'),
        'resource_menu_item_1' => array('title' => '', 'url' => ''),
        'resource_menu_item_2' => array('title' => '', 'url' => ''),
        'resource_menu_item_3' => array('title' => '', 'url' => '')
    );
}

// Helper function to get footer menu
function virical_get_footer_menu($type = 'product') {
    $options = get_option('virical_footer_menus');
    $defaults = virical_get_default_footer_menus();
    
    $menus = array();
    $prefix = $type . '_menu_item_';
    $count = ($type == 'product') ? 5 : 3;
    
    for ($i = 1; $i <= $count; $i++) {
        $field = $prefix . $i;
        
        if (isset($options[$field]) && !empty($options[$field]['title'])) {
            $menus[] = $options[$field];
        } elseif (isset($defaults[$field]) && !empty($defaults[$field]['title'])) {
            $menus[] = $defaults[$field];
        }
    }
    
    return $menus;
}

// Initialize default footer menu settings
function virical_init_footer_menu_settings() {
    $options = get_option('virical_footer_menus');
    
    // If options don't exist, create with defaults
    if (!$options) {
        update_option('virical_footer_menus', virical_get_default_footer_menus());
    }
}

// Run initialization
add_action('after_switch_theme', 'virical_init_footer_menu_settings');
add_action('admin_init', function() {
    if (!get_option('virical_footer_menus')) {
        virical_init_footer_menu_settings();
    }
});