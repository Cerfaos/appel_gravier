<!-- Outdoor Adventures Footer -->
<footer class="bg-outdoor-forest-600 text-white relative overflow-hidden">
  
  <!-- Background Decorations -->
  <div class="absolute top-12 right-16 text-8xl opacity-5">🏔️</div>
  <div class="absolute bottom-20 left-12 text-6xl opacity-5">🌲</div>
  
  <!-- Gradient Overlay -->
  <div class="absolute inset-0 bg-gradient-to-br from-outdoor-forest-600 via-outdoor-forest-700 to-outdoor-forest-800"></div>

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
});
</script>