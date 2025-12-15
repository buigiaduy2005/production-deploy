<?php
/**
 * Plugin Name: Virical Slider Manager
 * Description: Manages the hero slider for the Virical theme.
 * Version: 1.0
 * Author: Gemini
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// 1. Register Custom Post Type 'aura_slider'
function virical_slider_register_post_type() {
    $labels = array(
        'name'               => _x('Slides', 'post type general name', 'virical-slider'),
        'singular_name'      => _x('Slide', 'post type singular name', 'virical-slider'),
        'menu_name'          => _x('Hero Slider', 'admin menu', 'virical-slider'),
        'name_admin_bar'     => _x('Slide', 'add new on admin bar', 'virical-slider'),
        'add_new'            => _x('Add New', 'slide', 'virical-slider'),
        'add_new_item'       => __('Add New Slide', 'virical-slider'),
        'new_item'           => __('New Slide', 'virical-slider'),
        'edit_item'          => __('Edit Slide', 'virical-slider'),
        'view_item'          => __('View Slide', 'virical-slider'),
        'all_items'          => __('All Slides', 'virical-slider'),
        'search_items'       => __('Search Slides', 'virical-slider'),
        'parent_item_colon'  => __('Parent Slides:', 'virical-slider'),
        'not_found'          => __('No slides found.', 'virical-slider'),
        'not_found_in_trash' => __('No slides found in Trash.', 'virical-slider')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'slide'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-images-alt2',
        'supports'           => array('title', 'thumbnail', 'page-attributes'),
    );

    register_post_type('aura_slider', $args);
}
add_action('init', 'virical_slider_register_post_type');

// 2. Add Meta Box for Subtitle and Link
function virical_slider_add_meta_box() {
    add_meta_box(
        'virical_slider_meta',
        'Slide Details',
        'virical_slider_meta_box_callback',
        'aura_slider',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'virical_slider_add_meta_box');

// 3. Meta Box HTML
function virical_slider_meta_box_callback($post) {
    wp_nonce_field('virical_slider_save_meta_box_data', 'virical_slider_meta_box_nonce');

    $subtitle = get_post_meta($post->ID, '_slide_subtitle', true);
    $link = get_post_meta($post->ID, '_slide_link', true);

    echo '<p>';
    echo '<label for="virical_slide_subtitle"><strong>' . __('Slide Title/Subtitle', 'virical-slider') . '</strong></label><br />';
    echo '<input type="text" id="virical_slide_subtitle" name="virical_slide_subtitle" value="' . esc_attr($subtitle) . '" size="50" />';
    echo '<p class="description">' . __('This text appears on the slide image.', 'virical-slider') . '</p>';
    echo '</p>';

    echo '<p>';
    echo '<label for="virical_slide_link"><strong>' . __('Slide Link', 'virical-slider') . '</strong></label><br />';
    echo '<input type="url" id="virical_slide_link" name="virical_slide_link" value="' . esc_url($link) . '" size="50" />';
    echo '<p class="description">' . __('Enter the full URL where this slide should link to.', 'virical-slider') . '</p>';
    echo '</p>';
}

// 4. Save Meta Box Data
function virical_slider_save_meta_box_data($post_id) {
    if (!isset($_POST['virical_slider_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['virical_slider_meta_box_nonce'], 'virical_slider_save_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['post_type']) && 'aura_slider' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    if (isset($_POST['virical_slide_subtitle'])) {
        update_post_meta($post_id, '_slide_subtitle', sanitize_text_field($_POST['virical_slide_subtitle']));
    }

    if (isset($_POST['virical_slide_link'])) {
        update_post_meta($post_id, '_slide_link', esc_url_raw($_POST['virical_slide_link']));
    }
}
add_action('save_post', 'virical_slider_save_meta_box_data');

// 5. Add columns to the admin list
function virical_slider_add_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['image'] = __('Featured Image', 'virical-slider');
    $new_columns['title'] = $columns['title'];
    $new_columns['subtitle'] = __('Slide Subtitle', 'virical-slider');
    $new_columns['link'] = __('Link', 'virical-slider');
    $new_columns['menu_order'] = __('Order', 'virical-slider');
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_aura_slider_posts_columns', 'virical_slider_add_admin_columns');

// 6. Populate custom columns
function virical_slider_populate_custom_columns($column, $post_id) {
    switch ($column) {
        case 'image':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(100, 60));
            } else {
                echo '—';
            }
            break;
        case 'subtitle':
            $subtitle = get_post_meta($post_id, '_slide_subtitle', true);
            echo esc_html($subtitle);
            break;
        case 'link':
            $link = get_post_meta($post_id, '_slide_link', true);
            if ($link) {
                echo '<a href="' . esc_url($link) . '" target="_blank">' . esc_html($link) . '</a>';
            } else {
                echo '—';
            }
            break;
        case 'menu_order':
            $post = get_post($post_id);
            echo $post->menu_order;
            break;
    }
}
add_action('manage_aura_slider_posts_custom_column', 'virical_slider_populate_custom_columns', 10, 2);

// 7. Make 'menu_order' column sortable
function virical_slider_make_order_column_sortable($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-aura_slider_sortable_columns', 'virical_slider_make_order_column_sortable');

?>