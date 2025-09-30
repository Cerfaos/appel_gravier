/**
 * CERFAOS BLOG - ENHANCED INTERACTIONS
 * Modern, Accessible, Performance-Optimized JavaScript
 */

(function() {
    'use strict';
    
    // ===== CONFIGURATION =====
    const CONFIG = {
        animations: {
            duration: 300,
            easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
            reduceMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches
        },
        intersection: {
            rootMargin: '10% 0px -10% 0px',
            threshold: [0, 0.1, 0.5, 1]
        },
        debounce: {
            scroll: 16,
            resize: 250,
            search: 300
        }
    };
    
    // ===== UTILITY FUNCTIONS =====
    
    /**
     * Debounce function for performance optimization
     */
    function debounce(func, wait, immediate = false) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func(...args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func(...args);
        };
    }
    
    /**
     * Check if element is in viewport
     */
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
    
    /**
     * Add class with animation support
     */
    function animateClass(element, className, duration = CONFIG.animations.duration) {
        if (CONFIG.animations.reduceMotion) {
            element.classList.add(className);
            return Promise.resolve();
        }
        
        return new Promise(resolve => {
            element.classList.add(className);
            setTimeout(resolve, duration);
        });
    }
    
    /**
     * Smooth scroll to element
     */
    function smoothScrollTo(target, offset = 0) {
        const targetElement = typeof target === 'string' ? document.querySelector(target) : target;
        if (!targetElement) return;
        
        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - offset;
        
        if ('scrollBehavior' in document.documentElement.style) {
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        } else {
            // Fallback for older browsers
            const startPosition = window.pageYOffset;
            const distance = targetPosition - startPosition;
            const duration = Math.min(Math.abs(distance) / 2, 1000);
            let start = null;
            
            function animation(currentTime) {
                if (start === null) start = currentTime;
                const timeElapsed = currentTime - start;
                const run = ease(timeElapsed, startPosition, distance, duration);
                window.scrollTo(0, run);
                if (timeElapsed < duration) requestAnimationFrame(animation);
            }
            
            function ease(t, b, c, d) {
                t /= d / 2;
                if (t < 1) return c / 2 * t * t + b;
                t--;
                return -c / 2 * (t * (t - 2) - 1) + b;
            }
            
            requestAnimationFrame(animation);
        }
    }
    
    // ===== INTERSECTION OBSERVER =====
    
    class ScrollAnimator {
        constructor() {
            this.observer = null;
            this.elements = new Set();
            this.init();
        }
        
        init() {
            if (!('IntersectionObserver' in window)) {
                // Fallback: add visible class to all elements
                document.querySelectorAll('.scroll-animate, .scroll-animate-left, .scroll-animate-right, .scroll-animate-scale')
                    .forEach(el => el.classList.add('is-visible'));
                return;
            }
            
            this.observer = new IntersectionObserver(this.handleIntersection.bind(this), CONFIG.intersection);
            this.observeElements();
        }
        
        observeElements() {
            const selectors = [
                '.scroll-animate',
                '.scroll-animate-left', 
                '.scroll-animate-right',
                '.scroll-animate-scale'
            ];
            
            selectors.forEach(selector => {
                document.querySelectorAll(selector).forEach(el => {
                    if (!this.elements.has(el)) {
                        this.observer.observe(el);
                        this.elements.add(el);
                    }
                });
            });
        }
        
        handleIntersection(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio > 0.1) {
                    entry.target.classList.add('is-visible');
                    
                    // Optional: unobserve after animation
                    setTimeout(() => {
                        this.observer.unobserve(entry.target);
                        this.elements.delete(entry.target);
                    }, 1000);
                }
            });
        }
        
        refresh() {
            this.observeElements();
        }
    }
    
    // ===== SEARCH FUNCTIONALITY =====
    
    class SearchHandler {
        constructor() {
            this.searchInput = document.querySelector('.search-input');
            this.searchForm = document.querySelector('.search-form');
            this.searchButton = document.querySelector('.search-btn');
            this.init();
        }
        
        init() {
            if (!this.searchInput) return;
            
            this.searchForm.addEventListener('submit', this.handleSubmit.bind(this));
            this.searchInput.addEventListener('input', debounce(this.handleInput.bind(this), CONFIG.debounce.search));
            this.searchInput.addEventListener('focus', this.handleFocus.bind(this));
            this.searchInput.addEventListener('blur', this.handleBlur.bind(this));
            
            // Add accessibility attributes
            this.searchInput.setAttribute('aria-label', 'Rechercher dans le blog');
            this.searchButton.setAttribute('aria-label', 'Lancer la recherche');
        }
        
        handleSubmit(e) {
            e.preventDefault();
            const query = this.searchInput.value.trim();
            
            if (query.length < 2) {
                this.showMessage('Veuillez saisir au moins 2 caractères', 'warning');
                return;
            }
            
            this.performSearch(query);
        }
        
        handleInput(e) {
            const query = e.target.value.trim();
            
            if (query.length === 0) {
                this.clearSuggestions();
                return;
            }
            
            if (query.length >= 2) {
                this.showSuggestions(query);
            }
        }
        
        handleFocus() {
            this.searchInput.classList.add('focus-visible');
        }
        
        handleBlur() {
            this.searchInput.classList.remove('focus-visible');
        }
        
        performSearch(query) {
            // Add loading state
            this.searchButton.innerHTML = '<svg class="animate-spin w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
            
            // Simulate search (replace with actual search implementation)
            setTimeout(() => {
                console.log('Searching for:', query);
                this.showMessage(`Recherche pour "${query}" en cours...`, 'info');
                this.resetSearchButton();
            }, 1000);
        }
        
        showSuggestions(query) {
            // Implement search suggestions (could be connected to an API)
            console.log('Showing suggestions for:', query);
        }
        
        clearSuggestions() {
            // Clear search suggestions
        }
        
        showMessage(message, type = 'info') {
            // Create and show message (could be a toast notification)
            console.log(`${type.toUpperCase()}: ${message}`);
        }
        
        resetSearchButton() {
            this.searchButton.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>';
        }
    }
    
    // ===== ENHANCED CARD INTERACTIONS =====
    
    class CardEnhancer {
        constructor() {
            this.cards = document.querySelectorAll('.article-card');
            this.init();
        }
        
        init() {
            this.cards.forEach(card => this.enhanceCard(card));
        }
        
        enhanceCard(card) {
            // Add tilt effect on mouse move
            card.addEventListener('mousemove', this.handleMouseMove.bind(this));
            card.addEventListener('mouseleave', this.handleMouseLeave.bind(this));
            
            // Add keyboard navigation
            const link = card.querySelector('.article-btn');
            if (link) {
                card.setAttribute('tabindex', '0');
                card.setAttribute('role', 'article');
                card.addEventListener('keydown', this.handleKeydown.bind(this, link));
            }
            
            // Add loading animation for images
            const image = card.querySelector('.article-image');
            if (image) {
                this.addImageLoadingEffect(image);
            }
        }
        
        handleMouseMove(e) {
            if (CONFIG.animations.reduceMotion) return;
            
            const card = e.currentTarget;
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            card.style.transform = `
                perspective(1000px) 
                rotateX(${rotateX}deg) 
                rotateY(${rotateY}deg)
                translateZ(10px)
            `;
        }
        
        handleMouseLeave(e) {
            if (CONFIG.animations.reduceMotion) return;
            
            const card = e.currentTarget;
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateZ(0px)';
        }
        
        handleKeydown(link, e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                link.click();
            }
        }
        
        addImageLoadingEffect(image) {
            // Add loading placeholder
            const placeholder = document.createElement('div');
            placeholder.className = 'loading-shimmer absolute inset-0';
            image.parentNode.insertBefore(placeholder, image);
            
            // Remove placeholder when image loads
            if (image.complete) {
                placeholder.remove();
            } else {
                image.addEventListener('load', () => {
                    placeholder.style.opacity = '0';
                    setTimeout(() => placeholder.remove(), 300);
                });
                
                image.addEventListener('error', () => {
                    placeholder.remove();
                });
            }
        }
    }
    
    // ===== SIDEBAR ENHANCEMENTS =====
    
    class SidebarEnhancer {
        constructor() {
            this.sidebar = document.querySelector('.sidebar');
            this.widgets = document.querySelectorAll('.sidebar-widget');
            this.init();
        }
        
        init() {
            if (!this.sidebar) return;
            
            this.addStickyBehavior();
            this.enhanceWidgets();
            this.addCategoryHovers();
            this.addTagInteractions();
        }
        
        addStickyBehavior() {
            // Improve sticky sidebar behavior
            let ticking = false;
            
            const updateSidebar = () => {
                const scrollTop = window.pageYOffset;
                const windowHeight = window.innerHeight;
                const sidebarHeight = this.sidebar.offsetHeight;
                
                if (sidebarHeight > windowHeight) {
                    // If sidebar is taller than viewport, allow natural scrolling
                    this.sidebar.style.position = 'static';
                } else {
                    // Keep sticky behavior for shorter sidebars
                    this.sidebar.style.position = 'sticky';
                }
                
                ticking = false;
            };
            
            const requestTick = () => {
                if (!ticking) {
                    requestAnimationFrame(updateSidebar);
                    ticking = true;
                }
            };
            
            window.addEventListener('scroll', debounce(requestTick, CONFIG.debounce.scroll));
            window.addEventListener('resize', debounce(updateSidebar, CONFIG.debounce.resize));
        }
        
        enhanceWidgets() {
            this.widgets.forEach(widget => {
                // Add entrance animation
                widget.classList.add('scroll-animate-scale');
                
                // Add hover sound effect (optional)
                widget.addEventListener('mouseenter', () => {
                    if (!CONFIG.animations.reduceMotion) {
                        widget.style.transform = 'translateY(-2px) scale(1.02)';
                    }
                });
                
                widget.addEventListener('mouseleave', () => {
                    widget.style.transform = '';
                });
            });
        }
        
        addCategoryHovers() {
            const categoryItems = document.querySelectorAll('.category-item');
            
            categoryItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    if (!CONFIG.animations.reduceMotion) {
                        const count = item.querySelector('.category-count');
                        if (count) {
                            count.style.transform = 'scale(1.1)';
                        }
                    }
                });
                
                item.addEventListener('mouseleave', () => {
                    const count = item.querySelector('.category-count');
                    if (count) {
                        count.style.transform = '';
                    }
                });
            });
        }
        
        addTagInteractions() {
            const tagItems = document.querySelectorAll('.tag-item');
            
            tagItems.forEach(tag => {
                // Add click animation
                tag.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    if (!CONFIG.animations.reduceMotion) {
                        tag.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            tag.style.transform = '';
                        }, 150);
                    }
                    
                    // Here you would implement the actual filtering logic
                    console.log('Filter by tag:', tag.textContent.trim());
                });
                
                // Add keyboard support
                tag.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        tag.click();
                    }
                });
                
                // Make focusable
                tag.setAttribute('tabindex', '0');
                tag.setAttribute('role', 'button');
            });
        }
    }
    
    // ===== PERFORMANCE MONITOR =====
    
    class PerformanceMonitor {
        constructor() {
            this.metrics = {
                loadTime: 0,
                interactive: 0,
                animations: 0
            };
            this.init();
        }
        
        init() {
            // Monitor page load performance
            window.addEventListener('load', () => {
                this.metrics.loadTime = performance.now();
                console.log(`Page loaded in ${this.metrics.loadTime.toFixed(2)}ms`);
            });
            
            // Monitor Time to Interactive
            this.measureTTI();
            
            // Monitor animation performance
            this.monitorAnimations();
        }
        
        measureTTI() {
            // Simple TTI approximation
            setTimeout(() => {
                this.metrics.interactive = performance.now();
                console.log(`Time to Interactive: ${this.metrics.interactive.toFixed(2)}ms`);
            }, 0);
        }
        
        monitorAnimations() {
            // Monitor frame rate during animations
            let frameCount = 0;
            let startTime = performance.now();
            
            const countFrames = () => {
                frameCount++;
                
                if (frameCount % 60 === 0) { // Check every 60 frames
                    const currentTime = performance.now();
                    const fps = 60000 / (currentTime - startTime);
                    
                    if (fps < 30) {
                        console.warn(`Low FPS detected: ${fps.toFixed(1)} fps`);
                        // Consider disabling some animations
                        this.optimizeForPerformance();
                    }
                    
                    startTime = currentTime;
                }
                
                requestAnimationFrame(countFrames);
            };
            
            requestAnimationFrame(countFrames);
        }
        
        optimizeForPerformance() {
            // Disable non-essential animations if performance is poor
            document.body.classList.add('reduce-animations');
            CONFIG.animations.reduceMotion = true;
        }
    }
    
    // ===== ACCESSIBILITY ENHANCEMENTS =====
    
    class AccessibilityEnhancer {
        constructor() {
            this.init();
        }
        
        init() {
            this.addSkipLinks();
            this.improveKeyboardNavigation();
            this.addScreenReaderSupport();
            this.addHighContrastSupport();
            this.addFocusManagement();
        }
        
        addSkipLinks() {
            const skipLink = document.createElement('a');
            skipLink.className = 'skip-link';
            skipLink.href = '#main-content';
            skipLink.textContent = 'Passer au contenu principal';
            
            document.body.insertBefore(skipLink, document.body.firstChild);
            
            // Add target for skip link
            const mainContent = document.querySelector('.article-grid') || document.querySelector('main');
            if (mainContent) {
                mainContent.setAttribute('id', 'main-content');
                mainContent.setAttribute('tabindex', '-1');
            }
        }
        
        improveKeyboardNavigation() {
            // Add focus indicators
            const focusableElements = document.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            
            focusableElements.forEach(element => {
                element.addEventListener('focus', () => {
                    element.classList.add('focus-visible');
                });
                
                element.addEventListener('blur', () => {
                    element.classList.remove('focus-visible');
                });
            });
            
            // Escape key to close modals/dropdowns
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    // Close any open modals, dropdowns, etc.
                    document.querySelectorAll('.modal, .dropdown-open').forEach(el => {
                        el.classList.remove('modal-open', 'dropdown-open');
                    });
                }
            });
        }
        
        addScreenReaderSupport() {
            // Add aria-labels where missing
            const searchInput = document.querySelector('.search-input');
            if (searchInput && !searchInput.getAttribute('aria-label')) {
                searchInput.setAttribute('aria-label', 'Rechercher dans le blog');
            }
            
            // Add live region for dynamic content
            const liveRegion = document.createElement('div');
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.className = 'sr-only';
            liveRegion.id = 'live-region';
            document.body.appendChild(liveRegion);
            
            // Announce page changes
            this.announcePageChanges();
        }
        
        announcePageChanges() {
            const liveRegion = document.getElementById('live-region');
            
            // Announce when articles load
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.addedNodes.length > 0) {
                        mutation.addedNodes.forEach((node) => {
                            if (node.classList && node.classList.contains('article-card')) {
                                liveRegion.textContent = 'Nouvel article chargé';
                            }
                        });
                    }
                });
            });
            
            const articleContainer = document.querySelector('.article-grid');
            if (articleContainer) {
                observer.observe(articleContainer, { childList: true });
            }
        }
        
        addHighContrastSupport() {
            // Detect high contrast mode
            const highContrastQuery = window.matchMedia('(prefers-contrast: high)');
            
            const handleHighContrast = (e) => {
                if (e.matches) {
                    document.body.classList.add('high-contrast');
                } else {
                    document.body.classList.remove('high-contrast');
                }
            };
            
            highContrastQuery.addListener(handleHighContrast);
            handleHighContrast(highContrastQuery);
        }
        
        addFocusManagement() {
            // Trap focus in modal dialogs
            this.setupFocusTrap();
            
            // Restore focus after modal closes
            this.setupFocusRestore();
        }
        
        setupFocusTrap() {
            // Implementation for focus trapping in modals
            // (Would be expanded based on specific modal needs)
        }
        
        setupFocusRestore() {
            // Implementation for focus restoration
            // (Would be expanded based on specific interaction needs)
        }
    }
    
    // ===== MAIN INITIALIZATION =====
    
    class BlogEnhancer {
        constructor() {
            this.components = [];
            this.init();
        }
        
        init() {
            // Wait for DOM to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.initializeComponents());
            } else {
                this.initializeComponents();
            }
        }
        
        initializeComponents() {
            try {
                // Initialize all components
                this.components.push(new ScrollAnimator());
                this.components.push(new SearchHandler());
                this.components.push(new CardEnhancer());
                this.components.push(new SidebarEnhancer());
                this.components.push(new PerformanceMonitor());
                this.components.push(new AccessibilityEnhancer());
                
                console.log('Blog enhancements initialized successfully');
                
                // Add initialization complete event
                document.dispatchEvent(new CustomEvent('blogEnhanced', {
                    detail: { components: this.components.length }
                }));
                
            } catch (error) {
                console.error('Error initializing blog enhancements:', error);
            }
        }
        
        refresh() {
            // Refresh all components (useful after dynamic content loading)
            this.components.forEach(component => {
                if (typeof component.refresh === 'function') {
                    component.refresh();
                }
            });
        }
    }
    
    // ===== AUTO-INITIALIZATION =====
    
    // Initialize the blog enhancer
    window.BlogEnhancer = new BlogEnhancer();
    
    // Expose refresh method globally
    window.refreshBlogEnhancements = () => {
        window.BlogEnhancer.refresh();
    };
    
    // Add resize listener for responsive adjustments
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            window.BlogEnhancer.refresh();
        }, CONFIG.debounce.resize);
    });
    
})();