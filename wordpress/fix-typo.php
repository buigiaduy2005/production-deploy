<?php
// Include WordPress bootstrap file
require_once('wp-load.php');

global $wpdb;

// The incorrect and correct strings
$incorrect_string = 'THIẾT KỄ SANG TRỌNG - TINH TẾ';
$correct_string = 'THIẾT KẾ SANG TRỌNG - TINH TẾ';

// Find posts with the incorrect string
$posts = $wpdb->get_results($wpdb->prepare(
    "SELECT ID, post_content FROM $wpdb->posts WHERE post_content LIKE %s",
    '%' . $wpdb->esc_like($incorrect_string) . '%'
));

if (empty($posts)) {
    echo "No posts found with the incorrect string: '$incorrect_string'";
} else {
    foreach ($posts as $post) {
        // Replace the string in the post content
        $new_content = str_replace($incorrect_string, $correct_string, $post->post_content);

        // Update the post in the database
        $wpdb->update(
            $wpdb->posts,
            array('post_content' => $new_content),
            array('ID' => $post->ID)
        );

        echo "Updated post with ID: " . $post->ID . "\n";
    }
    echo "Typo correction complete.";
}
?>
