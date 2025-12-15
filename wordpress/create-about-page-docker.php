<?php
// Script to create About Us page with custom template

// Get WordPress database credentials from docker-compose
$db_host = 'localhost';
$db_name = 'aura_db';
$db_user = 'aura_user';
$db_pass = 'aura_pass123';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n";
    
    // First check if About Us page already exists
    $check_stmt = $pdo->prepare("SELECT ID FROM wp_posts WHERE post_type = 'page' AND (post_name = 'about-us' OR post_name = 'chung-toi')");
    $check_stmt->execute();
    $existing_page = $check_stmt->fetch();
    
    if ($existing_page) {
        echo "About Us page already exists with ID: " . $existing_page['ID'] . "\n";
        
        // Update the template
        $update_template = $pdo->prepare("UPDATE wp_postmeta SET meta_value = 'page-about-us.php' WHERE post_id = ? AND meta_key = '_wp_page_template'");
        $update_template->execute([$existing_page['ID']]);
        
        // If template meta doesn't exist, create it
        $check_template = $pdo->prepare("SELECT meta_id FROM wp_postmeta WHERE post_id = ? AND meta_key = '_wp_page_template'");
        $check_template->execute([$existing_page['ID']]);
        
        if (!$check_template->fetch()) {
            $insert_template = $pdo->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (?, '_wp_page_template', 'page-about-us.php')");
            $insert_template->execute([$existing_page['ID']]);
        }
        
        echo "Updated page template to page-about-us.php\n";
        
    } else {
        // Create new About Us page
        $page_data = [
            'post_author' => 1,
            'post_date' => date('Y-m-d H:i:s'),
            'post_date_gmt' => gmdate('Y-m-d H:i:s'),
            'post_content' => '',
            'post_title' => 'Chúng Tôi',
            'post_excerpt' => '',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_password' => '',
            'post_name' => 'chung-toi',
            'to_ping' => '',
            'pinged' => '',
            'post_modified' => date('Y-m-d H:i:s'),
            'post_modified_gmt' => gmdate('Y-m-d H:i:s'),
            'post_content_filtered' => '',
            'post_parent' => 0,
            'guid' => 'http://localhost:8000/?page_id=',
            'menu_order' => 0,
            'post_type' => 'page',
            'post_mime_type' => '',
            'comment_count' => 0
        ];
        
        $columns = implode(', ', array_keys($page_data));
        $placeholders = ':' . implode(', :', array_keys($page_data));
        
        $insert_stmt = $pdo->prepare("INSERT INTO wp_posts ($columns) VALUES ($placeholders)");
        $insert_stmt->execute($page_data);
        
        $page_id = $pdo->lastInsertId();
        
        // Update GUID
        $update_guid = $pdo->prepare("UPDATE wp_posts SET guid = ? WHERE ID = ?");
        $update_guid->execute(['http://localhost:8000/?page_id=' . $page_id, $page_id]);
        
        // Set page template
        $template_stmt = $pdo->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (?, '_wp_page_template', 'page-about-us.php')");
        $template_stmt->execute([$page_id]);
        
        echo "Created new About Us page with ID: $page_id\n";
        echo "Page URL: http://localhost:8000/chung-toi/\n";
    }
    
    // Initialize default options for the About page
    $default_options = [
        'aura_about_hero_title' => 'CHÚNG TÔI',
        'aura_about_hero_subtitle' => 'Aura Lighting - SMARTHOME',
        'aura_about_intro_title' => 'VỀ AURA LIGHTING',
        'aura_about_intro_content' => '<p>Aura Lighting là công ty hàng đầu chuyên thiết kế và cung cấp giải pháp chiếu sáng cao cấp cho các công trình kiến trúc, nội thất tại Việt Nam. Với đội ngũ chuyên gia giàu kinh nghiệm và đam mê sáng tạo, chúng tôi mang đến những giải pháp chiếu sáng độc đáo, kết hợp hoàn hảo giữa nghệ thuật và công nghệ.</p>',
        'aura_about_hero_image' => 'http://localhost:8000/wp-content/uploads/about-hero.jpg',
        'aura_about_intro_image' => 'http://localhost:8000/wp-content/uploads/about-intro.jpg'
    ];
    
    foreach ($default_options as $option_name => $option_value) {
        // Check if option exists
        $check_option = $pdo->prepare("SELECT option_id FROM wp_options WHERE option_name = ?");
        $check_option->execute([$option_name]);
        
        if ($check_option->fetch()) {
            $update_option = $pdo->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = ?");
            $update_option->execute([$option_value, $option_name]);
        } else {
            $insert_option = $pdo->prepare("INSERT INTO wp_options (option_name, option_value, autoload) VALUES (?, ?, 'yes')");
            $insert_option->execute([$option_name, $option_value]);
        }
    }
    
    echo "\nDefault content has been set for About Us page.\n";
    echo "You can customize it from WordPress Admin > About Page menu.\n";
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage() . "\n");
}
?>