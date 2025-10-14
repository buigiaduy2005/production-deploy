<?php
/**
 * Virical Template Manager Class
 * 
 * Manages page templates from database instead of filesystem
 * 
 * @package Virical
 * @version 1.0.0
 * @since 2025-09-10
 */

if (!defined('ABSPATH')) {
    exit;
}

class ViricalTemplateManager {
    
    /**
     * Database connection
     * @var wpdb
     */
    private $wpdb;
    
    /**
     * Table name
     * @var string
     */
    private $table_name;
    
    /**
     * Cache group for templates
     * @var string
     */
    private $cache_group = 'virical_templates';
    
    /**
     * Cache TTL in seconds
     * @var int
     */
    private $cache_ttl = 3600; // 1 hour
    
    /**
     * Constructor
     */
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'virical_page_templates';
    }
    
    /**
     * Initialize the template manager
     */
    public function init() {
        // Hook into WordPress template system
        add_filter('template_include', array($this, 'load_database_template'), 99);
        add_filter('theme_page_templates', array($this, 'add_database_templates'), 10, 4);
        
        // Admin hooks
        if (is_admin()) {
//             add_action('admin_menu', array($this, 'add_admin_menu'));
            add_action('wp_ajax_virical_save_template', array($this, 'ajax_save_template'));
            add_action('wp_ajax_virical_delete_template', array($this, 'ajax_delete_template'));
        }
    }
    
    /**
     * Load template from database instead of file
     * 
     * @param string $template Current template file
     * @return string Template file or rendered content
     */
    public function load_database_template($template) {
        // Check if this is a page with a custom template
        if (is_page() || is_single()) {
            global $post;
            
            // Get the template name from post meta
            $custom_template = get_post_meta($post->ID, '_wp_page_template', true);
            
            if ($custom_template && $custom_template !== 'default') {
                // Try to load from database
                $db_template = $this->get_template($custom_template);
                
                if ($db_template && $db_template->is_active) {
                    // Render the database template
                    return $this->render_database_template($db_template);
                }
            }
        }
        
        return $template;
    }
    
    /**
     * Get template from database
     * 
     * @param string $template_name Template identifier
     * @return object|null Template object or null
     */
    public function get_template($template_name) {
        // Check cache first
        $cache_key = 'template_' . md5($template_name);
        $cached = wp_cache_get($cache_key, $this->cache_group);
        
        if ($cached !== false) {
            return $cached;
        }
        
        // Query database
        $template = $this->wpdb->get_row(
            $this->wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE template_name = %s AND is_active = 1",
                $template_name
            )
        );
        
        if ($template) {
            // Decode JSON fields
            $template->template_settings = json_decode($template->template_settings, true);
            $template->sections = json_decode($template->sections, true);
            
            // Cache the result
            wp_cache_set($cache_key, $template, $this->cache_group, $this->cache_ttl);
        }
        
        return $template;
    }
    
    /**
     * Render a database template
     * 
     * @param object $template Template object from database
     * @return string Rendered template file path
     */
    public function render_database_template($template) {
        // Create a temporary file to render the template
        $temp_file = get_template_directory() . '/template-cache/temp_' . md5($template->template_name) . '.php';
        
        // Ensure cache directory exists
        $cache_dir = dirname($temp_file);
        if (!file_exists($cache_dir)) {
            wp_mkdir_p($cache_dir);
        }
        
        // Process template content
        $content = $this->process_template_content($template);
        
        // Write to temporary file
        file_put_contents($temp_file, $content);
        
        return $temp_file;
    }
    
    /**
     * Process template content with sections
     * 
     * @param object $template Template object
     * @return string Processed PHP content
     */
    public function process_template_content($template) {
        $output = "<?php\n";
        $output .= "/* Template: {$template->template_title} */\n";
        $output .= "/* Generated from database */\n\n";
        
        // Add header
        $output .= "get_header();\n";
        
        // Add custom CSS if exists
        if (!empty($template->css_content)) {
            $output .= "?>\n<style>\n{$template->css_content}\n</style>\n<?php\n";
        }
        
        // Process sections
        if (!empty($template->sections) && is_array($template->sections)) {
            foreach ($template->sections as $section) {
                $output .= $this->render_section($section);
            }
        } elseif (!empty($template->template_content)) {
            // Use raw content if no sections
            $output .= "?>\n{$template->template_content}\n<?php\n";
        }
        
        // Add custom JS if exists
        if (!empty($template->js_content)) {
            $output .= "?>\n<script>\n{$template->js_content}\n</script>\n<?php\n";
        }
        
        // Add footer
        $output .= "get_footer();\n";
        
        return $output;
    }
    
    /**
     * Render a template section
     * 
     * @param array $section Section data
     * @return string Section PHP code
     */
    public function render_section($section) {
        $output = '';
        
        switch ($section['type']) {
            case 'products':
                $output = $this->render_products_section($section);
                break;
                
            case 'projects':
                $output = $this->render_projects_section($section);
                break;
                
            case 'content':
                $output = $this->render_content_section($section);
                break;
                
            case 'hero':
                $output = $this->render_hero_section($section);
                break;
                
            case 'custom':
                $output = "?>\n" . $section['content'] . "\n<?php\n";
                break;
                
            default:
                $output = "/* Unknown section type: {$section['type']} */\n";
        }
        
        return $output;
    }
    
    /**
     * Render products section
     * 
     * @param array $section Section configuration
     * @return string Section PHP code
     */
    private function render_products_section($section) {
        $limit = isset($section['limit']) ? intval($section['limit']) : 12;
        $category = isset($section['category']) ? $section['category'] : '';
        
        $output = "?>\n";
        $output .= "<section class=\"products-section\">\n";
        $output .= "<?php\n";
        $output .= "global \$wpdb;\n";
        $output .= "\$products = \$wpdb->get_results(\"SELECT * FROM {\$wpdb->prefix}virical_products WHERE status = 'publish'";
        
        if ($category) {
            $output .= " AND category = '" . esc_sql($category) . "'";
        }
        
        $output .= " ORDER BY created_at DESC LIMIT {$limit}\");\n";
        $output .= "foreach (\$products as \$product) :\n";
        $output .= "?>\n";
        $output .= "<div class=\"product-item\">\n";
        $output .= "    <h3><?php echo esc_html(\$product->name); ?></h3>\n";
        $output .= "    <p><?php echo esc_html(\$product->description); ?></p>\n";
        $output .= "    <a href=\"/san-pham/<?php echo esc_attr(\$product->slug); ?>/\">Xem chi tiết</a>\n";
        $output .= "</div>\n";
        $output .= "<?php endforeach; ?>\n";
        $output .= "</section>\n";
        $output .= "<?php\n";
        
        return $output;
    }
    
    /**
     * Render projects section
     * 
     * @param array $section Section configuration
     * @return string Section PHP code
     */
    private function render_projects_section($section) {
        $limit = isset($section['limit']) ? intval($section['limit']) : 9;
        $type = isset($section['type']) ? $section['type'] : '';
        
        $output = "?>\n";
        $output .= "<section class=\"projects-section\">\n";
        $output .= "<?php\n";
        $output .= "global \$wpdb;\n";
        $output .= "\$projects = \$wpdb->get_results(\"SELECT * FROM {\$wpdb->prefix}virical_projects WHERE status = 'publish'";
        
        if ($type) {
            $output .= " AND project_type = '" . esc_sql($type) . "'";
        }
        
        $output .= " ORDER BY project_date DESC LIMIT {$limit}\");\n";
        $output .= "foreach (\$projects as \$project) :\n";
        $output .= "?>\n";
        $output .= "<div class=\"project-item\">\n";
        $output .= "    <h3><?php echo esc_html(\$project->title); ?></h3>\n";
        $output .= "    <p><?php echo esc_html(\$project->description); ?></p>\n";
        $output .= "    <a href=\"/cong-trinh/<?php echo esc_attr(\$project->slug); ?>/\">Xem chi tiết</a>\n";
        $output .= "</div>\n";
        $output .= "<?php endforeach; ?>\n";
        $output .= "</section>\n";
        $output .= "<?php\n";
        
        return $output;
    }
    
    /**
     * Render content section
     * 
     * @param array $section Section configuration
     * @return string Section PHP code
     */
    private function render_content_section($section) {
        $output = "?>\n";
        $output .= "<section class=\"content-section\">\n";
        
        if (isset($section['title'])) {
            $output .= "    <h2>" . esc_html($section['title']) . "</h2>\n";
        }
        
        if (isset($section['content'])) {
            $output .= "    <div class=\"content\">\n";
            $output .= "        " . wp_kses_post($section['content']) . "\n";
            $output .= "    </div>\n";
        }
        
        $output .= "</section>\n";
        $output .= "<?php\n";
        
        return $output;
    }
    
    /**
     * Render hero section
     * 
     * @param array $section Section configuration
     * @return string Section PHP code
     */
    private function render_hero_section($section) {
        $output = "?>\n";
        $output .= "<section class=\"hero-section\"";
        
        if (isset($section['background_image'])) {
            $output .= " style=\"background-image: url('" . esc_url($section['background_image']) . "');\"";
        }
        
        $output .= ">\n";
        $output .= "    <div class=\"hero-content\">\n";
        
        if (isset($section['title'])) {
            $output .= "        <h1>" . esc_html($section['title']) . "</h1>\n";
        }
        
        if (isset($section['subtitle'])) {
            $output .= "        <p class=\"subtitle\">" . esc_html($section['subtitle']) . "</p>\n";
        }
        
        if (isset($section['button_text']) && isset($section['button_url'])) {
            $output .= "        <a href=\"" . esc_url($section['button_url']) . "\" class=\"btn btn-primary\">";
            $output .= esc_html($section['button_text']) . "</a>\n";
        }
        
        $output .= "    </div>\n";
        $output .= "</section>\n";
        $output .= "<?php\n";
        
        return $output;
    }
    
    /**
     * Add database templates to WordPress template list
     * 
     * @param array $templates Current templates
     * @return array Modified templates list
     */
    public function add_database_templates($templates) {
        // Get all active templates from database
        $db_templates = $this->wpdb->get_results(
            "SELECT template_name, template_title FROM {$this->table_name} WHERE is_active = 1"
        );
        
        foreach ($db_templates as $template) {
            $templates[$template->template_name] = $template->template_title;
        }
        
        return $templates;
    }
    
    /**
     * Add admin menu for template management
     */
    public function add_admin_menu() {
        add_submenu_page(
            'virical-settings',
            'Template Manager',
            'Template Manager',
            'manage_options',
            'virical-template-manager',
            array($this, 'render_admin_page')
        );
    }
    
    /**
     * Render admin page
     */
    public function render_admin_page() {
        // Admin interface would go here
        echo '<div class="wrap">';
        echo '<h1>Template Manager</h1>';
        echo '<p>Manage your database-driven templates here.</p>';
        // Template management interface
        echo '</div>';
    }
    
    /**
     * Clear template cache
     * 
     * @param string $template_name Optional specific template to clear
     */
    public function clear_cache($template_name = null) {
        if ($template_name) {
            $cache_key = 'template_' . md5($template_name);
            wp_cache_delete($cache_key, $this->cache_group);
        } else {
            // Clear all template cache
            wp_cache_flush();
        }
    }
    
    /**
     * AJAX handler to save template
     */
    public function ajax_save_template() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Validate nonce
        check_ajax_referer('virical_template_nonce', 'nonce');
        
        // Get template data
        $template_data = array(
            'template_name' => sanitize_text_field($_POST['template_name']),
            'template_title' => sanitize_text_field($_POST['template_title']),
            'template_type' => sanitize_text_field($_POST['template_type']),
            'template_content' => wp_kses_post($_POST['template_content']),
            'template_settings' => json_encode($_POST['template_settings']),
            'sections' => json_encode($_POST['sections']),
            'css_content' => $_POST['css_content'],
            'js_content' => $_POST['js_content'],
            'is_active' => intval($_POST['is_active'])
        );
        
        // Save to database
        if (isset($_POST['template_id']) && $_POST['template_id']) {
            // Update existing
            $result = $this->wpdb->update(
                $this->table_name,
                $template_data,
                array('id' => intval($_POST['template_id']))
            );
        } else {
            // Insert new
            $result = $this->wpdb->insert($this->table_name, $template_data);
        }
        
        // Clear cache
        $this->clear_cache($template_data['template_name']);
        
        wp_send_json_success(array('message' => 'Template saved successfully'));
    }
    
    /**
     * AJAX handler to delete template
     */
    public function ajax_delete_template() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Validate nonce
        check_ajax_referer('virical_template_nonce', 'nonce');
        
        $template_id = intval($_POST['template_id']);
        
        // Delete from database
        $result = $this->wpdb->delete(
            $this->table_name,
            array('id' => $template_id)
        );
        
        // Clear cache
        $this->clear_cache();
        
        wp_send_json_success(array('message' => 'Template deleted successfully'));
    }
}