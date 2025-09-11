/**
 * CERFAOS - Optimiseur d'animations mobiles
 * Résout le problème des animations qui se déclenchent trop tard sur mobile
 */

(function() {
    'use strict';

    class MobileAnimationOptimizer {
        constructor() {
            this.isMobile = window.innerWidth <= 768;
            this.isSmallMobile = window.innerWidth <= 480;
            this.animatedElements = new Set();
            
            if (this.isMobile) {
                this.init();
            }
        }

        init() {
            this.setupSmartAnimations();
            this.replaceAOSWithCustom();
            this.addProgressiveAnimations();
            this.setupViewportAnimations();
            
            console.log('✅ Optimiseur animations mobiles activé');
        }

        /**
         * Remplacer AOS par un système custom plus intelligent
         */
        replaceAOSWithCustom() {
            // Attendre que AOS soit initialisé
            setTimeout(() => {
                const aosElements = document.querySelectorAll('[data-aos]');
                
                aosElements.forEach(element => {
                    // Sauvegarder l'animation originale
                    const originalAnimation = element.getAttribute('data-aos');
                    const originalDelay = element.getAttribute('data-aos-delay') || 0;
                    const originalDuration = element.getAttribute('data-aos-duration') || 400;
                    
                    // Retirer les classes AOS
                    element.classList.remove('aos-init', 'aos-animate');
                    
                    // Appliquer notre système custom
                    this.applyCustomAnimation(element, {
                        animation: originalAnimation,
                        delay: originalDelay,
                        duration: originalDuration
                    });
                });
            }, 100);
        }

        /**
         * Appliquer une animation custom optimisée mobile
         */
        applyCustomAnimation(element, options) {
            // Configuration initiale invisible
            element.style.opacity = '0';
            element.style.transform = this.getInitialTransform(options.animation);
            element.style.transition = `all ${options.duration}ms cubic-bezier(0.25, 0.46, 0.45, 0.94)`;

            // Observer d'intersection optimisé pour mobile
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !this.animatedElements.has(element)) {
                        this.animatedElements.add(element);
                        
                        // Délai réduit ou supprimé sur mobile
                        const mobileDelay = this.isMobile ? Math.min(options.delay / 2, 100) : options.delay;
                        
                        setTimeout(() => {
                            this.triggerAnimation(element, options.animation);
                        }, mobileDelay);
                        
                        observer.unobserve(element);
                    }
                });
            }, {
                // Seuils optimisés pour mobile
                threshold: this.isSmallMobile ? 0.1 : 0.2,
                rootMargin: this.getMobileRootMargin()
            });

            observer.observe(element);
        }

        /**
         * Calculer la marge root optimisée selon l'écran
         */
        getMobileRootMargin() {
            if (this.isSmallMobile) {
                return '150px 0px -50px 0px';  // Très anticipé sur petit écran
            } else if (this.isMobile) {
                return '100px 0px -30px 0px';  // Anticipé sur mobile
            } else {
                return '50px 0px 0px 0px';     // Standard desktop
            }
        }

        /**
         * Transform initial selon le type d'animation
         */
        getInitialTransform(animation) {
            const transforms = {
                'fade-up': 'translateY(30px)',
                'fade-down': 'translateY(-30px)',
                'fade-left': 'translateX(30px)',
                'fade-right': 'translateX(-30px)',
                'fade-up-right': 'translate(-20px, 20px)',
                'fade-up-left': 'translate(20px, 20px)',
                'fade-down-right': 'translate(-20px, -20px)',
                'fade-down-left': 'translate(20px, -20px)',
                'zoom-in': 'scale(0.8)',
                'zoom-in-up': 'scale(0.8) translateY(20px)',
                'zoom-in-down': 'scale(0.8) translateY(-20px)',
                'zoom-in-left': 'scale(0.8) translateX(20px)',
                'zoom-in-right': 'scale(0.8) translateX(-20px)',
                'flip-left': 'rotateY(-90deg)',
                'flip-right': 'rotateY(90deg)',
                'flip-up': 'rotateX(-90deg)',
                'flip-down': 'rotateX(90deg)',
                'fade': 'none'
            };

            return transforms[animation] || 'translateY(20px)';
        }

        /**
         * Déclencher l'animation finale
         */
        triggerAnimation(element, animationType) {
            element.style.opacity = '1';
            element.style.transform = 'translate(0) scale(1) rotate(0)';
            
            // Ajouter une classe pour le CSS custom si nécessaire
            element.classList.add('mobile-animated', `mobile-${animationType}`);
            
            // Feedback haptique léger pour l'animation
            if (navigator.vibrate && this.shouldVibrate()) {
                navigator.vibrate(10);
            }
        }

        /**
         * Animations progressives pour les sections
         */
        addProgressiveAnimations() {
            const sections = document.querySelectorAll('section, .section');
            
            sections.forEach((section, index) => {
                const elementsInSection = section.querySelectorAll('h1, h2, h3, p, .card, .feature-item, img');
                
                elementsInSection.forEach((element, elementIndex) => {
                    if (!element.hasAttribute('data-aos')) {
                        // Ajouter des animations progressives automatiques
                        const delay = elementIndex * 50; // 50ms entre chaque élément
                        this.applyProgressiveAnimation(element, delay, index);
                    }
                });
            });
        }

        /**
         * Animation progressive automatique
         */
        applyProgressiveAnimation(element, delay, sectionIndex) {
            // Types d'animation selon l'élément
            const animationType = this.getAnimationTypeForElement(element);
            
            element.style.opacity = '0';
            element.style.transform = this.getInitialTransform(animationType);
            element.style.transition = `all 300ms cubic-bezier(0.25, 0.46, 0.45, 0.94) ${delay}ms`;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            element.style.opacity = '1';
                            element.style.transform = 'translate(0) scale(1) rotate(0)';
                        }, this.isMobile ? Math.min(delay, 100) : delay);
                        
                        observer.unobserve(element);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: this.getMobileRootMargin()
            });

            observer.observe(element);
        }

        /**
         * Déterminer le type d'animation selon l'élément
         */
        getAnimationTypeForElement(element) {
            const tagName = element.tagName.toLowerCase();
            
            if (['h1', 'h2', 'h3'].includes(tagName)) {
                return 'fade-down';
            } else if (tagName === 'img') {
                return 'zoom-in';
            } else if (element.classList.contains('card')) {
                return 'fade-up';
            } else {
                return 'fade-up';
            }
        }

        /**
         * Animations basées sur le viewport intelligent
         */
        setupViewportAnimations() {
            // Animation quand l'utilisateur s'arrête de scroller
            let scrollTimer;
            let lastScrollTop = 0;

            window.addEventListener('scroll', () => {
                const scrollTop = window.pageYOffset;
                
                // Détecter si on scroll vers le haut ou le bas
                const scrollDirection = scrollTop > lastScrollTop ? 'down' : 'up';
                lastScrollTop = scrollTop;

                // Déclencher animations quand on arrête de scroller
                clearTimeout(scrollTimer);
                scrollTimer = setTimeout(() => {
                    this.triggerViewportAnimations(scrollDirection);
                }, 150);
            }, { passive: true });
        }

        /**
         * Déclencher les animations dans le viewport actuel
         */
        triggerViewportAnimations(direction) {
            const viewportHeight = window.innerHeight;
            const scrollTop = window.pageYOffset;
            
            const elementsInViewport = document.querySelectorAll('[data-viewport-animate]');
            
            elementsInViewport.forEach(element => {
                const rect = element.getBoundingClientRect();
                const elementTop = rect.top + scrollTop;
                const elementBottom = elementTop + rect.height;
                
                // Vérifier si l'élément est dans le viewport ou proche
                const isInViewport = (
                    elementTop < scrollTop + viewportHeight + 100 &&
                    elementBottom > scrollTop - 100
                );

                if (isInViewport && !element.classList.contains('viewport-animated')) {
                    element.classList.add('viewport-animated');
                    this.triggerAnimation(element, element.getAttribute('data-viewport-animate') || 'fade-up');
                }
            });
        }

        /**
         * Configuration des animations selon les sections
         */
        setupSmartAnimations() {
            // Animations spécifiques pour chaque section
            const sectionConfigs = {
                '.hero-section': { animation: 'fade-down', stagger: 100 },
                '.features-section': { animation: 'fade-up', stagger: 150 },
                '.about-section': { animation: 'fade-left', stagger: 80 },
                '.blog-section': { animation: 'zoom-in', stagger: 120 },
                '.contact-section': { animation: 'fade-up', stagger: 60 }
            };

            Object.entries(sectionConfigs).forEach(([selector, config]) => {
                const section = document.querySelector(selector);
                if (section) {
                    this.applySectionAnimations(section, config);
                }
            });
        }

        /**
         * Appliquer des animations à une section spécifique
         */
        applySectionAnimations(section, config) {
            const elements = section.querySelectorAll('h1, h2, h3, p, .card, .btn, img');
            
            elements.forEach((element, index) => {
                const delay = index * config.stagger;
                element.setAttribute('data-mobile-animation', config.animation);
                element.setAttribute('data-mobile-delay', delay);
                
                this.applyCustomAnimation(element, {
                    animation: config.animation,
                    delay: this.isMobile ? Math.min(delay, 200) : delay,
                    duration: 400
                });
            });
        }

        /**
         * Vérifier si le feedback haptique doit être activé
         */
        shouldVibrate() {
            // Vibrer seulement pour les éléments importants sur mobile
            return this.isMobile && 
                   !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        }
    }

    // Styles CSS pour les animations custom
    const customAnimationStyles = `
        .mobile-animated {
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        .mobile-fade-up {
            transform-origin: center bottom;
        }

        .mobile-fade-down {
            transform-origin: center top;
        }

        .mobile-zoom-in {
            transform-origin: center center;
        }

        .mobile-flip-left,
        .mobile-flip-right {
            transform-origin: center center;
            perspective: 2000px;
        }

        /* Réduction des animations sur préférence utilisateur */
        @media (prefers-reduced-motion: reduce) {
            .mobile-animated {
                animation: none !important;
                transition: opacity 0.1s !important;
            }
        }

        /* Optimisations pour très petits écrans */
        @media (max-width: 480px) {
            .mobile-animated {
                transition-duration: 0.2s !important;
            }
        }

        /* Classe helper pour viewport animations */
        [data-viewport-animate] {
            transition: all 0.4s ease-out;
        }

        .viewport-animated {
            opacity: 1 !important;
            transform: translate(0) scale(1) rotate(0) !important;
        }
    `;

    // Injecter les styles
    const styleSheet = document.createElement('style');
    styleSheet.textContent = customAnimationStyles;
    document.head.appendChild(styleSheet);

    // Initialisation après AOS
    setTimeout(() => {
        new MobileAnimationOptimizer();
    }, 200);

    // Export pour usage global
    window.MobileAnimationOptimizer = MobileAnimationOptimizer;

})();