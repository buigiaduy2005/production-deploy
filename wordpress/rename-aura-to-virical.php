<?php
// Script to rename all Aura references to Virical

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

// Update About page title and content
$updates = [
    // Update page title
    "UPDATE wp_posts SET post_title = 'Chúng Tôi' WHERE ID = 10",
    
    // Update all option values containing Aura
    "UPDATE wp_options SET option_value = REPLACE(option_value, 'Aura Lighting', 'Virical') WHERE option_value LIKE '%Aura Lighting%'",
    "UPDATE wp_options SET option_value = REPLACE(option_value, 'AURA LIGHTING', 'VIRICAL') WHERE option_value LIKE '%AURA LIGHTING%'",
    "UPDATE wp_options SET option_value = REPLACE(option_value, 'Aura', 'Virical') WHERE option_value LIKE '%Aura%' AND option_name LIKE 'aura_about_%'",
    
    // Update site title and tagline
    "UPDATE wp_options SET option_value = 'Virical' WHERE option_name = 'blogname'",
    "UPDATE wp_options SET option_value = 'Feeling Light' WHERE option_name = 'blogdescription'"
];

foreach ($updates as $query) {
    if ($mysqli->query($query)) {
        echo "Executed: " . substr($query, 0, 60) . "...\n";
    } else {
        echo "Error: " . $mysqli->error . "\n";
    }
}

// Get and update specific options
$specific_updates = [
    'aura_about_hero_subtitle' => 'Virical - Feeling Light',
    'aura_about_intro_title' => 'VỀ VIRICAL',
    'aura_about_intro_content' => '<p>Virical là công ty hàng đầu chuyên thiết kế và cung cấp giải pháp chiếu sáng cao cấp cho các công trình kiến trúc, nội thất tại Việt Nam. Với đội ngũ chuyên gia giàu kinh nghiệm và đam mê sáng tạo, chúng tôi mang đến những giải pháp chiếu sáng độc đáo, kết hợp hoàn hảo giữa nghệ thuật và công nghệ.</p>'
];

foreach ($specific_updates as $option_name => $new_value) {
    $new_value = $mysqli->real_escape_string($new_value);
    $query = "UPDATE wp_options SET option_value = '$new_value' WHERE option_name = '$option_name'";
    
    if ($mysqli->query($query)) {
        echo "Updated $option_name\n";
    }
}

// Update story sections
$check_story = "SELECT option_value FROM wp_options WHERE option_name = 'aura_about_story_sections'";
$result = $mysqli->query($check_story);

if ($result && $row = $result->fetch_assoc()) {
    $story_sections = unserialize($row['option_value']);
    
    // Update content
    foreach ($story_sections as &$section) {
        $section['content'] = str_replace('Aura Lighting', 'Virical', $section['content']);
    }
    
    $story_sections[0]['content'] = '<p>Được thành lập từ năm 2015, Virical đã không ngừng phát triển và khẳng định vị thế là đơn vị tiên phong trong lĩnh vực thiết kế chiếu sáng tại Việt Nam. Với hơn 8 năm kinh nghiệm, chúng tôi đã thực hiện hàng trăm dự án lớn nhỏ trên khắp cả nước.</p><p>Từ những ngày đầu khởi nghiệp với chỉ 5 thành viên, Virical giờ đây tự hào với đội ngũ hơn 50 chuyên gia và kỹ sư tài năng, luôn sẵn sàng mang đến những giải pháp chiếu sáng tối ưu nhất.</p>';
    
    $serialized = $mysqli->real_escape_string(serialize($story_sections));
    $update_story = "UPDATE wp_options SET option_value = '$serialized' WHERE option_name = 'aura_about_story_sections'";
    $mysqli->query($update_story);
    echo "Updated story sections\n";
}

// Update team members social links
$check_team = "SELECT option_value FROM wp_options WHERE option_name = 'aura_about_team_members'";
$result = $mysqli->query($check_team);

if ($result && $row = $result->fetch_assoc()) {
    $team_members = unserialize($row['option_value']);
    
    // Update social links
    if (isset($team_members[0])) {
        $team_members[0]['facebook'] = 'https://facebook.com/virical';
        $team_members[0]['linkedin'] = 'https://linkedin.com/company/virical';
    }
    
    $serialized = $mysqli->real_escape_string(serialize($team_members));
    $update_team = "UPDATE wp_options SET option_value = '$serialized' WHERE option_name = 'aura_about_team_members'";
    $mysqli->query($update_team);
    echo "Updated team members\n";
}

echo "\nAll Aura references have been updated to Virical!\n";
echo "The About Us page now reflects the Virical branding.\n";

$mysqli->close();
?>