document.addEventListener('DOMContentLoaded', function() {
    // --- DOM Elements ---
    const sidebar = document.querySelector('.sidebar');
    const pageContent = document.querySelector('.page-content');
    const toggleBtn = document.getElementById('sidebarToggle');
    const navbarToggle = document.querySelector('.js-sidebar-toggle');
    const root = document.documentElement;

    // --- Helper Functions ---
    const isMobile = () => window.innerWidth <= 768;
    
    // Debounce function for resize events
    const debounce = (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

    // Guard against cases where sidebar elements are not on the page
    if (!sidebar || !pageContent) {
        return;
    }

    // --- Accessibility ---
    /**
     * Updates the aria-expanded attribute on toggle buttons based on the sidebar's state.
     */
    function updateAriaExpanded() {
        const isExpanded = isMobile() ? sidebar.classList.contains('open') : !sidebar.classList.contains('collapsed');
        if (toggleBtn) {
            toggleBtn.setAttribute('aria-expanded', isExpanded);
        }
        if (navbarToggle) {
            navbarToggle.setAttribute('aria-expanded', isExpanded);
        }
    }

    // --- State Management ---
    /**
     * Initializes the sidebar's state based on localStorage and screen size.
     */
    function initSidebar() {
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        
        if (!isMobile() && isCollapsed) {
            sidebar.classList.add('collapsed');
            pageContent.classList.add('collapsed');
            root.classList.add('sidebar-collapsed');
        }
        updateAriaExpanded(); // Set initial state
        // Remove initializing class added before styles loaded
        root.classList.remove('sidebar-initializing');
    }

    /**
     * Toggles the sidebar's visibility for mobile (slide) and desktop (collapse).
     */
    function toggleSidebar() {
        // Prevent rapid clicking during animation
        if (sidebar.dataset.animating === 'true') {
            return;
        }
        
        sidebar.dataset.animating = 'true';
        
        if (isMobile()) {
            sidebar.classList.toggle('open');
            
            // Add/remove body scroll lock for mobile overlay
            if (sidebar.classList.contains('open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        } else {
            const isCollapsed = sidebar.classList.toggle('collapsed');
            pageContent.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
            
            if (isCollapsed) {
                root.classList.add('sidebar-collapsed');
            } else {
                root.classList.remove('sidebar-collapsed');
            }
        }
        
        updateAriaExpanded();
        
        // Reset animation lock after transition
        setTimeout(() => {
            sidebar.dataset.animating = 'false';
        }, 300);
    }

    // --- Event Listeners ---
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }
    
    if (navbarToggle) {
        navbarToggle.addEventListener('click', toggleSidebar);
    }

    // Close mobile sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (isMobile() && sidebar.classList.contains('open')) {
            const isClickInsideSidebar = sidebar.contains(e.target);
            const isClickOnToggle = (toggleBtn && toggleBtn.contains(e.target)) || 
                                   (navbarToggle && navbarToggle.contains(e.target));
            
            if (!isClickInsideSidebar && !isClickOnToggle) {
                sidebar.classList.remove('open');
                document.body.style.overflow = ''; // Restore scroll
                updateAriaExpanded();
            }
        }
    });
    
    // Handle escape key to close mobile sidebar
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isMobile() && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            document.body.style.overflow = '';
            updateAriaExpanded();
        }
    });

    // Handle window resize with debouncing
    const handleResize = debounce(() => {
        if (!isMobile()) {
            // Close mobile sidebar if switching to desktop
            if (sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                document.body.style.overflow = '';
            }
            
            // Apply desktop collapsed state from localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                pageContent.classList.add('collapsed');
                root.classList.add('sidebar-collapsed');
            } else {
                sidebar.classList.remove('collapsed');
                pageContent.classList.remove('collapsed');
                root.classList.remove('sidebar-collapsed');
            }
        } else {
            // On mobile, ensure desktop collapsed classes are removed
            sidebar.classList.remove('collapsed');
            pageContent.classList.remove('collapsed');
            root.classList.remove('sidebar-collapsed');
        }
        updateAriaExpanded();
    }, 150);
    
    window.addEventListener('resize', handleResize);

    // Initialize
    initSidebar();
    
    // Add smooth focus management for accessibility
    if (toggleBtn) {
        toggleBtn.addEventListener('focus', function() {
            this.style.outline = '2px solid var(--sidebar-active)';
            this.style.outlineOffset = '2px';
        });
        
        toggleBtn.addEventListener('blur', function() {
            this.style.outline = '';
            this.style.outlineOffset = '';
        });
    }
    
    if (navbarToggle) {
        navbarToggle.addEventListener('focus', function() {
            this.style.outline = '2px solid var(--sidebar-active)';
            this.style.outlineOffset = '2px';
        });
        
        navbarToggle.addEventListener('blur', function() {
            this.style.outline = '';
            this.style.outlineOffset = '';
        });
    }
});
