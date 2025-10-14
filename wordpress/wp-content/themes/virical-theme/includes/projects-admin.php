<?php
/**
 * Projects Admin Interface
 */

// Add admin menu
// add_action('admin_menu', 'virical_add_projects_menu');

function virical_add_projects_menu() {
    add_menu_page(
        'Quản lý Công trình',
        'Công trình Virical',
        'manage_options',
        'virical-projects',
        'virical_projects_admin_page',
        'dashicons-building',
        31
    );
    
    add_submenu_page(
        'virical-projects',
        'Loại công trình',
        'Loại công trình',
        'manage_options',
        'virical-project-types',
        'virical_project_types_page'
    );
}

// Projects management page
function virical_projects_admin_page() {
    global $wpdb;
    
    // Handle actions
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add_project' && check_admin_referer('virical_add_project')) {
            virical_add_project($_POST);
        } elseif ($_POST['action'] === 'update_project' && check_admin_referer('virical_update_project')) {
            virical_update_project($_POST);
        }
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        if (check_admin_referer('delete_project_' . $_GET['id'])) {
            virical_delete_project($_GET['id']);
        }
    }
    
    // Get projects
    $projects = $wpdb->get_results("
        SELECT p.*, t.name as type_name 
        FROM {$wpdb->prefix}virical_projects p
        LEFT JOIN {$wpdb->prefix}virical_project_types t ON p.type = t.slug
        ORDER BY p.sort_order, p.completion_year DESC, p.id DESC
    ");
    
    $types = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virical_project_types ORDER BY sort_order");
    
    // Edit mode
    $edit_project = null;
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $edit_project = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}virical_projects WHERE id = %d",
            $_GET['id']
        ));
    }
    ?>
    
    <div class="wrap">
        <h1>Quản lý Công trình</h1>
        
        <!-- Add/Edit Project Form -->
        <div class="card">
            <h2><?php echo $edit_project ? 'Sửa công trình' : 'Thêm công trình mới'; ?></h2>
            <form method="post" action="">
                <?php 
                if ($edit_project) {
                    wp_nonce_field('virical_update_project');
                    echo '<input type="hidden" name="action" value="update_project">';
                    echo '<input type="hidden" name="id" value="' . esc_attr($edit_project->id) . '">';
                } else {
                    wp_nonce_field('virical_add_project');
                    echo '<input type="hidden" name="action" value="add_project">';
                }
                ?>
                
                <table class="form-table">
                    <tr>
                        <th><label for="name">Tên công trình</label></th>
                        <td><input type="text" id="name" name="name" class="regular-text" value="<?php echo $edit_project ? esc_attr($edit_project->name) : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="slug">Slug</label></th>
                        <td><input type="text" id="slug" name="slug" class="regular-text" value="<?php echo $edit_project ? esc_attr($edit_project->slug) : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="type">Loại công trình</label></th>
                        <td>
                            <select id="type" name="type" required>
                                <option value="">-- Chọn loại --</option>
                                <?php foreach ($types as $type): ?>
                                    <option value="<?php echo esc_attr($type->slug); ?>" <?php echo ($edit_project && $edit_project->type === $type->slug) ? 'selected' : ''; ?>>
                                        <?php echo esc_html($type->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="area">Diện tích (m²)</label></th>
                        <td><input type="number" id="area" name="area" value="<?php echo $edit_project ? esc_attr($edit_project->area) : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="completion_year">Năm hoàn thiện</label></th>
                        <td>
                            <select id="completion_year" name="completion_year">
                                <option value="">-- Chọn năm --</option>
                                <?php for ($year = date('Y'); $year >= 2015; $year--): ?>
                                    <option value="<?php echo $year; ?>" <?php echo ($edit_project && $edit_project->completion_year == $year) ? 'selected' : ''; ?>>
                                        <?php echo $year; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="design_company">Đơn vị thiết kế</label></th>
                        <td><input type="text" id="design_company" name="design_company" class="regular-text" value="<?php echo $edit_project ? esc_attr($edit_project->design_company) : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="location">Địa điểm</label></th>
                        <td><input type="text" id="location" name="location" class="regular-text" value="<?php echo $edit_project ? esc_attr($edit_project->location) : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="description">Mô tả</label></th>
                        <td><textarea id="description" name="description" rows="4" cols="50"><?php echo $edit_project ? esc_textarea($edit_project->description) : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="main_image">Hình ảnh chính</label></th>
                        <td>
                            <input type="url" id="main_image" name="main_image" class="large-text" value="<?php echo $edit_project ? esc_attr($edit_project->main_image) : ''; ?>">
                            <button type="button" class="button" onclick="virical_media_upload('main_image')">Chọn từ thư viện</button>
                            <?php if ($edit_project && $edit_project->main_image): ?>
                                <br><img src="<?php echo esc_url($edit_project->main_image); ?>" style="max-width: 200px; margin-top: 10px;">
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="features">Đặc điểm</label></th>
                        <td>
                            <textarea id="features" name="features" rows="4" cols="50" placeholder="Mỗi đặc điểm một dòng"><?php 
                                if ($edit_project && $edit_project->features) {
                                    $features = json_decode($edit_project->features, true);
                                    echo is_array($features) ? implode("\n", $features) : '';
                                }
                            ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="gallery">Gallery URLs</label></th>
                        <td>
                            <textarea id="gallery" name="gallery" rows="4" cols="50" placeholder="Mỗi URL một dòng"><?php 
                                if ($edit_project && $edit_project->gallery) {
                                    $gallery = json_decode($edit_project->gallery, true);
                                    echo is_array($gallery) ? implode("\n", $gallery) : '';
                                }
                            ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="is_featured">Công trình nổi bật</label></th>
                        <td><input type="checkbox" id="is_featured" name="is_featured" value="1" <?php echo ($edit_project && $edit_project->is_featured) ? 'checked' : ''; ?>></td>
                    </tr>
                    <tr>
                        <th><label for="is_active">Kích hoạt</label></th>
                        <td><input type="checkbox" id="is_active" name="is_active" value="1" <?php echo (!$edit_project || $edit_project->is_active) ? 'checked' : ''; ?>></td>
                    </tr>
                    <tr>
                        <th><label for="sort_order">Thứ tự</label></th>
                        <td><input type="number" id="sort_order" name="sort_order" value="<?php echo $edit_project ? esc_attr($edit_project->sort_order) : '0'; ?>"></td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php echo $edit_project ? 'Cập nhật' : 'Thêm mới'; ?>">
                    <?php if ($edit_project): ?>
                        <a href="?page=virical-projects" class="button">Hủy</a>
                    <?php endif; ?>
                </p>
            </form>
        </div>
        
        <!-- Projects List -->
        <h2>Danh sách công trình</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th style="width: 100px;">Hình ảnh</th>
                    <th>Tên công trình</th>
                    <th>Loại</th>
                    <th>Diện tích</th>
                    <th>Năm</th>
                    <th>Địa điểm</th>
                    <th>Nổi bật</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?php echo $project->id; ?></td>
                    <td>
                        <?php if ($project->main_image): ?>
                            <img src="<?php echo esc_url($project->main_image); ?>" style="width: 80px; height: 60px; object-fit: cover;">
                        <?php endif; ?>
                    </td>
                    <td><strong><?php echo esc_html($project->name); ?></strong></td>
                    <td><?php echo esc_html($project->type_name); ?></td>
                    <td><?php echo $project->area ? $project->area . ' m²' : '-'; ?></td>
                    <td><?php echo $project->completion_year ?: '-'; ?></td>
                    <td><?php echo esc_html($project->location); ?></td>
                    <td><?php echo $project->is_featured ? '<span class="dashicons dashicons-star-filled" style="color: #f0ad4e;"></span>' : '-'; ?></td>
                    <td><?php echo $project->is_active ? '<span style="color: green;">✓ Kích hoạt</span>' : '<span style="color: red;">✗ Tắt</span>'; ?></td>
                    <td>
                        <a href="?page=virical-projects&action=edit&id=<?php echo $project->id; ?>" class="button button-small">Sửa</a>
                        <a href="<?php echo wp_nonce_url("?page=virical-projects&action=delete&id={$project->id}", 'delete_project_' . $project->id); ?>" 
                           class="button button-small" 
                           onclick="return confirm('Bạn có chắc muốn xóa công trình này?');">Xóa</a>
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
            
            // Show preview if main image
            if (target_id === 'main_image') {
                var preview = document.querySelector('#main_image').parentNode.querySelector('img');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.style.maxWidth = '200px';
                    preview.style.marginTop = '10px';
                    document.querySelector('#main_image').parentNode.appendChild(document.createElement('br'));
                    document.querySelector('#main_image').parentNode.appendChild(preview);
                }
                preview.src = attachment.url;
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
    </script>
    <?php
}

// Add project function
function virical_add_project($data) {
    global $wpdb;
    
    $features = isset($data['features']) ? array_filter(array_map('trim', explode("\n", $data['features']))) : [];
    $gallery = isset($data['gallery']) ? array_filter(array_map('trim', explode("\n", $data['gallery']))) : [];
    
    $result = $wpdb->insert(
        $wpdb->prefix . 'virical_projects',
        array(
            'name' => sanitize_text_field($data['name']),
            'slug' => sanitize_title($data['slug'] ?: $data['name']),
            'type' => sanitize_text_field($data['type']),
            'area' => intval($data['area']),
            'completion_year' => intval($data['completion_year']),
            'design_company' => sanitize_text_field($data['design_company']),
            'location' => sanitize_text_field($data['location']),
            'description' => wp_kses_post($data['description']),
            'main_image' => esc_url_raw($data['main_image']),
            'gallery' => json_encode($gallery),
            'features' => json_encode($features),
            'is_featured' => isset($data['is_featured']) ? 1 : 0,
            'is_active' => isset($data['is_active']) ? 1 : 0,
            'sort_order' => intval($data['sort_order'])
        )
    );
    
    if ($result) {
        echo '<div class="notice notice-success"><p>Công trình đã được thêm thành công!</p></div>';
    }
}

// Update project function
function virical_update_project($data) {
    global $wpdb;
    
    $features = isset($data['features']) ? array_filter(array_map('trim', explode("\n", $data['features']))) : [];
    $gallery = isset($data['gallery']) ? array_filter(array_map('trim', explode("\n", $data['gallery']))) : [];
    
    $result = $wpdb->update(
        $wpdb->prefix . 'virical_projects',
        array(
            'name' => sanitize_text_field($data['name']),
            'slug' => sanitize_title($data['slug'] ?: $data['name']),
            'type' => sanitize_text_field($data['type']),
            'area' => intval($data['area']),
            'completion_year' => intval($data['completion_year']),
            'design_company' => sanitize_text_field($data['design_company']),
            'location' => sanitize_text_field($data['location']),
            'description' => wp_kses_post($data['description']),
            'main_image' => esc_url_raw($data['main_image']),
            'gallery' => json_encode($gallery),
            'features' => json_encode($features),
            'is_featured' => isset($data['is_featured']) ? 1 : 0,
            'is_active' => isset($data['is_active']) ? 1 : 0,
            'sort_order' => intval($data['sort_order'])
        ),
        array('id' => intval($data['id']))
    );
    
    if ($result !== false) {
        echo '<div class="notice notice-success"><p>Công trình đã được cập nhật!</p></div>';
    }
}

// Delete project function
function virical_delete_project($id) {
    global $wpdb;
    
    $result = $wpdb->delete(
        $wpdb->prefix . 'virical_projects',
        array('id' => intval($id))
    );
    
    if ($result) {
        echo '<div class="notice notice-success"><p>Công trình đã được xóa!</p></div>';
    }
}

// Project types management page
function virical_project_types_page() {
    global $wpdb;
    
    // Handle form submission
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add_type' && check_admin_referer('virical_add_type')) {
            virical_add_project_type($_POST);
        }
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        if (check_admin_referer('delete_type_' . $_GET['id'])) {
            virical_delete_project_type($_GET['id']);
        }
    }
    
    $types = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}virical_project_types ORDER BY sort_order");
    ?>
    
    <div class="wrap">
        <h1>Loại công trình</h1>
        
        <div class="card">
            <h2>Thêm loại công trình mới</h2>
            <form method="post" action="">
                <?php wp_nonce_field('virical_add_type'); ?>
                <input type="hidden" name="action" value="add_type">
                
                <table class="form-table">
                    <tr>
                        <th><label for="type_name">Tên loại</label></th>
                        <td><input type="text" id="type_name" name="name" class="regular-text" required></td>
                    </tr>
                    <tr>
                        <th><label for="type_slug">Slug</label></th>
                        <td><input type="text" id="type_slug" name="slug" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="type_description">Mô tả</label></th>
                        <td><textarea id="type_description" name="description" rows="3" cols="50"></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="type_sort_order">Thứ tự</label></th>
                        <td><input type="number" id="type_sort_order" name="sort_order" value="0"></td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" class="button-primary" value="Thêm loại">
                </p>
            </form>
        </div>
        
        <h2>Danh sách loại công trình</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên loại</th>
                    <th>Slug</th>
                    <th>Mô tả</th>
                    <th>Thứ tự</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($types as $type): ?>
                <tr>
                    <td><?php echo $type->id; ?></td>
                    <td><strong><?php echo esc_html($type->name); ?></strong></td>
                    <td><?php echo esc_html($type->slug); ?></td>
                    <td><?php echo esc_html($type->description); ?></td>
                    <td><?php echo $type->sort_order; ?></td>
                    <td>
                        <a href="<?php echo wp_nonce_url("?page=virical-project-types&action=delete&id={$type->id}", 'delete_type_' . $type->id); ?>" 
                           class="button button-small" 
                           onclick="return confirm('Bạn có chắc muốn xóa loại công trình này?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script>
    document.getElementById('type_name').addEventListener('blur', function() {
        var slug_field = document.getElementById('type_slug');
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

// Add project type function
function virical_add_project_type($data) {
    global $wpdb;
    
    $result = $wpdb->insert(
        $wpdb->prefix . 'virical_project_types',
        array(
            'name' => sanitize_text_field($data['name']),
            'slug' => sanitize_title($data['slug'] ?: $data['name']),
            'description' => sanitize_textarea_field($data['description']),
            'sort_order' => intval($data['sort_order']),
            'is_active' => 1
        )
    );
    
    if ($result) {
        echo '<div class="notice notice-success"><p>Loại công trình đã được thêm thành công!</p></div>';
    }
}

// Delete project type function
function virical_delete_project_type($id) {
    global $wpdb;
    
    // Check if type has projects
    $count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}virical_projects WHERE type = 
        (SELECT slug FROM {$wpdb->prefix}virical_project_types WHERE id = %d)",
        $id
    ));
    
    if ($count > 0) {
        echo '<div class="notice notice-error"><p>Không thể xóa loại công trình đang có dự án!</p></div>';
        return;
    }
    
    $result = $wpdb->delete(
        $wpdb->prefix . 'virical_project_types',
        array('id' => intval($id))
    );
    
    if ($result) {
        echo '<div class="notice notice-success"><p>Loại công trình đã được xóa!</p></div>';
    }
}

// Enqueue media uploader
add_action('admin_enqueue_scripts', 'virical_projects_enqueue_media');
function virical_projects_enqueue_media() {
    if (isset($_GET['page']) && ($_GET['page'] === 'virical-projects' || $_GET['page'] === 'virical-project-types')) {
        wp_enqueue_media();
    }
}
?>