/**
 * Ultra Performance Optimization
 * Advanced performance enhancements for CERFAOS admin
 */

class UltraPerformance {
    constructor() {
        this.config = {
            lazyLoadImages: true,
            lazyLoadComponents: true,
            enableCaching: true,
            optimizeAnimations: true,
            enableVirtualScrolling: false,
            debounceDelay: 300,
            throttleDelay: 16,
            intersectionThreshold: 0.1
        };
        
        this.observers = {
            intersection: null,
            resize: null,
            mutation: null
        };
        
        this.cache = new Map();
        this.loadedComponents = new Set();
        this.deferredTasks = [];
        
        this.init();
    }
    
    init() {
        console.log('🚀 Initializing Ultra Performance optimizations...');
        
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.startOptimizations());
        } else {
            this.startOptimizations();
        }
    }
    
    startOptimizations() {
        // Performance optimizations
        this.setupLazyLoading();
        this.optimizeImages();
        this.setupComponentLazyLoading();
        this.optimizeAnimations();
        this.setupIntersectionObserver();
        this.optimizeEventListeners();
        this.setupResourceHints();
        this.optimizeScripts();
        
        // Accessibility optimizations
        this.enhanceAccessibility();
        this.setupKeyboardNavigation();
        this.optimizeScreenReader();
        this.enhanceFocusManagement();
        
        // Monitor performance
        this.setupPerformanceMonitoring();
        
        console.log('✅ Ultra Performance optimizations active');
    }
    
    // ======================
    // LAZY LOADING
    // ======================
    
    setupLazyLoading() {
        if (!this.config.lazyLoadImages) return;
        
        const images = document.querySelectorAll('img[data-src], img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            this.observers.intersection = new IntersectionObserver(
                (entries) => this.handleImageIntersection(entries),
                { threshold: this.config.intersectionThreshold }
            );
            
            images.forEach(img => {
                this.observers.intersection.observe(img);
            });
        } else {
            // Fallback for older browsers
            images.forEach(img => this.loadImage(img));
        }
    }
    
    handleImageIntersection(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                this.loadImage(entry.target);
                this.observers.intersection.unobserve(entry.target);
            }
        });
    }
    
    loadImage(img) {
        const src = img.dataset.src || img.src;
        if (!src) return;
        
        // Create a new image to preload
        const newImg = new Image();
        newImg.onload = () => {
            img.src = src;
            img.classList.add('loaded');
            img.removeAttribute('data-src');
        };
        newImg.onerror = () => {
            img.classList.add('error');
            console.warn('Failed to load image:', src);
        };
        newImg.src = src;
    }
    
    // ======================
    // COMPONENT LAZY LOADING
    // ======================
    
    setupComponentLazyLoading() {
        if (!this.config.lazyLoadComponents) return;
        
        const components = document.querySelectorAll('[data-lazy-component]');
        
        components.forEach(component => {
            if (this.observers.intersection) {
                this.observers.intersection.observe(component);
            }
        });
    }
    
    async loadComponent(element) {
        const componentName = element.dataset.lazyComponent;
        if (this.loadedComponents.has(componentName)) return;
        
        try {
            // Simulate component loading
            const response = await fetch(`/api/admin/components/${componentName}`);
            const html = await response.text();
            
            element.innerHTML = html;
            this.loadedComponents.add(componentName);
            
            // Re-initialize any scripts in the component
            this.initializeComponentScripts(element);
            
        } catch (error) {
            console.error(`Failed to load component ${componentName}:`, error);
            element.innerHTML = '<div class="component-error">Failed to load component</div>';
        }
    }
    
    initializeComponentScripts(element) {
        const scripts = element.querySelectorAll('script');
        scripts.forEach(script => {
            if (script.src) {
                // External script
                const newScript = document.createElement('script');
                newScript.src = script.src;
                newScript.async = true;
                document.head.appendChild(newScript);
            } else {
                // Inline script
                eval(script.innerHTML);
            }
        });
        
        // Re-initialize feather icons if present
        if (typeof feather !== 'undefined') {
            feather.replace(element);
        }
    }
    
    // ======================
    // IMAGE OPTIMIZATION
    // ======================
    
    optimizeImages() {
        const images = document.querySelectorAll('img');
        
        images.forEach(img => {
            // Add loading="lazy" if not present
            if (!img.hasAttribute('loading')) {
                img.loading = 'lazy';
            }
            
            // Add decoding="async" for better performance
            if (!img.hasAttribute('decoding')) {
                img.decoding = 'async';
            }
            
            // Optimize image format based on browser support
            this.optimizeImageFormat(img);
        });
    }
    
    optimizeImageFormat(img) {
        if (!img.src) return;
        
        // Check for WebP support
        if (this.supportsWebP() && !img.src.includes('.webp')) {
            const webpSrc = img.src.replace(/\.(jpg|jpeg|png)$/i, '.webp');
            
            // Test if WebP version exists
            const testImg = new Image();
            testImg.onload = () => {
                img.src = webpSrc;
            };
            testImg.src = webpSrc;
        }
    }
    
    supportsWebP() {
        const canvas = document.createElement('canvas');
        canvas.width = 1;
        canvas.height = 1;
        return canvas.toDataURL('image/webp').indexOf('data:image/webp') === 0;
    }
    
    // ======================
    // ANIMATION OPTIMIZATION
    // ======================
    
    optimizeAnimations() {
        if (!this.config.optimizeAnimations) return;
        
        // Respect user preferences
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            this.reduceAnimations();
            return;
        }
        
        // Use requestAnimationFrame for smooth animations
        this.setupRAFAnimations();
        
        // Optimize CSS animations
        this.optimizeCSSAnimations();
    }
    
    reduceAnimations() {
        document.documentElement.classList.add('reduce-motion');
        
        const style = document.createElement('style');
        style.textContent = `
            .reduce-motion *,
            .reduce-motion *::before,
            .reduce-motion *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        `;
        document.head.appendChild(style);
    }
    
    setupRAFAnimations() {
        // Replace jQuery animations with RAF-based ones
        window.ultraAnimate = (element, properties, duration = 300) => {
            return new Promise(resolve => {
                const start = performance.now();
                const startValues = {};
                const endValues = {};
                
                // Parse properties
                Object.keys(properties).forEach(prop => {
                    startValues[prop] = parseFloat(getComputedStyle(element)[prop]) || 0;
                    endValues[prop] = properties[prop];
                });
                
                const animate = (currentTime) => {
                    const elapsed = currentTime - start;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    // Easing function (ease-out)
                    const eased = 1 - Math.pow(1 - progress, 3);
                    
                    Object.keys(properties).forEach(prop => {
                        const current = startValues[prop] + (endValues[prop] - startValues[prop]) * eased;
                        element.style[prop] = current + (prop.includes('opacity') ? '' : 'px');
                    });
                    
                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        resolve();
                    }
                };
                
                requestAnimationFrame(animate);
            });
        };
    }
    
    optimizeCSSAnimations() {
        // Add will-change property to animated elements
        const animatedElements = document.querySelectorAll([
            '[data-aos]',
            '.animated',
            '.transition',
            '.hover\\:scale',
            '.hover\\:translate'
        ].join(', '));
        
        animatedElements.forEach(element => {
            element.style.willChange = 'transform, opacity';
        });
    }
    
    // ======================
    // INTERSECTION OBSERVER
    // ======================
    
    setupIntersectionObserver() {
        if (!('IntersectionObserver' in window)) return;
        
        // Optimize AOS (Animate On Scroll) with intersection observer
        const aosElements = document.querySelectorAll('[data-aos]');
        
        if (aosElements.length > 0) {
            const aosObserver = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('aos-animate');
                            aosObserver.unobserve(entry.target);
                        }
                    });
                },
                { threshold: 0.1 }
            );
            
            aosElements.forEach(element => {
                aosObserver.observe(element);
            });
        }
    }
    
    // ======================
    // EVENT LISTENER OPTIMIZATION
    // ======================
    
    optimizeEventListeners() {
        // Debounce scroll events
        let scrollTimeout;
        const originalScroll = window.addEventListener;
        
        window.addEventListener = function(event, handler, options) {
            if (event === 'scroll') {
                const debouncedHandler = (e) => {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => handler(e), 16); // ~60fps
                };
                originalScroll.call(this, event, debouncedHandler, options);
            } else {
                originalScroll.call(this, event, handler, options);
            }
        };
        
        // Optimize resize events
        this.optimizeResizeEvents();
        
        // Passive event listeners for better performance
        this.setupPassiveListeners();
    }
    
    optimizeResizeEvents() {
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                // Dispatch custom optimized resize event
                window.dispatchEvent(new CustomEvent('optimizedResize'));
            }, this.config.throttleDelay);
        }, { passive: true });
    }
    
    setupPassiveListeners() {
        const passiveEvents = ['scroll', 'wheel', 'touchstart', 'touchmove'];
        
        passiveEvents.forEach(event => {
            document.addEventListener(event, () => {}, { passive: true });
        });
    }
    
    // ======================
    // RESOURCE HINTS
    // ======================
    
    setupResourceHints() {
        // Preconnect to external domains
        const preconnectDomains = [
            'https://fonts.googleapis.com',
            'https://fonts.gstatic.com',
            'https://images.unsplash.com'
        ];
        
        preconnectDomains.forEach(domain => {
            const link = document.createElement('link');
            link.rel = 'preconnect';
            link.href = domain;
            document.head.appendChild(link);
        });
        
        // DNS prefetch for likely navigation
        const prefetchDomains = [
            '//cdn.jsdelivr.net',
            '//unpkg.com'
        ];
        
        prefetchDomains.forEach(domain => {
            const link = document.createElement('link');
            link.rel = 'dns-prefetch';
            link.href = domain;
            document.head.appendChild(link);
        });
    }
    
    // ======================
    // SCRIPT OPTIMIZATION
    // ======================
    
    optimizeScripts() {
        // Defer non-critical scripts
        const nonCriticalScripts = document.querySelectorAll('script[src]:not([defer]):not([async])');
        
        nonCriticalScripts.forEach(script => {
            if (!script.src.includes('critical') && !script.src.includes('inline')) {
                script.defer = true;
            }
        });
        
        // Load scripts on interaction
        this.setupInteractionBasedLoading();
    }
    
    setupInteractionBasedLoading() {
        const interactionEvents = ['click', 'keydown', 'touchstart', 'mouseover'];
        
        const loadHeavyScripts = () => {
            // Load heavy scripts only after user interaction
            const heavyScripts = document.querySelectorAll('[data-heavy-script]');
            
            heavyScripts.forEach(script => {
                const src = script.dataset.heavyScript;
                const newScript = document.createElement('script');
                newScript.src = src;
                newScript.async = true;
                document.head.appendChild(newScript);
            });
            
            // Remove event listeners after first load
            interactionEvents.forEach(event => {
                document.removeEventListener(event, loadHeavyScripts);
            });
        };
        
        interactionEvents.forEach(event => {
            document.addEventListener(event, loadHeavyScripts, { once: true, passive: true });
        });
    }
    
    // ======================
    // ACCESSIBILITY ENHANCEMENTS
    // ======================
    
    enhanceAccessibility() {
        console.log('🎯 Enhancing accessibility...');
        
        // Add missing ARIA labels
        this.addMissingAriaLabels();
        
        // Improve focus indicators
        this.enhanceFocusIndicators();
        
        // Add skip links
        this.addSkipLinks();
        
        // Enhance form accessibility
        this.enhanceFormAccessibility();
        
        // Add landmarks
        this.addLandmarks();
        
        // Improve color contrast
        this.checkColorContrast();
        
        // Add reduced motion support
        this.addReducedMotionSupport();
    }
    
    addMissingAriaLabels() {
        // Buttons without accessible names
        const unlabeledButtons = document.querySelectorAll('button:not([aria-label]):not([title]):empty');
        unlabeledButtons.forEach(button => {
            const icon = button.querySelector('i[data-feather]');
            if (icon) {
                const iconName = icon.dataset.feather;
                button.setAttribute('aria-label', this.getIconLabel(iconName));
            }
        });
        
        // Input fields without labels
        const unlabeledInputs = document.querySelectorAll('input:not([aria-label]):not([id])');
        unlabeledInputs.forEach(input => {
            if (input.placeholder) {
                input.setAttribute('aria-label', input.placeholder);
            }
        });
    }
    
    getIconLabel(iconName) {
        const iconLabels = {
            'menu': 'Menu',
            'search': 'Rechercher',
            'bell': 'Notifications',
            'user': 'Profil utilisateur',
            'settings': 'Paramètres',
            'x': 'Fermer',
            'eye': 'Voir',
            'edit': 'Modifier',
            'trash-2': 'Supprimer',
            'download': 'Télécharger',
            'upload': 'Uploader',
            'refresh-cw': 'Actualiser',
            'chevron-down': 'Développer',
            'chevron-up': 'Réduire',
            'chevron-left': 'Précédent',
            'chevron-right': 'Suivant'
        };
        
        return iconLabels[iconName] || iconName.charAt(0).toUpperCase() + iconName.slice(1);
    }
    
    enhanceFocusIndicators() {
        const style = document.createElement('style');
        style.textContent = `
            /* Enhanced focus indicators */
            *:focus {
                outline: 2px solid var(--cerfaos-primary, #2563eb) !important;
                outline-offset: 2px !important;
            }
            
            /* High contrast focus for better accessibility */
            @media (prefers-contrast: high) {
                *:focus {
                    outline: 3px solid currentColor !important;
                    outline-offset: 3px !important;
                }
            }
            
            /* Focus within for containers */
            .form-group:focus-within,
            .input-wrapper:focus-within {
                box-shadow: 0 0 0 2px var(--cerfaos-primary-alpha, rgba(37, 99, 235, 0.2)) !important;
            }
        `;
        document.head.appendChild(style);
    }
    
    addSkipLinks() {
        if (document.querySelector('.skip-links')) return;
        
        const skipLinks = document.createElement('div');
        skipLinks.className = 'skip-links';
        skipLinks.innerHTML = `
            <a href="#main-content" class="skip-link">Aller au contenu principal</a>
            <a href="#navigation" class="skip-link">Aller à la navigation</a>
        `;
        
        const style = document.createElement('style');
        style.textContent = `
            .skip-links {
                position: absolute;
                top: -100px;
                left: 0;
                z-index: 10000;
            }
            
            .skip-link {
                position: absolute;
                top: -100px;
                left: 0;
                background: var(--cerfaos-primary, #2563eb);
                color: white;
                padding: 8px 16px;
                text-decoration: none;
                border-radius: 0 0 4px 0;
                font-weight: 500;
                transition: top 0.3s ease;
            }
            
            .skip-link:focus {
                top: 0;
            }
        `;
        
        document.head.appendChild(style);
        document.body.insertBefore(skipLinks, document.body.firstChild);
        
        // Add IDs to main landmarks if they don't exist
        const mainContent = document.querySelector('main, [role="main"], .main-content, .ultra-main-content');
        if (mainContent && !mainContent.id) {
            mainContent.id = 'main-content';
        }
        
        const navigation = document.querySelector('nav, [role="navigation"], .sidebar, .navigation');
        if (navigation && !navigation.id) {
            navigation.id = 'navigation';
        }
    }
    
    enhanceFormAccessibility() {
        // Associate labels with inputs
        const inputs = document.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            const wrapper = input.closest('.form-group, .input-group, .field-wrapper');
            if (wrapper) {
                const label = wrapper.querySelector('label');
                if (label && !input.id) {
                    const id = 'input-' + Math.random().toString(36).substr(2, 9);
                    input.id = id;
                    label.setAttribute('for', id);
                }
            }
            
            // Add required indicators
            if (input.required && !input.getAttribute('aria-required')) {
                input.setAttribute('aria-required', 'true');
            }
            
            // Add error associations
            const errorElement = wrapper?.querySelector('.error, .invalid-feedback');
            if (errorElement) {
                const errorId = 'error-' + Math.random().toString(36).substr(2, 9);
                errorElement.id = errorId;
                input.setAttribute('aria-describedby', errorId);
            }
        });
    }
    
    addLandmarks() {
        // Add main landmark
        const mainContent = document.querySelector('.main-content, .ultra-main-content, .content');
        if (mainContent && !mainContent.getAttribute('role')) {
            mainContent.setAttribute('role', 'main');
        }
        
        // Add navigation landmark
        const sidebar = document.querySelector('.sidebar, .navigation');
        if (sidebar && !sidebar.getAttribute('role')) {
            sidebar.setAttribute('role', 'navigation');
            sidebar.setAttribute('aria-label', 'Navigation principale');
        }
        
        // Add banner landmark
        const header = document.querySelector('header, .header');
        if (header && !header.getAttribute('role')) {
            header.setAttribute('role', 'banner');
        }
        
        // Add contentinfo landmark
        const footer = document.querySelector('footer, .footer');
        if (footer && !footer.getAttribute('role')) {
            footer.setAttribute('role', 'contentinfo');
        }
    }
    
    checkColorContrast() {
        // This is a simplified contrast checker
        // In a production environment, you'd use a more sophisticated tool
        const style = document.createElement('style');
        style.textContent = `
            @media (prefers-contrast: high) {
                :root {
                    --cerfaos-text-primary: #000000;
                    --cerfaos-text-secondary: #1a1a1a;
                    --cerfaos-background: #ffffff;
                    --cerfaos-border: #666666;
                }
                
                .text-muted,
                .text-secondary {
                    color: #333333 !important;
                }
                
                .bg-light {
                    background-color: #ffffff !important;
                    border: 1px solid #000000 !important;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    addReducedMotionSupport() {
        const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
        
        const handleReducedMotion = (e) => {
            if (e.matches) {
                document.documentElement.classList.add('reduce-motion');
            } else {
                document.documentElement.classList.remove('reduce-motion');
            }
        };
        
        mediaQuery.addListener(handleReducedMotion);
        handleReducedMotion(mediaQuery);
    }
    
    // ======================
    // KEYBOARD NAVIGATION
    // ======================
    
    setupKeyboardNavigation() {
        console.log('⌨️ Setting up keyboard navigation...');
        
        // Roving tabindex for complex components
        this.setupRovingTabindex();
        
        // Arrow key navigation
        this.setupArrowNavigation();
        
        // Escape key handling
        this.setupEscapeHandling();
        
        // Tab trapping for modals
        this.setupTabTrapping();
    }
    
    setupRovingTabindex() {
        const componentSelectors = [
            '.stats-grid',
            '.quick-actions-grid',
            '.charts-grid',
            '.filter-tabs'
        ];
        
        componentSelectors.forEach(selector => {
            const containers = document.querySelectorAll(selector);
            containers.forEach(container => {
                this.initRovingTabindex(container);
            });
        });
    }
    
    initRovingTabindex(container) {
        const focusableElements = container.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        
        if (focusableElements.length === 0) return;
        
        // Set first element as tabbable
        focusableElements.forEach((el, index) => {
            el.tabIndex = index === 0 ? 0 : -1;
        });
        
        container.addEventListener('keydown', (e) => {
            if (!['ArrowRight', 'ArrowLeft', 'ArrowDown', 'ArrowUp'].includes(e.key)) return;
            
            e.preventDefault();
            
            const currentIndex = Array.from(focusableElements).indexOf(e.target);
            let nextIndex;
            
            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                nextIndex = (currentIndex + 1) % focusableElements.length;
            } else {
                nextIndex = (currentIndex - 1 + focusableElements.length) % focusableElements.length;
            }
            
            // Update tabindex
            focusableElements[currentIndex].tabIndex = -1;
            focusableElements[nextIndex].tabIndex = 0;
            focusableElements[nextIndex].focus();
        });
    }
    
    setupArrowNavigation() {
        // Custom arrow navigation for specific components
        const dropdowns = document.querySelectorAll('[data-dropdown]');
        
        dropdowns.forEach(dropdown => {
            dropdown.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    this.navigateDropdown(dropdown, e.key === 'ArrowDown' ? 1 : -1);
                }
            });
        });
    }
    
    navigateDropdown(dropdown, direction) {
        const items = dropdown.querySelectorAll('[role="menuitem"], button, a');
        const currentFocus = dropdown.querySelector(':focus');
        const currentIndex = Array.from(items).indexOf(currentFocus);
        
        let nextIndex = currentIndex + direction;
        if (nextIndex < 0) nextIndex = items.length - 1;
        if (nextIndex >= items.length) nextIndex = 0;
        
        items[nextIndex].focus();
    }
    
    setupEscapeHandling() {
        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Escape') return;
            
            // Close any open dropdowns
            const openDropdowns = document.querySelectorAll('[data-dropdown]:not([hidden])');
            openDropdowns.forEach(dropdown => {
                dropdown.hidden = true;
            });
            
            // Close any open modals
            const openModals = document.querySelectorAll('.modal.show, .modal:not([hidden])');
            openModals.forEach(modal => {
                modal.classList.remove('show');
                modal.hidden = true;
            });
        });
    }
    
    setupTabTrapping() {
        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Tab') return;
            
            const modal = document.querySelector('.modal.show, .modal:not([hidden])');
            if (!modal) return;
            
            const focusableElements = modal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            
            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];
            
            if (e.shiftKey) {
                if (document.activeElement === firstFocusable) {
                    e.preventDefault();
                    lastFocusable.focus();
                }
            } else {
                if (document.activeElement === lastFocusable) {
                    e.preventDefault();
                    firstFocusable.focus();
                }
            }
        });
    }
    
    // ======================
    // SCREEN READER OPTIMIZATION
    // ======================
    
    optimizeScreenReader() {
        console.log('🔊 Optimizing for screen readers...');
        
        // Add live regions
        this.setupLiveRegions();
        
        // Improve dynamic content announcements
        this.setupDynamicAnnouncements();
        
        // Add descriptive text
        this.addDescriptiveText();
    }
    
    setupLiveRegions() {
        // Create global live region for announcements
        if (!document.querySelector('#live-region')) {
            const liveRegion = document.createElement('div');
            liveRegion.id = 'live-region';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.style.cssText = 'position: absolute; left: -10000px; width: 1px; height: 1px; overflow: hidden;';
            document.body.appendChild(liveRegion);
        }
        
        // Create assertive live region for important updates
        if (!document.querySelector('#live-region-assertive')) {
            const assertiveLiveRegion = document.createElement('div');
            assertiveLiveRegion.id = 'live-region-assertive';
            assertiveLiveRegion.setAttribute('aria-live', 'assertive');
            assertiveLiveRegion.setAttribute('aria-atomic', 'true');
            assertiveLiveRegion.style.cssText = 'position: absolute; left: -10000px; width: 1px; height: 1px; overflow: hidden;';
            document.body.appendChild(assertiveLiveRegion);
        }
        
        // Global announcement function
        window.announceToScreenReader = (message, assertive = false) => {
            const liveRegion = document.querySelector(assertive ? '#live-region-assertive' : '#live-region');
            if (liveRegion) {
                liveRegion.textContent = message;
                // Clear after announcement
                setTimeout(() => {
                    liveRegion.textContent = '';
                }, 1000);
            }
        };
    }
    
    setupDynamicAnnouncements() {
        // Announce loading states
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'aria-busy') {
                    const element = mutation.target;
                    if (element.getAttribute('aria-busy') === 'true') {
                        window.announceToScreenReader?.('Chargement en cours...');
                    }
                }
                
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach(node => {
                        if (node.nodeType === 1 && node.classList.contains('notification-toast')) {
                            const title = node.querySelector('.toast-title')?.textContent;
                            const message = node.querySelector('.toast-message')?.textContent;
                            if (title && message) {
                                window.announceToScreenReader?.(`${title}: ${message}`, true);
                            }
                        }
                    });
                }
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['aria-busy']
        });
    }
    
    addDescriptiveText() {
        // Add descriptions to complex charts/graphs
        const charts = document.querySelectorAll('.chart, [id*="chart"], [id*="Chart"]');
        charts.forEach(chart => {
            if (!chart.getAttribute('aria-label') && !chart.getAttribute('aria-labelledby')) {
                chart.setAttribute('aria-label', 'Graphique interactif');
            }
        });
        
        // Add descriptions to data tables
        const tables = document.querySelectorAll('table');
        tables.forEach(table => {
            if (!table.querySelector('caption') && !table.getAttribute('aria-label')) {
                const title = table.closest('[data-component]')?.querySelector('h3, h4, h5')?.textContent;
                if (title) {
                    table.setAttribute('aria-label', `Tableau: ${title}`);
                }
            }
        });
    }
    
    // ======================
    // FOCUS MANAGEMENT
    // ======================
    
    enhanceFocusManagement() {
        console.log('🎯 Enhancing focus management...');
        
        // Focus restoration
        this.setupFocusRestoration();
        
        // Focus trapping for complex components
        this.setupAdvancedFocusTrapping();
        
        // Initial focus for dynamic content
        this.setupInitialFocus();
    }
    
    setupFocusRestoration() {
        let previousFocus = null;
        
        // Store focus before opening modals/dropdowns
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-toggle="modal"], [data-trigger]')) {
                previousFocus = e.target;
            }
        });
        
        // Restore focus when closing
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && previousFocus) {
                setTimeout(() => {
                    previousFocus.focus();
                    previousFocus = null;
                }, 100);
            }
        });
    }
    
    setupAdvancedFocusTrapping() {
        const focusableSelectors = [
            'button:not([disabled])',
            '[href]',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"])',
            '[contenteditable="true"]'
        ].join(', ');
        
        window.trapFocus = (container) => {
            const focusableElements = container.querySelectorAll(focusableSelectors);
            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];
            
            const handleTabKey = (e) => {
                if (e.key !== 'Tab') return;
                
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        e.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            };
            
            container.addEventListener('keydown', handleTabKey);
            
            // Return cleanup function
            return () => {
                container.removeEventListener('keydown', handleTabKey);
            };
        };
    }
    
    setupInitialFocus() {
        // Focus first interactive element in new content
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1 && node.matches('[data-auto-focus]')) {
                        const firstFocusable = node.querySelector(
                            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
                        );
                        if (firstFocusable) {
                            setTimeout(() => firstFocusable.focus(), 100);
                        }
                    }
                });
            });
        });
        
        observer.observe(document.body, { childList: true, subtree: true });
    }
    
    // ======================
    // PERFORMANCE MONITORING
    // ======================
    
    setupPerformanceMonitoring() {
        if (!('performance' in window)) return;
        
        // Monitor Core Web Vitals
        this.monitorCoreWebVitals();
        
        // Monitor memory usage
        this.monitorMemoryUsage();
        
        // Monitor long tasks
        this.monitorLongTasks();
        
        // Performance reporting
        this.setupPerformanceReporting();
    }
    
    monitorCoreWebVitals() {
        // Largest Contentful Paint
        new PerformanceObserver((list) => {
            const entries = list.getEntries();
            const lastEntry = entries[entries.length - 1];
            console.log('LCP:', lastEntry.startTime);
        }).observe({ entryTypes: ['largest-contentful-paint'] });
        
        // First Input Delay
        new PerformanceObserver((list) => {
            list.getEntries().forEach(entry => {
                console.log('FID:', entry.processingStart - entry.startTime);
            });
        }).observe({ entryTypes: ['first-input'] });
        
        // Cumulative Layout Shift
        let clsScore = 0;
        new PerformanceObserver((list) => {
            list.getEntries().forEach(entry => {
                if (!entry.hadRecentInput) {
                    clsScore += entry.value;
                }
            });
            console.log('CLS:', clsScore);
        }).observe({ entryTypes: ['layout-shift'] });
    }
    
    monitorMemoryUsage() {
        if ('memory' in performance) {
            setInterval(() => {
                const memory = performance.memory;
                console.log('Memory usage:', {
                    used: Math.round(memory.usedJSHeapSize / 1024 / 1024) + 'MB',
                    total: Math.round(memory.totalJSHeapSize / 1024 / 1024) + 'MB',
                    limit: Math.round(memory.jsHeapSizeLimit / 1024 / 1024) + 'MB'
                });
            }, 30000); // Check every 30 seconds
        }
    }
    
    monitorLongTasks() {
        if ('PerformanceObserver' in window) {
            new PerformanceObserver((list) => {
                list.getEntries().forEach(entry => {
                    console.warn('Long task detected:', entry.duration + 'ms');
                });
            }).observe({ entryTypes: ['longtask'] });
        }
    }
    
    setupPerformanceReporting() {
        // Report performance metrics to console (or send to analytics)
        window.addEventListener('load', () => {
            setTimeout(() => {
                const perfData = {
                    navigation: performance.getEntriesByType('navigation')[0],
                    resources: performance.getEntriesByType('resource').length,
                    timestamp: new Date().toISOString()
                };
                
                console.log('Performance Report:', perfData);
                
                // In production, send to analytics
                // analytics.track('performance', perfData);
            }, 3000);
        });
    }
    
    // ======================
    // UTILITY METHODS
    // ======================
    
    debounce(func, wait) {
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
    
    throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
    
    // Public API
    getCache() {
        return this.cache;
    }
    
    clearCache() {
        this.cache.clear();
        console.log('Performance cache cleared');
    }
    
    updateConfig(newConfig) {
        this.config = { ...this.config, ...newConfig };
        console.log('Performance config updated:', this.config);
    }
    
    getPerformanceReport() {
        return {
            loadedComponents: Array.from(this.loadedComponents),
            cacheSize: this.cache.size,
            config: this.config,
            timestamp: new Date().toISOString()
        };
    }
}

// Initialize Ultra Performance
document.addEventListener('DOMContentLoaded', function() {
    window.ultraPerformance = new UltraPerformance();
});

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = UltraPerformance;
}