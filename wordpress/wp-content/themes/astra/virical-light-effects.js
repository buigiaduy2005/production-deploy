/**
 * Virical Smart Light Effects
 * Hiệu ứng ánh sáng thông minh khi cuộn trang
 */

document.addEventListener('DOMContentLoaded', function() {
    // Tạo overlay cho hiệu ứng ánh sáng
    const lightOverlay = document.createElement('div');
    lightOverlay.className = 'virical-light-overlay';
    lightOverlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 9999;
        transition: all 0.3s ease;
        mix-blend-mode: multiply;
    `;
    document.body.appendChild(lightOverlay);

    // Tạo gradient động cho ánh sáng
    const createLightGradient = (scrollPercent) => {
        // Tính toán màu sắc dựa trên vị trí cuộn
        let color1, color2, opacity;
        
        if (scrollPercent < 20) {
            // Ánh sáng trắng sáng - Buổi sáng
            color1 = 'rgba(255, 255, 255, 0.1)';
            color2 = 'rgba(255, 251, 235, 0.05)';
            opacity = 0.3;
        } else if (scrollPercent < 40) {
            // Ánh sáng vàng ấm - Buổi trưa
            color1 = 'rgba(255, 223, 134, 0.15)';
            color2 = 'rgba(255, 193, 7, 0.08)';
            opacity = 0.4;
        } else if (scrollPercent < 60) {
            // Ánh sáng cam - Buổi chiều
            color1 = 'rgba(255, 152, 0, 0.2)';
            color2 = 'rgba(255, 87, 34, 0.1)';
            opacity = 0.5;
        } else if (scrollPercent < 80) {
            // Ánh sáng tím - Hoàng hôn
            color1 = 'rgba(156, 39, 176, 0.15)';
            color2 = 'rgba(103, 58, 183, 0.08)';
            opacity = 0.6;
        } else {
            // Ánh sáng xanh dương - Buổi tối
            color1 = 'rgba(33, 150, 243, 0.2)';
            color2 = 'rgba(13, 71, 161, 0.15)';
            opacity = 0.7;
        }

        return {
            gradient: `radial-gradient(ellipse at center top, ${color1} 0%, ${color2} 100%)`,
            opacity: opacity
        };
    };

    // Tạo đèn LED động
    const createFloatingLights = () => {
        const lightsContainer = document.createElement('div');
        lightsContainer.className = 'floating-lights-container';
        lightsContainer.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9998;
        `;
        
        // Tạo 20 điểm sáng
        for (let i = 0; i < 20; i++) {
            const light = document.createElement('div');
            light.className = 'floating-light';
            light.style.cssText = `
                position: absolute;
                width: ${Math.random() * 4 + 2}px;
                height: ${Math.random() * 4 + 2}px;
                background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, transparent 70%);
                border-radius: 50%;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                animation: float ${Math.random() * 10 + 10}s ease-in-out infinite;
                animation-delay: ${Math.random() * 5}s;
            `;
            lightsContainer.appendChild(light);
        }
        
        document.body.appendChild(lightsContainer);
    };

    // CSS cho animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }
            25% {
                transform: translate(30px, -30px) scale(1.2);
                opacity: 0.6;
            }
            50% {
                transform: translate(-20px, 20px) scale(0.8);
                opacity: 0.4;
            }
            75% {
                transform: translate(40px, 40px) scale(1.1);
                opacity: 0.7;
            }
        }

        .virical-section {
            position: relative;
            overflow: hidden;
        }

        .virical-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, transparent 30%, rgba(0,0,0,0.1) 70%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Hiệu ứng glow cho text */
        .virical-glow-text {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5),
                         0 0 20px rgba(255, 255, 255, 0.3),
                         0 0 30px rgba(255, 255, 255, 0.2);
            transition: text-shadow 0.3s ease;
        }

        .virical-glow-text:hover {
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.8),
                         0 0 30px rgba(255, 255, 255, 0.6),
                         0 0 45px rgba(255, 255, 255, 0.4);
        }

        /* Nút điều khiển đèn */
        .light-control-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            z-index: 10000;
        }

        .light-control-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .light-control-btn::before {
            content: '💡';
            font-size: 24px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    `;
    document.head.appendChild(style);

    // Xử lý sự kiện cuộn
    let lastScrollTop = 0;
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / scrollHeight) * 100;
        
        // Cập nhật hiệu ứng ánh sáng
        const lightEffect = createLightGradient(scrollPercent);
        lightOverlay.style.background = lightEffect.gradient;
        lightOverlay.style.opacity = lightEffect.opacity;
        
        // Hiệu ứng parallax cho các section
        const sections = document.querySelectorAll('.virical-section');
        sections.forEach((section, index) => {
            const speed = 0.5 + (index * 0.1);
            const yPos = -(scrollTop * speed);
            section.style.transform = `translateY(${yPos}px)`;
        });
        
        lastScrollTop = scrollTop;
    });

    // Tạo nút điều khiển đèn
    const lightControlBtn = document.createElement('button');
    lightControlBtn.className = 'light-control-btn';
    lightControlBtn.title = 'Điều khiển ánh sáng';
    
    let lightMode = 'auto';
    lightControlBtn.addEventListener('click', () => {
        if (lightMode === 'auto') {
            lightMode = 'bright';
            document.body.style.filter = 'brightness(1.2)';
        } else if (lightMode === 'bright') {
            lightMode = 'warm';
            document.body.style.filter = 'sepia(0.3) brightness(1.1)';
        } else if (lightMode === 'warm') {
            lightMode = 'cool';
            document.body.style.filter = 'hue-rotate(180deg) brightness(0.9)';
        } else if (lightMode === 'cool') {
            lightMode = 'dim';
            document.body.style.filter = 'brightness(0.7)';
        } else {
            lightMode = 'auto';
            document.body.style.filter = 'none';
        }
    });
    
    document.body.appendChild(lightControlBtn);
    
    // Khởi tạo hiệu ứng
    createFloatingLights();
    
    // Hiệu ứng hover cho sản phẩm
    document.addEventListener('mousemove', (e) => {
        const products = document.querySelectorAll('.product');
        products.forEach(product => {
            const rect = product.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            if (x >= 0 && x <= rect.width && y >= 0 && y <= rect.height) {
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const deltaX = (x - centerX) / centerX;
                const deltaY = (y - centerY) / centerY;
                
                product.style.transform = `
                    perspective(1000px)
                    rotateX(${deltaY * -10}deg)
                    rotateY(${deltaX * 10}deg)
                    translateZ(20px)
                `;
                product.style.boxShadow = `
                    ${deltaX * 20}px ${deltaY * 20}px 40px rgba(0,0,0,0.1),
                    0 0 60px rgba(255,255,255,0.1)
                `;
            } else {
                product.style.transform = '';
                product.style.boxShadow = '';
            }
        });
    });
});