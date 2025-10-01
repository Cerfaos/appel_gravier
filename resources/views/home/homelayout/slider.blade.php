<!-- GRAND HERO VISUEL - Carrousel d'images dynamique -->
<section class="relative min-h-screen text-white overflow-hidden">
    <!-- Carrousel d'images en arrière-plan -->
    <div class="carousel-container absolute inset-0 w-full h-full">
        <!-- Image 1 -->
        <div class="carousel-slide active absolute inset-0 w-full h-full bg-no-repeat bg-center"
             style="background-image: url('{{ asset('upload/design-test/images/cerfaos_alsace16.png') }}');
                    background-size: contain;">
        </div>
        <!-- Image 2 -->
        <div class="carousel-slide absolute inset-0 w-full h-full bg-no-repeat bg-center"
             style="background-image: url('{{ asset('upload/design-test/images/moi_descente.png') }}');
                    background-size: contain;">
        </div>
        <!-- Image 3 -->
        <div class="carousel-slide absolute inset-0 w-full h-full bg-no-repeat bg-center"
             style="background-image: url('{{ asset('upload/design-test/images/moi_jaune.png') }}');
                    background-size: contain;">
        </div>
        <!-- Image 4 -->
        <div class="carousel-slide absolute inset-0 w-full h-full bg-no-repeat bg-center"
             style="background-image: url('{{ asset('upload/design-test/images/aube_foret.png') }}');
                    background-size: contain;">
        </div>
        <!-- Image 5 -->
        <div class="carousel-slide absolute inset-0 w-full h-full bg-no-repeat bg-center"
             style="background-image: url('{{ asset('upload/design-test/images/cerfaos_sept25_03.png') }}');
                    background-size: contain;">
        </div>
    </div>

    <!-- Overlay gradient outdoor par-dessus les images -->
    <div class="absolute inset-0 bg-black/30"></div>
    
    <!-- Particules d'animation -->
    <div class="absolute inset-0">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white/20 rounded-full animate-float"></div>
        <div class="absolute top-1/3 right-1/3 w-3 h-3 bg-white/10 rounded-full animate-float-delayed"></div>
        <div class="absolute bottom-1/3 left-1/2 w-1 h-1 bg-white/30 rounded-full animate-float-slow"></div>
    </div>
    
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
        /* ===== CARROUSEL STYLES ===== */
        .carousel-slide {
            transition: opacity 1.5s ease-in-out;
            opacity: 0 !important;
            z-index: 1 !important;
            visibility: hidden;
        }

        .carousel-slide.active {
            opacity: 1 !important;
            z-index: 2 !important;
            visibility: visible;
            transition: opacity 1.5s ease-in-out;
        }

        /* Initialisation - Cacher toutes les slides sauf la première */
        .carousel-slide:not(.active) {
            display: none;
        }

        .carousel-slide.active {
            display: block;
        }

        .carousel-dot {
            cursor: pointer;
            transform: scale(1);
            transition: all 0.3s ease;
        }

        .carousel-dot:hover {
            transform: scale(1.3);
        }

        .carousel-dot.active {
            transform: scale(1.4);
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

    <!-- Navigation du carrousel (points indicateurs) -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-50 flex space-x-3">
        <button class="carousel-dot active w-3 h-3 rounded-full bg-white/80 hover:bg-white transition-all duration-300" data-slide="0"></button>
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/40 hover:bg-white/80 transition-all duration-300" data-slide="1"></button>
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/40 hover:bg-white/80 transition-all duration-300" data-slide="2"></button>
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/40 hover:bg-white/80 transition-all duration-300" data-slide="3"></button>
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/40 hover:bg-white/80 transition-all duration-300" data-slide="4"></button>
    </div>

    <!-- JavaScript - Carrousel & Smooth scroll -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== CARROUSEL =====
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-dot');
            let currentSlide = 0;
            let carouselInterval;
            let isPaused = false;

            // Fonction pour changer de slide
            function showSlide(index) {
                console.log('Changement de slide vers:', index);

                // Retirer la classe active de tous les slides
                slides.forEach((slide, i) => {
                    slide.classList.remove('active');
                    slide.style.opacity = '0';
                    slide.style.zIndex = '1';
                });

                // Retirer la classe active de tous les dots
                dots.forEach(dot => {
                    dot.classList.remove('active');
                    dot.classList.remove('bg-white/80');
                    dot.classList.add('bg-white/40');
                });

                // Activer le slide et le dot correspondants
                slides[index].classList.add('active');
                slides[index].style.opacity = '1';
                slides[index].style.zIndex = '2';

                dots[index].classList.add('active');
                dots[index].classList.remove('bg-white/40');
                dots[index].classList.add('bg-white/80');

                currentSlide = index;
            }

            // Fonction pour passer au slide suivant
            function nextSlide() {
                if (!isPaused) {
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);
                }
            }

            // Démarrer le carrousel automatique
            function startCarousel() {
                carouselInterval = setInterval(nextSlide, 5000); // Change toutes les 5 secondes
            }

            // Arrêter le carrousel
            function stopCarousel() {
                clearInterval(carouselInterval);
            }

            // Navigation manuelle avec les dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', function() {
                    showSlide(index);
                    stopCarousel();
                    isPaused = true;
                    // Redémarrer après 10 secondes
                    setTimeout(() => {
                        isPaused = false;
                        startCarousel();
                    }, 10000);
                });
            });

            // Pause au survol
            const carouselContainer = document.querySelector('.carousel-container');
            carouselContainer.addEventListener('mouseenter', () => {
                isPaused = true;
            });
            carouselContainer.addEventListener('mouseleave', () => {
                isPaused = false;
            });

            // Initialiser le carrousel
            showSlide(0);
            startCarousel();

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