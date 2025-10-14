<?php
/**
 * Company Info Functions
 * 
 * Functions to retrieve company information from database
 * 
 * @package Virical
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get company info from database
 * 
 * @param string $field The field to retrieve
 * @param string $default Default value if not found
 * @return string The field value
 */
function virical_get_company_info($field, $default = '') {
    global $wpdb;
    
    // Check cache first
    $cache_key = 'virical_company_info_' . $field;
    $cached_value = wp_cache_get($cache_key);
    
    if ($cached_value !== false) {
        return $cached_value;
    }
    
    // Query database
    $table_name = $wpdb->prefix . 'virical_company_info';
    $value = $wpdb->get_var($wpdb->prepare(
        "SELECT info_value FROM $table_name WHERE info_key = %s",
        $field
    ));
    
    // Use default if not found
    if ($value === null) {
        $value = $default;
    }
    
    // Process special fields
    if ($field === 'copyright_text') {
        $value = str_replace('{year}', date('Y'), $value);
    }
    
    // Cache the result
    wp_cache_set($cache_key, $value, '', 3600); // 1 hour cache
    
    return $value;
}

/**
 * Update company info in database
 * 
 * @param string $field The field to update
 * @param string $value The new value
 * @return bool Success status
 */
function virical_update_company_info($field, $value) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'virical_company_info';
    
    // Check if field exists
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE info_key = %s",
        $field
    ));
    
    if ($exists) {
        // Update existing
        $result = $wpdb->update(
            $table_name,
            array('info_value' => $value),
            array('info_key' => $field),
            array('%s'),
            array('%s')
        );
    } else {
        // Insert new
        $result = $wpdb->insert(
            $table_name,
            array(
                'info_key' => $field,
                'info_value' => $value,
                'info_type' => 'text'
            ),
            array('%s', '%s', '%s')
        );
    }
    
    // Clear cache
    wp_cache_delete('virical_company_info_' . $field);
    
    return $result !== false;
}

/**
 * Get all company info as array
 * 
 * @return array All company info
 */
function virical_get_all_company_info() {
    global $wpdb;
    
    // Check cache
    $cache_key = 'virical_all_company_info';
    $cached = wp_cache_get($cache_key);
    
    if ($cached !== false) {
        return $cached;
    }
    
    $table_name = $wpdb->prefix . 'virical_company_info';
    $results = $wpdb->get_results(
        "SELECT info_key, info_value FROM $table_name",
        ARRAY_A
    );
    
    $info = array();
    foreach ($results as $row) {
        $info[$row['info_key']] = $row['info_value'];
    }
    
    // Process special fields
    if (isset($info['copyright_text'])) {
        $info['copyright_text'] = str_replace('{year}', date('Y'), $info['copyright_text']);
    }
    
    // Cache the result
    wp_cache_set($cache_key, $info, '', 3600);
    
    return $info;
}