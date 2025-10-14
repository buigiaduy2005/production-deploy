<?php
/**
 * The template for displaying the footer
 *
 * @package Aura_Lighting
 */
?>

        </div><!-- .ast-container -->
    </div><!-- #content -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="footer-main">
            <div class="ast-container">
                <div class="footer-content">
                    <div class="footer-widget footer-about">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/virical-logo.svg' ); ?>" 
                             alt="<?php bloginfo( 'name' ); ?>" 
                             class="footer-logo">
                        <p>VIRICAL - Feeling Light</p>
                        <p>Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.</p>
                        <div class="social-links">
                            <?php if ($facebook = virical_get_company_info('facebook')): ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if ($youtube = virical_get_company_info('youtube')): ?>
                                <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                            <?php if ($zalo = virical_get_company_info('zalo')): ?>
                                <a href="<?php echo esc_url($zalo); ?>" target="_blank" rel="noopener">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                        <path d="M8 11h8v2H8z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="footer-widget">
                        <h3>Sản Phẩm</h3>
                        <ul>
                            <li><a href="<?php echo home_url('/indoor/'); ?>">Đèn Indoor</a></li>
                            <li><a href="<?php echo home_url('/san-pham/#outdoor'); ?>">Đèn Outdoor</a></li>
                            <li><a href="<?php echo home_url('/san-pham/'); ?>">Đèn Downlight</a></li>
                            <li><a href="<?php echo home_url('/san-pham/'); ?>">Đèn Spotlight</a></li>
                            <li><a href="<?php echo home_url('/san-pham/'); ?>">Đèn Ray</a></li>
                        </ul>
                    </div>

                    <div class="footer-widget">
                        <h3>Thông Tin</h3>
                        <ul>
                            <li><a href="<?php echo home_url('/about-us/'); ?>">Về Chúng Tôi</a></li>
                            <li><a href="<?php echo home_url('/cong-trinh/'); ?>">Công Trình</a></li>
                            <li><a href="#">Catalogue</a></li>
                            <li><a href="#">Chính Sách Bảo Hành</a></li>
                            <li><a href="<?php echo home_url('/lien-he/'); ?>">Liên Hệ</a></li>
                        </ul>
                    </div>

                    <div class="footer-widget footer-contact">
                        <h3>Liên Hệ</h3>
                        <ul class="contact-info">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo nl2br(virical_get_company_info('address')); ?></span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span><?php echo virical_get_company_info('phone'); ?> | <?php echo virical_get_company_info('mobile'); ?></span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span><?php echo virical_get_company_info('email'); ?></span>
                            </li>
                        </ul>
                        <div class="newsletter">
                            <h4>Đăng Ký Nhận Tin</h4>
                            <form class="newsletter-form">
                                <input type="email" placeholder="Email của bạn" required>
                                <button type="submit">Đăng Ký</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="ast-container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> Virical. All Rights Reserved. | Designed by Virical Team</p>
                    </div>
                    <div class="footer-menu">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer',
                                'menu_class'     => 'footer-nav',
                                'container'      => false,
                                'fallback_cb'    => false,
                                'depth'          => 1,
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->

</div><!-- #page -->

<style>
/* Footer Styles */
.site-footer {
    background: #1a1a1a;
    color: #ffffff;
    padding: 0;
    margin-top: 0;
}

.footer-main {
    padding: 80px 0 60px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.footer-content {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 2fr;
    gap: 50px;
}

.footer-logo {
    height: 60px;
    margin-bottom: 20px;
}

.footer-widget h3 {
    color: #ffffff;
    font-size: 1.2rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 30px;
    position: relative;
    padding-bottom: 15px;
}

.footer-widget h3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background: var(--primary-color);
}

.footer-widget ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-widget ul li {
    margin-bottom: 12px;
}

.footer-widget a {
    color: rgba(255,255,255,0.7);
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.footer-widget a:hover {
    color: var(--primary-color);
    padding-left: 5px;
}

.footer-about p {
    color: rgba(255,255,255,0.7);
    margin-bottom: 15px;
    line-height: 1.8;
}

/* Social Links */
.social-links {
    display: flex;
    gap: 15px;
    margin-top: 25px;
}

.social-links a {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    transition: all 0.3s ease;
}

.social-links a:hover {
    background: var(--primary-color);
    transform: translateY(-3px);
}

/* Contact Info */
.contact-info {
    list-style: none;
    padding: 0;
    margin: 0 0 30px 0;
}

.contact-info li {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
    color: rgba(255,255,255,0.7);
}

.contact-info i {
    color: var(--primary-color);
    margin-right: 15px;
    margin-top: 3px;
    font-size: 16px;
}

/* Newsletter */
.newsletter h4 {
    color: #ffffff;
    font-size: 1rem;
    margin-bottom: 15px;
}

.newsletter-form {
    display: flex;
    gap: 10px;
}

.newsletter-form input {
    flex: 1;
    padding: 12px 20px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 50px;
    color: #ffffff;
    font-size: 14px;
    transition: all 0.3s ease;
}

.newsletter-form input::placeholder {
    color: rgba(255,255,255,0.5);
}

.newsletter-form input:focus {
    outline: none;
    background: rgba(255,255,255,0.15);
    border-color: var(--primary-color);
}

.newsletter-form button {
    padding: 12px 30px;
    background: var(--primary-color);
    border: none;
    border-radius: 50px;
    color: #ffffff;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.newsletter-form button:hover {
    background: var(--ast-global-color-1);
    transform: translateY(-2px);
}

/* Footer Bottom */
.footer-bottom {
    background: #0f0f0f;
    padding: 25px 0;
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.copyright p {
    margin: 0;
    color: rgba(255,255,255,0.5);
    font-size: 0.9rem;
}

.footer-nav {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 30px;
}

.footer-nav a {
    color: rgba(255,255,255,0.5);
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.footer-nav a:hover {
    color: var(--primary-color);
}

/* Responsive */
@media (max-width: 991px) {
    .footer-content {
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
    }
    
    .footer-about {
        grid-column: span 2;
    }
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .footer-about {
        grid-column: span 1;
        text-align: center;
    }
    
    .footer-widget h3::after {
        left: 50%;
        transform: translateX(-50%);
    }
    
    .social-links {
        justify-content: center;
    }
    
    .footer-bottom-content {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    
    .newsletter-form {
        flex-direction: column;
    }
    
    .newsletter-form button {
        width: 100%;
    }
}
</style>

<?php wp_footer(); ?>

</body>
</html>