<!-- Outdoor Adventures Footer avec Stats Dashboard -->
<footer class="bg-outdoor-forest-600 text-white relative overflow-hidden">

  <!-- Background Pattern - Topographic Lines -->
  <div class="absolute inset-0 opacity-5" style="background-image: repeating-linear-gradient(0deg, transparent, transparent 20px, rgba(255,255,255,0.1) 20px, rgba(255,255,255,0.1) 21px), repeating-linear-gradient(90deg, transparent, transparent 20px, rgba(255,255,255,0.1) 20px, rgba(255,255,255,0.1) 21px);"></div>

  <!-- Gradient Overlay -->
  <div class="absolute inset-0 bg-gradient-to-br from-outdoor-forest-600 via-outdoor-forest-700 to-outdoor-forest-800"></div>

  <!-- Adventure Stats Section - NOUVEAU -->
  <div class="relative z-20 border-b border-outdoor-forest-500/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="text-center mb-12">
        <h3 class="text-3xl md:text-4xl font-bold text-white mb-3">L'Aventure en Chiffres</h3>
        <p class="text-outdoor-cream-200">Mon parcours outdoor jusqu'à aujourd'hui</p>
      </div>

      <!-- Stats Grid -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

        <!-- Stat 1 - Sorties -->
        <div class="stat-card group bg-outdoor-forest-700/50 backdrop-blur-sm rounded-2xl p-6 border border-outdoor-forest-500/30 hover:border-outdoor-olive-500/50 transition-all duration-500 hover:transform hover:scale-105">
          <div class="text-5xl mb-4 group-hover:animate-bounce">🚴‍♂️</div>
          <div class="text-4xl md:text-5xl font-bold text-outdoor-olive-400 mb-2 counter" data-target="{{ \App\Models\Sortie::where('status', 'published')->count() }}">0</div>
          <div class="text-outdoor-cream-200 text-sm md:text-base">Sorties Réalisées</div>
          <div class="mt-3 h-1 bg-outdoor-olive-500/20 rounded-full overflow-hidden">
            <div class="h-full bg-outdoor-olive-500 rounded-full stat-bar" style="width: 0%"></div>
          </div>
        </div>

        <!-- Stat 2 - Itinéraires -->
        <div class="stat-card group bg-outdoor-forest-700/50 backdrop-blur-sm rounded-2xl p-6 border border-outdoor-forest-500/30 hover:border-outdoor-earth-500/50 transition-all duration-500 hover:transform hover:scale-105">
          <div class="text-5xl mb-4 group-hover:animate-bounce">🗺️</div>
          <div class="text-4xl md:text-5xl font-bold text-outdoor-earth-400 mb-2 counter" data-target="{{ \App\Models\EnhancedItinerary::where('status', 'published')->count() }}">0</div>
          <div class="text-outdoor-cream-200 text-sm md:text-base">Itinéraires Explorés</div>
          <div class="mt-3 h-1 bg-outdoor-earth-500/20 rounded-full overflow-hidden">
            <div class="h-full bg-outdoor-earth-500 rounded-full stat-bar" style="width: 0%"></div>
          </div>
        </div>

        <!-- Stat 3 - Kilomètres -->
        <div class="stat-card group bg-outdoor-forest-700/50 backdrop-blur-sm rounded-2xl p-6 border border-outdoor-forest-500/30 hover:border-outdoor-ochre-500/50 transition-all duration-500 hover:transform hover:scale-105">
          <div class="text-5xl mb-4 group-hover:animate-bounce">📏</div>
          <div class="text-4xl md:text-5xl font-bold text-outdoor-ochre-400 mb-2">
            <span class="counter" data-target="{{ round(\App\Models\Sortie::where('status', 'published')->sum('distance_km')) }}">0</span><span class="text-2xl">km</span>
          </div>
          <div class="text-outdoor-cream-200 text-sm md:text-base">Distance Parcourue</div>
          <div class="mt-3 h-1 bg-outdoor-ochre-500/20 rounded-full overflow-hidden">
            <div class="h-full bg-outdoor-ochre-500 rounded-full stat-bar" style="width: 0%"></div>
          </div>
        </div>

        <!-- Stat 4 - Dénivelé -->
        <div class="stat-card group bg-outdoor-forest-700/50 backdrop-blur-sm rounded-2xl p-6 border border-outdoor-forest-500/30 hover:border-outdoor-sage-500/50 transition-all duration-500 hover:transform hover:scale-105">
          <div class="text-5xl mb-4 group-hover:animate-bounce">⛰️</div>
          <div class="text-4xl md:text-5xl font-bold text-outdoor-sage-400 mb-2">
            <span class="counter" data-target="{{ round(\App\Models\Sortie::where('status', 'published')->sum('elevation_gain_m')) }}">0</span><span class="text-2xl">m</span>
          </div>
          <div class="text-outdoor-cream-200 text-sm md:text-base">Dénivelé Positif</div>
          <div class="mt-3 h-1 bg-outdoor-sage-500/20 rounded-full overflow-hidden">
            <div class="h-full bg-outdoor-sage-500 rounded-full stat-bar" style="width: 0%"></div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
    
    <!-- Main Footer Content -->
    <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-8 lg:gap-12">
      
      <!-- Brand Section -->
      <div class="lg:col-span-1 space-y-6">
        <div class="flex items-center space-x-3">
          <div class="flex items-center justify-center w-12 h-12 bg-outdoor-olive-500 rounded-2xl text-white">
            <span class="text-2xl">🚴‍♂️</span>
          </div>
          <div>
            <div class="font-display font-bold text-2xl">Cerfaos</div>
            <div class="text-outdoor-cream-200 text-sm">L'aventure en vélo gravel</div>
          </div>
        </div>
        
        <p class="text-outdoor-cream-200 leading-relaxed">
          Je débute en gravel, donc on reste simple et agréable. Distances raisonnables, pauses quand il faut, zéro pression : l’idée, c’est de pédaler tranquille et d’apprendre.
        </p>
        
        <!-- Social Links -->
       
      </div>

      <!-- Navigation -->
      <div class="space-y-6">
        <h4 class="text-xl font-display font-semibold text-white">Navigation</h4>
        <div class="grid grid-cols-2 gap-4">
          <div class="space-y-3">
            <a href="{{ url('/') }}" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
              Accueil
            </a>
            <a href="#about" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
              À propos
            </a>
            <a href="#services" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
              Activités
            </a>
            
          </div>
          <div class="space-y-3">
            <a href="{{ route('itineraries.index') }}" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
              Itinéraires
            </a>
            
            <a href="{{ route('sorties.index') }}" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
              Sorties
            </a>
            <a href="{{ url('/blog') }}" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
              Blog
            </a>
          </div>
        </div>
      </div>

      <!-- Services -->
      <div class="space-y-6">
        <h4 class="text-xl font-display font-semibold text-white">Mes activités</h4>
        <div class="space-y-3">
          <a href="#mountain" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
            🏔️ Randonnée Montagne
          </a>
          <a href="#forest" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
            🌲 Trekking Forestier
          </a>
          <a href="#camping" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
            🏕️ Camping Sauvage
          </a>
          <a href="#climbing" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
            🚴‍♂️ Vélo gravel
          </a>
          <a href="#photo" class="block text-outdoor-cream-200 hover:text-outdoor-ochre-300 transition-colors duration-300">
            🛶 Canoë/Kayak
          </a>
         
        </div>
      </div>

      <!-- Logo Section -->
      <div class="flex items-center justify-center">
        <img src="{{ asset('frontend/assets/images/img_cerfaos/logo-vintage.png') }}" 
             alt="Cerfaos Logo Vintage" 
             class="h-40 w-auto opacity-80 hover:opacity-100 transition-opacity duration-300 mx-auto"
             loading="lazy">
      </div>
    </div>

    <!-- Contact Info Bar -->
    <div class="grid md:grid-cols-3 gap-6 mt-16 pt-12 border-t border-outdoor-forest-500">
      
      <div class="flex items-center space-x-4 group">
        <div class="w-12 h-12 bg-outdoor-olive-500 group-hover:bg-outdoor-olive-600 rounded-xl flex items-center justify-center transition-colors duration-300">
          <span class="text-xl">📍</span>
        </div>
        <div>
          <div class="text-sm text-outdoor-cream-300">Ma Base</div>
          <div class="font-semibold text-white">Colmar, Haut-Rhin</div>
        </div>
      </div>

      

     
    </div>

    <!-- Bottom Footer -->
    <div>
      <div>
        © <span id="current-year">2024</span> Cerfaos -  Tous droits réservés.
      </div>
      
      
    </div>
  </div>
</footer>

<script>
// Update current year
document.addEventListener('DOMContentLoaded', function() {
  const currentYear = new Date().getFullYear();
  const yearElement = document.getElementById('current-year');
  if (yearElement) {
    yearElement.textContent = currentYear;
  }

  // ===== ANIMATED COUNTERS =====
  const counters = document.querySelectorAll('.counter');
  const statBars = document.querySelectorAll('.stat-bar');
  let hasAnimated = false;

  // Fonction pour animer un compteur
  function animateCounter(counter) {
    const target = parseInt(counter.getAttribute('data-target'));
    const duration = 2000; // 2 secondes
    const increment = target / (duration / 16); // 60fps
    let current = 0;

    const updateCounter = () => {
      current += increment;
      if (current < target) {
        counter.textContent = Math.floor(current);
        requestAnimationFrame(updateCounter);
      } else {
        counter.textContent = target;
      }
    };

    updateCounter();
  }

  // Fonction pour animer les barres de progression
  function animateStatBars() {
    statBars.forEach((bar, index) => {
      setTimeout(() => {
        bar.style.transition = 'width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1)';
        bar.style.width = '100%';
      }, index * 200); // Délai en cascade
    });
  }

  // Observer pour détecter quand le footer est visible
  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.3
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !hasAnimated) {
        hasAnimated = true;

        // Animer tous les compteurs
        counters.forEach((counter, index) => {
          setTimeout(() => {
            animateCounter(counter);
          }, index * 150); // Délai en cascade
        });

        // Animer les barres
        setTimeout(() => {
          animateStatBars();
        }, 300);

        // Animer les cartes (fade in + scale)
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(30px) scale(0.9)';

          setTimeout(() => {
            card.style.transition = 'opacity 0.8s ease-out, transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1)';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
          }, index * 100);
        });
      }
    });
  }, observerOptions);

  // Observer la section stats
  const statsSection = document.querySelector('.stat-card');
  if (statsSection) {
    observer.observe(statsSection.parentElement.parentElement);
  }
});
</script>

<style>
/* Animations supplémentaires pour les stats */
@keyframes pulse-glow {
  0%, 100% {
    box-shadow: 0 0 20px rgba(96, 108, 56, 0.2);
  }
  50% {
    box-shadow: 0 0 40px rgba(96, 108, 56, 0.4);
  }
}

.stat-card:hover {
  animation: pulse-glow 2s ease-in-out infinite;
}

/* Mobile responsive pour stats */
@media (max-width: 768px) {
  .stat-card {
    opacity: 1 !important;
    transform: none !important;
  }
}
</style>