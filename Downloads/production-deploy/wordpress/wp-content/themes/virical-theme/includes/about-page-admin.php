<?php
/**
 * About Page Admin Settings
 * 
 * @package Virical
 */

// Register settings
function aura_about_page_register_settings() {
    // Hero section
    register_setting('aura_about_page_settings', 'aura_about_hero_image');
    register_setting('aura_about_page_settings', 'aura_about_hero_title');
    register_setting('aura_about_page_settings', 'aura_about_hero_subtitle');
    
    // Introduction section
    register_setting('aura_about_page_settings', 'aura_about_intro_title');
    register_setting('aura_about_page_settings', 'aura_about_intro_content');
    register_setting('aura_about_page_settings', 'aura_about_intro_image');
    
    // Story sections
    register_setting('aura_about_page_settings', 'aura_about_story_sections');
    
    // Company values
    register_setting('aura_about_page_settings', 'aura_about_company_values');
    
    // Team members
    register_setting('aura_about_page_settings', 'aura_about_team_members');
    
    // Achievements
    register_setting('aura_about_page_settings', 'aura_about_achievements');
    
    // Partners
    register_setting('aura_about_page_settings', 'aura_about_partners');
}
add_action('admin_init', 'aura_about_page_register_settings');

// Add admin menu
function aura_about_page_admin_menu() {
    add_menu_page(
        'About Page Settings',
        'About Page',
        'manage_options',
        'aura-about-page',
        'aura_about_page_admin_page',
        'dashicons-info',
        30
    );
}
// add_action('admin_menu', 'aura_about_page_admin_menu');
// 
// Admin page content
function aura_about_page_admin_page() {
    // Handle form submission
    if (isset($_POST['submit'])) {
        // Save hero section
        update_option('aura_about_hero_image', sanitize_text_field($_POST['hero_image']));
        update_option('aura_about_hero_title', sanitize_text_field($_POST['hero_title']));
        update_option('aura_about_hero_subtitle', sanitize_text_field($_POST['hero_subtitle']));
        
        // Save introduction section
        update_option('aura_about_intro_title', sanitize_text_field($_POST['intro_title']));
        update_option('aura_about_intro_content', wp_kses_post($_POST['intro_content']));
        update_option('aura_about_intro_image', esc_url_raw($_POST['intro_image']));
        
        // Save story sections
        $story_sections = array();
        if (isset($_POST['story_sections'])) {
            foreach ($_POST['story_sections'] as $section) {
                $story_sections[] = array(
                    'title' => sanitize_text_field($section['title']),
                    'content' => wp_kses_post($section['content']),
                    'image' => esc_url_raw($section['image'])
                );
            }
        }
        update_option('aura_about_story_sections', $story_sections);
        
        // Save company values
        $company_values = array();
        if (isset($_POST['company_values'])) {
            foreach ($_POST['company_values'] as $value) {
                $company_values[] = array(
                    'icon' => sanitize_text_field($value['icon']),
                    'title' => sanitize_text_field($value['title']),
                    'description' => sanitize_textarea_field($value['description'])
                );
            }
        }
        update_option('aura_about_company_values', $company_values);
        
        // Save team members
        $team_members = array();
        if (isset($_POST['team_members'])) {
            foreach ($_POST['team_members'] as $member) {
                $team_members[] = array(
                    'photo' => esc_url_raw($member['photo']),
                    'name' => sanitize_text_field($member['name']),
                    'position' => sanitize_text_field($member['position']),
                    'bio' => sanitize_textarea_field($member['bio']),
                    'facebook' => esc_url_raw($member['facebook'] ?? ''),
                    'linkedin' => esc_url_raw($member['linkedin'] ?? '')
                );
            }
        }
        update_option('aura_about_team_members', $team_members);
        
        // Save achievements
        $achievements = array();
        if (isset($_POST['achievements'])) {
            foreach ($_POST['achievements'] as $achievement) {
                $achievements[] = array(
                    'number' => intval($achievement['number']),
                    'suffix' => sanitize_text_field($achievement['suffix'] ?? ''),
                    'title' => sanitize_text_field($achievement['title']),
                    'description' => sanitize_text_field($achievement['description'])
                );
            }
        }
        update_option('aura_about_achievements', $achievements);
        
        // Save partners
        $partners = array();
        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $partner) {
                $partners[] = array(
                    'name' => sanitize_text_field($partner['name']),
                    'logo' => esc_url_raw($partner['logo'])
                );
            }
        }
        update_option('aura_about_partners', $partners);
        
        echo '<div class="notice notice-success"><p>Settings saved!</p></div>';
    }
    
    // Get current values
    $hero_image = get_option('aura_about_hero_image', '');
    $hero_title = get_option('aura_about_hero_title', 'CHÚNG TÔI');
    $hero_subtitle = get_option('aura_about_hero_subtitle', 'Virical - Feeling Light');
    $intro_title = get_option('aura_about_intro_title', 'VỀ VIRICAL');
    $intro_content = get_option('aura_about_intro_content', 'Virical là công ty chuyên thiết kế và cung cấp giải pháp chiếu sáng cao cấp cho các công trình kiến trúc, nội thất tại Việt Nam.');
    $intro_image = get_option('aura_about_intro_image', '');
    $story_sections = get_option('aura_about_story_sections', array());
    $company_values = get_option('aura_about_company_values', array());
    $team_members = get_option('aura_about_team_members', array());
    $achievements = get_option('aura_about_achievements', array());
    $partners = get_option('aura_about_partners', array());
    
    // Enqueue media uploader
    wp_enqueue_media();
    ?>
    
    <div class="wrap">
        <h1>About Page Settings</h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('aura_about_page_settings'); ?>
            
            <!-- Hero Section -->
            <h2>Hero Section</h2>
            <table class="form-table">
                <tr>
                    <th><label for="hero_image">Hero Background Image</label></th>
                    <td>
                        <input type="text" id="hero_image" name="hero_image" value="<?php echo esc_url($hero_image); ?>" class="regular-text" />
                        <button type="button" class="button upload-image-button" data-target="#hero_image">Upload Image</button>
                        <p class="description">Upload hero background image (recommended size: 1920x600px)</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="hero_title">Hero Title</label></th>
                    <td><input type="text" id="hero_title" name="hero_title" value="<?php echo esc_attr($hero_title); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="hero_subtitle">Hero Subtitle</label></th>
                    <td><input type="text" id="hero_subtitle" name="hero_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" class="regular-text" /></td>
                </tr>
            </table>
            
            <!-- Introduction Section -->
            <h2>Introduction Section</h2>
            <table class="form-table">
                <tr>
                    <th><label for="intro_title">Introduction Title</label></th>
                    <td><input type="text" id="intro_title" name="intro_title" value="<?php echo esc_attr($intro_title); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="intro_content">Introduction Content</label></th>
                    <td>
                        <?php 
                        wp_editor($intro_content, 'intro_content', array(
                            'textarea_name' => 'intro_content',
                            'textarea_rows' => 5,
                            'media_buttons' => true
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="intro_image">Introduction Image</label></th>
                    <td>
                        <input type="text" id="intro_image" name="intro_image" value="<?php echo esc_url($intro_image); ?>" class="regular-text" />
                        <button type="button" class="button upload-image-button" data-target="#intro_image">Upload Image</button>
                        <p class="description">Upload introduction image (recommended size: 600x600px)</p>
                    </td>
                </tr>
            </table>
            
            <!-- Story Sections -->
            <h2>Story Sections</h2>
            <div id="story-sections-container">
                <?php 
                if (empty($story_sections)) {
                    $story_sections = array(array('title' => '', 'content' => '', 'image' => ''));
                }
                foreach ($story_sections as $index => $section): 
                ?>
                <div class="story-section-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
                    <h3>Section <?php echo $index + 1; ?></h3>
                    <table class="form-table">
                        <tr>
                            <th><label>Title</label></th>
                            <td><input type="text" name="story_sections[<?php echo $index; ?>][title]" value="<?php echo esc_attr($section['title']); ?>" class="regular-text" /></td>
                        </tr>
                        <tr>
                            <th><label>Content</label></th>
                            <td>
                                <?php 
                                wp_editor($section['content'], 'story_content_' . $index, array(
                                    'textarea_name' => 'story_sections[' . $index . '][content]',
                                    'textarea_rows' => 5,
                                    'media_buttons' => true
                                ));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Image</label></th>
                            <td>
                                <input type="text" name="story_sections[<?php echo $index; ?>][image]" value="<?php echo esc_url($section['image']); ?>" class="regular-text story-image-url" />
                                <button type="button" class="button upload-image-button">Upload Image</button>
                            </td>
                        </tr>
                    </table>
                    <button type="button" class="button remove-section">Remove Section</button>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button button-primary" id="add-story-section">Add Story Section</button>
            
            <!-- Company Values -->
            <h2>Company Values</h2>
            <div id="values-container">
                <?php 
                if (empty($company_values)) {
                    $company_values = array(array('icon' => 'fas fa-lightbulb', 'title' => '', 'description' => ''));
                }
                foreach ($company_values as $index => $value): 
                ?>
                <div class="value-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
                    <table class="form-table">
                        <tr>
                            <th><label>Icon Class</label></th>
                            <td>
                                <input type="text" name="company_values[<?php echo $index; ?>][icon]" value="<?php echo esc_attr($value['icon']); ?>" class="regular-text" />
                                <p class="description">FontAwesome icon class (e.g., fas fa-lightbulb)</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Title</label></th>
                            <td><input type="text" name="company_values[<?php echo $index; ?>][title]" value="<?php echo esc_attr($value['title']); ?>" class="regular-text" /></td>
                        </tr>
                        <tr>
                            <th><label>Description</label></th>
                            <td><textarea name="company_values[<?php echo $index; ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($value['description']); ?></textarea></td>
                        </tr>
                    </table>
                    <button type="button" class="button remove-value">Remove Value</button>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button button-primary" id="add-value">Add Value</button>
            
            <!-- Team Members -->
            <h2>Team Members</h2>
            <div id="team-container">
                <?php 
                if (empty($team_members)) {
                    $team_members = array(array('photo' => '', 'name' => '', 'position' => '', 'bio' => ''));
                }
                foreach ($team_members as $index => $member): 
                ?>
                <div class="team-member-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
                    <table class="form-table">
                        <tr>
                            <th><label>Photo</label></th>
                            <td>
                                <input type="text" name="team_members[<?php echo $index; ?>][photo]" value="<?php echo esc_url($member['photo']); ?>" class="regular-text member-photo-url" />
                                <button type="button" class="button upload-image-button">Upload Photo</button>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Name</label></th>
                            <td><input type="text" name="team_members[<?php echo $index; ?>][name]" value="<?php echo esc_attr($member['name']); ?>" class="regular-text" /></td>
                        </tr>
                        <tr>
                            <th><label>Position</label></th>
                            <td><input type="text" name="team_members[<?php echo $index; ?>][position]" value="<?php echo esc_attr($member['position']); ?>" class="regular-text" /></td>
                        </tr>
                        <tr>
                            <th><label>Bio</label></th>
                            <td><textarea name="team_members[<?php echo $index; ?>][bio]" rows="3" class="large-text"><?php echo esc_textarea($member['bio']); ?></textarea></td>
                        </tr>
                        <tr>
                            <th><label>Facebook URL</label></th>
                            <td><input type="url" name="team_members[<?php echo $index; ?>][facebook]" value="<?php echo esc_url($member['facebook'] ?? ''); ?>" class="regular-text" placeholder="https://facebook.com/username" /></td>
                        </tr>
                        <tr>
                            <th><label>LinkedIn URL</label></th>
                            <td><input type="url" name="team_members[<?php echo $index; ?>][linkedin]" value="<?php echo esc_url($member['linkedin'] ?? ''); ?>" class="regular-text" placeholder="https://linkedin.com/in/username" /></td>
                        </tr>
                    </table>
                    <button type="button" class="button remove-member">Remove Member</button>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button button-primary" id="add-member">Add Team Member</button>
            
            <!-- Achievements -->
            <h2>Achievements</h2>
            <div id="achievements-container">
                <?php 
                if (empty($achievements)) {
                    $achievements = array(array('number' => '', 'title' => '', 'description' => ''));
                }
                foreach ($achievements as $index => $achievement): 
                ?>
                <div class="achievement-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
                    <table class="form-table">
                        <tr>
                            <th><label>Number</label></th>
                            <td><input type="number" name="achievements[<?php echo $index; ?>][number]" value="<?php echo esc_attr($achievement['number']); ?>" class="small-text" /></td>
                        </tr>
                        <tr>
                            <th><label>Suffix</label></th>
                            <td>
                                <input type="text" name="achievements[<?php echo $index; ?>][suffix]" value="<?php echo esc_attr($achievement['suffix'] ?? ''); ?>" class="small-text" />
                                <p class="description">Optional suffix (e.g., +, %, K)</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Title</label></th>
                            <td><input type="text" name="achievements[<?php echo $index; ?>][title]" value="<?php echo esc_attr($achievement['title']); ?>" class="regular-text" /></td>
                        </tr>
                        <tr>
                            <th><label>Description</label></th>
                            <td><input type="text" name="achievements[<?php echo $index; ?>][description]" value="<?php echo esc_attr($achievement['description']); ?>" class="regular-text" /></td>
                        </tr>
                    </table>
                    <button type="button" class="button remove-achievement">Remove Achievement</button>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button button-primary" id="add-achievement">Add Achievement</button>
            
            <!-- Partners -->
            <h2>Partners</h2>
            <div id="partners-container">
                <?php 
                if (empty($partners)) {
                    $partners = array(array('name' => '', 'logo' => ''));
                }
                foreach ($partners as $index => $partner): 
                ?>
                <div class="partner-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
                    <table class="form-table">
                        <tr>
                            <th><label>Partner Name</label></th>
                            <td><input type="text" name="partners[<?php echo $index; ?>][name]" value="<?php echo esc_attr($partner['name']); ?>" class="regular-text" /></td>
                        </tr>
                        <tr>
                            <th><label>Logo</label></th>
                            <td>
                                <input type="text" name="partners[<?php echo $index; ?>][logo]" value="<?php echo esc_url($partner['logo']); ?>" class="regular-text partner-logo-url" />
                                <button type="button" class="button upload-image-button">Upload Logo</button>
                                <p class="description">Partner logo (recommended size: 200x100px)</p>
                            </td>
                        </tr>
                    </table>
                    <button type="button" class="button remove-partner">Remove Partner</button>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button button-primary" id="add-partner">Add Partner</button>
            
            <p class="submit">
                <input type="submit" name="submit" class="button button-primary" value="Save Settings" />
            </p>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Media uploader
        $('.upload-image-button').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            var target = button.data('target') || button.prev('input');
            
            var frame = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                if (typeof target === 'string') {
                    $(target).val(attachment.url);
                } else {
                    target.val(attachment.url);
                }
            });
            
            frame.open();
        });
        
        // Dynamic sections
        var storyIndex = <?php echo count($story_sections); ?>;
        $('#add-story-section').on('click', function() {
            var html = '<div class="story-section-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">' +
                '<h3>Section ' + (storyIndex + 1) + '</h3>' +
                '<table class="form-table">' +
                '<tr><th><label>Title</label></th><td><input type="text" name="story_sections[' + storyIndex + '][title]" class="regular-text" /></td></tr>' +
                '<tr><th><label>Content</label></th><td><textarea name="story_sections[' + storyIndex + '][content]" rows="5" class="large-text"></textarea></td></tr>' +
                '<tr><th><label>Image</label></th><td><input type="text" name="story_sections[' + storyIndex + '][image]" class="regular-text story-image-url" /><button type="button" class="button upload-image-button">Upload Image</button></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-section">Remove Section</button>' +
                '</div>';
            $('#story-sections-container').append(html);
            storyIndex++;
        });
        
        // Remove buttons
        $(document).on('click', '.remove-section', function() {
            $(this).closest('.story-section-item').remove();
        });
        
        $(document).on('click', '.remove-value', function() {
            $(this).closest('.value-item').remove();
        });
        
        $(document).on('click', '.remove-member', function() {
            $(this).closest('.team-member-item').remove();
        });
        
        $(document).on('click', '.remove-achievement', function() {
            $(this).closest('.achievement-item').remove();
        });
        
        // Add more dynamic sections (similar pattern for values, members, achievements)
        var valueIndex = <?php echo count($company_values); ?>;
        $('#add-value').on('click', function() {
            var html = '<div class="value-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">' +
                '<table class="form-table">' +
                '<tr><th><label>Icon Class</label></th><td><input type="text" name="company_values[' + valueIndex + '][icon]" value="fas fa-lightbulb" class="regular-text" /><p class="description">FontAwesome icon class</p></td></tr>' +
                '<tr><th><label>Title</label></th><td><input type="text" name="company_values[' + valueIndex + '][title]" class="regular-text" /></td></tr>' +
                '<tr><th><label>Description</label></th><td><textarea name="company_values[' + valueIndex + '][description]" rows="3" class="large-text"></textarea></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-value">Remove Value</button>' +
                '</div>';
            $('#values-container').append(html);
            valueIndex++;
        });
        
        var memberIndex = <?php echo count($team_members); ?>;
        $('#add-member').on('click', function() {
            var html = '<div class="team-member-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">' +
                '<table class="form-table">' +
                '<tr><th><label>Photo</label></th><td><input type="text" name="team_members[' + memberIndex + '][photo]" class="regular-text member-photo-url" /><button type="button" class="button upload-image-button">Upload Photo</button></td></tr>' +
                '<tr><th><label>Name</label></th><td><input type="text" name="team_members[' + memberIndex + '][name]" class="regular-text" /></td></tr>' +
                '<tr><th><label>Position</label></th><td><input type="text" name="team_members[' + memberIndex + '][position]" class="regular-text" /></td></tr>' +
                '<tr><th><label>Bio</label></th><td><textarea name="team_members[' + memberIndex + '][bio]" rows="3" class="large-text"></textarea></td></tr>' +
                '<tr><th><label>Facebook URL</label></th><td><input type="url" name="team_members[' + memberIndex + '][facebook]" class="regular-text" placeholder="https://facebook.com/username" /></td></tr>' +
                '<tr><th><label>LinkedIn URL</label></th><td><input type="url" name="team_members[' + memberIndex + '][linkedin]" class="regular-text" placeholder="https://linkedin.com/in/username" /></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-member">Remove Member</button>' +
                '</div>';
            $('#team-container').append(html);
            memberIndex++;
        });
        
        var achievementIndex = <?php echo count($achievements); ?>;
        $('#add-achievement').on('click', function() {
            var html = '<div class="achievement-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">' +
                '<table class="form-table">' +
                '<tr><th><label>Number</label></th><td><input type="number" name="achievements[' + achievementIndex + '][number]" class="small-text" /></td></tr>' +
                '<tr><th><label>Suffix</label></th><td><input type="text" name="achievements[' + achievementIndex + '][suffix]" class="small-text" /><p class="description">Optional suffix (e.g., +, %, K)</p></td></tr>' +
                '<tr><th><label>Title</label></th><td><input type="text" name="achievements[' + achievementIndex + '][title]" class="regular-text" /></td></tr>' +
                '<tr><th><label>Description</label></th><td><input type="text" name="achievements[' + achievementIndex + '][description]" class="regular-text" /></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-achievement">Remove Achievement</button>' +
                '</div>';
            $('#achievements-container').append(html);
            achievementIndex++;
        });
        
        // Partners
        var partnerIndex = <?php echo count($partners); ?>;
        $('#add-partner').on('click', function() {
            var html = '<div class="partner-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">' +
                '<table class="form-table">' +
                '<tr><th><label>Partner Name</label></th><td><input type="text" name="partners[' + partnerIndex + '][name]" class="regular-text" /></td></tr>' +
                '<tr><th><label>Logo</label></th><td><input type="text" name="partners[' + partnerIndex + '][logo]" class="regular-text partner-logo-url" /><button type="button" class="button upload-image-button">Upload Logo</button><p class="description">Partner logo (recommended size: 200x100px)</p></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-partner">Remove Partner</button>' +
                '</div>';
            $('#partners-container').append(html);
            partnerIndex++;
        });
        
        // Remove partner handler
        $(document).on('click', '.remove-partner', function() {
            if (confirm('Are you sure you want to remove this partner?')) {
                $(this).closest('.partner-item').remove();
            }
        });
    });
    </script>
    <?php
}