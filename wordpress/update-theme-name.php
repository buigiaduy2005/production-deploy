<?php
// Script to update theme name in database

// Database credentials
$db_host = 'mysql';
$db_name = 'aura_db';
$db_user = 'aura_user';
$db_pass = 'aura_pass123';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

echo "Connected to database successfully.\n";

// Update active theme
$queries = [
    "UPDATE wp_options SET option_value = 'virical-theme' WHERE option_name = 'template'",
    "UPDATE wp_options SET option_value = 'virical-theme' WHERE option_name = 'stylesheet'",
    "UPDATE wp_options SET option_value = 'virical-theme' WHERE option_name = 'current_theme'"
];

foreach ($queries as $query) {
    if ($mysqli->query($query)) {
        echo "Executed: $query\n";
    } else {
        echo "Error: " . $mysqli->error . "\n";
    }
}

echo "\nTheme name has been updated to virical-theme!\n";

$mysqli->close();
?>