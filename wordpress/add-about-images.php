<?php
// Script to add sample images to About Us page

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

// Sample images from Unsplash (lighting/architecture themed)
$images = [
    'hero' => [
        'url' => 'https://images.unsplash.com/photo-1565636192180-fc90d66304bb?w=1920&h=1080&fit=crop',
        'title' => 'Modern Lighting Hero'
    ],
    'intro' => [
        'url' => 'https://images.unsplash.com/photo-1524634126442-357e0eac3c14?w=800&h=800&fit=crop',
        'title' => 'Aura Lighting Introduction'
    ],
    'story1' => [
        'url' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=600&fit=crop',
        'title' => 'Our Story'
    ],
    'story2' => [
        'url' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=800&h=600&fit=crop',
        'title' => 'Vision and Mission'
    ]
];

// Update About page options with real images
$image_options = [
    'aura_about_hero_image' => $images['hero']['url'],
    'aura_about_intro_image' => $images['intro']['url']
];

foreach ($image_options as $option_name => $option_value) {
    $option_value = $mysqli->real_escape_string($option_value);
    
    $check_option = "SELECT option_id FROM wp_options WHERE option_name = '$option_name'";
    $result = $mysqli->query($check_option);
    
    if ($result && $result->num_rows > 0) {
        $update_query = "UPDATE wp_options SET option_value = '$option_value' WHERE option_name = '$option_name'";
        $mysqli->query($update_query);
        echo "Updated $option_name\n";
    } else {
        $insert_query = "INSERT INTO wp_options (option_name, option_value, autoload) VALUES ('$option_name', '$option_value', 'yes')";
        $mysqli->query($insert_query);
        echo "Created $option_name\n";
    }
}

// Update story sections with images
$story_sections = [
    [
        'title' => 'CÂU CHUYỆN CỦA CHÚNG TÔI',
        'content' => '<p>Được thành lập từ năm 2015, Aura Lighting đã không ngừng phát triển và khẳng định vị thế là đơn vị tiên phong trong lĩnh vực thiết kế chiếu sáng tại Việt Nam. Với hơn 8 năm kinh nghiệm, chúng tôi đã thực hiện hàng trăm dự án lớn nhỏ trên khắp cả nước.</p><p>Từ những ngày đầu khởi nghiệp với chỉ 5 thành viên, Aura Lighting giờ đây tự hào với đội ngũ hơn 50 chuyên gia và kỹ sư tài năng, luôn sẵn sàng mang đến những giải pháp chiếu sáng tối ưu nhất.</p>',
        'image' => $images['story1']['url']
    ],
    [
        'title' => 'TẦM NHÌN & SỨ MỆNH',
        'content' => '<p><strong>Tầm nhìn:</strong> Trở thành công ty thiết kế chiếu sáng hàng đầu Đông Nam Á, tiên phong trong việc ứng dụng công nghệ chiếu sáng thông minh và bền vững.</p><p><strong>Sứ mệnh:</strong> Mang đến những giải pháp chiếu sáng sáng tạo, tiết kiệm năng lượng, góp phần nâng cao chất lượng cuộc sống và bảo vệ môi trường. Chúng tôi cam kết tạo ra những không gian sống và làm việc hoàn hảo thông qua ánh sáng.</p>',
        'image' => $images['story2']['url']
    ]
];

// Company values with icons
$company_values = [
    [
        'icon' => 'fas fa-lightbulb',
        'title' => 'SÁNG TẠO',
        'description' => 'Luôn đổi mới và tìm kiếm giải pháp chiếu sáng độc đáo cho mỗi dự án'
    ],
    [
        'icon' => 'fas fa-shield-alt',
        'title' => 'CHẤT LƯỢNG',
        'description' => 'Cam kết sử dụng thiết bị cao cấp và công nghệ tiên tiến nhất'
    ],
    [
        'icon' => 'fas fa-leaf',
        'title' => 'BỀN VỮNG',
        'description' => 'Ưu tiên giải pháp tiết kiệm năng lượng và thân thiện môi trường'
    ],
    [
        'icon' => 'fas fa-handshake',
        'title' => 'TẬN TÂM',
        'description' => 'Đặt lợi ích khách hàng lên hàng đầu, tư vấn chuyên nghiệp'
    ],
    [
        'icon' => 'fas fa-users',
        'title' => 'ĐOÀN KẾT',
        'description' => 'Xây dựng đội ngũ vững mạnh, cùng nhau phát triển'
    ],
    [
        'icon' => 'fas fa-award',
        'title' => 'UY TÍN',
        'description' => 'Xây dựng niềm tin thông qua chất lượng và dịch vụ hoàn hảo'
    ]
];

// Sample team members
$team_members = [
    [
        'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&h=400&fit=crop',
        'name' => 'Nguyễn Văn An',
        'position' => 'Giám Đốc Điều Hành',
        'bio' => 'Với hơn 15 năm kinh nghiệm trong ngành chiếu sáng',
        'facebook' => 'https://facebook.com/auralighting',
        'linkedin' => 'https://linkedin.com/company/auralighting'
    ],
    [
        'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=400&fit=crop',
        'name' => 'Trần Thị Mai',
        'position' => 'Giám Đốc Sáng Tạo',
        'bio' => 'Chuyên gia thiết kế ánh sáng với nhiều giải thưởng quốc tế',
        'facebook' => '',
        'linkedin' => 'https://linkedin.com/in/example'
    ],
    [
        'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop',
        'name' => 'Phạm Đức Huy',
        'position' => 'Giám Đốc Kỹ Thuật',
        'bio' => 'Kỹ sư điện với chuyên môn cao về hệ thống chiếu sáng thông minh',
        'facebook' => '',
        'linkedin' => ''
    ],
    [
        'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=400&fit=crop',
        'name' => 'Lê Thị Hương',
        'position' => 'Giám Đốc Kinh Doanh',
        'bio' => 'Chuyên gia tư vấn giải pháp chiếu sáng cho doanh nghiệp',
        'facebook' => '',
        'linkedin' => ''
    ]
];

// Achievements
$achievements = [
    [
        'number' => '500',
        'suffix' => '+',
        'title' => 'DỰ ÁN HOÀN THÀNH',
        'description' => 'Trên khắp Việt Nam'
    ],
    [
        'number' => '50',
        'suffix' => '+',
        'title' => 'CHUYÊN GIA',
        'description' => 'Đội ngũ kỹ sư tài năng'
    ],
    [
        'number' => '8',
        'suffix' => '',
        'title' => 'NĂM KINH NGHIỆM',
        'description' => 'Trong ngành chiếu sáng'
    ],
    [
        'number' => '95',
        'suffix' => '%',
        'title' => 'HÀI LÒNG',
        'description' => 'Khách hàng quay lại'
    ]
];

// Partner logos
$partners = [
    ['name' => 'Philips', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/52/Philips_logo_new.svg'],
    ['name' => 'Osram', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/f3/Logo_OSRAM.svg'],
    ['name' => 'Schneider', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/9/96/Schneider_Electric_2007.svg'],
    ['name' => 'ABB', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/0/00/ABB_logo.svg']
];

// Save all data to database
$sections_to_save = [
    'aura_about_story_sections' => $story_sections,
    'aura_about_company_values' => $company_values,
    'aura_about_team_members' => $team_members,
    'aura_about_achievements' => $achievements,
    'aura_about_partners' => $partners
];

foreach ($sections_to_save as $option_name => $data) {
    $serialized_data = $mysqli->real_escape_string(serialize($data));
    
    $check_option = "SELECT option_id FROM wp_options WHERE option_name = '$option_name'";
    $result = $mysqli->query($check_option);
    
    if ($result && $result->num_rows > 0) {
        $update_query = "UPDATE wp_options SET option_value = '$serialized_data' WHERE option_name = '$option_name'";
        $mysqli->query($update_query);
        echo "Updated $option_name\n";
    } else {
        $insert_query = "INSERT INTO wp_options (option_name, option_value, autoload) VALUES ('$option_name', '$serialized_data', 'yes')";
        $mysqli->query($insert_query);
        echo "Created $option_name\n";
    }
}

echo "\nAll images and content have been added successfully!\n";
echo "Visit http://localhost:8000/chung-toi/ to see the updated About Us page.\n";

$mysqli->close();
?>