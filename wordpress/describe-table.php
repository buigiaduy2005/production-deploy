<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

global $wpdb;

header('Content-Type: text/plain; charset=utf-8');

$table_name = 'wp_virical_routing_rules'; // <-- Changed this line

$columns = $wpdb->get_results("DESCRIBE {$table_name}");

if (empty($columns)) {
    echo "Could not describe table '{$table_name}': " . $wpdb->last_error;
} else {
    echo "Columns in table '{$table_name}':\n\n";
    echo str_pad('Field', 30) . str_pad('Type', 30) . "\n";
    echo str_repeat('-', 60) . "\n";
    foreach ($columns as $column) {
        echo str_pad($column->Field, 30) . str_pad($column->Type, 30) . "\n";
    }
}

?>