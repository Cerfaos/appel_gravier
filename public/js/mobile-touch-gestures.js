/**
 * CERFAOS - Gestion des gestures tactiles mobiles
 * Optimisations pour améliorer l'expérience utilisateur mobile
 */

(function() {
    'use strict';

    // Configuration des gestures
    const TOUCH_CONFIG = {
        swipeThreshold: 50,           // Distance minimale pour détecter un swipe
        swipeTimeout: 300,            // Temps maximum pour un swipe
        tapTimeout: 200,              // Temps maximum pour un tap
        doubleTapDelay: 300,          // Délai pour détecter double tap
        longPressDelay: 500,          // Délai pour long press
        hapticEnabled: true           // Vibration tactile si supportée
    };

    // État global des touches
    let touchState = {
        startX: 0,
        startY: 0,
        startTime: 0,
        isScrolling: false,
        lastTap: 0
    };

    /**
     * Classe principale pour la gestion des gestures
     */
    class TouchGestureManager {
        constructor() {
            this.init();
        }

        init() {
            this.setupTouchEvents();
            this.setupClickEnhancements();
            this.setupSwipeGestures();
            this.setupPullToRefresh();
            this.addHapticFeedback();
            
            console.log('✅ Touch Gesture Manager initialisé');
        }

        /**
         * Configuration des événements tactiles de base
         */
        setupTouchEvents() {
            // Amélioration du feedback pour tous les éléments interactifs
            document.addEventListener('touchstart', this.handleTouchStart.bind(this), { passive: false });
            document.addEventListener('touchend', this.handleTouchEnd.bind(this), { passive: false });
            document.addEventListener('touchmove', this.handleTouchMove.bind(this), { passive: false });
            
            // Gestion spéciale pour les boutons
            this.enhanceButtons();
        }

        /**
         * Gestion du début du toucher
         */
        handleTouchStart(e) {
            const touch = e.touches[0];
            touchState.startX = touch.clientX;
            touchState.startY = touch.clientY;
            touchState.startTime = Date.now();
            touchState.isScrolling = false;

            const target = e.target.closest('button, .btn, .touch-target, .card-interactive');
            if (target) {
                target.classList.add('touch-active');
                this.triggerHaptic('light');
            }
        }

        /**
         * Gestion du mouvement tactile
         */
        handleTouchMove(e) {
            if (!touchState.startTime) return;

            const touch = e.touches[0];
            const deltaX = Math.abs(touch.clientX - touchState.startX);
            const deltaY = Math.abs(touch.clientY - touchState.startY);

            // Détecter si c'est un scroll
            if (deltaY > deltaX && deltaY > 10) {
                touchState.isScrolling = true;
            }

            // Supprimer les états actifs si l'utilisateur bouge trop
            if (deltaX > 20 || deltaY > 20) {
                document.querySelectorAll('.touch-active').forEach(el => {
                    el.classList.remove('touch-active');
                });
            }
        }

        /**
         * Gestion de la fin du toucher
         */
        handleTouchEnd(e) {
            const target = e.target.closest('button, .btn, .touch-target, .card-interactive');
            
            // Nettoyer les états actifs
            document.querySelectorAll('.touch-active').forEach(el => {
                el.classList.remove('touch-active');
            });

            if (!touchState.startTime) return;

            const duration = Date.now() - touchState.startTime;
            const touch = e.changedTouches[0];
            const deltaX = touch.clientX - touchState.startX;
            const deltaY = touch.clientY - touchState.startY;

            // Détecter les différents types de gestures
            this.detectGestures({
                target: e.target,
                duration,
                deltaX,
                deltaY,
                isScrolling: touchState.isScrolling
            });

            // Réinitialiser l'état
            touchState = { startX: 0, startY: 0, startTime: 0, isScrolling: false, lastTap: 0 };
        }

        /**
         * Détection des gestures
         */
        detectGestures({ target, duration, deltaX, deltaY, isScrolling }) {
            const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY);
            
            // Long press
            if (duration > TOUCH_CONFIG.longPressDelay && distance < 20) {
                this.handleLongPress(target);
                return;
            }

            // Swipe
            if (!isScrolling && distance > TOUCH_CONFIG.swipeThreshold && duration < TOUCH_CONFIG.swipeTimeout) {
                this.handleSwipe(target, deltaX, deltaY);
                return;
            }

            // Tap simple ou double tap
            if (distance < 20 && duration < TOUCH_CONFIG.tapTimeout) {
                const now = Date.now();
                if (now - touchState.lastTap < TOUCH_CONFIG.doubleTapDelay) {
                    this.handleDoubleTap(target);
                } else {
                    setTimeout(() => {
                        if (Date.now() - touchState.lastTap >= TOUCH_CONFIG.doubleTapDelay) {
                            this.handleTap(target);
                        }
                    }, TOUCH_CONFIG.doubleTapDelay);
                }
                touchState.lastTap = now;
            }
        }

        /**
         * Amélioration des boutons avec feedback tactile
         */
        enhanceButtons() {
            document.querySelectorAll('button, .btn, [role="button"]').forEach(button => {
                if (!button.dataset.touchEnhanced) {
                    button.dataset.touchEnhanced = 'true';
                    button.classList.add('touch-target', 'ripple-effect');
                    
                    // Ajouter l'effet ripple
                    button.addEventListener('touchstart', this.createRipple.bind(this));
                }
            });
        }

        /**
         * Création de l'effet ripple
         */
        createRipple(e) {
            const button = e.currentTarget;
            const circle = document.createElement('span');
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;

            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${e.touches[0].clientX - button.offsetLeft - radius}px`;
            circle.style.top = `${e.touches[0].clientY - button.offsetTop - radius}px`;
            circle.classList.add('ripple');

            const ripple = button.getElementsByClassName('ripple')[0];
            if (ripple) {
                ripple.remove();
            }

            button.appendChild(circle);
        }

        /**
         * Gestion des swipes
         */
        handleSwipe(target, deltaX, deltaY) {
            let direction;
            
            if (Math.abs(deltaX) > Math.abs(deltaY)) {
                direction = deltaX > 0 ? 'right' : 'left';
            } else {
                direction = deltaY > 0 ? 'down' : 'up';
            }

            // Dispatch custom event
            const swipeEvent = new CustomEvent('swipe', {
                detail: { direction, target, deltaX, deltaY }
            });
            target.dispatchEvent(swipeEvent);

            // Actions spécifiques selon les éléments
            this.handleSwipeActions(target, direction);
        }

        /**
         * Actions spécifiques pour les swipes
         */
        handleSwipeActions(target, direction) {
            // Swipe sur les cartes
            if (target.classList.contains('card-interactive')) {
                if (direction === 'left') {
                    target.classList.add('swipe-left-animation');
                    setTimeout(() => target.classList.remove('swipe-left-animation'), 300);
                }
            }

            // Navigation par swipe
            const swipeNav = target.closest('.swipe-navigation');
            if (swipeNav) {
                this.handleNavigationSwipe(swipeNav, direction);
            }

            // Carrousels
            const carousel = target.closest('.carousel, .slider');
            if (carousel) {
                this.handleCarouselSwipe(carousel, direction);
            }
        }

        /**
         * Gestion du swipe pour la navigation
         */
        handleNavigationSwipe(element, direction) {
            if (direction === 'right') {
                // Retour en arrière
                if (window.history.length > 1) {
                    window.history.back();
                }
            }
        }

        /**
         * Gestion du swipe pour les carrousels
         */
        handleCarouselSwipe(carousel, direction) {
            const nextBtn = carousel.querySelector('.carousel-control-next, .slider-next');
            const prevBtn = carousel.querySelector('.carousel-control-prev, .slider-prev');

            if (direction === 'left' && nextBtn) {
                nextBtn.click();
            } else if (direction === 'right' && prevBtn) {
                prevBtn.click();
            }
        }

        /**
         * Gestion du tap simple
         */
        handleTap(target) {
            // Feedback visuel léger
            target.classList.add('tap-feedback');
            setTimeout(() => target.classList.remove('tap-feedback'), 150);
        }

        /**
         * Gestion du double tap
         */
        handleDoubleTap(target) {
            const doubleTapEvent = new CustomEvent('doubletap', { detail: { target } });
            target.dispatchEvent(doubleTapEvent);

            // Actions par défaut pour le double tap
            if (target.classList.contains('zoomable')) {
                this.handleZoom(target);
            }
        }

        /**
         * Gestion du long press
         */
        handleLongPress(target) {
            this.triggerHaptic('medium');
            
            const longPressEvent = new CustomEvent('longpress', { detail: { target } });
            target.dispatchEvent(longPressEvent);

            // Actions par défaut pour le long press
            if (target.tagName === 'A' || target.classList.contains('contextual')) {
                this.showContextMenu(target);
            }
        }

        /**
         * Amélioration des clics
         */
        setupClickEnhancements() {
            // Éliminer le délai de 300ms sur les clics
            document.addEventListener('touchend', (e) => {
                const target = e.target;
                if (target.tagName === 'A' || target.tagName === 'BUTTON' || target.hasAttribute('onclick')) {
                    e.preventDefault();
                    target.click();
                }
            });
        }

        /**
         * Configuration du pull-to-refresh
         */
        setupPullToRefresh() {
            let startY = 0;
            let pullDistance = 0;
            const threshold = 100;
            let isPulling = false;

            document.addEventListener('touchstart', (e) => {
                if (window.pageYOffset === 0) {
                    startY = e.touches[0].clientY;
                }
            });

            document.addEventListener('touchmove', (e) => {
                if (startY && window.pageYOffset === 0) {
                    pullDistance = e.touches[0].clientY - startY;
                    
                    if (pullDistance > 20) {
                        isPulling = true;
                        e.preventDefault();
                        
                        // Effet visuel de pull
                        document.body.style.transform = `translateY(${Math.min(pullDistance / 3, 50)}px)`;
                        
                        if (pullDistance > threshold) {
                            document.body.classList.add('pull-refresh-ready');
                        }
                    }
                }
            }, { passive: false });

            document.addEventListener('touchend', () => {
                if (isPulling) {
                    document.body.style.transform = '';
                    
                    if (pullDistance > threshold) {
                        // Déclencher le refresh
                        this.triggerRefresh();
                    }
                    
                    document.body.classList.remove('pull-refresh-ready');
                }
                
                startY = 0;
                pullDistance = 0;
                isPulling = false;
            });
        }

        /**
         * Déclencher le refresh de la page
         */
        triggerRefresh() {
            this.triggerHaptic('heavy');
            
            // Afficher un indicateur de chargement
            const loader = document.createElement('div');
            loader.className = 'refresh-loader';
            loader.innerHTML = '🔄 Actualisation...';
            document.body.appendChild(loader);
            
            // Simuler le chargement puis rafraîchir
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }

        /**
         * Feedback haptique
         */
        triggerHaptic(intensity = 'light') {
            if (!TOUCH_CONFIG.hapticEnabled || !navigator.vibrate) return;
            
            const patterns = {
                light: 10,
                medium: 50,
                heavy: [50, 30, 50]
            };
            
            navigator.vibrate(patterns[intensity] || patterns.light);
        }

        /**
         * Ajouter le support haptique
         */
        addHapticFeedback() {
            // Feedback sur les interactions importantes
            document.addEventListener('click', (e) => {
                const target = e.target;
                if (target.matches('button, .btn, [type="submit"]')) {
                    this.triggerHaptic('light');
                }
            });
        }

        /**
         * Afficher un menu contextuel
         */
        showContextMenu(target) {
            // Créer un menu contextuel simple
            const menu = document.createElement('div');
            menu.className = 'context-menu';
            menu.innerHTML = `
                <div class="context-menu-item" data-action="copy">Copier</div>
                <div class="context-menu-item" data-action="share">Partager</div>
                <div class="context-menu-item" data-action="bookmark">Marquer</div>
            `;
            
            document.body.appendChild(menu);
            
            // Positionner le menu
            const rect = target.getBoundingClientRect();
            menu.style.position = 'fixed';
            menu.style.top = `${rect.bottom + 10}px`;
            menu.style.left = `${rect.left}px`;
            menu.style.zIndex = '9999';
            
            // Supprimer le menu après un délai
            setTimeout(() => {
                menu.remove();
            }, 3000);
        }

        /**
         * Gestion du zoom
         */
        handleZoom(target) {
            target.classList.toggle('zoomed');
        }
    }

    // Styles CSS pour les animations ajoutées dynamiquement
    const styles = `
        .touch-active {
            transform: scale(0.95) !important;
            transition: transform 0.1s ease-out !important;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .swipe-left-animation {
            transform: translateX(-10px);
            transition: transform 0.3s ease;
        }
        
        .tap-feedback {
            background-color: rgba(5, 150, 105, 0.1) !important;
            transition: background-color 0.15s ease !important;
        }
        
        .context-menu {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            min-width: 120px;
        }
        
        .context-menu-item {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }
        
        .context-menu-item:hover {
            background-color: #f8f9fa;
        }
        
        .context-menu-item:last-child {
            border-bottom: none;
        }
        
        .pull-refresh-ready {
            background: linear-gradient(to bottom, rgba(5, 150, 105, 0.1) 0%, transparent 100%);
        }
        
        .refresh-loader {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            z-index: 10000;
            font-size: 14px;
        }
        
        .zoomed {
            transform: scale(1.2);
            transition: transform 0.3s ease;
            z-index: 100;
        }
    `;

    // Injecter les styles
    const styleSheet = document.createElement('style');
    styleSheet.textContent = styles;
    document.head.appendChild(styleSheet);

    // Initialisation quand le DOM est prêt
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            new TouchGestureManager();
        });
    } else {
        new TouchGestureManager();
    }

    // Exporter pour usage global si nécessaire
    window.TouchGestureManager = TouchGestureManager;

})();