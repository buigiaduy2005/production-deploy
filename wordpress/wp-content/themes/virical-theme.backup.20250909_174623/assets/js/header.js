jQuery(document).ready(function($) {
    // Header scroll behavior
    var header = $('#masthead');
    var scrollThreshold = 100;
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > scrollThreshold) {
            header.addClass('scrolled');
        } else {
            header.removeClass('scrolled');
        }
    });
    
    // Mobile menu toggle
    $('.menu-toggle').on('click', function() {
        $(this).toggleClass('active');
        $('.primary-menu-container').toggleClass('active');
        $('body').toggleClass('menu-open');
    });
    
    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.main-navigation').length && $('.menu-toggle').hasClass('active')) {
            $('.menu-toggle').removeClass('active');
            $('.primary-menu-container').removeClass('active');
            $('body').removeClass('menu-open');
        }
    });
    
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
});