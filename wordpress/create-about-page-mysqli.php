<?php
// Script to create About Us page with custom template

// Get WordPress database credentials from docker-compose
$db_host = 'mysql'; // Use service name in Docker
$db_name = 'aura_db';
$db_user = 'aura_user';
$db_pass = 'aura_pass123';

// Use mysqli
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

echo "Connected to database successfully.\n";

// First check if About Us page already exists
$check_query = "SELECT ID FROM wp_posts WHERE post_type = 'page' AND (post_name = 'about-us' OR post_name = 'chung-toi')";
$result = $mysqli->query($check_query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $page_id = $row['ID'];
    echo "About Us page already exists with ID: $page_id\n";
    
    // Update the template
    $update_template = "UPDATE wp_postmeta SET meta_value = 'page-about-us.php' WHERE post_id = $page_id AND meta_key = '_wp_page_template'";
    $mysqli->query($update_template);
    
    // Check if template meta exists
    $check_template = "SELECT meta_id FROM wp_postmeta WHERE post_id = $page_id AND meta_key = '_wp_page_template'";
    $template_result = $mysqli->query($check_template);
    
    if ($template_result->num_rows == 0) {
        $insert_template = "INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ($page_id, '_wp_page_template', 'page-about-us.php')";
        $mysqli->query($insert_template);
    }
    
    echo "Updated page template to page-about-us.php\n";
    
} else {
    // Create new About Us page
    $date = date('Y-m-d H:i:s');
    $date_gmt = gmdate('Y-m-d H:i:s');
    
    $insert_page = "INSERT INTO wp_posts (
        post_author, post_date, post_date_gmt, post_content, post_title,
        post_excerpt, post_status, comment_status, ping_status, post_password,
        post_name, to_ping, pinged, post_modified, post_modified_gmt,
        post_content_filtered, post_parent, guid, menu_order, post_type,
        post_mime_type, comment_count
    ) VALUES (
        1, '$date', '$date_gmt', '', 'Chúng Tôi',
        '', 'publish', 'closed', 'closed', '',
        'chung-toi', '', '', '$date', '$date_gmt',
        '', 0, '', 0, 'page',
        '', 0
    )";
    
    if ($mysqli->query($insert_page)) {
        $page_id = $mysqli->insert_id;
        
        // Update GUID
        $guid = "http://localhost:8000/?page_id=$page_id";
        $update_guid = "UPDATE wp_posts SET guid = '$guid' WHERE ID = $page_id";
        $mysqli->query($update_guid);
        
        // Set page template
        $template_query = "INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ($page_id, '_wp_page_template', 'page-about-us.php')";
        $mysqli->query($template_query);
        
        echo "Created new About Us page with ID: $page_id\n";
        echo "Page URL: http://localhost:8000/chung-toi/\n";
    } else {
        echo "Error creating page: " . $mysqli->error . "\n";
    }
}

// Initialize default options for the About page
$default_options = [
    'aura_about_hero_title' => 'CHÚNG TÔI',
    'aura_about_hero_subtitle' => 'Aura Lighting - Feeling Light',
    'aura_about_intro_title' => 'VỀ AURA LIGHTING',
    'aura_about_intro_content' => '<p>Aura Lighting là công ty hàng đầu chuyên thiết kế và cung cấp giải pháp chiếu sáng cao cấp cho các công trình kiến trúc, nội thất tại Việt Nam. Với đội ngũ chuyên gia giàu kinh nghiệm và đam mê sáng tạo, chúng tôi mang đến những giải pháp chiếu sáng độc đáo, kết hợp hoàn hảo giữa nghệ thuật và công nghệ.</p>',
    'aura_about_hero_image' => 'http://localhost:8000/wp-content/uploads/about-hero.jpg',
    'aura_about_intro_image' => 'http://localhost:8000/wp-content/uploads/about-intro.jpg'
];

foreach ($default_options as $option_name => $option_value) {
    // Escape value
    $option_value = $mysqli->real_escape_string($option_value);
    
    // Check if option exists
    $check_option = "SELECT option_id FROM wp_options WHERE option_name = '$option_name'";
    $option_result = $mysqli->query($check_option);
    
    if ($option_result && $option_result->num_rows > 0) {
        $update_option = "UPDATE wp_options SET option_value = '$option_value' WHERE option_name = '$option_name'";
        $mysqli->query($update_option);
    } else {
        $insert_option = "INSERT INTO wp_options (option_name, option_value, autoload) VALUES ('$option_name', '$option_value', 'yes')";
        $mysqli->query($insert_option);
    }
}

// Add some sample data
$story_sections = [
    [
        'title' => 'CÂU CHUYỆN CỦA CHÚNG TÔI',
        'content' => '<p>Được thành lập từ năm 2015, Aura Lighting đã không ngừng phát triển và khẳng định vị thế là đơn vị tiên phong trong lĩnh vực thiết kế chiếu sáng tại Việt Nam. Chúng tôi tin rằng ánh sáng không chỉ là công cụ chiếu sáng mà còn là nghệ thuật tạo nên cảm xúc và trải nghiệm độc đáo.</p>',
        'image' => 'http://localhost:8000/wp-content/uploads/story-1.jpg'
    ],
    [
        'title' => 'TẦM NHÌN & SỨ MỆNH',
        'content' => '<p>Tầm nhìn của chúng tôi là trở thành công ty thiết kế chiếu sáng hàng đầu Đông Nam Á. Sứ mệnh của Aura Lighting là mang đến những giải pháp chiếu sáng sáng tạo, bền vững và tiết kiệm năng lượng, góp phần nâng cao chất lượng cuộc sống.</p>',
        'image' => 'http://localhost:8000/wp-content/uploads/story-2.jpg'
    ]
];

$story_sections_serialized = $mysqli->real_escape_string(serialize($story_sections));
$check_story = "SELECT option_id FROM wp_options WHERE option_name = 'aura_about_story_sections'";
$story_result = $mysqli->query($check_story);

if ($story_result && $story_result->num_rows > 0) {
    $update_story = "UPDATE wp_options SET option_value = '$story_sections_serialized' WHERE option_name = 'aura_about_story_sections'";
    $mysqli->query($update_story);
} else {
    $insert_story = "INSERT INTO wp_options (option_name, option_value, autoload) VALUES ('aura_about_story_sections', '$story_sections_serialized', 'yes')";
    $mysqli->query($insert_story);
}

echo "\nDefault content has been set for About Us page.\n";
echo "You can customize it from WordPress Admin > About Page menu.\n";

$mysqli->close();
?>