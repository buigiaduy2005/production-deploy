<?php
/**
 * Admin Menu Manager
 * Quản lý menu items trong WordPress admin
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu page
 */
function virical_add_menu_manager_page() {
    add_menu_page(
        'Quản lý Menu',           // Page title
        'Quản lý Menu',           // Menu title
        'manage_options',         // Capability
        'virical-menu-manager',   // Menu slug
        'virical_render_menu_manager_page', // Callback
        'dashicons-menu',         // Icon
        25                        // Position
    );
}
add_action('admin_menu', 'virical_add_menu_manager_page');

/**
 * AJAX handler to update multiple menu orders
 */
function virical_ajax_update_menu_order() {
    check_ajax_referer('virical_menu_order_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_navigation_menus';
    
    $updates = json_decode(stripslashes($_POST['updates']), true);
    
    if (!is_array($updates)) {
        wp_send_json_error('Invalid data');
        return;
    }
    
    foreach ($updates as $update) {
        $wpdb->update(
            $table_name,
            array('sort_order' => intval($update['sort_order'])),
            array('id' => intval($update['id'])),
            array('%d'),
            array('%d')
        );
    }
    
    wp_send_json_success('Menu orders updated');
}
add_action('wp_ajax_virical_update_menu_order', 'virical_ajax_update_menu_order');

/**
 * AJAX handler to update single menu order
 */
function virical_ajax_update_single_menu_order() {
    check_ajax_referer('virical_menu_order_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_navigation_menus';
    
    $menu_id = intval($_POST['menu_id']);
    $sort_order = intval($_POST['sort_order']);
    
    $result = $wpdb->update(
        $table_name,
        array('sort_order' => $sort_order),
        array('id' => $menu_id),
        array('%d'),
        array('%d')
    );
    
    if ($result !== false) {
        wp_send_json_success('Sort order updated');
    } else {
        wp_send_json_error('Failed to update');
    }
}
add_action('wp_ajax_virical_update_single_menu_order', 'virical_ajax_update_single_menu_order');

/**
 * Render admin page
 */
function virical_render_menu_manager_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_navigation_menus';
    
    // Handle form submissions
    if (isset($_POST['virical_menu_action'])) {
        check_admin_referer('virical_menu_nonce');
        
        $action = sanitize_text_field($_POST['virical_menu_action']);
        
        if ($action === 'add' || $action === 'edit') {
            $data = array(
                'menu_location' => sanitize_text_field($_POST['menu_location']),
                'parent_id' => !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : null,
                'item_title' => sanitize_text_field($_POST['item_title']),
                'item_url' => esc_url_raw($_POST['item_url']),
                'item_icon' => sanitize_text_field($_POST['item_icon']),
                'item_description' => sanitize_text_field($_POST['item_description']),
                'sort_order' => intval($_POST['sort_order']),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            );
            
            if ($action === 'add') {
                $wpdb->insert($table_name, $data);
                echo '<div class="notice notice-success"><p>✓ Đã thêm menu item thành công!</p></div>';
            } else {
                $id = intval($_POST['menu_id']);
                $wpdb->update($table_name, $data, array('id' => $id));
                echo '<div class="notice notice-success"><p>✓ Đã cập nhật menu item thành công!</p></div>';
            }
        } elseif ($action === 'delete') {
            $id = intval($_POST['menu_id']);
            $wpdb->delete($table_name, array('id' => $id));
            echo '<div class="notice notice-success"><p>✓ Đã xóa menu item thành công!</p></div>';
        }
    }
    
    // Get all menu items
    $menus = $wpdb->get_results("SELECT * FROM {$table_name} ORDER BY menu_location, sort_order ASC");
    
    // Group by location
    $menu_by_location = array();
    foreach ($menus as $menu) {
        $menu_by_location[$menu->menu_location][] = $menu;
    }
    
    ?>
    <div class="wrap">
        <h1>🎯 Quản lý Menu Items</h1>
        <p>Quản lý các menu items hiển thị trên website</p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            
            <!-- Left Column: Menu List -->
            <div>
                <div style="background: white; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h2>📋 Danh sách Menu Items</h2>
                    
                    <?php foreach ($menu_by_location as $location => $items): ?>
                        <h3 style="margin-top: 20px; padding: 10px; background: #f0f0f0;">
                            📍 Location: <?php echo esc_html($location); ?>
                        </h3>
                        
                        <table class="wp-list-table widefat fixed striped" id="sortable-menu-<?php echo esc_attr($location); ?>">
                            <thead>
                                <tr>
                                    <th width="30">🔢</th>
                                    <th width="40">ID</th>
                                    <th>Tiêu đề</th>
                                    <th>URL</th>
                                    <th width="80">Thứ tự</th>
                                    <th width="60">Active</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $index => $item): ?>
                                    <tr data-id="<?php echo $item->id; ?>" data-location="<?php echo $location; ?>" class="sortable-row">
                                        <td class="drag-handle" style="cursor: move; text-align: center;" title="Kéo để sắp xếp">
                                            ⋮⋮
                                        </td>
                                        <td><?php echo $item->id; ?></td>
                                        <td>
                                            <strong><?php echo esc_html($item->item_title); ?></strong>
                                            <?php if ($item->parent_id): ?>
                                                <br><small style="color: #666;">↳ Parent: <?php echo $item->parent_id; ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><small><?php echo esc_html($item->item_url); ?></small></td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 5px;">
                                                <input type="number" 
                                                       class="sort-order-input" 
                                                       value="<?php echo $item->sort_order; ?>"
                                                       data-id="<?php echo $item->id; ?>"
                                                       style="width: 50px; text-align: center;"
                                                       min="1">
                                                <button type="button" class="button button-small move-up" 
                                                        onclick="moveMenuItem(<?php echo $item->id; ?>, 'up')"
                                                        <?php echo $index === 0 ? 'disabled' : ''; ?>
                                                        title="Di chuyển lên">
                                                    ▲
                                                </button>
                                                <button type="button" class="button button-small move-down" 
                                                        onclick="moveMenuItem(<?php echo $item->id; ?>, 'down')"
                                                        <?php echo $index === count($items) - 1 ? 'disabled' : ''; ?>
                                                        title="Di chuyển xuống">
                                                    ▼
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($item->is_active): ?>
                                                <span style="color: green; font-size: 18px;">✓</span>
                                            <?php else: ?>
                                                <span style="color: red; font-size: 18px;">✗</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="button button-small" 
                                                    onclick="editMenuItem(<?php echo htmlspecialchars(json_encode($item)); ?>)">
                                                ✏️ Sửa
                                            </button>
                                            <form method="post" style="display: inline;">
                                                <?php wp_nonce_field('virical_menu_nonce'); ?>
                                                <input type="hidden" name="virical_menu_action" value="delete">
                                                <input type="hidden" name="menu_id" value="<?php echo $item->id; ?>">
                                                <button type="submit" class="button button-small" 
                                                        onclick="return confirm('Bạn có chắc muốn xóa menu item này?')">
                                                    🗑️ Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Right Column: Add/Edit Form -->
            <div>
                <div style="background: white; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h2 id="form-title">➕ Thêm Menu Item Mới</h2>
                    
                    <form method="post" id="menu-form">
                        <?php wp_nonce_field('virical_menu_nonce'); ?>
                        <input type="hidden" name="virical_menu_action" id="menu-action" value="add">
                        <input type="hidden" name="menu_id" id="menu-id" value="">
                        
                        <table class="form-table">
                            <tr>
                                <th><label for="menu_location">Location</label></th>
                                <td>
                                    <select name="menu_location" id="menu_location" required style="width: 100%;">
                                        <option value="primary">Primary</option>
                                        <option value="footer">Footer</option>
                                        <option value="mobile">Mobile</option>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><label for="item_title">Tiêu đề *</label></th>
                                <td>
                                    <input type="text" name="item_title" id="item_title" required 
                                           style="width: 100%;" placeholder="Ví dụ: Trang chủ">
                                </td>
                            </tr>
                            
                            <tr>
                                <th><label for="item_url">URL *</label></th>
                                <td>
                                    <input type="text" name="item_url" id="item_url" required 
                                           style="width: 100%;" placeholder="Ví dụ: /trang-chu/">
                                </td>
                            </tr>
                            
                            <tr>
                                <th><label for="item_icon">Icon Class</label></th>
                                <td>
                                    <input type="text" name="item_icon" id="item_icon" 
                                           style="width: 100%;" placeholder="Ví dụ: fas fa-home">
                                    <small>Font Awesome icon class (optional)</small>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><label for="item_description">Mô tả</label></th>
                                <td>
                                    <textarea name="item_description" id="item_description" 
                                              style="width: 100%;" rows="3"></textarea>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><label for="parent_id">Parent ID</label></th>
                                <td>
                                    <input type="number" name="parent_id" id="parent_id" 
                                           style="width: 100%;" placeholder="Để trống nếu không có parent">
                                    <small>ID của menu item cha (để trống nếu là menu chính)</small>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><label for="sort_order">Thứ tự</label></th>
                                <td>
                                    <input type="number" name="sort_order" id="sort_order" 
                                           value="<?php echo count($menus) + 1; ?>" required 
                                           style="width: 100%;">
                                    <small>Số thứ tự hiển thị (1, 2, 3...)</small>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><label for="is_active">Active</label></th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="is_active" id="is_active" checked>
                                        Hiển thị menu item này
                                    </label>
                                </td>
                            </tr>
                        </table>
                        
                        <p>
                            <button type="submit" class="button button-primary button-large">
                                💾 Lưu Menu Item
                            </button>
                            <button type="button" class="button button-large" onclick="resetForm()">
                                🔄 Reset Form
                            </button>
                        </p>
                    </form>
                </div>
                
                <!-- Quick Actions -->
                <div style="background: #e7f3ff; padding: 15px; margin-top: 20px; border-left: 4px solid #2196F3;">
                    <h3>⚡ Quick Actions</h3>
                    <p>
                        <a href="<?php echo admin_url('admin.php?page=virical-menu-manager'); ?>" class="button">
                            🔄 Refresh
                        </a>
                        <a href="/" class="button" target="_blank">
                            👁️ Xem Website
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function editMenuItem(item) {
        document.getElementById('form-title').textContent = '✏️ Sửa Menu Item #' + item.id;
        document.getElementById('menu-action').value = 'edit';
        document.getElementById('menu-id').value = item.id;
        document.getElementById('menu_location').value = item.menu_location;
        document.getElementById('item_title').value = item.item_title;
        document.getElementById('item_url').value = item.item_url;
        document.getElementById('item_icon').value = item.item_icon || '';
        document.getElementById('item_description').value = item.item_description || '';
        document.getElementById('parent_id').value = item.parent_id || '';
        document.getElementById('sort_order').value = item.sort_order;
        document.getElementById('is_active').checked = item.is_active == 1;
        
        // Scroll to form
        document.getElementById('form-title').scrollIntoView({ behavior: 'smooth' });
    }
    
    function resetForm() {
        document.getElementById('form-title').textContent = '➕ Thêm Menu Item Mới';
        document.getElementById('menu-action').value = 'add';
        document.getElementById('menu-id').value = '';
        document.getElementById('menu-form').reset();
    }
    
    // Move menu item up or down
    function moveMenuItem(menuId, direction) {
        const row = document.querySelector('tr[data-id="' + menuId + '"]');
        const tbody = row.parentElement;
        const rows = Array.from(tbody.querySelectorAll('tr[data-id]'));
        const currentIndex = rows.indexOf(row);
        
        if (direction === 'up' && currentIndex > 0) {
            tbody.insertBefore(row, rows[currentIndex - 1]);
        } else if (direction === 'down' && currentIndex < rows.length - 1) {
            tbody.insertBefore(rows[currentIndex + 1], row);
        }
        
        // Update sort orders after move
        updateSortOrders(tbody);
    }
    
    // Update sort orders in the database
    function updateSortOrders(tbody) {
        const rows = tbody.querySelectorAll('tr[data-id]');
        const updates = [];
        
        rows.forEach((row, index) => {
            const menuId = row.getAttribute('data-id');
            const newOrder = index + 1;
            const input = row.querySelector('.sort-order-input');
            input.value = newOrder;
            
            updates.push({
                id: menuId,
                sort_order: newOrder
            });
        });
        
        // Send AJAX request to update database
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'virical_update_menu_order',
                nonce: '<?php echo wp_create_nonce('virical_menu_order_nonce'); ?>',
                updates: JSON.stringify(updates)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('✓ Đã cập nhật thứ tự menu', 'success');
            } else {
                showNotification('✗ Lỗi cập nhật thứ tự', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('✗ Lỗi kết nối', 'error');
        });
    }
    
    // Update individual sort order when input changes
    document.addEventListener('DOMContentLoaded', function() {
        const sortInputs = document.querySelectorAll('.sort-order-input');
        sortInputs.forEach(input => {
            input.addEventListener('change', function() {
                const menuId = this.getAttribute('data-id');
                const newOrder = parseInt(this.value);
                
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'virical_update_single_menu_order',
                        nonce: '<?php echo wp_create_nonce('virical_menu_order_nonce'); ?>',
                        menu_id: menuId,
                        sort_order: newOrder
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('✓ Đã cập nhật thứ tự', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification('✗ Lỗi cập nhật', 'error');
                    }
                });
            });
        });
    });
    
    // Show notification
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = 'notice notice-' + type + ' is-dismissible';
        notification.style.position = 'fixed';
        notification.style.top = '32px';
        notification.style.right = '20px';
        notification.style.zIndex = '99999';
        notification.innerHTML = '<p>' + message + '</p>';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    </script>
    
    <style>
    .wp-list-table th {
        font-weight: bold;
        background: #f9f9f9;
    }
    .form-table th {
        padding: 15px 10px 15px 0;
        font-weight: 600;
    }
    .form-table td {
        padding: 15px 10px;
    }
    </style>
    <?php
}
?>
