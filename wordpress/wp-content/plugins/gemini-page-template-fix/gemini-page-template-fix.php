<?php
/**
 * Plugin Name: Gemini Page Template Fix
 * Description: A plugin to force the correct template for the Indoor and Outdoor pages.
 * Version: 1.0
 * Author: Gemini
 */

if (!defined('ABSPATH')) exit;

function gemini_force_page_template($template) {
    if (is_page('indoor') || is_page('outdoor')) {
        $new_template = locate_template(['page-templates/product-classification.php']);
        if ('' != $new_template) {
            return $new_template;
        }
    }
    return $template;
}

add_filter('template_include', 'gemini_force_page_template', 99);
