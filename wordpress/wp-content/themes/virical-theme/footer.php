<?php
/**
 * The template for displaying the footer
 *
 * @package Virical
 */
?>

        </div><!-- .ast-container -->
    </div><!-- #content -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="footer-main">
            <div class="ast-container">
                <div class="footer-content">
                    <!-- Company Info -->
                    <div class="footer-widget footer-about">
                        <div class="footer-logo-wrapper" style="width: 200px !important; height: 60px !important; overflow: hidden !important; margin-bottom: 19px; position: relative; display: block;">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/virical-logo.svg' ); ?>" style="position: absolute !important; top: -589px !important; left: -282px !important; width: 497px !important; height: auto !important; max-width: none !important;"
                                 alt="<?php bloginfo( 'name' ); ?>">
                        </div>
                        <p><?php echo esc_html(virical_get_company_info('description', 'Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.')); ?></p>
                        <div class="social-links">
                            <a href="<?php echo esc_url(virical_get_social_link('facebook')); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="<?php echo esc_url(virical_get_social_link('youtube')); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="<?php echo esc_url(virical_get_social_link('zalo', 'https://zalo.me/virical')); ?>" target="_blank" rel="noopener">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/zalo-icon.png" alt="Zalo" style="width: 16px; height: 16px;">
                            </a>
                            <a href="<?php echo esc_url(virical_get_social_link('instagram')); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="<?php echo esc_url(virical_get_social_link('linkedin')); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Products Menu -->
                    <div class="footer-widget">
                        <h3>Sản Phẩm</h3>
                        <ul>
                            <li><a href="<?php echo home_url('/indoor/'); ?>">Đèn Indoor</a></li>
                            <li><a href="<?php echo home_url('/outdoor/'); ?>">Đèn Outdoor</a></li>
                            <li><a href="<?php echo home_url('/san-pham/downlight/'); ?>">Đèn Downlight</a></li>
                            <li><a href="<?php echo home_url('/san-pham/spotlight/'); ?>">Đèn Spotlight</a></li>
                            <li><a href="<?php echo home_url('/san-pham/ray-nam-cham/'); ?>">Đèn Ray Nam Châm</a></li>
                        </ul>
                    </div>

                    <!-- Information Menu -->
                    <div class="footer-widget">
                        <h3>Thông Tin</h3>
                        <ul>
                            <li><a href="<?php echo home_url('/gioi-thieu/'); ?>">Về Chúng Tôi</a></li>
                            <li><a href="<?php echo home_url('/cong-trinh/'); ?>">Công Trình</a></li>
                            <li><a href="<?php echo home_url('/lien-he/'); ?>">Liên Hệ</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="footer-widget footer-contact">
                        <h3>Liên Hệ</h3>
                        <ul class="contact-info">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo nl2br(esc_html(virical_get_company_info('address', 'Số 30 Ngõ 100 Nguyễn Xiển, Thanh Xuân, Hà Nội, Việt Nam'))); ?></span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span><?php echo esc_html(virical_get_company_info('phone', '0869995698')); ?><?php $mobile = virical_get_company_info('mobile'); if ($mobile && $mobile !== virical_get_company_info('phone')) echo ' | ' . esc_html($mobile); ?></span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span><?php echo esc_html(virical_get_company_info('email', 'info@virical.vn')); ?></span>
                            </li>
                        </ul>
                        <div class="newsletter">
                            <h4>Đăng Ký Nhận Tin</h4>
                            <form class="newsletter-form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
                                <input type="email" name="email" placeholder="Email của bạn" required>
                                <button type="submit">Đăng Ký</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="ast-container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> Virical. All Rights Reserved. | Designed by Virical Team</p>
                    </div>

                </div>
            </div>
        </div>
    </footer><!-- #colophon -->

    <style>
    /* Footer Styles */
    .site-footer {
        background: #1a1a1a;
        color: #bbb;
        padding: 0;
        margin-top: 80px;
    }

    .footer-main {
        padding: 60px 0 40px;
        border-bottom: 1px solid #333;
    }

    .footer-content {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1.5fr;
        gap: 40px;
    }

    .footer-widget h3 {
        color: #fff;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .footer-widget ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-widget ul li {
        margin-bottom: 12px;
    }

    .footer-widget ul li a {
        color: #bbb;
        text-decoration: none;
        transition: color 0.3s;
        font-size: 14px;
    }

    .footer-widget ul li a:hover {
        color: #d94948;
    }

    .footer-about p {
        margin: 20px 0;
        line-height: 1.8;
        font-size: 14px;
    }

    .footer-logo-wrapper {
        margin-bottom: 20px;
    }

    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-links a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        transition: all 0.3s;
    }

    .social-links a:hover {
        background: #d94948;
        transform: translateY(-3px);
    }

    .contact-info {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .contact-info li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .contact-info li i {
        color: #d94948;
        margin-right: 10px;
        margin-top: 3px;
        width: 16px;
    }

    .newsletter {
        margin-top: 25px;
    }

    .newsletter h4 {
        color: #fff;
        font-size: 16px;
        margin-bottom: 15px;
    }

    .newsletter-form {
        display: flex;
        gap: 10px;
    }

    .newsletter-form input {
        flex: 1;
        padding: 10px 15px;
        background: #333;
        border: 1px solid #444;
        color: #fff;
        border-radius: 4px;
        font-size: 14px;
    }

    .newsletter-form input::placeholder {
        color: #888;
    }

    .newsletter-form button {
        padding: 10px 20px;
        background: #d94948;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: background 0.3s;
    }

    .newsletter-form button:hover {
        background: #c73938;
    }

    /* Footer Bottom */
    .footer-bottom {
        background: #111;
        padding: 20px 0;
    }

    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .copyright p {
        margin: 0;
        font-size: 14px;
        color: #888;
    }

    .footer-links ul {
        display: flex;
        gap: 30px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .footer-links a {
        color: #888;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }

    .footer-links a:hover {
        color: #d94948;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .footer-content {
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
    }

    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .footer-bottom-content {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        .footer-links ul {
            flex-direction: column;
            gap: 10px;
        }
    }
    </style>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>