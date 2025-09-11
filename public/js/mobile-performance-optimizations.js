/**
 * CERFAOS - Optimisations Performance Mobile
 * Améliorations spécifiques pour les performances sur mobile
 */

(function() {
    'use strict';

    /**
     * Classe principale pour les optimisations de performance mobile
     */
    class MobilePerformanceOptimizer {
        constructor() {
            this.isMobile = this.detectMobile();
            this.isLowEndDevice = this.detectLowEndDevice();
            
            if (this.isMobile) {
                this.init();
            }
        }

        init() {
            this.optimizeImages();
            this.implementLazyLoading();
            this.optimizeAnimations();
            this.optimizeScroll();
            this.implementResourceHints();
            this.optimizeTouch();
            this.manageMemory();
            this.optimizeNetwork();
            
            console.log('✅ Optimisations performance mobile activées');
        }

        /**
         * Détection mobile
         */
        detectMobile() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
                   window.innerWidth <= 768;
        }

        /**
         * Détection d'appareil bas de gamme
         */
        detectLowEndDevice() {
            // Détecter via les capacités du device
            const hardwareConcurrency = navigator.hardwareConcurrency || 1;
            const deviceMemory = navigator.deviceMemory || 1;
            const connectionSpeed = navigator.connection?.effectiveType || '4g';
            
            return hardwareConcurrency <= 2 || 
                   deviceMemory <= 2 || 
                   ['slow-2g', '2g', '3g'].includes(connectionSpeed);
        }

        /**
         * Optimisation des images
         */
        optimizeImages() {
            const images = document.querySelectorAll('img');
            
            images.forEach(img => {
                // Lazy loading natif
                if (!img.loading) {
                    img.loading = 'lazy';
                }
                
                // Décoder de manière asynchrone
                if (img.decode) {
                    img.decode().catch(() => {
                        // Fallback silencieux
                    });
                }
                
                // Optimisation pour les images hors viewport
                if (!this.isInViewport(img)) {
                    img.style.opacity = '0';
                    img.addEventListener('load', () => {
                        img.style.transition = 'opacity 0.3s';
                        img.style.opacity = '1';
                    });
                }
            });

            // Conversion WebP si supportée
            if (this.supportsWebP()) {
                this.convertToWebP();
            }
        }

        /**
         * Support WebP
         */
        supportsWebP() {
            const canvas = document.createElement('canvas');
            return canvas.toDataURL('image/webp').indexOf('image/webp') === 5;
        }

        /**
         * Lazy Loading avancé
         */
        implementLazyLoading() {
            const lazyElements = document.querySelectorAll('.lazy, [data-src]');
            
            if ('IntersectionObserver' in window) {
                const lazyImageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const lazyElement = entry.target;
                            this.loadLazyElement(lazyElement);
                            lazyImageObserver.unobserve(lazyElement);
                        }
                    });
                }, {
                    // Charger 100px avant d'être visible
                    rootMargin: '100px'
                });

                lazyElements.forEach(element => {
                    lazyImageObserver.observe(element);
                });
            } else {
                // Fallback pour navigateurs sans IntersectionObserver
                this.fallbackLazyLoading(lazyElements);
            }
        }

        /**
         * Charger un élément lazy
         */
        loadLazyElement(element) {
            if (element.dataset.src) {
                element.src = element.dataset.src;
                delete element.dataset.src;
            }
            
            if (element.dataset.srcset) {
                element.srcset = element.dataset.srcset;
                delete element.dataset.srcset;
            }
            
            element.classList.remove('lazy');
        }

        /**
         * Optimisation des animations
         */
        optimizeAnimations() {
            // Réduire les animations sur les appareils bas de gamme
            if (this.isLowEndDevice) {
                document.documentElement.style.setProperty('--animation-duration', '0.1s');
                document.documentElement.classList.add('reduce-motion');
            }

            // Respecter les préférences utilisateur
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                document.documentElement.classList.add('reduce-motion');
            }

            // Optimiser les animations coûteuses
            this.optimizeExpensiveAnimations();
        }

        /**
         * Optimiser les animations coûteuses
         */
        optimizeExpensiveAnimations() {
            const animatedElements = document.querySelectorAll('.animate, [class*="animate-"]');
            
            animatedElements.forEach(element => {
                // Forcer l'accélération matérielle
                element.style.willChange = 'transform, opacity';
                element.style.transform = 'translateZ(0)';
                
                // Nettoyer will-change après l'animation
                element.addEventListener('animationend', () => {
                    element.style.willChange = 'auto';
                });
            });
        }

        /**
         * Optimisation du scroll
         */
        optimizeScroll() {
            let ticking = false;

            const updateScrollPosition = () => {
                // Logique de scroll optimisée
                this.handleScrollEffects();
                ticking = false;
            };

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(updateScrollPosition);
                    ticking = true;
                }
            }, { passive: true });

            // Smooth scrolling optimisé
            document.documentElement.style.scrollBehavior = 'smooth';
        }

        /**
         * Effets de scroll optimisés
         */
        handleScrollEffects() {
            const scrollY = window.pageYOffset;
            
            // Parallaxe optimisé pour mobile
            const parallaxElements = document.querySelectorAll('.parallax');
            parallaxElements.forEach(element => {
                if (this.isInViewport(element)) {
                    const speed = element.dataset.speed || 0.5;
                    const yPos = -(scrollY * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                }
            });
        }

        /**
         * Resource hints
         */
        implementResourceHints() {
            // Preload des ressources critiques
            this.preloadCriticalResources();
            
            // Prefetch des ressources probables
            this.prefetchLikelyResources();
        }

        /**
         * Preload ressources critiques
         */
        preloadCriticalResources() {
            const criticalCSS = document.querySelector('link[rel="stylesheet"]');
            if (criticalCSS) {
                const preloadLink = document.createElement('link');
                preloadLink.rel = 'preload';
                preloadLink.as = 'style';
                preloadLink.href = criticalCSS.href;
                document.head.appendChild(preloadLink);
            }
        }

        /**
         * Prefetch ressources probables
         */
        prefetchLikelyResources() {
            // Prefetch des liens visibles
            const visibleLinks = document.querySelectorAll('a[href]:not([href^="#"]):not([href^="mailto:"]):not([href^="tel:"])');
            
            visibleLinks.forEach(link => {
                if (this.isInViewport(link)) {
                    const prefetchLink = document.createElement('link');
                    prefetchLink.rel = 'prefetch';
                    prefetchLink.href = link.href;
                    document.head.appendChild(prefetchLink);
                }
            });
        }

        /**
         * Optimisation du touch
         */
        optimizeTouch() {
            // Optimiser les événements touch
            document.addEventListener('touchstart', () => {}, { passive: true });
            document.addEventListener('touchmove', () => {}, { passive: true });
            
            // Éviter les scrolls accidentels
            this.preventAccidentalScroll();
        }

        /**
         * Prévenir les scrolls accidentels
         */
        preventAccidentalScroll() {
            let lastTouchY = 0;
            
            document.addEventListener('touchstart', (e) => {
                lastTouchY = e.touches[0].clientY;
            });

            document.addEventListener('touchmove', (e) => {
                const touchY = e.touches[0].clientY;
                const touchYDelta = touchY - lastTouchY;
                lastTouchY = touchY;

                // Empêcher le scroll si c'est dans un conteneur scrollable
                const target = e.target.closest('.prevent-scroll');
                if (target && Math.abs(touchYDelta) < 5) {
                    e.preventDefault();
                }
            }, { passive: false });
        }

        /**
         * Gestion mémoire
         */
        manageMemory() {
            // Nettoyer les ressources inutilisées
            this.cleanupUnusedResources();
            
            // Monitorer la mémoire si possible
            if (performance.memory) {
                this.monitorMemoryUsage();
            }
        }

        /**
         * Nettoyer les ressources inutilisées
         */
        cleanupUnusedResources() {
            // Supprimer les images hors du viewport depuis longtemps
            setInterval(() => {
                const images = document.querySelectorAll('img[src]');
                images.forEach(img => {
                    if (!this.isInViewport(img, 1000)) {
                        // Conserver l'URL mais vider le src pour libérer la mémoire
                        if (!img.dataset.originalSrc) {
                            img.dataset.originalSrc = img.src;
                            img.src = '';
                        }
                    } else if (img.dataset.originalSrc && !img.src) {
                        // Recharger si revenu dans le viewport
                        img.src = img.dataset.originalSrc;
                    }
                });
            }, 30000); // Toutes les 30 secondes
        }

        /**
         * Monitorer l'usage mémoire
         */
        monitorMemoryUsage() {
            const checkMemory = () => {
                const memory = performance.memory;
                const memoryUsage = memory.usedJSHeapSize / memory.totalJSHeapSize;
                
                if (memoryUsage > 0.9) {
                    console.warn('⚠️ Usage mémoire élevé:', Math.round(memoryUsage * 100) + '%');
                    this.forceClearnup();
                }
            };

            setInterval(checkMemory, 60000); // Vérifier toutes les minutes
        }

        /**
         * Forcer le nettoyage
         */
        forceClearnup() {
            // Forcer le garbage collection si possible
            if (window.gc) {
                window.gc();
            }
            
            // Nettoyer les caches
            if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
                navigator.serviceWorker.controller.postMessage({
                    command: 'CLEANUP_CACHE'
                });
            }
        }

        /**
         * Optimisations réseau
         */
        optimizeNetwork() {
            if ('connection' in navigator) {
                const connection = navigator.connection;
                
                // Adapter la qualité selon la connexion
                this.adaptToConnection(connection);
                
                // Écouter les changements de connexion
                connection.addEventListener('change', () => {
                    this.adaptToConnection(connection);
                });
            }
        }

        /**
         * Adapter à la connexion
         */
        adaptToConnection(connection) {
            const effectiveType = connection.effectiveType;
            
            if (['slow-2g', '2g'].includes(effectiveType)) {
                // Mode économie extrême
                document.documentElement.classList.add('low-bandwidth');
                this.enableDataSaver();
            } else if (effectiveType === '3g') {
                // Mode économie modéré
                document.documentElement.classList.add('medium-bandwidth');
            } else {
                // Connexion rapide
                document.documentElement.classList.remove('low-bandwidth', 'medium-bandwidth');
            }
        }

        /**
         * Activer le mode économie de données
         */
        enableDataSaver() {
            // Désactiver les images non critiques
            const images = document.querySelectorAll('img:not(.critical)');
            images.forEach(img => {
                if (!this.isInViewport(img)) {
                    img.style.display = 'none';
                }
            });

            // Désactiver les animations non essentielles
            document.documentElement.classList.add('data-saver-mode');
        }

        /**
         * Vérifier si un élément est dans le viewport
         */
        isInViewport(element, threshold = 0) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= -threshold &&
                rect.left >= -threshold &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) + threshold &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth) + threshold
            );
        }

        /**
         * Fallback lazy loading
         */
        fallbackLazyLoading(elements) {
            const loadOnScroll = () => {
                elements.forEach(element => {
                    if (this.isInViewport(element, 100)) {
                        this.loadLazyElement(element);
                    }
                });
            };

            window.addEventListener('scroll', loadOnScroll, { passive: true });
            window.addEventListener('resize', loadOnScroll, { passive: true });
            loadOnScroll(); // Charger les éléments déjà visibles
        }

        /**
         * Conversion WebP
         */
        convertToWebP() {
            const images = document.querySelectorAll('img[src*=".jpg"], img[src*=".png"], img[src*=".jpeg"]');
            
            images.forEach(img => {
                const webpSrc = img.src.replace(/\.(jpg|jpeg|png)$/, '.webp');
                
                // Tester si l'image WebP existe
                const testImg = new Image();
                testImg.onload = () => {
                    img.src = webpSrc;
                };
                testImg.src = webpSrc;
            });
        }
    }

    // Styles CSS pour les optimisations
    const performanceStyles = `
        .reduce-motion * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
        
        .low-bandwidth .non-critical {
            display: none !important;
        }
        
        .data-saver-mode .animation {
            animation: none !important;
        }
        
        .data-saver-mode .gradient {
            background: #f5f5f5 !important;
        }
        
        img[loading="lazy"] {
            transition: opacity 0.3s;
        }
        
        .parallax {
            will-change: transform;
        }
        
        .hardware-accelerated {
            transform: translateZ(0);
            backface-visibility: hidden;
        }
    `;

    // Injecter les styles de performance
    const styleSheet = document.createElement('style');
    styleSheet.textContent = performanceStyles;
    document.head.appendChild(styleSheet);

    // Initialisation
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            new MobilePerformanceOptimizer();
        });
    } else {
        new MobilePerformanceOptimizer();
    }

    // Export global
    window.MobilePerformanceOptimizer = MobilePerformanceOptimizer;

})();