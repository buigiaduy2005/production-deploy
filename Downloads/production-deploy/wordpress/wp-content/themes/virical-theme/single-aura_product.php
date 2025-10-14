<?php
/**
 * Legacy Single Product Template - Redirects to new structure
 * 
 * This template handles old aura_product URLs and redirects them to the new product structure
 * Reference: todos.md Task 1.2 - Update single product template
 * 
 * @package Virical
 */

// Get the current post
global $post, $wpdb;

if ($post && $post->post_type === 'aura_product') {
    // Try to find the corresponding product in the new virical_products table
    $product_slug = $post->post_name;
    
    // Check if product exists in new table
    $new_product = $wpdb->get_row($wpdb->prepare(
        "SELECT slug FROM {$wpdb->prefix}virical_products WHERE slug = %s AND is_active = 1",
        $product_slug
    ));
    
    if ($new_product) {
        // Redirect to new product URL structure
        wp_redirect(home_url('/san-pham/' . $new_product->slug . '/'), 301);
        exit;
    } else {
        // Try to find by product name if slug doesn't match
        $new_product = $wpdb->get_row($wpdb->prepare(
            "SELECT slug FROM {$wpdb->prefix}virical_products WHERE name = %s AND is_active = 1",
            $post->post_title
        ));
        
        if ($new_product) {
            wp_redirect(home_url('/san-pham/' . $new_product->slug . '/'), 301);
            exit;
        }
    }
}

// If no matching product found, redirect to products page
wp_redirect(home_url('/san-pham/'), 301);
exit;