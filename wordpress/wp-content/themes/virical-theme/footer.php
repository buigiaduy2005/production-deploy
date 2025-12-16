<?php
/**
 * The template for displaying the footer
 *
 * @package Virical
 */
?>

        </div><!-- .ast-container -->
    </div><!-- #content -->

    <!-- Service Info Section -->
    <section class="service-info-section">
        <div class="ast-container">
            <div class="service-info-grid">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="service-content">
                        <h4>Bảo hành 1 đổi 1 trong 15 tháng</h4>
                        <p>Cam kết chất lượng với chính sách bảo hành toàn diện</p>
                    </div>
                </div>
                
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="service-content">
                        <h4>Bảo hành nhanh chóng</h4>
                        <p>Xử lý bảo hành nhanh chóng, chuyên nghiệp</p>
                    </div>
                </div>
                
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="service-content">
                        <h4>Hỗ trợ khách trọn đời</h4>
                        <p>Tư vấn và hỗ trợ khách hàng suốt quá trình sử dụng</p>
                    </div>
                </div>
                
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="service-content">
                        <h4>Vận chuyển nội bộc toàn quốc</h4>
                        <p>Giao hàng an toàn, nhanh chóng trên toàn quốc</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="ast-container">
            <div id="footer-contact-form-container" class="newsletter-content">
                <h3>Nhận thông tin tư vấn từ chúng tôi</h3>
                <div class="form-group">
                    <input type="text" id="phone-input-trigger" placeholder="Nhập số điện thoại" readonly style="cursor: pointer;">
                    <button type="button" class="btn-submit" id="open-contact-modal">Gửi đi</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Modal -->
    <div id="contact-modal" class="contact-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h3>Nhận thông tin tư vấn từ chúng tôi</h3>
            <form id="footer-phone-capture-form">
                <input type="hidden" name="action" value="virical_contact_form">
                <input type="hidden" name="source" value="Footer Phone Form">
                <input type="hidden" name="subject" value="Yêu cầu tư vấn qua điện thoại (Footer)">
                
                <div class="modal-form-group">
                    <label for="modal-name">Họ và tên</label>
                    <input type="text" id="modal-name" name="name" placeholder="Nhập họ và tên của bạn" required>
                </div>
                
                <div class="modal-form-group">
                    <label for="modal-phone">Số điện thoại *</label>
                    <input type="tel" id="modal-phone" name="phone" placeholder="Nhập số điện thoại" required>
                </div>
                
                <div class="modal-form-group">
                    <label for="modal-email">Email</label>
                    <input type="email" id="modal-email" name="email" placeholder="Nhập email của bạn">
                </div>
                
                <div class="modal-form-group">
                    <label for="modal-message">Nội dung</label>
                    <textarea id="modal-message" name="message" rows="4" placeholder="Nhập nội dung cần tư vấn"></textarea>
                </div>
                
                <button type="submit" class="btn-submit-modal">Gửi thông tin</button>
            </form>
        </div>
    </div>

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
                            <a href="<?php echo esc_url(virical_get_social_link('zalo', 'https://zalo.me/virical')); ?>" target="_blank" rel="noopener" style="font-weight: 700; font-size: 16px; display: flex; align-items: center; justify-content: center;">
                                Z
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
                    <div class="footer-notification-logo">
                        <a href="http://online.gov.vn/Home/WebDetails/113888" target="_blank" rel="nofollow noreferrer">
                            <?php
                            $bct_logo_id = get_option('virical_bct_logo_id');
                            if ($bct_logo_id) {
                                $bct_logo_url = wp_get_attachment_image_url($bct_logo_id, 'full'); // Use 'full' size or define a custom size
                                echo '<img src="' . esc_url($bct_logo_url) . '" alt="Đã thông báo Bộ Công Thương" width="150">';
                            } else {
                                // Fallback to the hardcoded image if no custom logo is set
                                echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/thongbaobocongthuonglogo.svg' ) . '" alt="Đã thông báo Bộ Công Thương" width="150">';
                            }
                            ?>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </footer><!-- #colophon -->

    <style>
    /* Service Info Section Styles */
    .service-info-section {
        background: #f8f9fa;
        padding: 60px 0;
        margin-top: 0;
    }
    
    .service-info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .service-item {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        text-align: left;
    }
    
    .service-icon {
        width: 60px;
        height: 60px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        flex-shrink: 0;
    }
    
    .service-icon i {
        font-size: 24px;
        color: #666;
    }
    
    .service-content h4 {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin: 0 0 8px 0;
        line-height: 1.3;
    }
    
    .service-content p {
        font-size: 14px;
        color: #666;
        margin: 0;
        line-height: 1.5;
    }
    
    /* Responsive for Service Info */
    @media (max-width: 1200px) {
        .service-info-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }
    }
    
    @media (max-width: 768px) {
        .service-info-section {
            padding: 40px 0;
        }
        
        .service-info-grid {
            grid-template-columns: 1fr;
            gap: 25px;
        }
        
        .service-item {
            gap: 15px;
        }
        
        .service-icon {
            width: 50px;
            height: 50px;
        }
        
        .service-icon i {
            font-size: 20px;
        }
        
        .service-content h4 {
            font-size: 15px;
        }
        
        .service-content p {
            font-size: 13px;
        }
    }

    /* Newsletter Section Styles */
    .newsletter-section {
        background: #fff;
        padding: 50px 0;
        text-align: center;
        border-top: 1px solid #e0e0e0;
    }
    
    .newsletter-content h3 {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin: 0 0 30px 0;
    }
    
    .newsletter-form-main {
        max-width: 500px;
        margin: 0 auto;
    }
    
    .form-group {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    
    .form-group input {
        flex: 1;
        padding: 15px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        outline: none;
        transition: border-color 0.3s;
    }
    
    .form-group input:focus {
        border-color: #007bff;
    }
    
    .form-group input::placeholder {
        color: #999;
    }
    
    .btn-submit {
        padding: 15px 30px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
        white-space: nowrap;
    }
    
    .btn-submit:hover {
        background: #0056b3;
    }
    
    /* Responsive for Newsletter */
    @media (max-width: 768px) {
        .newsletter-section {
            padding: 40px 0;
        }
        
        .newsletter-content h3 {
            font-size: 20px;
            margin-bottom: 25px;
        }
        
        .form-group {
            flex-direction: column;
            gap: 15px;
        }
        
        .form-group input,
        .btn-submit {
            width: 100%;
            padding: 12px 20px;
            font-size: 15px;
        }
    }

    /* Footer Styles */
    .site-footer {
        background: #1a1a1a;
        color: #bbb;
        padding: 0;
        margin-top: 0;
        position: relative;
        z-index: 60;
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

    /* Contact Modal Styles */
    .contact-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
        animation: fadeIn 0.3s ease;
    }

    .contact-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 40px;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        position: relative;
        animation: slideDown 0.3s ease;
    }

    .close-modal {
        color: #aaa;
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 32px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: #333;
    }

    .modal-content h3 {
        color: #333;
        font-size: 24px;
        font-weight: 600;
        margin: 0 0 30px 0;
        text-align: center;
    }

    .modal-form-group {
        margin-bottom: 20px;
    }

    .modal-form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 500;
        font-size: 14px;
    }

    .modal-form-group input,
    .modal-form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 15px;
        outline: none;
        transition: border-color 0.3s;
        font-family: inherit;
        box-sizing: border-box;
    }

    .modal-form-group input:focus,
    .modal-form-group textarea:focus {
        border-color: #007bff;
    }

    .modal-form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .btn-submit-modal {
        width: 100%;
        padding: 15px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 10px;
    }

    .btn-submit-modal:hover {
        background: #0056b3;
    }

    .btn-submit-modal:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .footer-content {
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
    }

    @media (max-width: 768px) {
        .modal-content {
            padding: 30px 20px;
            width: 95%;
        }

        .modal-content h3 {
            font-size: 20px;
            margin-bottom: 25px;
        }

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

<script>
jQuery(document).ready(function($) {
    var modal = $('#contact-modal');
    var phoneInputTrigger = $('#phone-input-trigger');
    var openModalBtn = $('#open-contact-modal');
    var closeModalBtn = $('.close-modal');
    
    // Open modal when clicking on the phone input or button
    phoneInputTrigger.on('click', function() {
        modal.addClass('show');
        $('#modal-phone').focus();
    });
    
    openModalBtn.on('click', function() {
        modal.addClass('show');
        $('#modal-phone').focus();
    });
    
    // Close modal when clicking on X button
    closeModalBtn.on('click', function() {
        modal.removeClass('show');
    });
    
    // Close modal when clicking outside of modal content
    $(window).on('click', function(event) {
        if (event.target.id === 'contact-modal') {
            modal.removeClass('show');
        }
    });
    
    // Close modal on ESC key
    $(document).on('keydown', function(event) {
        if (event.key === 'Escape' && modal.hasClass('show')) {
            modal.removeClass('show');
        }
    });
    
    // Handle form submission
    $('#footer-phone-capture-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitButton = form.find('.btn-submit-modal');
        var originalButtonText = submitButton.text();

        submitButton.text('Đang gửi...').prop('disabled', true);

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // Show success message in modal
                    $('.modal-content').html(
                        '<span class="close-modal">&times;</span>' +
                        '<div style="text-align: center; padding: 20px;">' +
                        '<h3 style="color: #28a745; margin-bottom: 15px;">✓ Cảm ơn bạn!</h3>' +
                        '<p style="color: #333; font-size: 16px;">' + response.data + '</p>' +
                        '<button type="button" class="btn-submit-modal" style="margin-top: 20px;" onclick="jQuery(\'#contact-modal\').removeClass(\'show\')">Đóng</button>' +
                        '</div>'
                    );
                    
                    // Re-attach close button event
                    $('.close-modal').on('click', function() {
                        modal.removeClass('show');
                    });
                } else {
                    alert('Lỗi: ' + response.data);
                    submitButton.text(originalButtonText).prop('disabled', false);
                }
            },
            error: function() {
                alert('Đã có lỗi xảy ra, vui lòng thử lại.');
                submitButton.text(originalButtonText).prop('disabled', false);
            }
        });
    });
});
</script>

</body>
</html>