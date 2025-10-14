<?php
/**
 * Migration Script: Aura to Virical
 * 
 * This script migrates all data from Aura system (WordPress Custom Post Type)
 * to Virical system (Custom Tables)
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Aura_To_Virical_Migration {
    
    private $wpdb;
    private $migrated_count = 0;
    private $errors = [];
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
    }
    
    /**
     * Run the complete migration
     */
    public function run_migration() {
        echo "<h2>Starting Aura to Virical Migration</h2>";
        
        // Step 1: Migrate Categories
        echo "<h3>Step 1: Migrating Categories...</h3>";
        $this->migrate_categories();
        
        // Step 2: Migrate Products
        echo "<h3>Step 2: Migrating Products...</h3>";
        $this->migrate_products();
        
        // Step 3: Show summary
        $this->show_summary();
    }
    
    /**
     * Migrate product categories from taxonomy to custom table
     */
    private function migrate_categories() {
        // Get all product_category terms
        $categories = get_terms(array(
            'taxonomy' => 'product_category',
            'hide_empty' => false,
        ));
        
        if (is_wp_error($categories)) {
            $this->errors[] = "Error fetching categories: " . $categories->get_error_message();
            return;
        }
        
        $migrated_cats = 0;
        
        foreach ($categories as $category) {
            // Check if category already exists in virical table
            $exists = $this->wpdb->get_var($this->wpdb->prepare(
                "SELECT id FROM {$this->wpdb->prefix}virical_product_categories WHERE slug = %s",
                $category->slug
            ));
            
            if (!$exists) {
                // Get category image from ACF if available
                $category_image = get_field('category_image', 'product_category_' . $category->term_id);
                $image_url = '';
                if ($category_image && is_array($category_image)) {
                    $image_url = $category_image['url'];
                }
                
                // Insert into virical categories table
                $result = $this->wpdb->insert(
                    $this->wpdb->prefix . 'virical_product_categories',
                    array(
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'description' => $category->description,
                        'image_url' => $image_url,
                        'sort_order' => $category->term_order ?: 0,
                        'is_active' => 1
                    ),
                    array('%s', '%s', '%s', '%s', '%d', '%d')
                );
                
                if ($result) {
                    $migrated_cats++;
                    echo "✓ Migrated category: {$category->name}<br>";
                } else {
                    $this->errors[] = "Failed to migrate category: {$category->name}";
                }
            } else {
                echo "⚠ Category already exists: {$category->name}<br>";
            }
        }
        
        echo "<p>Categories migrated: {$migrated_cats}</p>";
    }
    
    /**
     * Migrate products from custom post type to custom table
     */
    private function migrate_products() {
        // Get all aura_product posts
        $args = array(
            'post_type' => 'aura_product',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );
        
        $products = get_posts($args);
        
        foreach ($products as $product) {
            // Check if product already exists in virical table
            $exists = $this->wpdb->get_var($this->wpdb->prepare(
                "SELECT id FROM {$this->wpdb->prefix}virical_products WHERE slug = %s",
                $product->post_name
            ));
            
            if (!$exists) {
                // Get product metadata
                $product_code = get_post_meta($product->ID, 'product_code', true);
                $product_price = get_post_meta($product->ID, 'product_price', true);
                $product_features = get_post_meta($product->ID, 'product_features', true);
                $product_specifications = get_post_meta($product->ID, 'product_specifications', true);
                $product_image_url = get_post_meta($product->ID, 'product_image_url', true);
                
                // Get featured image if no custom image URL
                if (!$product_image_url && has_post_thumbnail($product->ID)) {
                    $thumbnail_id = get_post_thumbnail_id($product->ID);
                    $image_data = wp_get_attachment_image_src($thumbnail_id, 'full');
                    if ($image_data) {
                        $product_image_url = $image_data[0];
                    }
                }
                
                // Get product category
                $categories = get_the_terms($product->ID, 'product_category');
                $category_slug = '';
                if ($categories && !is_wp_error($categories)) {
                    $category_slug = $categories[0]->slug;
                }
                
                // Convert features to JSON array
                $features_array = [];
                if ($product_features) {
                    // If it's already an array
                    if (is_array($product_features)) {
                        $features_array = $product_features;
                    } else {
                        // If it's a string, split by newlines
                        $features_array = array_filter(array_map('trim', explode("\n", $product_features)));
                    }
                }
                
                // Prepare data for insertion
                $data = array(
                    'name' => $product->post_title,
                    'slug' => $product->post_name,
                    'description' => wp_strip_all_tags($product->post_content),
                    'category' => $category_slug,
                    'price' => floatval($product_price),
                    'image_url' => $product_image_url,
                    'features' => json_encode($features_array),
                    'specifications' => $product_specifications,
                    'is_featured' => 0, // You can add logic to determine featured products
                    'is_active' => 1,
                    'sort_order' => $product->menu_order,
                    'created_at' => $product->post_date
                );
                
                // Additional custom fields
                $data['meta_data'] = json_encode(array(
                    'product_code' => $product_code,
                    'original_post_id' => $product->ID,
                    'migrated_from' => 'aura_product',
                    'migration_date' => current_time('mysql')
                ));
                
                // Insert into virical products table
                $result = $this->wpdb->insert(
                    $this->wpdb->prefix . 'virical_products',
                    $data
                );
                
                if ($result) {
                    $this->migrated_count++;
                    echo "✓ Migrated product: {$product->post_title}<br>";
                    
                    // Optionally update the original post to mark it as migrated
                    update_post_meta($product->ID, '_migrated_to_virical', true);
                    update_post_meta($product->ID, '_virical_product_id', $this->wpdb->insert_id);
                } else {
                    $this->errors[] = "Failed to migrate product: {$product->post_title} - " . $this->wpdb->last_error;
                }
            } else {
                echo "⚠ Product already exists: {$product->post_title}<br>";
            }
        }
    }
    
    /**
     * Show migration summary
     */
    private function show_summary() {
        echo "<h3>Migration Summary</h3>";
        echo "<p><strong>Products migrated:</strong> {$this->migrated_count}</p>";
        
        if (!empty($this->errors)) {
            echo "<h4>Errors encountered:</h4>";
            echo "<ul>";
            foreach ($this->errors as $error) {
                echo "<li style='color: red;'>{$error}</li>";
            }
            echo "</ul>";
        }
        
        // Show current counts
        $aura_count = wp_count_posts('aura_product')->publish;
        $virical_count = $this->wpdb->get_var("SELECT COUNT(*) FROM {$this->wpdb->prefix}virical_products WHERE is_active = 1");
        
        echo "<h4>Current Status:</h4>";
        echo "<p>Aura products (aura_product): {$aura_count}</p>";
        echo "<p>Virical products (custom table): {$virical_count}</p>";
        
        // Trigger redirect setup if products were migrated
        if ($this->migrated_count > 0) {
            do_action('virical_after_migration');
            echo "<p style='color: green;'><strong>✓ Redirects have been set up for migrated products.</strong></p>";
        }
    }
    
    /**
     * Cleanup function to remove Aura data after successful migration
     */
    public function cleanup_aura_data($dry_run = true) {
        if ($dry_run) {
            echo "<h3>Cleanup Preview (Dry Run)</h3>";
            echo "<p>The following actions would be performed:</p>";
        } else {
            echo "<h3>Performing Cleanup</h3>";
        }
        
        // Get migrated products
        $migrated_products = get_posts(array(
            'post_type' => 'aura_product',
            'posts_per_page' => -1,
            'meta_key' => '_migrated_to_virical',
            'meta_value' => true
        ));
        
        echo "<p>Products to be removed: " . count($migrated_products) . "</p>";
        
        if (!$dry_run) {
            foreach ($migrated_products as $product) {
                // Move to trash first (safer than permanent delete)
                wp_trash_post($product->ID);
                echo "Moved to trash: {$product->post_title}<br>";
            }
            
            // Optionally remove the custom post type registration
            // This would be done in functions.php by removing the registration code
            echo "<p><strong>Note:</strong> To complete cleanup, remove the aura_product post type registration from functions.php</p>";
        }
    }
}

// Admin page for migration
function virical_migration_admin_page() {
    ?>
    <div class="wrap">
        <h1>Aura to Virical Migration</h1>
        
        <?php
        if (isset($_POST['run_migration']) && check_admin_referer('virical_migration')) {
            $migration = new Aura_To_Virical_Migration();
            $migration->run_migration();
        } elseif (isset($_POST['cleanup_preview']) && check_admin_referer('virical_migration')) {
            $migration = new Aura_To_Virical_Migration();
            $migration->cleanup_aura_data(true);
        } elseif (isset($_POST['cleanup_execute']) && check_admin_referer('virical_migration')) {
            $migration = new Aura_To_Virical_Migration();
            $migration->cleanup_aura_data(false);
        } else {
            // Show migration options
            ?>
            <div class="card">
                <h2>Migration Options</h2>
                <p>This tool will migrate all products and categories from the Aura system (WordPress Custom Post Type) to the Virical system (Custom Tables).</p>
                
                <h3>Current Status:</h3>
                <?php
                global $wpdb;
                $aura_count = wp_count_posts('aura_product')->publish;
                $virical_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}virical_products WHERE is_active = 1");
                $aura_cats = wp_count_terms('product_category');
                $virical_cats = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}virical_product_categories");
                ?>
                <ul>
                    <li>Aura Products: <?php echo $aura_count; ?></li>
                    <li>Aura Categories: <?php echo $aura_cats; ?></li>
                    <li>Virical Products: <?php echo $virical_count; ?></li>
                    <li>Virical Categories: <?php echo $virical_cats; ?></li>
                </ul>
                
                <form method="post" action="">
                    <?php wp_nonce_field('virical_migration'); ?>
                    <p>
                        <input type="submit" name="run_migration" class="button button-primary" value="Run Migration" 
                               onclick="return confirm('This will migrate all Aura products to Virical. Continue?');">
                    </p>
                </form>
                
                <hr>
                
                <h3>Cleanup Options</h3>
                <p>After successful migration, you can clean up the old Aura data:</p>
                <form method="post" action="">
                    <?php wp_nonce_field('virical_migration'); ?>
                    <p>
                        <input type="submit" name="cleanup_preview" class="button" value="Preview Cleanup (Dry Run)">
                        <input type="submit" name="cleanup_execute" class="button button-secondary" value="Execute Cleanup" 
                               onclick="return confirm('This will move all migrated Aura products to trash. This action can be undone from the trash. Continue?');">
                    </p>
                </form>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

// Add admin menu
// add_action('admin_menu', 'virical_add_migration_menu');
function virical_add_migration_menu() {
    add_submenu_page(
        'virical-products',
        'Migration Tool',
        'Migration Tool',
        'manage_options',
        'virical-migration',
        'virical_migration_admin_page'
    );
}