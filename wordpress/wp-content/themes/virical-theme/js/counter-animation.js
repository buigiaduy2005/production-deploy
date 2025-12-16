jQuery(document).ready(function ($) {
    let intervalSet = false; // Flag to ensure interval is only set once

    // Counter Animation
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60 FPS
        let current = 0;

        const timer = setInterval(function () {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }

            // Update the number, keep the suffix (+ or %)
            const suffix = element.getAttribute('data-suffix') || '';
            element.textContent = Math.floor(current) + suffix;
        }, 16);
    }

    // Function to reset and animate all counters
    function resetAndAnimateCounters() {
        $('.highlight-number[data-target]').each(function () {
            // Reset to 0
            const suffix = $(this).attr('data-suffix') || '';
            $(this).text('0' + suffix);

            // Animate
            animateCounter(this);
        });
    }

    // Intersection Observer to trigger animation when visible
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                entry.target.classList.add('counted');
                animateCounter(entry.target);

                // Set interval only once for all counters
                if (!intervalSet) {
                    intervalSet = true;
                    setInterval(function () {
                        resetAndAnimateCounters();
                    }, 300000); // 5 minutes = 300000 ms
                }
            }
        });
    }, observerOptions);

    // Observe all counter elements
    $('.highlight-number[data-target]').each(function () {
        observer.observe(this);
    });
});
