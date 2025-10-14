<?php
/**
 * Template Name: Giới Thiệu
 * 
 * @package Virical
 */

get_header();

// Ensure we have the theme constants
if (!defined('AURA_THEME_URI')) {
    define('AURA_THEME_URI', get_template_directory_uri());
}

// Get custom fields from WordPress options
$hero_image = get_option('aura_about_hero_image', AURA_THEME_URI . '/assets/images/about-default.jpg');
$hero_title = get_option('aura_about_hero_title', 'CHÚNG TÔI');
$hero_subtitle = get_option('aura_about_hero_subtitle', 'Virical - Feeling Light');

// Company intro
$intro_title = get_option('aura_about_intro_title', 'VỀ VIRICAL');
$intro_content = get_option('aura_about_intro_content', 'Virical là công ty chuyên thiết kế và cung cấp giải pháp chiếu sáng cao cấp cho các công trình kiến trúc, nội thất tại Việt Nam.');
$intro_image = get_option('aura_about_intro_image', AURA_THEME_URI . '/assets/images/about-intro.jpg');

// Company story sections
$story_sections = get_option('aura_about_story_sections', array());

// Team members
$team_members = get_option('aura_about_team_members', array());

// Company values
$company_values = get_option('aura_about_company_values', array());

// Company achievements
$achievements = get_option('aura_about_achievements', array());

// Partners
$partners = get_option('aura_about_partners', array());
?>

<main id="main" class="site-main about-page">
    <!-- Hero Section -->
    <section class="about-hero-section">
        <div class="hero-background">
            <img src="<?php echo esc_url($hero_image); ?>" alt="<?php echo esc_attr($hero_title); ?>" class="hero-bg-image">
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content">
            <div class="container">
                <h1 class="hero-title animate-fade-up"><?php echo esc_html($hero_title); ?></h1>
                <div class="hero-subtitle animate-fade-up-delay"><?php echo esc_html($hero_subtitle); ?></div>
            </div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="intro-section">
        <div class="container">
            <div class="intro-wrapper">
                <div class="intro-image-col">
                    <div class="intro-image-wrapper animate-fade-right">
                        <img src="<?php echo esc_url($intro_image); ?>" alt="<?php echo esc_attr($intro_title); ?>" class="intro-image">
                        <div class="image-decoration"></div>
                    </div>
                </div>
                <div class="intro-content-col">
                    <div class="intro-content animate-fade-left">
                        <h2 class="intro-title"><?php echo esc_html($intro_title); ?></h2>
                        <div class="intro-text">
                            <?php echo wp_kses_post($intro_content); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Sections -->
    <?php if (!empty($story_sections)) : ?>
    <section class="story-sections">
        <?php foreach ($story_sections as $index => $section) : ?>
        <div class="story-section <?php echo $index % 2 == 0 ? 'section-normal' : 'section-reverse'; ?>">
            <div class="container">
                <div class="story-wrapper">
                    <div class="story-image-col">
                        <div class="story-image-wrapper animate-scale">
                            <img src="<?php echo esc_url($section['image'] ?? ''); ?>" alt="<?php echo esc_attr($section['title'] ?? ''); ?>" class="story-image">
                        </div>
                    </div>
                    <div class="story-content-col">
                        <div class="story-content animate-fade">
                            <h2 class="story-title"><?php echo esc_html($section['title'] ?? ''); ?></h2>
                            <div class="story-text">
                                <?php echo wp_kses_post($section['content'] ?? ''); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <!-- Company Values -->
    <?php if (!empty($company_values)) : ?>
    <section class="values-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title animate-fade-up">GIÁ TRỊ CỐT LÕI</h2>
                <div class="section-line"></div>
            </div>
            <div class="values-grid">
                <?php foreach ($company_values as $index => $value) : ?>
                <div class="value-item animate-fade-up" style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="value-icon">
                        <i class="<?php echo esc_attr($value['icon']); ?>"></i>
                    </div>
                    <h3 class="value-title"><?php echo esc_html($value['title']); ?></h3>
                    <p class="value-description"><?php echo esc_html($value['description']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Team Section -->
    <?php if (!empty($team_members)) : ?>
    <section class="team-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title animate-fade-up">ĐỘI NGŨ CỦA CHÚNG TÔI</h2>
                <div class="section-line"></div>
            </div>
            <div class="team-grid">
                <?php foreach ($team_members as $index => $member) : ?>
                <div class="team-member animate-fade-up" style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="member-image-wrapper">
                        <img src="<?php echo esc_url($member['photo']); ?>" alt="<?php echo esc_attr($member['name']); ?>" class="member-image">
                        <div class="member-overlay">
                            <div class="member-social">
                                <?php if (!empty($member['facebook'])) : ?>
                                <a href="<?php echo esc_url($member['facebook']); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($member['linkedin'])) : ?>
                                <a href="<?php echo esc_url($member['linkedin']); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4 class="member-name"><?php echo esc_html($member['name']); ?></h4>
                        <p class="member-position"><?php echo esc_html($member['position']); ?></p>
                        <p class="member-bio"><?php echo esc_html($member['bio']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Achievements -->
    <?php /* Achievements Section - Hidden
    if (!empty($achievements)) : ?>
    <section class="achievements-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title animate-fade-up">THÀNH TỰU</h2>
                <div class="section-line"></div>
            </div>
            <div class="achievements-grid">
                <?php foreach ($achievements as $achievement) : ?>
                <div class="achievement-item animate-fade-up">
                    <div class="achievement-number" data-count="<?php echo esc_attr($achievement['number']); ?>">
                        <span class="number">0</span>
                        <?php if (!empty($achievement['suffix'])) : ?>
                        <span class="suffix"><?php echo esc_html($achievement['suffix']); ?></span>
                        <?php endif; ?>
                    </div>
                    <h4 class="achievement-title"><?php echo esc_html($achievement['title']); ?></h4>
                    <p class="achievement-description"><?php echo esc_html($achievement['description']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif;
    */ ?>

    <!-- Partners Section - Hidden (using placeholder images)
    <?php if (!empty($partners)) : ?>
    <section class="partners-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title animate-fade-up">ĐỐI TÁC</h2>
                <div class="section-line"></div>
            </div>
            <div class="partners-slider">
                <div class="partners-wrapper">
                    <?php foreach ($partners as $partner) : ?>
                    <div class="partner-item">
                        <img src="<?php echo esc_url($partner['logo']); ?>" alt="<?php echo esc_attr($partner['name']); ?>" class="partner-logo">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    -->
</main>

<style>
/* About Us Page - Virical Design */
/* Import Montserrat font */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

:root {
    --virical-primary: #d94948;
    --virical-secondary: #e93333;
    --virical-dark: #011627;
    --virical-dark-75: rgba(1, 22, 39, 0.75);
    --virical-white: #ffffff;
    --virical-light-gray: #f9f8f8;
    --virical-gray: #f2f5f7;
    --virical-text-gray: #424242;
    --virical-black: #000000;
    --virical-gold: #d4af37;
}

body.page-template-page-gioi-thieu {
    background-color: var(--virical-black);
    color: var(--virical-white);
    margin: 0;
    padding: 0;
}

.about-page {
    overflow-x: hidden;
}

/* Hero Section */
.about-hero-section {
    position: relative;
    height: 100vh;
    min-height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: -100px;
    padding-top: 100px;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
}

.hero-bg-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(180deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.8) 100%);
}

.hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
    width: 100%;
}

.hero-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 70px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 5px;
    margin-bottom: 20px;
    color: var(--virical-white);
}

.hero-subtitle {
    font-family: 'Montserrat', sans-serif;
    font-size: 24px;
    font-weight: 300;
    letter-spacing: 2px;
    opacity: 0.9;
    color: var(--virical-white);
}

/* Introduction Section */
.intro-section {
    padding: 120px 0;
    background-color: var(--virical-black);
}

.intro-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.intro-image-wrapper {
    position: relative;
}

.intro-image {
    width: 100%;
    height: auto;
    border-radius: 0;
    filter: brightness(0.9);
}

.image-decoration {
    position: absolute;
    top: -30px;
    left: -30px;
    width: 100%;
    height: 100%;
    border: 2px solid var(--virical-gold);
    z-index: -1;
}

.intro-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 34px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 30px;
    color: var(--virical-white);
}

.intro-text {
    font-size: 16px;
    line-height: 1.8;
    color: rgba(255, 255, 255, 0.8);
}

/* Story Sections */
.story-sections {
    background-color: var(--virical-black);
}

.story-section {
    padding: 100px 0;
}

.story-section:nth-child(even) {
    background-color: rgba(255, 255, 255, 0.02);
}

.story-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.section-reverse .story-wrapper {
    direction: rtl;
}

.section-reverse .story-content {
    direction: ltr;
}

.story-image-wrapper {
    position: relative;
    overflow: hidden;
}

.story-image {
    width: 100%;
    height: auto;
    transition: transform 0.6s ease;
}

.story-image-wrapper:hover .story-image {
    transform: scale(1.05);
}

.story-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 34px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 30px;
    color: var(--virical-white);
}

.story-text {
    font-size: 16px;
    line-height: 1.8;
    color: rgba(255, 255, 255, 0.8);
}

/* Values Section */
.values-section {
    padding: 120px 0;
    background-color: rgba(255, 255, 255, 0.02);
}

.section-header {
    text-align: center;
    margin-bottom: 80px;
}

.section-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 42px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 20px;
    color: var(--virical-white);
}

.section-line {
    width: 100px;
    height: 2px;
    background: var(--virical-gold);
    margin: 0 auto;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
}

.value-item {
    text-align: center;
    padding: 50px 30px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.value-item:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.05);
    border-color: var(--virical-gold);
}

.value-icon {
    font-size: 60px;
    color: var(--virical-gold);
    margin-bottom: 30px;
}

.value-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 22px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
    color: var(--virical-white);
}

.value-description {
    font-size: 15px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.7);
}

/* Team Section */
.team-section {
    padding: 120px 0;
    background-color: var(--virical-black);
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
}

.team-member {
    position: relative;
    overflow: hidden;
}

.member-image-wrapper {
    position: relative;
    overflow: hidden;
    margin-bottom: 20px;
}

.member-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    filter: grayscale(100%);
    transition: all 0.4s ease;
}

.team-member:hover .member-image {
    filter: grayscale(0%);
}

.member-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(217, 73, 72, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.team-member:hover .member-overlay {
    opacity: 1;
}

.member-social {
    display: flex;
    gap: 20px;
}

.member-social a {
    width: 40px;
    height: 40px;
    border: 2px solid var(--virical-white);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--virical-white);
    transition: all 0.3s ease;
}

.member-social a:hover {
    background: var(--virical-white);
    color: var(--virical-primary);
}

.member-info {
    text-align: center;
}

.member-name {
    font-family: 'Montserrat', sans-serif;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--virical-white);
}

.member-position {
    font-size: 14px;
    color: var(--virical-gold);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

.member-bio {
    font-size: 14px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.7);
}

/* Achievements Section */
.achievements-section {
    padding: 120px 0;
    background: linear-gradient(135deg, rgba(217, 73, 72, 0.1) 0%, rgba(233, 51, 51, 0.1) 100%);
    position: relative;
}

.achievements-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(to right, transparent, var(--virical-gold), transparent);
}

.achievements-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
}

.achievement-item {
    text-align: center;
}

.achievement-number {
    font-family: 'Montserrat', sans-serif;
    font-size: 64px;
    font-weight: 300;
    color: var(--virical-gold);
    margin-bottom: 20px;
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 5px;
}

.achievement-number .number {
    font-size: 64px;
}

.achievement-number .suffix {
    font-size: 32px;
    font-weight: 400;
}

.achievement-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
    color: var(--virical-white);
}

.achievement-description {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.7);
}

/* Partners Section */
.partners-section {
    padding: 120px 0;
    background-color: var(--virical-black);
}

.partners-slider {
    overflow: hidden;
}

.partners-wrapper {
    display: flex;
    gap: 60px;
    align-items: center;
    animation: scroll 20s linear infinite;
}

@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.partner-item {
    flex-shrink: 0;
}

.partner-logo {
    height: 80px;
    width: auto;
    filter: brightness(0) invert(1);
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.partner-logo:hover {
    opacity: 1;
}

/* Container */
.container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Animations */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeLeft {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeRight {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fade-up {
    animation: fadeUp 0.8s ease-out;
}

.animate-fade-up-delay {
    animation: fadeUp 0.8s ease-out 0.3s both;
}

.animate-fade-left {
    animation: fadeLeft 0.8s ease-out;
}

.animate-fade-right {
    animation: fadeRight 0.8s ease-out;
}

.animate-scale {
    animation: scaleIn 0.8s ease-out;
}

.animate-fade {
    animation: fadeUp 0.8s ease-out;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .hero-title {
        font-size: 50px;
    }
    
    .values-grid,
    .achievements-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .team-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 36px;
        letter-spacing: 2px;
    }
    
    .hero-subtitle {
        font-size: 18px;
    }
    
    .intro-wrapper,
    .story-wrapper {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .image-decoration {
        display: none;
    }
    
    .section-reverse .story-wrapper {
        direction: ltr;
    }
    
    .values-grid,
    .team-grid,
    .achievements-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .section-title {
        font-size: 32px;
    }
    
    .achievement-number .number {
        font-size: 48px;
    }
    
    .achievement-number .suffix {
        font-size: 24px;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 28px;
    }
    
    .hero-subtitle {
        font-size: 16px;
    }
    
    .intro-title,
    .story-title {
        font-size: 24px;
    }
    
    .section-title {
        font-size: 28px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate achievement numbers on scroll
    const achievementNumbers = document.querySelectorAll('.achievement-number');
    
    const animateNumbers = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const numberElement = target.querySelector('.number');
                const count = parseInt(target.getAttribute('data-count'));
                let current = 0;
                const duration = 2000; // 2 seconds
                const increment = count / (duration / 16); // 60 FPS
                
                const updateNumber = () => {
                    current += increment;
                    if (current < count) {
                        numberElement.textContent = Math.floor(current);
                        requestAnimationFrame(updateNumber);
                    } else {
                        numberElement.textContent = count;
                    }
                };
                
                updateNumber();
                observer.unobserve(target);
            }
        });
    };
    
    const observer = new IntersectionObserver(animateNumbers, {
        threshold: 0.5
    });
    
    achievementNumbers.forEach(number => {
        observer.observe(number);
    });
    
    // Animate elements on scroll
    const animateElements = document.querySelectorAll('.animate-fade-up, .animate-fade-left, .animate-fade-right, .animate-scale');
    
    const animateOnScroll = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                animateOnScroll.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });
    
    animateElements.forEach(element => {
        element.style.opacity = '0';
        animateOnScroll.observe(element);
    });
    
    // Partners slider duplicate for infinite scroll
    const partnersWrapper = document.querySelector('.partners-wrapper');
    if (partnersWrapper) {
        const partners = partnersWrapper.innerHTML;
        partnersWrapper.innerHTML += partners;
    }
});
</script>

<?php get_footer(); ?>