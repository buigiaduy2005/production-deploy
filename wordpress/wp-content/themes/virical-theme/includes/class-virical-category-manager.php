<?php
if (!defined('ABSPATH')) {
    exit;
}

class ViricalCategoryManager {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_page'));
        add_action('admin_post_virical_save_category_parents', array($this, 'save_category_parents'));
        add_action('wp_ajax_get_child_categories', array($this, 'ajax_get_child_categories'));
    }

    public function ajax_get_child_categories() {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'virical_admin_nonce')) {
            wp_send_json_error('Invalid nonce');
        }

        $parent_id = intval($_POST['parent_id']);
        global $wpdb;
        $table_name = $wpdb->prefix . 'virical_product_categories';
        $categories = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE parent_id = %d ORDER BY name ASC", $parent_id));

        wp_send_json_success($categories);
    }

    public function add_admin_page() {
        add_submenu_page(
            'edit.php?post_type=product',
            'Manage Categories',
            'Manage Categories',
            'manage_options',
            'virical-category-manager',
            array($this, 'render_admin_page')
        );
    }

    public function render_admin_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'virical_product_categories';
        $categories = $wpdb->get_results("SELECT * FROM $table_name ORDER BY name ASC");
        ?>
        <div class="wrap">
            <h1>Manage Product Categories</h1>
            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="virical_save_category_parents">
                <?php wp_nonce_field('virical_save_category_parents_nonce', 'virical_category_nonce'); ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th scope="col">Category Name</th>
                            <th scope="col">Parent Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) : ?>
                            <tr>
                                <td><?php echo esc_html($category->name); ?></td>
                                <td>
                                    <select name="category_parent[<?php echo $category->id; ?>]">
                                        <option value="">None</option>
                                        <?php foreach ($categories as $parent_category) : ?>
                                            <?php if ($parent_category->id !== $category->id) : ?>
                                                <option value="<?php echo esc_attr($parent_category->id); ?>" <?php selected($category->parent_id, $parent_category->id); ?>>
                                                    <?php echo esc_html($parent_category->name); ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php submit_button('Save Changes'); ?>
            </form>
        </div>
        <?php
    }

    public function save_category_parents() {
        if (!isset($_POST['virical_category_nonce']) || !wp_verify_nonce($_POST['virical_category_nonce'], 'virical_save_category_parents_nonce')) {
            wp_die('Security check failed.');
        }

        if (!current_user_can('manage_options')) {
            wp_die('You do not have permission to perform this action.');
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'virical_product_categories';

        if (isset($_POST['category_parent']) && is_array($_POST['category_parent'])) {
            foreach ($_POST['category_parent'] as $category_id => $parent_id) {
                $wpdb->update(
                    $table_name,
                    array('parent_id' => empty($parent_id) ? null : intval($parent_id)),
                    array('id' => intval($category_id)),
                    array('%d'),
                    array('%d')
                );
            }
        }

        wp_redirect(admin_url('edit.php?post_type=product&page=virical-category-manager&settings-updated=true'));
        exit;
    }
}
