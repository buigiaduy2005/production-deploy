<?php
/**
 * Template Name: Virical Product Detail Page
 *
 * This is the template that displays a custom product page for Virical.
 */

// Basic WordPress setup
require_once(dirname(__FILE__) . '/wp-load.php');

// You can add any specific PHP logic here if needed.
// For this static design, we'll focus on HTML and CSS.

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virical Dual Smart Dimmer T2 Zigbee Driver Quốc Tế - Virical</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #121212;
            color: #FFFFFF;
            font-family: sans-serif;
        }
        .virical-yellow {
            background-color: #FFD700;
            color: #000000;
        }
        .virical-yellow-text {
            color: #FFD700;
        }
        .virical-gray-border {
            border: 1px solid #FFFFFF;
            color: #FFFFFF;
        }
        .virical-dark-bg {
            background-color: #1E1E1E;
        }
        .cta-input {
            background-color: #2A2A2A;
            border: 1px solid #444444;
            color: #FFFFFF;
        }
        .slider-container {
            position: relative;
            max-width: 500px;
            margin: auto;
        }
        .slide {
            display: none;
        }
        .slide.active {
            display: block;
        }
        .slide img {
            width: 100%;
            border-radius: 8px;
        }
        .slider-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }
        .slider-nav button {
            background-color: rgba(0,0,0,0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container mx-auto p-4 md:p-8">

    <!-- Hero Section -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center my-12">
        <!-- Left: Product Image Slider -->
        <div class="slider-container">
            <div class="slide active">
                <img src="https://i.imgur.com/lI2N9N8.png" alt="Virical Dual Smart Dimmer T2 Zigbee Driver Quốc Tế - Image 1">
            </div>
            <div class="slide">
                <img src="https://i.imgur.com/lI2N9N8.png" alt="Virical Dual Smart Dimmer T2 Zigbee Driver Quốc Tế - Image 2">
            </div>
            <div class="slider-nav">
                <button onclick="changeSlide(-1)">&#10094;</button>
                <button onclick="changeSlide(1)">&#10095;</button>
            </div>
        </div>

        <!-- Right: Product Info -->
        <div class="flex flex-col space-y-6">
            <h1 class="text-4xl md:text-5xl font-bold">Virical Dual Smart Dimmer T2 Zigbee Driver Quốc Tế</h1>
            <p class="text-lg text-gray-300">Bộ driver điều khiển thông minh Zigbee, tương thích Apple HomeKit và ứng dụng Virical Home.</p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <button class="virical-yellow font-bold py-3 px-8 rounded-lg text-lg hover:opacity-90 transition-opacity">LIÊN HỆ NHẬN BÁO GIÁ</button>
                <button class="virical-gray-border font-bold py-3 px-8 rounded-lg text-lg hover:bg-white hover:text-black transition-colors">TẢI CATALOGUE</button>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="bg-gray-100 dark:bg-gray-800 py-12 my-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <div class="flex flex-col items-center text-center p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-500 dark:text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 11.667 0l3.181-3.183m-4.991-2.691V5.25a2.25 2.25 0 0 0-2.25-2.25h-4.5a2.25 2.25 0 0 0-2.25 2.25v4.992m2.25 0h4.5" />
                    </svg>
                    <p class="font-bold text-gray-900 dark:text-white mt-4">Bảo hành 1 đổi 1 trong 15 tháng</p>
                </div>
                <div class="flex flex-col items-center text-center p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-500 dark:text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z" />
                    </svg>
                    <p class="font-bold text-gray-900 dark:text-white mt-4">Bảo hành nhanh chóng</p>
                </div>
                <div class="flex flex-col items-center text-center p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-500 dark:text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.47-1.678 3.122A11.954 11.954 0 0 1 12 21c-2.647 0-5.195-.604-7.422-1.758C3.63 14.47 3 13.268 3 12c0-1.268.63-2.47 1.678-3.122A11.954 11.954 0 0 1 12 3c2.647 0 5.195.604 7.422 1.758C20.37 9.53 21 10.732 21 12z" />
                    </svg>
                    <p class="font-bold text-gray-900 dark:text-white mt-4">Hỗ trợ khách trọn đời</p>
                </div>
                <div class="flex flex-col items-center text-center p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-500 dark:text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.13 1.13 0 0 0-.987 1.106v.958m12 0a2.25 2.25 0 0 0-2.25-2.25H5.25a2.25 2.25 0 0 0-2.25 2.25m13.5 0v-4.125c0-.621-.504-1.125-1.125-1.125H4.125a1.125 1.125 0 0 0-1.125 1.125V14.25" />
                    </svg>
                    <p class="font-bold text-gray-900 dark:text-white mt-4">Vận chuyển hoả tốc toàn quốc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Technical Details Section -->
    <section class="my-16">
        <h2 class="text-3xl font-bold text-center mb-8">Thông tin chi tiết sản phẩm</h2>
        <div class="virical-dark-bg rounded-lg p-8 max-w-4xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="border-b border-gray-700 pb-4">
                    <strong class="virical-yellow-text">Phiên bản:</strong> 15W, 24W
                </div>
                <div class="border-b border-gray-700 pb-4">
                    <strong class="virical-yellow-text">Nguồn:</strong> 220–240V
                </div>
                <div class="border-b border-gray-700 pb-4">
                    <strong class="virical-yellow-text">Kết nối:</strong> Zigbee
                </div>
                <div class="border-b border-gray-700 pb-4">
                    <strong class="virical-yellow-text">Tương thích:</strong> Apple HomeKit, Virical Home App
                </div>
                <div class="border-b border-gray-700 pb-4">
                    <strong class="virical-yellow-text">Điều khiển:</strong> Lịch, hẹn giờ, điều chỉnh độ sáng
                </div>
                <div class="border-b border-gray-700 pb-4">
                    <strong class="virical-yellow-text">Bảo hành:</strong> 12 tháng
                </div>
            </div>
        </div>
    </section>

    <!-- Product Description Section -->
    <section class="my-16 max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-8">Virical Dual Smart Dimmer T2 Zigbee – Giải pháp chiếu sáng thông minh</h2>
        <div class="text-gray-300 space-y-4 text-lg">
            <p>Thay đổi độ sáng, nhiệt độ màu của các đèn âm trần (Downlight) một cách linh hoạt.</p>
            <p>Đầu vào 220–240V, cho phép kết nối trực tiếp mà không cần nguồn chuyển đổi phức tạp.</p>
            <p>Tương thích hoàn toàn với hệ sinh thái Apple HomeKit và ứng dụng Virical Home, mang lại trải nghiệm đồng bộ.</p>
            <p>Điều khiển từ xa qua ứng dụng Virical Home, cho phép bạn quản lý hệ thống chiếu sáng mọi lúc, mọi nơi.</p>
            <p>Thích hợp cho các loại đèn downlight hoặc spotlight có driver rời, dễ dàng nâng cấp hệ thống hiện có.</p>
            <p>Kết hợp cùng các thiết bị Virical Home khác để tạo nên một hệ thống nhà thông minh hoàn chỉnh và tự động.</p>
        </div>
    </section>

    <!-- Quality Commitment Section -->
    <section class="my-16 virical-dark-bg rounded-lg p-8 max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-8 virical-yellow-text">Cam kết chất lượng từ Virical</h2>
        <ul class="space-y-4 text-lg list-disc list-inside">
            <li>Sản phẩm chính hãng, được bảo hành 12 tháng theo tiêu chuẩn nhà sản xuất.</li>
            <li>Hoàn tiền 100% nếu phát hiện hàng giả, hàng nhái, hàng kém chất lượng.</li>
            <li>Hỗ trợ đổi trả trong vòng 7 ngày nếu sản phẩm có lỗi từ nhà sản xuất.</li>
        </ul>
    </section>

    <!-- Final CTA Section -->
    <section class="my-16 text-center max-w-3xl mx-auto">
        <p class="text-xl text-gray-300 mb-6">Liên hệ ngay để nhận tư vấn và báo giá sản phẩm Virical Dual Smart Dimmer T2 Zigbee Driver Quốc Tế.</p>
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            <button class="virical-yellow font-bold py-3 px-8 rounded-lg text-lg w-full sm:w-auto hover:opacity-90 transition-opacity">NHẬN BÁO GIÁ NGAY</button>
            <div class="flex w-full sm:w-auto">
                <input type="tel" placeholder="Nhập số điện thoại của bạn" class="cta-input p-3 rounded-l-lg w-full focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button class="bg-gray-700 text-white font-bold p-3 rounded-r-lg hover:bg-gray-600 transition-colors">GỬI ĐI</button>
            </div>
        </div>
    </section>

</div>

<script>
    let slideIndex = 0;
    showSlides();

    function changeSlide(n) {
        slideIndex += n;
        showSlides();
    }

    function showSlides() {
        let slides = document.getElementsByClassName("slide");
        if (slideIndex >= slides.length) {slideIndex = 0}
        if (slideIndex < 0) {slideIndex = slides.length - 1}
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex].style.display = "block";
    }
</script>

</body>
</html>
