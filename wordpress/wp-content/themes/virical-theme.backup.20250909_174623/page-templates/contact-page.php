<?php
/**
 * Template Name: Contact Page
 * Description: Template for contact page with form and company information
 *
 * @package Aura_Lighting
 */

get_header();
?>

<main id="primary" class="site-main contact-page">
    <div class="page-header-section">
        <div class="ast-container">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </div>
    </div>

    <div class="contact-content-section">
        <div class="ast-container">
            <div class="contact-grid">
                <div class="contact-info">
                    <h2><?php esc_html_e( 'Thông Tin Liên Hệ', 'aura-lighting' ); ?></h2>
                    
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="info-content">
                            <h3><?php esc_html_e( 'Địa Chỉ', 'aura-lighting' ); ?></h3>
                            <p><?php echo nl2br(virical_get_company_info('address')); ?></p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div class="info-content">
                            <h3><?php esc_html_e( 'Điện Thoại', 'aura-lighting' ); ?></h3>
                            <p>TEL: <?php echo virical_get_company_info('phone'); ?><br>
                            Hotline: <?php echo virical_get_company_info('mobile'); ?></p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div class="info-content">
                            <h3><?php esc_html_e( 'Email', 'aura-lighting' ); ?></h3>
                            <p><a href="mailto:<?php echo virical_get_company_info('email'); ?>"><?php echo virical_get_company_info('email'); ?></a></p>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <h3><?php esc_html_e( 'Kết Nối Với Chúng Tôi', 'aura-lighting' ); ?></h3>
                        <div class="social-icons">
                            <a href="https://www.facebook.com/Aura-Lighting-104015011947121" target="_blank" rel="noopener">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" target="_blank" rel="noopener">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" target="_blank" rel="noopener">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h2><?php esc_html_e( 'Gửi Tin Nhắn', 'aura-lighting' ); ?></h2>
                    
                    <?php
                    // Check if Contact Form 7 or WPForms is active
                    if ( shortcode_exists( 'contact-form-7' ) ) {
                        // If you have a specific form ID, replace 123 with your form ID
                        echo do_shortcode( '[contact-form-7 id="123" title="Contact form"]' );
                    } elseif ( shortcode_exists( 'wpforms' ) ) {
                        // If you have a specific form ID, replace 123 with your form ID
                        echo do_shortcode( '[wpforms id="123"]' );
                    } else {
                        // Fallback HTML form
                        ?>
                        <form class="default-contact-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
                            <input type="hidden" name="action" value="aura_contact_form">
                            <?php wp_nonce_field( 'aura_contact_form_nonce', 'aura_contact_nonce' ); ?>
                            
                            <div class="form-group">
                                <label for="contact-name"><?php esc_html_e( 'Họ và Tên *', 'aura-lighting' ); ?></label>
                                <input type="text" id="contact-name" name="contact_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-email"><?php esc_html_e( 'Email *', 'aura-lighting' ); ?></label>
                                <input type="email" id="contact-email" name="contact_email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-phone"><?php esc_html_e( 'Số Điện Thoại', 'aura-lighting' ); ?></label>
                                <input type="tel" id="contact-phone" name="contact_phone">
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-subject"><?php esc_html_e( 'Tiêu Đề', 'aura-lighting' ); ?></label>
                                <input type="text" id="contact-subject" name="contact_subject">
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-message"><?php esc_html_e( 'Nội Dung *', 'aura-lighting' ); ?></label>
                                <textarea id="contact-message" name="contact_message" rows="5" required></textarea>
                            </div>
                            
                            <button type="submit" class="submit-button">
                                <?php esc_html_e( 'Gửi Tin Nhắn', 'aura-lighting' ); ?>
                            </button>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="map-section">
        <div class="google-map">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.2924240922394!2d105.84761731476292!3d20.98087698602456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ad5a5f8c8c6f%3A0x5f8c8c6f0c0c0c0c!2sThe%20Manor%20Central%20Park!5e0!3m2!1sen!2s!4v1635745623456!5m2!1sen!2s" 
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>

</main><!-- #primary -->

<style>
.contact-page {
    padding-bottom: 0;
}

.page-header-section {
    text-align: center;
    padding: 40px 0;
    background-color: #f5f5f5;
    margin-bottom: 60px;
}

.page-header-section .page-title {
    font-size: 48px;
    margin: 0;
    text-transform: uppercase;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    margin-bottom: 60px;
}

.contact-info h2,
.contact-form h2 {
    font-size: 28px;
    margin-bottom: 30px;
    color: var(--ast-global-color-3);
}

.info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 30px;
}

.info-item i {
    font-size: 24px;
    color: var(--ast-global-color-0);
    margin-right: 20px;
    width: 30px;
}

.info-content h3 {
    font-size: 18px;
    margin-bottom: 10px;
    color: var(--ast-global-color-3);
}

.info-content p {
    margin: 0;
    color: #666;
}

.info-content a {
    color: var(--ast-global-color-0);
}

.social-links {
    margin-top: 40px;
}

.social-links h3 {
    font-size: 18px;
    margin-bottom: 15px;
}

.social-icons {
    display: flex;
    gap: 15px;
}

.social-icons a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: var(--ast-global-color-0);
    color: white;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.social-icons a:hover {
    background-color: var(--ast-global-color-1);
    transform: translateY(-3px);
}

/* Contact Form Styles */
.default-contact-form .form-group {
    margin-bottom: 20px;
}

.default-contact-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--ast-global-color-3);
}

.default-contact-form input,
.default-contact-form textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.default-contact-form input:focus,
.default-contact-form textarea:focus {
    outline: none;
    border-color: var(--ast-global-color-0);
}

.submit-button {
    background-color: var(--ast-global-color-0);
    color: white;
    padding: 15px 40px;
    border: none;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.submit-button:hover {
    background-color: var(--ast-global-color-1);
    transform: translateY(-2px);
}

/* Map Section */
.map-section {
    position: relative;
    width: 100%;
    height: 450px;
}

.google-map {
    width: 100%;
    height: 100%;
}

.google-map iframe {
    width: 100%;
    height: 100%;
}

/* Style for Contact Form 7 */
.wpcf7 input[type="text"],
.wpcf7 input[type="email"],
.wpcf7 input[type="tel"],
.wpcf7 textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

.wpcf7 input[type="submit"] {
    background-color: var(--ast-global-color-0);
    color: white;
    padding: 15px 40px;
    border: none;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.wpcf7 input[type="submit"]:hover {
    background-color: var(--ast-global-color-1);
}

@media (max-width: 768px) {
    .page-header-section .page-title {
        font-size: 36px;
    }
    
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .contact-info {
        order: 2;
    }
    
    .contact-form {
        order: 1;
    }
    
    .map-section {
        height: 300px;
    }
}
</style>

<?php
get_footer();