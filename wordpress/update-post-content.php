<?php
// Load the WordPress environment
if (!file_exists('wp-load.php')) {
    die('Could not find wp-load.php. Make sure this script is in your WordPress root directory.');
}
require_once('wp-load.php');
global $wpdb;

$old_url = 'http://localhost:8082';
$new_url = 'http://localhost:8080';

echo "Starting update of post content...<br>";
echo "Old URL: " . htmlspecialchars($old_url) . "<br>";
echo "New URL: " . htmlspecialchars($new_url) . "<br><hr>";

// Run the update query directly on the database
$query = $wpdb->prepare(
    "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s) WHERE post_content LIKE %s",
    $old_url,
    $new_url,
    '%"' . $wpdb->esc_like($old_url) . '"%' // Only update rows that contain the old URL
);
$rows_affected = $wpdb->query($query);

if ($rows_affected === false) {
    echo "<strong style='color:red;'>Error:</strong> The database query failed.<br>";
    echo "Last DB Error: " . htmlspecialchars($wpdb->last_error) . "<br>";
} else {
    echo "<strong style='color:green;'>Success!</strong><br>";
    echo "<strong>Rows updated: " . $rows_affected . "</strong><br>";
}

echo "<hr><strong>ACTION REQUIRED:</strong> Please copy this entire output and paste it in your reply.<br>";
echo "After that, clear your browser cache thoroughly and check the page again.<br>";

?>