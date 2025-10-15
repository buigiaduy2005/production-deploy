<?php
// Load WordPress environment
require_once( __DIR__ . '/wp-load.php' );

global $wpdb;

header('Content-Type: text/plain; charset=utf-8');

$table_name = 'wp_virical_routing_rules';

echo "--- DUMPING TABLE: {$table_name} (Corrected) ---\\n\\n";

$rules = $wpdb->get_results("SELECT * FROM {$table_name} WHERE is_active = 1 ORDER BY priority ASC");

if (empty($rules)) {
    echo "No active rules found in {$table_name}.";
} else {
    foreach ($rules as $rule) {
        echo "[ID: {$rule->id} | Priority: {$rule->priority}]\\n";
        echo "  Name:    " . $rule->rule_name . "\\n";
        echo "  Pattern: " . $rule->pattern . "\\n";
        echo "  Rewrite: " . $rule->rewrite . "\\n";
        echo "--------------------------------------------------\\n";
    }
}

?>