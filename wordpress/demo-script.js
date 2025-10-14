// Auto demo script
setTimeout(() => {
    // Show loading complete
    document.body.classList.add('loaded');
    
    // Auto scroll demo after 3 seconds
    setTimeout(() => {
        window.scrollTo({
            top: window.innerHeight,
            behavior: 'smooth'
        });
    }, 3000);
}, 1000);

// Add keyboard shortcuts
document.addEventListener('keydown', (e) => {
    // Press 'L' to toggle light modes
    if (e.key === 'l' || e.key === 'L') {
        document.getElementById('lightController').click();
    }
    
    // Press 'P' for party mode
    if (e.key === 'p' || e.key === 'P') {
        document.getElementById('sceneSelect').value = 'party';
        document.getElementById('sceneSelect').dispatchEvent(new Event('change'));
    }
    
    // Press 'D' for dark mode
    if (e.key === 'd' || e.key === 'D') {
        document.getElementById('sceneSelect').value = 'sleep';
        document.getElementById('sceneSelect').dispatchEvent(new Event('change'));
    }
});

// Add smooth reveal on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all cards
document.querySelectorAll('.control-card, .product-card, .tech-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'all 0.6s ease';
    observer.observe(el);
});
