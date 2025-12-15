jQuery(document).ready(function($) {
    // Header scroll behavior
    var header = $('#site-header');
    var scrollThreshold = 100;
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > scrollThreshold) {
            header.addClass('scrolled');
        } else {
            header.removeClass('scrolled');
        }
    });
    
    // mobile menu toggle
    $('.menu-toggle').on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
        $('.main-navigation').toggleClass('active');
        $('body').toggleClass('menu-open');
    });
    
    // Dropdown menu handling for mobile
    $('.menu-item-has-children > a').on('click', function(e) {
        if ($(window).width() <= 768) {
            e.preventDefault();
            $(this).parent().toggleClass('submenu-open');
            $(this).next('.sub-menu').slideToggle(300);
        }
    });
    
    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.main-navigation').length && !$(e.target).closest('.menu-toggle').length && $('.menu-toggle').hasClass('active')) {
            $('.menu-toggle').removeClass('active');
            $('.main-navigation').removeClass('active');
            $('body').removeClass('menu-open');
            
            // Close all open submenus
            $('.submenu-open').removeClass('submenu-open');
            $('.sub-menu').slideUp(300);
        }
    });
    
    /*
    // Ensure dropdown menus work on hover for desktop
    $('.menu-item-has-children').hover(
        function() {
            if ($(window).width() > 768) {
                $(this).addClass('hover');
                $(this).find('.sub-menu').stop(true, true).fadeIn(300);
            }
        },
        function() {
            if ($(window).width() > 768) {
                $(this).removeClass('hover');
                $(this).find('.sub-menu').stop(true, true).fadeOut(300);
            }
        }
    );
    */
    
    // Smooth scroll for anchor links
    $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                event.preventDefault();
                var headerHeight = header.outerHeight();
                $('html, body').animate({
                    scrollTop: target.offset().top - headerHeight
                }, 800);
            }
        }
    });

    // Category widget accordion
    $('.product-categories-list .has-children .toggle-submenu').on('click', function() {
        var parentLi = $(this).closest('li');
        parentLi.toggleClass('open');
        parentLi.children('.sub-menu').slideToggle(300);
    });
});