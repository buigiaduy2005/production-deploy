<?php
/**
<!-- DEBUG: Using page-lien-he.php template -->
 * Template for Contact page (/lien-he/)
 * Displays contact information from wp_contact_offices table
 *
 * @package Virical_Theme
 */

get_header();
?>

<main id="primary" class="site-main contact-page">
    <div class="page-header-section">
        <div class="ast-container">
            <h1 class="page-title">Liên Hệ Với Chúng Tôi</h1>
            <p class="page-subtitle">Đội ngũ tư vấn chuyên nghiệp sẵn sàng hỗ trợ bạn</p>
        </div>
    </div>

    <div class="contact-content-section">
        <div class="ast-container">
            <div class="contact-grid">
                <!-- Contact Form Section -->
                <div class="contact-form-section">
                    <h2>Gửi Yêu Cầu Tư Vấn</h2>
                    <p>Hãy để lại thông tin, chúng tôi sẽ liên hệ tư vấn miễn phí trong thời gian sớm nhất.</p>
                    
                    <form class="virical-contact-form" id="contact-form" method="post" action="" accept-charset="UTF-8">
                        <?php wp_nonce_field( 'virical_contact_form', 'contact_nonce' ); ?>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact-name">Họ và Tên <span class="required">*</span></label>
                                <input type="text" id="contact-name" name="contact_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-phone">Số Điện Thoại <span class="required">*</span></label>
                                <input type="tel" id="contact-phone" name="contact_phone" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact-email">Email</label>
                                <input type="email" id="contact-email" name="contact_email">
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-service">Dịch Vụ Quan Tâm</label>
                                <select id="contact-service" name="contact_service">
                                    <option value="">Chọn dịch vụ</option>
                                    <option value="indoor">Đèn LED Indoor</option>
                                    <option value="outdoor">Đèn LED Outdoor</option>
                                    <option value="industrial">Đèn Công Nghiệp</option>
                                    <option value="smart">Smart Lighting</option>
                                    <option value="other">Khác</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact-message">Nội Dung Yêu Cầu <span class="required">*</span></label>
                            <textarea id="contact-message" name="contact_message" rows="5" placeholder="Vui lòng mô tả chi tiết nhu cầu của bạn..." required></textarea>
                        </div>
                        
                        <button type="submit" class="submit-button">
                            <i class="fas fa-paper-plane"></i>
                            Gửi Yêu Cầu Ngay
                        </button>
                    </form>
                </div>

                <!-- Office Information Section -->
                <div class="office-info-section">
                    <h2>Hệ Thống Văn Phòng & Showroom</h2>
                    <p>Thông tin văn phòng và thời gian làm việc của chúng tôi.</p>

                    <?php
                    global $wpdb;
                    
                    // Set proper charset for MySQL connection
                    $wpdb->query("SET NAMES utf8mb4");
                    $wpdb->query("SET CHARACTER SET utf8mb4");
                    $wpdb->query("SET character_set_connection=utf8mb4");
                    
                    // Get office data from database with proper encoding
                    $offices = $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT * FROM {$wpdb->prefix}contact_offices 
                             WHERE is_active = %d 
                             ORDER BY is_main DESC, sort_order ASC",
                            1
                        ),
                        ARRAY_A
                    );
                    
                    if ($offices) {
                        foreach ($offices as $office) {
                            ?>
                            <div class="office-item <?php echo $office['is_main'] ? 'main-office' : ''; ?>">
                                <div class="office-header">
                                    <h3>
                                        <?php echo esc_html($office['name']); ?>
                                        <?php if ($office['is_main']): ?>
                                            <span class="main-badge">Văn phòng chính</span>
                                        <?php endif; ?>
                                    </h3>
                                </div>
                                
                                <div class="office-details">
                                    <div class="detail-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <div class="detail-content">
                                            <strong>Địa chỉ:</strong>
                                            <p><?php echo esc_html($office['address']); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <i class="fas fa-phone"></i>
                                        <div class="detail-content">
                                            <strong>Điện thoại:</strong>
                                            <p><a href="tel:<?php echo esc_attr($office['phone']); ?>"><?php echo esc_html($office['phone']); ?></a></p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <i class="fas fa-envelope"></i>
                                        <div class="detail-content">
                                            <strong>Email:</strong>
                                            <p><a href="mailto:<?php echo esc_attr($office['email']); ?>"><?php echo esc_html($office['email']); ?></a></p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <i class="fas fa-clock"></i>
                                        <div class="detail-content">
                                            <strong>Giờ làm việc:</strong>
                                            <p><?php echo nl2br(esc_html($office['working_hours'])); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="no-offices">Thông tin văn phòng đang được cập nhật.</div>';
                    }
                    ?>

                    <?php /* Hotline section - hidden
                    <div class="contact-cta">
                        <h3>Liên Hệ Hotline</h3>
                        <p class="hotline-number">
                            <i class="fas fa-phone-volume"></i>
                            <a href="tel:0246656268824">024.6656.2688</a>
                        </p>
                        <p class="hotline-note">Tư vấn miễn phí 24/7</p>
                    </div>
                    */ ?>
                </div>
            </div>
        </div>
    </div>

    <?php /* Map Section - hidden
    <div class="map-section">
        <div class="ast-container">
            <h2 class="section-title">Bản Đồ Các Văn Phòng</h2>
        </div>

        <div class="google-map-container">
            <?php
            // Get main office coordinates for map center with proper encoding
            $wpdb->query("SET NAMES utf8mb4");
            $main_office = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT latitude, longitude, address FROM {$wpdb->prefix}contact_offices
                     WHERE is_main = %d AND is_active = %d LIMIT 1",
                    1, 1
                ),
                ARRAY_A
            );

            if ($main_office && $main_office['latitude'] && $main_office['longitude']) {
                $lat = $main_office['latitude'];
                $lng = $main_office['longitude'];
                ?>
                <iframe
                    src="https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q=<?php echo urlencode($main_office['address']); ?>&center=<?php echo $lat; ?>,<?php echo $lng; ?>&zoom=15"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <?php
            } else {
                // Fallback map for Hanoi
                ?>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8639810699474!2d105.78244699999999!3d21.02851100000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab4c0c00369f%3A0x2b14c0e6f8e8c6f0!2sTon%20That%20Thuyet%2C%20My%20Dinh%2C%20Nam%20Tu%20Liem%2C%20Hanoi%2C%20Vietnam!5e0!3m2!1sen!2s!4v1694755623456!5m2!1sen!2s"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <?php
            }
            ?>
        </div>
    </div>
    */ ?>

</main>

<?php get_footer(); ?>

<style>
/* Contact Page Styles */
.contact-page {
    background-color: #fff;
}

.page-header-section {
    background: #000;
    color: white;
    text-align: center;
    padding: 100px 0 60px 0;
}

.page-header-section .page-title {
    font-size: 48px;
    margin: 0 0 15px 0;
    font-weight: 700;
    color: white !important;
}

.page-header-section .page-subtitle {
    font-size: 18px;
    opacity: 0.9;
    margin: 0;
    color: white !important;
}

.contact-content-section {
    padding: 80px 0;
    background-color: #f8f9fa;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: stretch;
}

/* Contact Form Styles */
.contact-form-section h2,
.office-info-section h2 {
    font-size: 32px;
    color: #000 !important;
    margin-bottom: 20px;
    font-weight: 600;
}

.contact-form-section p,
.office-info-section p {
    color: #666;
    margin-bottom: 30px;
    font-size: 16px;
    line-height: 1.6;
}

.virical-contact-form {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.form-group .required {
    color: #e74c3c;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #000;
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.submit-button {
    background: #000;
    color: white;
    padding: 18px 40px;
    border: none;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.submit-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(30, 60, 114, 0.3);
}

/* Office Info Styles */
.office-item {
    background: white;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border-left: 4px solid #e9ecef;
    transition: all 0.3s ease;
}

.office-item.main-office {
    border-left-color: #000;
    background: linear-gradient(135deg, #f8f9ff 0%, #fff 100%);
}

.office-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.office-header h3 {
    color: #000;
    font-size: 20px;
    margin: 0 0 20px 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 15px;
}

.main-badge {
    background: #000;
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
}

.detail-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
}

.detail-item i {
    font-size: 16px;
    color: #000;
    margin-right: 15px;
    margin-top: 2px;
    width: 20px;
    flex-shrink: 0;
}

.detail-content strong {
    display: block;
    color: #333;
    font-weight: 600;
    margin-bottom: 5px;
}

.detail-content p {
    margin: 0;
    color: #666;
    line-height: 1.5;
}

.detail-content a {
    color: #000;
    text-decoration: none;
    font-weight: 500;
}

.detail-content a:hover {
    text-decoration: underline;
}

/* Contact CTA */
.contact-cta {
    background: #000;
    color: white;
    padding: 30px;
    border-radius: 12px;
    text-align: center;
    margin-top: 30px;
}

.contact-cta h3 {
    color: white;
    font-size: 24px;
    margin-bottom: 15px;
}

.hotline-number {
    font-size: 32px;
    font-weight: 700;
    margin: 20px 0 10px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.hotline-number i {
    font-size: 28px;
    animation: pulse 2s infinite;
}

.hotline-number a {
    color: #ffd700;
    text-decoration: none;
}

.hotline-note {
    font-size: 14px;
    opacity: 0.9;
    margin: 0;
}

/* Map Section */
.map-section {
    padding: 80px 0 0 0;
    background: white;
}

.section-title {
    text-align: center;
    font-size: 36px;
    color: #000;
    margin-bottom: 50px;
    font-weight: 600;
}

.google-map-container {
    position: relative;
    width: 100%;
    height: 450px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.google-map-container iframe {
    width: 100%;
    height: 100%;
}

.no-offices {
    background: white;
    padding: 30px;
    border-radius: 12px;
    text-align: center;
    color: #666;
    font-style: italic;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

/* Animations */
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header-section .page-title {
        font-size: 36px;
    }
    
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }
    
    .virical-contact-form {
        padding: 25px;
    }
    
    .office-item {
        padding: 20px;
    }
    
    .hotline-number {
        font-size: 24px;
    }
    
    .google-map-container {
        height: 300px;
    }
    
    .section-title {
        font-size: 28px;
    }
}

@media (max-width: 480px) {
    .contact-content-section {
        padding: 40px 0;
    }
    
    .page-header-section {
        padding: 40px 0;
    }
    
    .virical-contact-form {
        padding: 20px;
    }
    
    .submit-button {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            const name = document.getElementById('contact-name').value.trim();
            const phone = document.getElementById('contact-phone').value.trim();
            const message = document.getElementById('contact-message').value.trim();
            
            if (!name || !phone || !message) {
                alert('Vui lòng điền đầy đủ các trường bắt buộc (*)');
                return;
            }
            
            // Phone validation (basic Vietnamese phone number)
            const phoneRegex = /^(0[3|5|7|8|9])[0-9]{8}$/;
            if (!phoneRegex.test(phone.replace(/\s/g, ''))) {
                alert('Vui lòng nhập số điện thoại hợp lệ (10 chữ số, bắt đầu bằng 03, 05, 07, 08, 09)');
                return;
            }
            
            // Submit form (would typically send via AJAX)
            const submitButton = form.querySelector('.submit-button');
            const originalText = submitButton.innerHTML;
            
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
            submitButton.disabled = true;
            
            // Simulate form submission
            setTimeout(function() {
                alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
                form.reset();
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 2000);
        });
    }
});
</script>