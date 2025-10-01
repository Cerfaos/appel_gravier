<!-- OPTION 5 : EFFET KEN BURNS - Zoom et pan progressif sur images -->
<section class="relative min-h-screen text-white overflow-hidden bg-black">
    <!-- Vidéo de fond fixe avec opacité fluctuante -->
    <video autoplay muted loop playsinline class="background-video absolute inset-0 w-full h-full object-cover"
           style="filter: blur(3px);">
        <source src="{{ asset('upload/design-test/videos/Sept2025 ‐ Bilan720.mp4') }}" type="video/mp4">
    </video>

    <!-- Conteneur pour l'effet Ken Burns -->
    <div class="ken-burns-container absolute inset-0">
        <!-- Les slides seront créés dynamiquement par JavaScript -->
    </div>

    <!-- Overlay gradient pour améliorer la lisibilité -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/20 to-black/60 z-10"></div>
    
    <!-- Layout responsive : centré sur mobile, aligné à gauche sur desktop -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-screen flex items-center justify-center lg:items-start lg:justify-start">
        <!-- Mobile : layout centré -->
        <div class="block lg:hidden text-center">
            <div class="space-y-8">
                <h1 class="text-4xl md:text-6xl font-bold leading-tight tracking-tight text-white">
                    {{ $slider->title ?? 'Découvrez l\'aventure qui vous attend' }}
                </h1>
                <p class="text-lg md:text-xl max-w-3xl mx-auto opacity-90 leading-relaxed font-light text-white">
                    {{ $slider->description ?? 'Explorez des itinéraires uniques, rejoignez nos sorties en groupe, et enrichissez-vous de nos conseils d\'experts pour vos aventures outdoor.' }}
                </p>
            </div>
        </div>

    </div>
    
    <!-- Desktop : Contenu au centre à gauche avec animations corrigées -->
    <div class="absolute top-1/2 left-0 right-0 p-8 z-30 transform -translate-y-1/2">
        <div class="hidden lg:block max-w-2xl">
            <!-- Titre avec animation élégante -->
            <h1 class="text-5xl xl:text-6xl font-bold text-white mb-4 animate-elegant-title">
                {{ $slider->title ?? 'Découvrez l\'aventure qui vous attend' }}
            </h1>
            
            <!-- Description avec animation -->
            <p class="text-lg text-white/90 mb-4 animate-elegant-desc">
                {{ $slider->description ?? 'Explorez des itinéraires uniques, rejoignez nos sorties en groupe, et enrichissez-vous de nos conseils d\'experts pour vos aventures outdoor.' }}
            </p>
            
            <!-- CTA FINAL avec style et animations -->
            <div id="scroll-btn-hero" class="animate-elegant-cta"
                 style="background: transparent; color: white; padding: 14px 28px; margin: 10px 0; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 16px; display: inline-block; user-select: none; transition: all 0.3s ease; border: 2px solid rgba(255,255,255,0.8); backdrop-filter: blur(10px);">
                Commencer l'exploration
            </div>
            
            <script>
                document.getElementById('scroll-btn-hero').addEventListener('click', function() {
                    window.scrollTo({
                        top: window.innerHeight,
                        behavior: 'smooth'
                    });
                });
                
                // Hover effects
                document.getElementById('scroll-btn-hero').addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                    this.style.background = 'rgba(255,255,255,0.2)';
                    this.style.borderColor = 'rgba(255,255,255,1)';
                });
                
                document.getElementById('scroll-btn-hero').addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                    this.style.background = 'transparent';
                    this.style.borderColor = 'rgba(255,255,255,0.8)';
                });
            </script>
        </div>

        <!-- CTA mobile centré -->
        <div class="flex lg:hidden pt-8 justify-center animate-fade-in-up">
            <a href="#main-content" class="scroll-link inline-flex items-center text-white hover:text-yellow-200 group transition-all duration-300">
                <span class="text-xl font-medium">Commencer l'exploration</span>
                <svg class="ml-3 w-8 h-8 group-hover:translate-y-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </a>
        </div>
    </div>
    
    
    <!-- Styles intégrés -->
    <style>
        /* ===== BACKGROUND VIDEO WITH PULSING OPACITY ===== */
        @keyframes backgroundPulse {
            0%, 100% {
                opacity: 0.7;
            }
            50% {
                opacity: 1;
            }
        }

        .background-video {
            animation: backgroundPulse 8s ease-in-out infinite;
            z-index: 1;
        }

        /* ===== KEN BURNS EFFECT STYLES ===== */
        .ken-burns-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 2s ease-in-out;
            z-index: 2;
        }

        .ken-burns-slide.active {
            opacity: 0.4;
        }

        /* Animations Ken Burns - Différentes variantes */
        @keyframes kenBurnsZoomIn {
            0% {
                transform: scale(1) translate(0, 0);
            }
            100% {
                transform: scale(1.2) translate(-5%, -5%);
            }
        }

        @keyframes kenBurnsZoomOut {
            0% {
                transform: scale(1.2) translate(5%, 5%);
            }
            100% {
                transform: scale(1) translate(0, 0);
            }
        }

        @keyframes kenBurnsPanLeft {
            0% {
                transform: scale(1.15) translateX(5%);
            }
            100% {
                transform: scale(1.15) translateX(-5%);
            }
        }

        @keyframes kenBurnsPanRight {
            0% {
                transform: scale(1.15) translateX(-5%);
            }
            100% {
                transform: scale(1.15) translateX(5%);
            }
        }

        @keyframes kenBurnsDiagonal {
            0% {
                transform: scale(1) translate(0, 0);
            }
            100% {
                transform: scale(1.2) translate(-8%, 8%);
            }
        }

        /* ===== ANIMATIONS EXISTANTES ===== */
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Animation blur to focus élégante */
        @keyframes blur-to-focus {
            0% { 
                filter: blur(15px);
                transform: scale(0.9);
                opacity: 0;
            }
            60% {
                filter: blur(0px);
                opacity: 0.8;
            }
            100% { 
                filter: blur(0px);
                transform: scale(1);
                opacity: 1;
            }
        }
        
        /* Animation elastic scale */
        @keyframes elastic-scale {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        /* Animation fade cascade */
        @keyframes elegant-fade {
            0% {
                transform: translateY(30px) scale(0.95);
                opacity: 0;
                filter: blur(5px);
            }
            100% {
                transform: translateY(0) scale(1);
                opacity: 1;
                filter: blur(0px);
            }
        }
        
        @keyframes blink-cursor {
            0%, 50% { border-right: 3px solid white; }
            51%, 100% { border-right: 3px solid transparent; }
        }
        
        /* Animation slide-up pour la description */
        @keyframes slide-up {
            from { 
                opacity: 0; 
                transform: translateY(40px);
            }
            to { 
                opacity: 0.9; 
                transform: translateY(0);
            }
        }
        
        /* Animation fade-in lente pour le CTA */
        @keyframes fade-in-slow {
            from { 
                opacity: 0; 
                transform: translateY(20px) scale(0.95);
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1);
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes float-delayed {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes scroll-down {
            0% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(10px); opacity: 0.5; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        .animate-fade-in-up { animation: fade-in-up 1s ease-out; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float-delayed 8s ease-in-out infinite; }
        .animate-float-slow { animation: float-slow 10s ease-in-out infinite; }
        .animate-scroll-down { animation: scroll-down 2s ease-in-out infinite; }
        
        /* Classes d'animation desktop - VISIBLES dès le début */
        @media (min-width: 1024px) {
            .animate-elegant-title { 
                animation: blur-to-focus 2s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.3s forwards;
                /* Commence visible et s'améliore */
                opacity: 0.7;
                filter: blur(2px);
                transform: scale(0.98);
            }
            
            .animate-elegant-desc { 
                animation: elastic-scale 1.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.8s forwards;
                /* Commence visible */
                opacity: 0.6;
                transform: scale(0.96);
            }
            
            .animate-elegant-cta { 
                animation: elegant-fade 1.5s ease-out 1.4s forwards;
                /* Commence visible */
                opacity: 0.5;
                transform: translateY(10px) scale(0.98);
            }
        }
        
        /* Mobile - Style statique sans animations */
        @media (max-width: 1023px) {
            .animate-elegant-title, 
            .animate-elegant-desc, 
            .animate-elegant-cta { 
                /* Éléments statiques et entièrement visibles */
                opacity: 1;
                filter: none;
                transform: none;
                animation: none;
            }
            
            .animate-typewriter { 
                animation: fade-in-up 1s ease-out;
            }
            
            .animate-slide-up-delayed { 
                animation: fade-in-up 1s ease-out 0.3s forwards;
                opacity: 0;
            }
            
            .animate-fade-in-slow { 
                animation: fade-in-up 1s ease-out 0.6s forwards;
                opacity: 0;
            }
        }
        
        html { scroll-behavior: smooth; }
        
        .scroll-link { cursor: pointer; }
    </style>

    <!-- JavaScript - Ken Burns Effect & Smooth scroll -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== KEN BURNS EFFECT =====
            const container = document.querySelector('.ken-burns-container');

            // Images pour le diaporama (utilisons des gradients colorés pour tester sans problème de chemin)
            const slides = [
                { type: 'gradient', value: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' },
                { type: 'gradient', value: 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)' },
                { type: 'gradient', value: 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)' },
                { type: 'gradient', value: 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)' },
                { type: 'gradient', value: 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)' }
            ];

            // Animations Ken Burns
            const animations = [
                'kenBurnsZoomIn',
                'kenBurnsZoomOut',
                'kenBurnsPanLeft',
                'kenBurnsPanRight',
                'kenBurnsDiagonal'
            ];

            let currentSlide = 0;

            // Créer les slides
            slides.forEach((slide, index) => {
                const slideEl = document.createElement('div');
                slideEl.className = 'ken-burns-slide';
                slideEl.style.background = slide.value;

                if (index === 0) {
                    slideEl.classList.add('active');
                    slideEl.style.animation = `${animations[index]} 8s ease-in-out infinite alternate`;
                }

                container.appendChild(slideEl);
            });

            const slideElements = document.querySelectorAll('.ken-burns-slide');

            // Fonction pour changer de slide
            function changeSlide() {
                // Masquer le slide actuel
                slideElements[currentSlide].classList.remove('active');

                // Passer au slide suivant
                currentSlide = (currentSlide + 1) % slides.length;

                // Afficher le nouveau slide avec son animation
                const nextSlide = slideElements[currentSlide];
                nextSlide.classList.add('active');
                nextSlide.style.animation = `${animations[currentSlide % animations.length]} 8s ease-in-out infinite alternate`;
            }

            // Changer de slide toutes les 8 secondes
            setInterval(changeSlide, 8000);

            // ===== SMOOTH SCROLL =====
            document.querySelectorAll('.scroll-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const offsetTop = target.offsetTop - 100;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</section>