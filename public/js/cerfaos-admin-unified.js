/* =========================================
   🎯 CERFAOS ADMIN UNIFIED INTERACTIONS
   ========================================= */

document.addEventListener('DOMContentLoaded', function() {
    
    // ═══════════════════════════════════════
    // 📱 SIDEBAR MANAGEMENT
    // ═══════════════════════════════════════
    
    const sidebar = document.getElementById('elegant-sidebar');
    const layout = document.querySelector('.layout');
    const sidebarToggle = document.getElementById('elegant-sidebar-toggle');
    
    // Toggle mobile sidebar with modern approach
    window.toggleMobileSidebar = function() {
        const toggle = document.getElementById('elegant-sidebar-toggle');
        
        if (sidebar) {
            const isOpen = sidebar.classList.contains('is-open');
            
            if (isOpen) {
                closeMobileSidebar();
            } else {
                openMobileSidebar();
            }
            
            // Toggle hamburger animation
            if (toggle) {
                toggle.classList.toggle('is-active');
            }
        }
    };
    
    // Maintain old function for compatibility
    window.toggleSidebar = window.toggleMobileSidebar;
    
    // Open mobile sidebar
    function openMobileSidebar() {
        sidebar.classList.add('is-open');
        document.body.style.overflow = 'hidden'; // Prevent scroll
        createMobileOverlay();
    }
    
    // Close mobile sidebar
    function closeMobileSidebar() {
        const toggle = document.getElementById('elegant-sidebar-toggle');
        
        sidebar.classList.remove('is-open');
        document.body.style.overflow = ''; // Restore scroll
        removeMobileOverlay();
        
        if (toggle) {
            toggle.classList.remove('is-active');
        }
    }
    
    // Create modern overlay for mobile sidebar
    function createMobileOverlay() {
        if (!document.querySelector('.mobile-sidebar-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'mobile-sidebar-overlay';
            document.body.appendChild(overlay);
            
            // Force reflow and animate in
            overlay.offsetHeight;
            overlay.classList.add('is-visible');
            
            // Close on overlay click
            overlay.addEventListener('click', closeMobileSidebar);
            
            // Close on escape key
            document.addEventListener('keydown', handleEscapeKey);
        }
    }
    
    // Remove mobile overlay
    function removeMobileOverlay() {
        const overlay = document.querySelector('.mobile-sidebar-overlay');
        if (overlay) {
            overlay.classList.remove('is-visible');
            
            setTimeout(() => {
                if (overlay.parentNode) {
                    overlay.remove();
                }
                document.removeEventListener('keydown', handleEscapeKey);
            }, 300);
        }
    }
    
    // Handle escape key press
    function handleEscapeKey(e) {
        if (e.key === 'Escape') {
            closeMobileSidebar();
        }
    }
    
    // Close sidebar when clicking on main content (mobile only)
    function initMobileContentClick() {
        if (window.innerWidth <= 1024) {
            document.addEventListener('click', function(e) {
                const mainContent = document.querySelector('.layout__main');
                const sidebarOpen = sidebar && sidebar.classList.contains('is-open');
                
                if (sidebarOpen && mainContent && mainContent.contains(e.target)) {
                    closeMobileSidebar();
                }
            });
        }
    }
    
    // Initialize mobile interactions
    initMobileContentClick();
    initSwipeToClose();
    
    // Initialize mobile swipe gestures for sidebar
    function initSwipeToClose() {
        if (!sidebar) return;
        
        let startX = 0;
        let currentX = 0;
        let isDragging = false;
        
        sidebar.addEventListener('touchstart', function(e) {
            if (window.innerWidth <= 1024 && sidebar.classList.contains('is-open')) {
                startX = e.touches[0].clientX;
                isDragging = false;
            }
        });
        
        sidebar.addEventListener('touchmove', function(e) {
            if (window.innerWidth <= 1024 && sidebar.classList.contains('is-open')) {
                currentX = e.touches[0].clientX;
                const deltaX = currentX - startX;
                
                // Only allow swipe left (negative deltaX)
                if (deltaX < -50) {
                    isDragging = true;
                    // Add visual feedback
                    sidebar.style.transform = `translateX(${Math.max(deltaX, -280)}px)`;
                    sidebar.style.opacity = Math.max(1 + deltaX / 280, 0.3);
                }
            }
        });
        
        sidebar.addEventListener('touchend', function(e) {
            if (window.innerWidth <= 1024 && sidebar.classList.contains('is-open')) {
                const deltaX = currentX - startX;
                
                // Reset styles
                sidebar.style.transform = '';
                sidebar.style.opacity = '';
                
                // Close if swiped far enough left
                if (isDragging && deltaX < -100) {
                    closeMobileSidebar();
                }
                
                isDragging = false;
            }
        });
    }
    
    // ═══════════════════════════════════════
    // 📋 SUBMENU MANAGEMENT
    // ═══════════════════════════════════════
    
    window.toggleSubmenu = function(event, submenuId) {
        event.preventDefault();
        
        const link = event.currentTarget;
        const submenu = document.getElementById(submenuId);
        
        if (submenu) {
            const isExpanded = submenu.classList.contains('is-expanded');
            const isMobile = window.innerWidth <= 768;
            
            // Close all other submenus
            document.querySelectorAll('.sidebar__submenu.is-expanded').forEach(menu => {
                if (menu !== submenu) {
                    menu.classList.remove('is-expanded');
                    const parentLink = document.querySelector(`[onclick="toggleSubmenu(event, '${menu.id}')"]`);
                    if (parentLink) {
                        parentLink.classList.remove('is-expanded');
                    }
                }
            });
            
            // Toggle current submenu
            if (isExpanded) {
                submenu.classList.remove('is-expanded');
                link.classList.remove('is-expanded');
            } else {
                submenu.classList.add('is-expanded');
                link.classList.add('is-expanded');
                
                // On mobile, trigger animation for submenu links
                if (isMobile) {
                    const submenuLinks = submenu.querySelectorAll('.sidebar__submenu-link');
                    submenuLinks.forEach((sublink, index) => {
                        setTimeout(() => {
                            sublink.style.opacity = '1';
                            sublink.style.transform = 'translateX(0)';
                        }, 50 + (index * 25));
                    });
                }
            }
        }
    };
    
    // ═══════════════════════════════════════
    // 🔽 DROPDOWN MANAGEMENT
    // ═══════════════════════════════════════
    
    window.toggleDropdown = function(event, dropdown) {
        event.preventDefault();
        event.stopPropagation();
        
        const isOpen = dropdown.classList.contains('is-open');
        
        // Close all dropdowns
        document.querySelectorAll('.header__dropdown.is-open').forEach(dd => {
            dd.classList.remove('is-open');
        });
        
        // Toggle current dropdown
        if (!isOpen) {
            dropdown.classList.add('is-open');
        }
    };
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.header__dropdown')) {
            document.querySelectorAll('.header__dropdown.is-open').forEach(dd => {
                dd.classList.remove('is-open');
            });
        }
    });
    
    // ═══════════════════════════════════════
    // 🖥️ FULLSCREEN TOGGLE
    // ═══════════════════════════════════════
    
    window.toggleFullscreen = function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.warn('Fullscreen not supported:', err);
            });
        } else {
            document.exitFullscreen().catch(err => {
                console.warn('Exit fullscreen not supported:', err);
            });
        }
    };
    
    // ═══════════════════════════════════════
    // 🔍 SEARCH FUNCTIONALITY
    // ═══════════════════════════════════════
    
    const searchInput = document.querySelector('.header__search-input');
    let searchTimeout;
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    performSearch(query);
                }, 300);
            }
        });
        
        searchInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const query = this.value.trim();
                if (query.length >= 2) {
                    performSearch(query);
                }
            }
        });
    }
    
    function performSearch(query) {
        // Cette fonction peut être étendue pour implémenter la recherche globale
        console.log('Searching for:', query);
        
        // Exemple d'implementation avec fetch API
        /*
        fetch(`/admin/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data.results);
            })
            .catch(error => {
                console.error('Search error:', error);
            });
        */
    }
    
    // ═══════════════════════════════════════
    // 📱 RESPONSIVE BEHAVIOR
    // ═══════════════════════════════════════
    
    function handleResize() {
        const width = window.innerWidth;
        
        if (width > 1024) {
            // Desktop: ensure sidebar is visible and no overlay
            if (sidebar) {
                sidebar.classList.remove('is-open');
            }
            removeMobileOverlay();
        }
    }
    
    window.addEventListener('resize', handleResize);
    handleResize(); // Initial check
    
    // ═══════════════════════════════════════
    // 🎨 FEATHER ICONS ACTIVATION
    // ═══════════════════════════════════════
    
    // Initialize Feather icons if available
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    // Re-initialize icons after dynamic content changes
    window.refreshIcons = function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    };
    
    // ═══════════════════════════════════════
    // 🎯 ACTIVE STATES MANAGEMENT
    // ═══════════════════════════════════════
    
    // Update active sidebar links based on current route
    function updateActiveStates() {
        const currentPath = window.location.pathname;
        
        document.querySelectorAll('.sidebar__link, .sidebar__submenu-link').forEach(link => {
            const href = link.getAttribute('href');
            if (href && href !== '#') {
                if (currentPath === href || currentPath.startsWith(href + '/')) {
                    link.classList.add('is-active');
                    
                    // If it's a submenu link, expand parent
                    if (link.classList.contains('sidebar__submenu-link')) {
                        const submenu = link.closest('.sidebar__submenu');
                        if (submenu) {
                            submenu.classList.add('is-expanded');
                            const parentLink = document.querySelector(`[onclick*="${submenu.id}"]`);
                            if (parentLink) {
                                parentLink.classList.add('is-expanded');
                            }
                        }
                    }
                } else {
                    link.classList.remove('is-active');
                }
            }
        });
    }
    
    // Initial active state update
    updateActiveStates();
    
    // ═══════════════════════════════════════
    // ⚡ PERFORMANCE OPTIMIZATIONS
    // ═══════════════════════════════════════
    
    // Debounce function for performance
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Throttle function for scroll events
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
    
    // ═══════════════════════════════════════
    // 🎭 ANIMATIONS & TRANSITIONS
    // ═══════════════════════════════════════
    
    // Add loading states for buttons
    window.addButtonLoading = function(button) {
        if (button && !button.disabled) {
            button.disabled = true;
            const originalText = button.innerHTML;
            button.dataset.originalText = originalText;
            button.innerHTML = '<i data-feather="loader" class="animate-spin"></i> Chargement...';
            refreshIcons();
        }
    };
    
    window.removeButtonLoading = function(button) {
        if (button && button.dataset.originalText) {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText;
            delete button.dataset.originalText;
            refreshIcons();
        }
    };
    
    // ═══════════════════════════════════════
    // 🔔 NOTIFICATIONS SYSTEM
    // ═══════════════════════════════════════
    
    window.showNotification = function(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `notification notification--${type}`;
        notification.style.cssText = `
            position: fixed;
            top: var(--cerfaos-space-4);
            right: var(--cerfaos-space-4);
            background: var(--cerfaos-bg-white);
            border: 1px solid var(--cerfaos-border);
            border-left: 4px solid var(--cerfaos-${type === 'error' ? 'danger' : type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'accent'});
            border-radius: var(--cerfaos-radius-lg);
            padding: var(--cerfaos-space-4);
            box-shadow: var(--cerfaos-shadow-lg);
            z-index: var(--cerfaos-z-tooltip);
            max-width: 400px;
            transform: translateX(100%);
            transition: var(--cerfaos-transition);
        `;
        
        notification.innerHTML = `
            <div class="u-flex u-items-center u-gap-3">
                <div style="color: var(--cerfaos-${type === 'error' ? 'danger' : type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'accent'});">
                    <i data-feather="${type === 'error' ? 'x-circle' : type === 'success' ? 'check-circle' : type === 'warning' ? 'alert-triangle' : 'info'}"></i>
                </div>
                <div style="flex: 1; color: var(--cerfaos-text-primary); font-size: var(--cerfaos-font-size-sm);">${message}</div>
                <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; color: var(--cerfaos-text-muted); cursor: pointer; padding: var(--cerfaos-space-1);">
                    <i data-feather="x" style="width: 16px; height: 16px;"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        refreshIcons();
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        // Auto remove
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, duration);
    };
    
    // ═══════════════════════════════════════
    // 🎭 ENHANCED INTERACTIONS
    // ═══════════════════════════════════════
    
    // Add ripple effect to buttons
    function createRipple(event) {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            pointer-events: none;
            transform: scale(0);
            animation: rippleEffect 0.6s ease-out;
        `;
        
        button.style.position = 'relative';
        button.style.overflow = 'hidden';
        button.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
    
    // Add ripple to enhanced buttons
    document.querySelectorAll('.btn.cerfaos-enhanced').forEach(button => {
        button.addEventListener('click', createRipple);
    });
    
    // Enhanced hover effects for cards
    document.querySelectorAll('.card.cerfaos-enhanced').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.01)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Parallax effect for floating elements
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallax = scrolled * 0.1;
        
        document.querySelectorAll('.cerfaos-float').forEach((element, index) => {
            element.style.transform = `translateY(${parallax + (index * 2)}px)`;
        });
    });
    
    // Progressive enhancement for stat numbers
    function animateNumbers() {
        document.querySelectorAll('.stat-number').forEach(element => {
            const target = parseInt(element.textContent);
            if (target > 0) {
                let current = 0;
                const increment = target / 30;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    element.textContent = Math.floor(current);
                }, 50);
            }
        });
    }
    
    // Trigger number animation when stats come into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                entry.target.classList.add('animated');
                setTimeout(animateNumbers, 200);
            }
        });
    });
    
    document.querySelectorAll('.stat-card').forEach(card => {
        observer.observe(card);
    });
    
    // Enhanced form interactions
    document.querySelectorAll('.form-field.cerfaos-enhanced input, .form-field.cerfaos-enhanced textarea').forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.form-field').classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.closest('.form-field').classList.remove('focused');
        });
        
        input.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.closest('.form-field').classList.add('has-value');
            } else {
                this.closest('.form-field').classList.remove('has-value');
            }
        });
    });
    
    // Page transition effects
    function addPageTransitions() {
        // Fade in elements as they come into view
        const fadeElements = document.querySelectorAll('.cerfaos-animate-fade-in-up, .cerfaos-animate-fade-in-left, .cerfaos-animate-fade-in-right');
        
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, { threshold: 0.1 });
        
        fadeElements.forEach(element => {
            element.style.animationPlayState = 'paused';
            fadeObserver.observe(element);
        });
    }
    
    // Initialize page transitions
    setTimeout(addPageTransitions, 100);
    
    // Enhanced notification system with progress bar
    window.showNotificationEnhanced = function(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `notification notification--${type} cerfaos-enhanced`;
        notification.style.cssText = `
            position: fixed;
            top: var(--cerfaos-space-4);
            right: var(--cerfaos-space-4);
            background: var(--cerfaos-bg-white);
            border: 1px solid var(--cerfaos-border);
            border-left: 4px solid var(--cerfaos-${type === 'error' ? 'danger' : type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'accent'});
            border-radius: var(--cerfaos-radius-lg);
            padding: var(--cerfaos-space-4);
            box-shadow: var(--cerfaos-shadow-lg);
            z-index: var(--cerfaos-z-tooltip);
            max-width: 400px;
            transform: translateX(100%);
            transition: var(--cerfaos-transition);
            overflow: hidden;
        `;
        
        notification.innerHTML = `
            <div class="u-flex u-items-center u-gap-3">
                <div style="color: var(--cerfaos-${type === 'error' ? 'danger' : type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'accent'});">
                    <i data-feather="${type === 'error' ? 'x-circle' : type === 'success' ? 'check-circle' : type === 'warning' ? 'alert-triangle' : 'info'}"></i>
                </div>
                <div style="flex: 1; color: var(--cerfaos-text-primary); font-size: var(--cerfaos-font-size-sm);">${message}</div>
                <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; color: var(--cerfaos-text-muted); cursor: pointer; padding: var(--cerfaos-space-1);">
                    <i data-feather="x" style="width: 16px; height: 16px;"></i>
                </button>
            </div>
            <div class="progress-bar" style="position: absolute; bottom: 0; left: 0; height: 3px; background: var(--cerfaos-${type === 'error' ? 'danger' : type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'accent'}); width: 100%; transform-origin: left; animation: progressShrink ${duration}ms linear;"></div>
        `;
        
        document.body.appendChild(notification);
        refreshIcons();
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        // Auto remove
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, duration);
    };
    
    // ═══════════════════════════════════════
    // 🚀 INITIALIZATION COMPLETE
    // ═══════════════════════════════════════
    
    console.log('🏔️ CERFAOS Admin Unified System initialized with enhanced animations');
});

// ═══════════════════════════════════════
// 📊 CSS ANIMATIONS
// ═══════════════════════════════════════

// Add CSS animations dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from { transform: translateX(-20px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .animate-slide-in {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes rippleEffect {
        0% { transform: scale(0); opacity: 1; }
        100% { transform: scale(4); opacity: 0; }
    }
    
    @keyframes progressShrink {
        from { transform: scaleX(1); }
        to { transform: scaleX(0); }
    }
    
    @keyframes morphBorder {
        0%, 100% { border-radius: var(--cerfaos-radius-md); }
        50% { border-radius: var(--cerfaos-radius-xl); }
    }
    
    /* Enhanced form states */
    .form-field.cerfaos-enhanced.focused .form-field__label {
        color: var(--cerfaos-accent);
        transform: scale(0.9) translateY(-2px);
    }
    
    .form-field.cerfaos-enhanced.has-value .form-field__label {
        transform: scale(0.9) translateY(-2px);
    }
    
    .form-field.cerfaos-enhanced input:focus,
    .form-field.cerfaos-enhanced textarea:focus {
        animation: morphBorder 2s ease-in-out infinite;
    }
    
    /* Notification animations */
    .notification {
        animation: slideInRight 0.3s ease-out;
    }
    
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    /* Enhanced loading states */
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        animation: pulse 2s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 0.6; }
        50% { opacity: 0.8; }
    }
    
    /* Advanced hover enhancements */
    .card:hover:not(.cerfaos-enhanced),
    .sidebar__link:hover,
    .header__action:hover {
        transform: translateY(-1px);
    }
    
    .btn:hover:not(:disabled):not(.cerfaos-enhanced) {
        transform: translateY(-1px);
        box-shadow: var(--cerfaos-shadow-lg);
    }
    
    /* Staggered table row animations */
    .table.cerfaos-enhanced tbody tr {
        animation: fadeIn 0.4s ease-out backwards;
    }
    
    .table.cerfaos-enhanced tbody tr:nth-child(1) { animation-delay: 0.1s; }
    .table.cerfaos-enhanced tbody tr:nth-child(2) { animation-delay: 0.2s; }
    .table.cerfaos-enhanced tbody tr:nth-child(3) { animation-delay: 0.3s; }
    .table.cerfaos-enhanced tbody tr:nth-child(4) { animation-delay: 0.4s; }
    .table.cerfaos-enhanced tbody tr:nth-child(5) { animation-delay: 0.5s; }
    .table.cerfaos-enhanced tbody tr:nth-child(6) { animation-delay: 0.6s; }
    .table.cerfaos-enhanced tbody tr:nth-child(7) { animation-delay: 0.7s; }
    .table.cerfaos-enhanced tbody tr:nth-child(8) { animation-delay: 0.8s; }
    
    /* Parallax scrolling enhancements */
    .cerfaos-parallax {
        transition: transform 0.1s ease-out;
    }
    
    /* Advanced badge animations */
    .badge.cerfaos-pulse {
        animation: pulse 2s ease-in-out infinite;
        animation-delay: var(--delay, 0s);
    }
    
    .badge.cerfaos-shimmer {
        position: relative;
        overflow: hidden;
    }
    
    .badge.cerfaos-shimmer::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.6),
            transparent
        );
        animation: shimmerMove 2s infinite;
    }
    
    @keyframes shimmerMove {
        0% { left: -100%; }
        100% { left: 100%; }
    }
`;

document.head.appendChild(style);

// ═══════════════════════════════════════
// 📱 RESPONSIVE MOBILE MENU MANAGEMENT
// ═══════════════════════════════════════

// Handle window resize for responsive behavior
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('elegant-sidebar');
    const toggle = document.getElementById('elegant-sidebar-toggle');
    
    if (window.innerWidth > 768) {
        // Desktop mode - ensure sidebar is properly positioned and visible
        if (sidebar) {
            sidebar.classList.remove('is-open');
            // Reset any mobile-specific inline styles
            const allSidebarElements = sidebar.querySelectorAll('.sidebar__brand, .sidebar__section, .sidebar__link, .sidebar__submenu, .sidebar__submenu-link, .sidebar__widget');
            allSidebarElements.forEach(element => {
                element.style.opacity = '';
                element.style.transform = '';
            });
        }
        if (toggle) {
            toggle.classList.remove('is-active');
        }
        document.body.style.overflow = '';
        removeMobileOverlay();
    }
});

// Initialize mobile gestures if touch is supported
if ('ontouchstart' in window) {
    initializeMobileGestures();
}