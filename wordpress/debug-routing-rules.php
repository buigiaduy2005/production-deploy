<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

global $wpdb;

header('Content-Type: text/plain; charset=utf-8');

$table_name = 'wp_virical_routing_rules';

echo "--- DUMPING TABLE: {$table_name} ---\\n\\n";

$rules = $wpdb->get_results("SELECT * FROM {$table_name}", ARRAY_A);

if (empty($rules)) {
    echo "No rules found in {$table_name}.";
} else {
    foreach ($rules as $rule) {
        echo "[ID: {$rule['id']}]\\n";
        echo "  Route Pattern: " . $rule['route_pattern'] . "\\n";
        echo "  Template File: " . $rule['template_file'] . "\\n";
        echo "  Query Vars:    " . $rule['query_vars'] . "\\n";
        echo "-------------------------------------\\n";
    }
}

?>