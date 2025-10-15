<?php
// Load the WordPress environment
if (file_exists('wp-load.php')) {
    require_once('wp-load.php');
} else {
    die('Could not find wp-load.php. Make sure this script is in your WordPress root directory.');
}

// Define the correct and incorrect URLs
$correct_url = 'http://localhost:8080';
$incorrect_url = 'http://localhost:8082';

// Get the current siteurl and home options
$siteurl = get_option('siteurl');
$home = get_option('home');

echo "Current siteurl: " . $siteurl . "<br>";
echo "Current home: " . $home . "<br>";

$updated = false;

// Check and update the siteurl
if (strpos($siteurl, $incorrect_url) !== false) {
    $new_siteurl = str_replace($incorrect_url, $correct_url, $siteurl);
    update_option('siteurl', $new_siteurl);
    echo "Updated siteurl to: " . $new_siteurl . "<br>";
    $updated = true;
}

// Check and update the home url
if (strpos($home, $incorrect_url) !== false) {
    $new_home = str_replace($incorrect_url, $correct_url, $home);
    update_option('home', $new_home);
    echo "Updated home url to: " . $new_home . "<br>";
    $updated = true;
}

if ($updated) {
    echo "<strong>Success:</strong> Site URLs have been updated. Please clear your browser cache and hard-refresh the page to see the changes.<br>";
} else {
    echo "No updates were necessary. The URLs in the database seem to be correct.<br>";
}

// Check if the URLs are hardcoded in wp-config.php
if (defined('WP_HOME') || defined('WP_SITEURL')) {
    echo "<hr>";
    echo "<strong>Warning:</strong> Your `wp-config.php` file contains hardcoded values for `WP_HOME` or `WP_SITEURL`.<br>";
    if (defined('WP_HOME')) {
        echo "WP_HOME: <strong>" . WP_HOME . "</strong><br>";
    }
    if (defined('WP_SITEURL')) {
        echo "WP_SITEURL: <strong>" . WP_SITEURL . "</strong><br>";
    }
    echo "If these values still point to `$incorrect_url`, you must manually edit your `wp-config.php` file to change them to `$correct_url`.<br>";
}

?>
