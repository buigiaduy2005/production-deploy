<?php
require_once('wp-load.php');

global $wpdb;

$incorrect_string = 'THIẾT KỄ';
$correct_string = 'THIẾT KẾ';

$tables_to_search = [
    $wpdb->posts => ['post_content', 'post_title', 'post_excerpt'],
    $wpdb->options => ['option_value'],
    $wpdb->postmeta => ['meta_value'],
    $wpdb->termmeta => ['meta_value'],
    $wpdb->commentmeta => ['meta_value'],
];

$total_updates = 0;

foreach ($tables_to_search as $table => $columns) {
    foreach ($columns as $column) {
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE $column LIKE %s",
            '%' . $wpdb->esc_like($incorrect_string) . '%'
        ));

        if (!empty($results)) {
            echo "Found potential matches in table '$table', column '$column'.\n";
            foreach ($results as $row) {
                $primary_key = 'ID'; // default primary key
                if ($table === $wpdb->options) $primary_key = 'option_id';
                if ($table === $wpdb->postmeta) $primary_key = 'meta_id';
                if ($table === $wpdb->termmeta) $primary_key = 'meta_id';
                if ($table === $wpdb->commentmeta) $primary_key = 'meta_id';

                $original_value = $row->$column;
                $new_value = str_replace($incorrect_string, $correct_string, $original_value);

                $wpdb->update(
                    $table,
                    [$column => $new_value],
                    [$primary_key => $row->$primary_key]
                );
                $total_updates++;
                echo "  - Updated row with $primary_key: " . $row->$primary_key . "\n";
            }
        }
    }
}

if ($total_updates > 0) {
    echo "\nDeep typo correction complete. Found and updated $total_updates occurrences.\n";
} else {
    echo "\nNo occurrences of the typo were found in the database.\n";
}

?>