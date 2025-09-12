<!-- GRAND HERO VISUEL - Style Outdoor Cohérent -->
<section class="relative min-h-screen flex items-center justify-center text-white overflow-hidden">
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
    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-600/80 via-outdoor-forest-600/70 to-outdoor-earth-600/80"></div>
    <div class="absolute inset-0 bg-black/30"></div>
    
    <!-- Fade vers la couleur exacte du dégradé des blocs -->
    <div class="absolute bottom-0 left-0 right-0" style="height: 40vh; background: linear-gradient(to bottom, transparent 0%, rgba(96, 108, 56, 0.3) 30%, rgba(40, 54, 24, 0.6) 70%, #232f15 100%) !important; z-index: 10;"></div>
    
    <!-- Particules d'animation -->
    <div class="absolute inset-0">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white/20 rounded-full animate-float"></div>
        <div class="absolute top-1/3 right-1/3 w-3 h-3 bg-white/10 rounded-full animate-float-delayed"></div>
        <div class="absolute bottom-1/3 left-1/2 w-1 h-1 bg-white/30 rounded-full animate-float-slow"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="space-y-8 animate-fade-in-up">
            <!-- Titre principal -->
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold leading-tight tracking-tight text-white">
                {{ $slider->title ?? 'Découvrez l\'aventure qui vous attend' }}
            </h1>
            
            <!-- Sous-titre -->
            <p class="text-xl md:text-2xl lg:text-3xl max-w-4xl mx-auto opacity-90 leading-relaxed font-light text-white">
                {{ $slider->description ?? 'Explorez des itinéraires uniques, rejoignez nos sorties en groupe, et enrichissez-vous de nos conseils d\'experts pour vos aventures outdoor.' }}
            </p>
            
            <!-- CTA décentré à droite -->
            <div class="pt-8 flex justify-end">
                <a href="#main-content" class="scroll-link inline-flex items-center text-white hover:text-yellow-200 group transition-all duration-300">
                    <span class="text-xl font-medium">Commencer l'exploration</span>
                    <svg class="ml-3 w-8 h-8 group-hover:translate-y-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    
    <!-- Styles intégrés -->
    <style>
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
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