<?php
/**
 * Template Name: Giải Pháp Thông Minh
 * Description: Trang giới thiệu giải pháp chiếu sáng thông minh
 *
 * @package Virical_Theme
 */

get_header(); ?>

<style>
/* Light Theme Override */
.smart-solutions-page, .smart-intro, .smart-features, .smart-technology, .smart-usecases, .smart-benefits {
    background-color: #ffffff !important;
    color: #000000 !important;
}

.smart-hero {
    background: #f0f8ff !important;
}

.smart-hero .smart-hero-title,
.smart-hero .smart-hero-subtitle,
.smart-hero .smart-badge {
    color: #ffffff !important;
}

.smart-hero::before {
    opacity: 0.1 !important;
}

.smart-hero-overlay {
    background: rgba(0, 0, 0, 0.6) !important;
}

h1, h2, h3, h4 {
    color: #000000 !important;
}

p, .usecase-content ul li {
    color: #666666 !important;
}

.section-label {
    color: #666666 !important;
}

.feature-card, .usecase-card, .benefit-item, .tech-item-icon {
    background-color: #f8f9fa !important;
    border: 1px solid #e5e7eb !important;
}

.benefit-item:hover {
    background: #f1f3f4 !important;
}

.smart-badge {
    background: rgba(59, 130, 246, 0.1) !important;
    border-color: rgba(59, 130, 246, 0.3) !important;
    color: #3b82f6 !important;
}

.btn-primary {
    background: #ffffff !important;
    color: #121212 !important;
}

.btn-primary:hover {
    background: #dddddd !important;
    color: #121212 !important;
}

.btn-secondary {
    color: #ffffff !important;
    border-color: #ffffff !important;
}

.btn-secondary:hover {
    background: #ffffff !important;
    color: #121212 !important;
}

.smart-cta {
    background: #f8f9fa !important;
}

.smart-cta h2,
.smart-cta p {
    color: #000000 !important;
}

.btn-cta-primary {
    background: #ffffff !important;
    color: #121212 !important;
}

.btn-cta-secondary {
    border-color: #000000 !important;
    color: #000000 !important;
}

.usecase-overlay {
    background: rgba(255, 255, 255, 0.9) !important;
    color: #121212 !important;
}

.feature-icon {
    background: #333 !important;
}

.smart-intro-list i, .cta-feature i {
    color: #4CAF50 !important;
}

.usecase-content ul li::before {
    color: #4CAF50 !important;
}

.benefit-number {
    color: #4a4a4a !important;
}

.benefit-item:hover .benefit-number {
    color: #6a6a6a !important;
}

</style>

<div class="smart-solutions-page">

    <!-- Hero Section -->
    <section class="smart-hero">
        <div class="smart-hero-overlay"></div>
        <div class="smart-hero-content">
            <div class="container">
                <span class="smart-badge">CÔNG NGHỆ TIÊN TIẾN</span>
                <h1 class="smart-hero-title">Giải Pháp Chiếu Sáng Thông Minh</h1>
                <p class="smart-hero-subtitle">Kiểm soát ánh sáng hoàn hảo, tiết kiệm năng lượng, tạo không gian sống hiện đại</p>
                <div class="smart-hero-buttons">
                    <a href="#features" class="btn-primary">Khám Phá Ngay</a>
                    <a href="/lien-he/" class="btn-secondary">Tư Vấn Miễn Phí</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Introduction -->
    <section class="smart-intro">
        <div class="container">
            <div class="smart-intro-grid">
                <div class="smart-intro-content">
                    <h2>Chào Mừng Đến Với Tương Lai Chiếu Sáng</h2>
                    <p>Giải pháp chiếu sáng thông minh của VIRICAL mang đến sự kết hợp hoàn hảo giữa công nghệ tiên tiến và thiết kế đẹp mắt. Với hệ thống điều khiển tự động, bạn có thể quản lý toàn bộ ánh sáng trong không gian chỉ bằng một chạm hoặc giọng nói.</p>
                    <ul class="smart-intro-list">
                        <li><i class="fas fa-check-circle"></i> Tiết kiệm đến 70% điện năng</li>
                        <li><i class="fas fa-check-circle"></i> Điều khiển từ xa qua smartphone</li>
                        <li><i class="fas fa-check-circle"></i> Tích hợp AI và IoT</li>
                        <li><i class="fas fa-check-circle"></i> Hẹn giờ và tạo kịch bản tự động</li>
                    </ul>
                </div>
                <div class="smart-intro-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contract_oficinas_arkoslight-899x1024-1.jpg" alt="Smart Lighting">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="smart-features" id="features">
        <div class="container">
            <div class="section-header-center">
                <span class="section-label">TÍNH NĂNG NỔI BẬT</span>
                <h2 class="section-title-large">Điều Khiển Thông Minh, Trải Nghiệm Vượt Trội</h2>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Điều Khiển Qua App</h3>
                    <p>Điều khiển mọi đèn trong nhà qua ứng dụng di động. Bật/tắt, điều chỉnh độ sáng, màu sắc mọi lúc mọi nơi.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-microphone"></i>
                    </div>
                    <h3>Điều Khiển Giọng Nói</h3>
                    <p>Tích hợp với Google Assistant, Alexa, Siri. Chỉ cần nói là đèn sẽ thực hiện theo lệnh của bạn.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Hẹn Giờ Tự Động</h3>
                    <p>Lập lịch bật/tắt đèn tự động theo thời gian. Tiết kiệm điện và tăng độ an toàn cho ngôi nhà.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3>Kịch Bản Ánh Sáng</h3>
                    <p>Tạo các kịch bản ánh sáng cho từng không gian: Đọc sách, Xem phim, Tiệc tùng, Nghỉ ngơi...</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Theo Dõi Năng Lượng</h3>
                    <p>Giám sát lượng điện tiêu thụ theo thời gian thực. Báo cáo chi tiết giúp tối ưu hóa sử dụng.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sun"></i>
                    </div>
                    <h3>Cảm Biến Thông Minh</h3>
                    <p>Tự động điều chỉnh ánh sáng theo điều kiện tự nhiên. Tắt đèn khi không có người, bật khi phát hiện chuyển động.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Section -->
    <section class="smart-technology">
        <div class="container">
            <div class="tech-grid">
                <div class="tech-content">
                    <span class="section-label">CÔNG NGHỆ HÀNG ĐẦU</span>
                    <h2>Nền Tảng Công Nghệ Tiên Phong</h2>
                    <div class="tech-list">
                        <div class="tech-item">
                            <div class="tech-item-icon">
                                <i class="fas fa-network-wired"></i>
                            </div>
                            <div class="tech-item-content">
                                <h4>IoT & Cloud Computing</h4>
                                <p>Kết nối tất cả thiết bị qua internet, lưu trữ dữ liệu trên đám mây an toàn.</p>
                            </div>
                        </div>

                        <div class="tech-item">
                            <div class="tech-item-icon">
                                <i class="fas fa-brain"></i>
                            </div>
                            <div class="tech-item-content">
                                <h4>AI & Machine Learning</h4>
                                <p>Học hỏi thói quen sử dụng, tự động tối ưu hóa ánh sáng và tiết kiệm năng lượng.</p>
                            </div>
                        </div>

                        <div class="tech-item">
                            <div class="tech-item-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="tech-item-content">
                                <h4>Bảo Mật Cao Cấp</h4>
                                <p>Mã hóa dữ liệu end-to-end, xác thực 2 lớp, bảo vệ quyền riêng tư tuyệt đối.</p>
                            </div>
                        </div>

                        <div class="tech-item">
                            <div class="tech-item-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div class="tech-item-content">
                                <h4>Tích Hợp Đa Nền Tảng</h4>
                                <p>Tương thích với Apple HomeKit, Google Home, Amazon Alexa, Samsung SmartThings.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tech-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/2f4e33132815651.61b09f5f09ecb-ppf8srk0353cspqcrrdji9xnzwever04ldoj5kme68.jpg" alt="Technology">
                </div>
            </div>
        </div>
    </section>

    <!-- Use Cases -->
    <section class="smart-usecases">
        <div class="container">
            <div class="section-header-center">
                <span class="section-label">ỨNG DỤNG THỰC TẾ</span>
                <h2 class="section-title-large">Giải Pháp Cho Mọi Không Gian</h2>
            </div>

            <div class="usecases-grid">
                <div class="usecase-card">
                    <div class="usecase-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/habitat_home.jpg" alt="Nhà Ở">
                        <div class="usecase-overlay">
                            <i class="fas fa-home"></i>
                        </div>
                    </div>
                    <div class="usecase-content">
                        <h3>Nhà Ở Thông Minh</h3>
                        <p>Biệt thự, căn hộ cao cấp với hệ thống chiếu sáng tự động, tiết kiệm và tiện nghi.</p>
                        <ul>
                            <li>Điều khiển từng phòng</li>
                            <li>Kịch bản sáng/tối tự động</li>
                            <li>Tích hợp smart home</li>
                        </ul>
                    </div>
                </div>

                <div class="usecase-card">
                    <div class="usecase-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contract_oficinas_arkoslight-899x1024-1.jpg" alt="Văn Phòng">
                        <div class="usecase-overlay">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                    <div class="usecase-content">
                        <h3>Văn Phòng Hiện Đại</h3>
                        <p>Tối ưu năng suất làm việc với ánh sáng tự động điều chỉnh theo từng khu vực.</p>
                        <ul>
                            <li>Cảm biến chuyển động</li>
                            <li>Điều chỉnh theo ánh sáng tự nhiên</li>
                            <li>Tiết kiệm đến 70% điện</li>
                        </ul>
                    </div>
                </div>

                <div class="usecase-card">
                    <div class="usecase-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/post_gal_0029_r1-1024x576.jpg" alt="Khách Sạn">
                        <div class="usecase-overlay">
                            <i class="fas fa-hotel"></i>
                        </div>
                    </div>
                    <div class="usecase-content">
                        <h3>Khách Sạn & Resort</h3>
                        <p>Nâng cao trải nghiệm khách hàng với hệ thống chiếu sáng sang trọng, dễ sử dụng.</p>
                        <ul>
                            <li>Điều khiển tập trung</li>
                            <li>Kịch bản welcome/goodbye</li>
                            <li>Quản lý năng lượng toàn diện</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits -->
    <section class="smart-benefits">
        <div class="container">
            <div class="section-header-center">
                <span class="section-label">LỢI ÍCH</span>
                <h2 class="section-title-large">Tại Sao Chọn Giải Pháp Của VIRICAL?</h2>
            </div>

            <div class="benefits-grid">
                <div class="benefit-item">
                    <div class="benefit-number">01</div>
                    <h3>Tiết Kiệm Chi Phí</h3>
                    <p>Giảm đến 70% hóa đơn tiền điện nhờ hệ thống tự động tối ưu hóa sử dụng năng lượng.</p>
                </div>

                <div class="benefit-item">
                    <div class="benefit-number">02</div>
                    <h3>Tiện Nghi Vượt Trội</h3>
                    <p>Điều khiển mọi lúc mọi nơi qua smartphone, giọng nói hoặc tự động hoàn toàn.</p>
                </div>

                <div class="benefit-item">
                    <div class="benefit-number">03</div>
                    <h3>Bảo Vệ Môi Trường</h3>
                    <p>Sử dụng đèn LED hiệu suất cao, giảm phát thải CO2, góp phần xây dựng tương lai xanh.</p>
                </div>

                <div class="benefit-item">
                    <div class="benefit-number">04</div>
                    <h3>Tăng Giá Trị Tài Sản</h3>
                    <p>Công nghệ smart home làm tăng giá trị và tính hấp dẫn của bất động sản.</p>
                </div>

                <div class="benefit-item">
                    <div class="benefit-number">05</div>
                    <h3>An Toàn & Bảo Mật</h3>
                    <p>Mô phỏng có người ở nhà khi đi vắng, tích hợp với hệ thống an ninh thông minh.</p>
                </div>

                <div class="benefit-item">
                    <div class="benefit-number">06</div>
                    <h3>Dễ Dàng Mở Rộng</h3>
                    <p>Hệ thống module, dễ dàng thêm thiết bị mới mà không cần sửa chữa công trình.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="smart-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Sẵn Sàng Trải Nghiệm Tương Lai Chiếu Sáng?</h2>
                <p>Đội ngũ chuyên gia của VIRICAL sẵn sàng tư vấn và thiết kế giải pháp chiếu sáng thông minh phù hợp nhất cho không gian của bạn.</p>
                <div class="cta-buttons">
                    <a href="/lien-he/" class="btn-cta-primary">Đặt Lịch Tư Vấn</a>
                    <a href="tel:0123456789" class="btn-cta-secondary">
                        <i class="fas fa-phone"></i> 0123 456 789
                    </a>
                </div>
                <div class="cta-features">
                    <div class="cta-feature">
                        <i class="fas fa-check"></i>
                        <span>Tư vấn miễn phí</span>
                    </div>
                    <div class="cta-feature">
                        <i class="fas fa-check"></i>
                        <span>Khảo sát tại chỗ</span>
                    </div>
                    <div class="cta-feature">
                        <i class="fas fa-check"></i>
                        <span>Báo giá chi tiết</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<style>
/* Smart Solutions Page Styles */
.smart-solutions-page {
    font-family: 'Quicksand', sans-serif;
}

/* Hero Section */
.smart-hero {
    position: relative;
    min-height: 80vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    overflow: hidden;
}

.smart-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('<?php echo get_template_directory_uri(); ?>/assets/images/2203-tracklights-arkoslight-1024x576.jpg') center/cover;
    opacity: 0.15;
}

.smart-hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
}

.smart-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
    padding: 60px 20px;
}

.smart-badge {
    display: inline-block;
    padding: 8px 20px;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 30px;
    font-size: 12px;
    letter-spacing: 2px;
    font-weight: 500;
    margin-bottom: 20px;
    backdrop-filter: blur(10px);
}

.smart-hero-title {
    font-size: 56px;
    font-weight: 700;
    margin-bottom: 20px;
    line-height: 1.2;
}

.smart-hero-subtitle {
    font-size: 20px;
    max-width: 700px;
    margin: 0 auto 40px;
    line-height: 1.6;
    opacity: 0.95;
}

.smart-hero-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary, .btn-secondary {
    padding: 15px 35px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s;
    display: inline-block;
}

.btn-primary {
    background: white;
    color: #667eea;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
}

.btn-secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn-secondary:hover {
    background: white;
    color: #667eea;
}

/* Introduction Section */
.smart-intro {
    padding: 100px 0;
    background: #fff;
}

.smart-intro-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.smart-intro-content h2 {
    font-size: 36px;
    color: #2a2a2a;
    margin-bottom: 25px;
    line-height: 1.3;
}

.smart-intro-content p {
    font-size: 16px;
    line-height: 1.8;
    color: #666;
    margin-bottom: 30px;
}

.smart-intro-list {
    list-style: none;
    padding: 0;
}

.smart-intro-list li {
    font-size: 16px;
    color: #555;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.smart-intro-list i {
    color: #4CAF50;
    font-size: 18px;
}

.smart-intro-image {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.smart-intro-image img {
    width: 100%;
    height: auto;
    display: block;
}

/* Features Section */
.smart-features {
    padding: 100px 0;
    background: #f9f9f9;
}

.section-header-center {
    text-align: center;
    margin-bottom: 60px;
}

.section-label {
    display: inline-block;
    color: #667eea;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 2px;
    margin-bottom: 10px;
}

.section-title-large {
    font-size: 42px;
    color: #2a2a2a;
    font-weight: 600;
    line-height: 1.3;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
}

.feature-card {
    background: white;
    padding: 40px 30px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
}

.feature-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 25px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 32px;
}

.feature-card h3 {
    font-size: 20px;
    color: #2a2a2a;
    margin-bottom: 15px;
    font-weight: 600;
}

.feature-card p {
    font-size: 15px;
    line-height: 1.7;
    color: #666;
}

/* Technology Section */
.smart-technology {
    padding: 100px 0;
    background: white;
}

.tech-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.tech-content h2 {
    font-size: 36px;
    color: #2a2a2a;
    margin-bottom: 40px;
}

.tech-list {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.tech-item {
    display: flex;
    gap: 20px;
}

.tech-item-icon {
    width: 60px;
    height: 60px;
    background: #f0f0f0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #667eea;
    flex-shrink: 0;
}

.tech-item-content h4 {
    font-size: 18px;
    color: #2a2a2a;
    margin-bottom: 8px;
    font-weight: 600;
}

.tech-item-content p {
    font-size: 14px;
    line-height: 1.6;
    color: #666;
}

.tech-image {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.tech-image img {
    width: 100%;
    height: auto;
    display: block;
}

/* Use Cases Section */
.smart-usecases {
    padding: 100px 0;
    background: #f9f9f9;
}

.usecases-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
}

.usecase-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s;
}

.usecase-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.usecase-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.usecase-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.usecase-card:hover .usecase-image img {
    transform: scale(1.1);
}

.usecase-overlay {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #667eea;
}

.usecase-content {
    padding: 30px;
}

.usecase-content h3 {
    font-size: 22px;
    color: #2a2a2a;
    margin-bottom: 15px;
    font-weight: 600;
}

.usecase-content p {
    font-size: 15px;
    line-height: 1.7;
    color: #666;
    margin-bottom: 20px;
}

.usecase-content ul {
    list-style: none;
    padding: 0;
}

.usecase-content ul li {
    font-size: 14px;
    color: #555;
    margin-bottom: 8px;
    padding-left: 20px;
    position: relative;
}

.usecase-content ul li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #4CAF50;
    font-weight: bold;
}

/* Benefits Section */
.smart-benefits {
    padding: 100px 0;
    background: white;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
}

.benefit-item {
    padding: 40px 30px;
    background: #f9f9f9;
    border-radius: 12px;
    transition: all 0.3s;
}

.benefit-item:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-5px);
}

.benefit-number {
    font-size: 48px;
    font-weight: 700;
    color: #667eea;
    opacity: 0.3;
    margin-bottom: 20px;
    line-height: 1;
}

.benefit-item:hover .benefit-number {
    color: white;
    opacity: 0.5;
}

.benefit-item h3 {
    font-size: 20px;
    margin-bottom: 15px;
    font-weight: 600;
}

.benefit-item p {
    font-size: 15px;
    line-height: 1.7;
    opacity: 0.9;
}

/* CTA Section */
.smart-cta {
    padding: 100px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-align: center;
}

.cta-content h2 {
    font-size: 42px;
    margin-bottom: 20px;
    font-weight: 700;
}

.cta-content p {
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto 40px;
    line-height: 1.7;
    opacity: 0.95;
}

.cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.btn-cta-primary, .btn-cta-secondary {
    padding: 18px 40px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-cta-primary {
    background: white;
    color: #667eea;
}

.btn-cta-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
}

.btn-cta-secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn-cta-secondary:hover {
    background: white;
    color: #667eea;
}

.cta-features {
    display: flex;
    gap: 40px;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-feature {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
}

.cta-feature i {
    color: #4CAF50;
}

/* Responsive */
@media (max-width: 1024px) {
    .smart-intro-grid,
    .tech-grid {
        grid-template-columns: 1fr;
    }

    .features-grid,
    .usecases-grid,
    .benefits-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .smart-hero-title {
        font-size: 42px;
    }
}

@media (max-width: 768px) {
    .features-grid,
    .usecases-grid,
    .benefits-grid {
        grid-template-columns: 1fr;
    }

    .smart-hero-title {
        font-size: 32px;
    }

    .smart-hero-subtitle {
        font-size: 16px;
    }

    .section-title-large {
        font-size: 32px;
    }

    .cta-content h2 {
        font-size: 32px;
    }
}
</style>

<?php get_footer(); ?>