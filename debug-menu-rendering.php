<?php
/**
 * Debug Menu Rendering - Find where menus are being rendered
 */

// Include WordPress
require_once('wordpress/wp-config.php');

echo "<h1>🔍 Debug Menu Rendering</h1>";
echo "<hr>";

// Enable debug mode
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get the homepage HTML
ob_start();
include('wordpress/index.php');
$html = ob_get_clean();

echo "<h2>Analysis Results:</h2>";

// Count how many times main-nav appears
$nav_count = substr_count($html, 'class="main-nav"');
echo "<p><strong>Number of .main-nav found:</strong> <span style='color: " . ($nav_count > 1 ? 'red' : 'green') . "; font-size: 24px;'>{$nav_count}</span></p>";

// Count menu items
$trang_chu_count = substr_count($html, '>TRANG CHỦ<');
$san_pham_count = substr_count($html, '>SẢN PHẨM<');
$gioi_thieu_count = substr_count($html, '>GIỚI THIỆU<');
$lien_he_count = substr_count($html, '>LIÊN HỆ<');

echo "<h3>Menu Item Counts:</h3>";
echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr style='background: #f0f0f0;'><th>Menu Item</th><th>Count</th><th>Status</th></tr>";

$items = [
    'TRANG CHỦ' => $trang_chu_count,
    'SẢN PHẨM' => $san_pham_count,
    'GIỚI THIỆU' => $gioi_thieu_count,
    'LIÊN HỆ' => $lien_he_count
];

foreach ($items as $item => $count) {
    $status = $count > 1 ? '❌ DUPLICATE' : '✓ OK';
    $color = $count > 1 ? 'red' : 'green';
    echo "<tr>";
    echo "<td>{$item}</td>";
    echo "<td style='font-size: 20px; font-weight: bold;'>{$count}</td>";
    echo "<td style='color: {$color}; font-weight: bold;'>{$status}</td>";
    echo "</tr>";
}
echo "</table>";

// Extract and show all nav menus
echo "<hr><h3>All Navigation Menu HTML:</h3>";
$pattern = '/<nav[^>]*class="[^"]*main-navigation[^"]*"[^>]*>.*?<\/nav>/s';
preg_match_all($pattern, $html, $matches);

if (!empty($matches[0])) {
    echo "<p>Found " . count($matches[0]) . " navigation blocks:</p>";
    foreach ($matches[0] as $index => $nav_html) {
        echo "<div style='margin: 20px 0; padding: 15px; border: 2px solid " . ($index > 0 ? 'red' : 'green') . "; background: #f9f9f9;'>";
        echo "<h4 style='color: " . ($index > 0 ? 'red' : 'green') . ";'>Navigation Block #" . ($index + 1) . ($index > 0 ? ' (DUPLICATE!)' : ' (Original)') . "</h4>";
        echo "<pre style='overflow: auto; max-height: 300px;'>" . htmlspecialchars($nav_html) . "</pre>";
        echo "</div>";
    }
}

// Check for ul.main-nav specifically
echo "<hr><h3>All &lt;ul class='main-nav'&gt; Elements:</h3>";
$ul_pattern = '/<ul[^>]*class="[^"]*main-nav[^"]*"[^>]*>.*?<\/ul>/s';
preg_match_all($ul_pattern, $html, $ul_matches);

if (!empty($ul_matches[0])) {
    echo "<p style='color: red; font-size: 20px; font-weight: bold;'>Found " . count($ul_matches[0]) . " ul.main-nav elements!</p>";
    foreach ($ul_matches[0] as $index => $ul_html) {
        echo "<div style='margin: 20px 0; padding: 15px; border: 2px solid red; background: #ffe6e6;'>";
        echo "<h4>UL.main-nav #" . ($index + 1) . "</h4>";
        echo "<pre style='overflow: auto; max-height: 200px;'>" . htmlspecialchars(substr($ul_html, 0, 500)) . "...</pre>";
        echo "</div>";
    }
}

// Show solution
echo "<hr><h2>🔧 Solution:</h2>";
if ($nav_count > 1) {
    echo "<div style='background: #fff3cd; padding: 20px; border-left: 4px solid #ffc107;'>";
    echo "<h3>Problem Identified:</h3>";
    echo "<p>The navigation menu is being rendered <strong>{$nav_count} times</strong> in the HTML output.</p>";
    echo "<h3>Possible Causes:</h3>";
    echo "<ul>";
    echo "<li>header.php is being included multiple times</li>";
    echo "<li>virical_render_navigation_menu() is being called multiple times</li>";
    echo "<li>WordPress theme or plugin is injecting additional menu</li>";
    echo "<li>Template is using both get_header() and custom header</li>";
    echo "</ul>";
    echo "<h3>Recommended Fix:</h3>";
    echo "<ol>";
    echo "<li>Check which template is being used (single.php, page.php, index.php)</li>";
    echo "<li>Search for multiple get_header() calls</li>";
    echo "<li>Use output buffering to remove duplicate menus</li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<div style='background: #d4edda; padding: 20px; border-left: 4px solid #28a745;'>";
    echo "<h3>✅ No Duplicates Found!</h3>";
    echo "<p>The menu is rendering correctly. Clear your browser cache if you still see duplicates on the actual site.</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><a href='/' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>View Homepage</a></p>";
?>
