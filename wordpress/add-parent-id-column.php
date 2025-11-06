<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

global $wpdb;

$table_name = $wpdb->prefix . 'virical_product_categories';
$column_name = 'parent_id';

// Check if the column already exists
$column = $wpdb->get_results( $wpdb->prepare(
    "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s",
    DB_NAME, $table_name, $column_name
) );

if ( empty( $column ) ) {
    $wpdb->query( "ALTER TABLE $table_name ADD COLUMN $column_name INT(11) UNSIGNED NULL DEFAULT NULL AFTER `slug`" );
    echo "Column '$column_name' added to table '$table_name'.";
} else {
    echo "Column '$column_name' already exists in table '$table_name'.";
}

?>