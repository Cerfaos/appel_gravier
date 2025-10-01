<!-- OPTION 3 : MOSAÏQUE ANIMÉE - Grille dynamique de tuiles -->
<section class="relative min-h-screen text-white overflow-hidden bg-black">
    <!-- Grille de mosaïque -->
    <div class="mosaic-grid absolute inset-0 grid grid-cols-6 grid-rows-4 gap-1">
        <!-- Les tuiles seront créées dynamiquement par JavaScript -->
    </div>

    <!-- Overlay gradient pour améliorer la lisibilité -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70 z-10"></div>
    
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
        /* ===== MOSAIC STYLES ===== */
        .mosaic-tile {
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0.7;
        }

        .mosaic-tile:hover {
            transform: scale(1.1);
            opacity: 1;
            z-index: 5;
        }

        @keyframes mosaic-reveal {
            from {
                opacity: 0;
                transform: scale(0.8) rotate(5deg);
            }
            to {
                opacity: 0.7;
                transform: scale(1) rotate(0deg);
            }
        }

        @keyframes mosaic-pulse {
            0%, 100% {
                opacity: 0.7;
                filter: brightness(1);
            }
            50% {
                opacity: 0.9;
                filter: brightness(1.2);
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

    <!-- JavaScript - Mosaic Animation & Smooth scroll -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== MOSAIC ANIMATION =====
            const mosaicGrid = document.querySelector('.mosaic-grid');

            // Couleurs dynamiques pour les tuiles
            const colors = [
                '#1e3a8a', '#1e40af', '#1d4ed8', '#2563eb', '#3b82f6', // Bleus
                '#134e4a', '#115e59', '#0f766e', '#14b8a6', '#2dd4bf', // Turquoise
                '#164e63', '#155e75', '#0e7490', '#0891b2', '#06b6d4', // Cyan
                '#1e293b', '#334155', '#475569', '#64748b', '#94a3b8'  // Gris-bleu
            ];

            // Créer 24 tuiles (6 colonnes × 4 lignes)
            for (let i = 0; i < 24; i++) {
                const tile = document.createElement('div');
                tile.className = 'mosaic-tile';

                // Assigner une couleur aléatoire
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                tile.style.background = randomColor;
                tile.style.animationDelay = `${i * 0.05}s`;
                tile.style.animation = 'mosaic-reveal 0.8s ease-out forwards';

                // Ajouter animation de pulse continue (différente pour chaque tuile)
                setTimeout(() => {
                    tile.style.animation = `mosaic-pulse ${3 + Math.random() * 2}s ease-in-out infinite`;
                    tile.style.animationDelay = `${Math.random() * 2}s`;
                }, 800 + (i * 50));

                mosaicGrid.appendChild(tile);
            }

            // Effet de changement de couleur au survol
            document.querySelectorAll('.mosaic-tile').forEach(tile => {
                tile.addEventListener('mouseenter', function() {
                    const newColor = colors[Math.floor(Math.random() * colors.length)];
                    this.style.background = newColor;
                });
            });

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