<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

global $wpdb;

header('Content-Type: text/plain; charset=utf-8');

$tables = $wpdb->get_results("SHOW TABLES");

if (empty($tables)) {
    echo "Could not fetch tables from database: " . $wpdb->last_error;
} else {
    echo "Tables in database '{$wpdb->dbname}':\n\n";
    foreach ($tables as $table) {
        foreach ($table as $table_name) {
            echo "- " . $table_name . "\n";
        }
    }
}

?>