<!-- GRAND HERO VISUEL - Style Outdoor Cohérent -->
<section class="relative min-h-screen text-white overflow-hidden">
    <!-- Image de fond du slider - Optimisé pour images paysage 874×490 -->
    @if($slider && $slider->image)
        <div class="absolute inset-0 w-full h-full bg-no-repeat" 
             style="background-image: url('{{ asset($slider->image) }}');
                    background-size: cover;
                    background-position: center center;
                    background-attachment: scroll;
                    min-height: 100vh;">
        </div>
    @endif
    
    <!-- Overlay gradient outdoor par-dessus l'image -->
    <div class="absolute inset-0 bg-black/20"></div>
    
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
                <h1 class="text-4xl md:text-6xl font-bold leading-tight tracking-tight text-white animate-elegant-title">
                    {{ $slider->title ?? 'Découvrez l\'aventure qui vous attend' }}
                </h1>
                <p class="text-lg md:text-xl max-w-3xl mx-auto opacity-90 leading-relaxed font-light text-white animate-elegant-desc">
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
        <div class="flex lg:hidden pt-8 justify-center">
            <div class="scroll-link animate-elegant-cta" 
                 style="background: transparent; color: white; padding: 14px 28px; margin: 10px 0; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 16px; display: inline-block; user-select: none; transition: all 0.3s ease; border: 2px solid rgba(255,255,255,0.8); backdrop-filter: blur(10px);"
                 onclick="window.scrollTo({top: window.innerHeight, behavior: 'smooth'});">
                Commencer l'exploration
            </div>
        </div>
    </div>
    
    
    <!-- Styles intégrés -->
    <style>
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
        
        /* Animations mobiles - mêmes animations élégantes que desktop */
        @media (max-width: 1023px) {
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

    <!-- JavaScript - Smooth scroll -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll pour le hero
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