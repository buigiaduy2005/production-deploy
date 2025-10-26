<?php
/**
 * The template for displaying single products using the standard WordPress loop.
 *
 * @package Virical
 */

get_header();
?>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #FFFFFF;
    }
    .breadcrumb a {
        color: #9CA3AF;
        transition: color 0.2s;
    }
    .breadcrumb a:hover {
        color: #3B82F6;
    }
    .product-image-container {
        position: relative;
        overflow: hidden;
    }
    .product-image {
        transition: transform 0.3s ease;
    }
    .product-image-container:hover .product-image {
        transform: scale(1.05);
    }
    .add-to-cart-btn {
        background-color: #3B82F6;
        color: white;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        text-align: center;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    .add-to-cart-btn:hover {
        background-color: #2563EB;
    }
    .product-description h3 {
        font-size: 20px;
        font-weight: 600;
        color: #1E40AF;
        margin-top: 20px;
        margin-bottom: 10px;
    }
</style>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-24">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <!-- Breadcrumb -->
    <nav class="breadcrumb text-sm mb-8">
        <a href="/">Trang chủ</a> &gt;
        <a href="/san-pham">Sản phẩm</a> &gt;
        <span class="text-gray-500"><?php the_title(); ?></span>
    </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Left: Product Image -->
                    <div class="product-image-container rounded-lg shadow-sm">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title_attribute(); ?>" class="product-image w-full h-auto object-cover rounded-lg">
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/default-product.jpg'; ?>" alt="Placeholder Image" class="product-image w-full h-auto object-cover rounded-lg">
                        <?php endif; ?>
                    </div>

                    <!-- Right: Product Info -->
                    <div class="flex flex-col space-y-4">
                        <h1 class="text-3xl font-bold text-black" style="color: black !important;"><?php the_title(); ?></h1>
                        
                        <div class="text-xl font-semibold text-blue-600">
                            Hãy liên hệ với chúng tôi để được giá ưu đãi nhất
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <a href="/lien-he/" class="px-6 py-3 text-center bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-colors w-full">Liên hệ</a>
                        </div>

                        <div class="pt-6">
                            <p class="text-sm text-gray-600 mb-2">Để lại số điện thoại, chúng tôi sẽ gọi lại ngay</p>
                            <div class="flex">
                                <input type="tel" placeholder="Nhập số điện thoại" class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button class="px-6 py-2 bg-blue-700 text-white font-semibold rounded-r-md hover:bg-blue-800 transition-colors">Gửi đi</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description Section -->
                <div class="product-description bg-white p-6 md:p-8 rounded-lg shadow-sm mt-12">
                    <h2 class="text-2xl font-bold text-black mb-4" style="color: black !important;">Mô tả sản phẩm</h2>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Commitment Box -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h3 class="text-center font-bold text-black uppercase tracking-wider text-sm mb-4" style="color: black !important;">Cam kết chính hiệu bởi</h3>
                    <div class="flex items-center justify-center space-x-4 mb-5">
                        <img src="<?php echo get_template_directory_uri() . '/assets/images/logo_virical1.png'; ?>" alt="Virical Logo" class="h-12">
                        <span class="text-gray-700 font-semibold text-sm leading-tight">Phân phối Virical<br>chính hãng tại Việt Nam</span>
                    </div>
                    <div class="space-y-3 text-gray-600 text-sm">
                        <div class="flex items-center p-3 bg-gray-50 rounded-md">
                            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 20.417l4.5-4.5M12 14a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                            <span>Hoàn tiền 100% nếu phát hiện hàng giả</span>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-md">
                            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M4 20h5v-5M20 4h-5v5"></path></svg>
                            <span>Đổi trả trong 7 ngày nếu lỗi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endwhile; else : ?>

        <p class="text-center text-2xl">Sản phẩm không được tìm thấy.</p>

    <?php endif; ?>

</div>

<?php get_footer(); ?>
