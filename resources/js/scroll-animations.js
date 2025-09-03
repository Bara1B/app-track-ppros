// Scroll-triggered fade animations
class ScrollAnimations {
    constructor() {
        this.observer = null;
        this.scrollProgressBar = null;
        this.init();
    }

    init() {
        // Delay setup to allow initial animations to complete
        setTimeout(() => {
            this.setupScrollProgress();
            this.setupIntersectionObserver();
            this.observeElements();
        }, 2000);
    }

    setupScrollProgress() {
        this.scrollProgressBar = document.querySelector('.scroll-progress');
        if (this.scrollProgressBar) {
            window.addEventListener('scroll', () => {
                this.updateScrollProgress();
            });
        }
    }

    updateScrollProgress() {
        if (!this.scrollProgressBar) return;

        const scrollTop = window.pageYOffset;
        const docHeight = document.body.offsetHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;

        this.scrollProgressBar.style.width = scrollPercent + '%';
    }

    setupIntersectionObserver() {
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-active');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '50px'
        });
    }

    observeElements() {
        // Only observe elements with fade-in classes, exclude initial-fade elements
        const elements = document.querySelectorAll('.fade-in, .fade-in-left, .fade-in-right, .fade-in-up, .fade-in-scale');

        elements.forEach(element => {
            if (!element.classList.contains('initial-fade')) {
                this.observer.observe(element);
            }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ScrollAnimations();
});
