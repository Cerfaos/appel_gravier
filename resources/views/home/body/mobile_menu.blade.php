<!-- Outdoor Mobile Menu -->
<div class="fixed inset-0 z-50 lg:hidden" id="mobile-menu-overlay" style="display: none;">
  
  <!-- Backdrop -->
  <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeMobileMenu()"></div>
  
  <!-- Menu Panel -->
  <div class="fixed inset-y-0 right-0 w-80 max-w-full bg-white shadow-outdoor-2xl transform translate-x-full transition-transform duration-300" id="mobile-menu-panel">
    
    <!-- Menu Header -->
    <div class="flex items-center justify-between p-6 border-b border-outdoor-cream-200">
      <div class="flex items-center space-x-3">
        <div class="flex items-center justify-center w-10 h-10 bg-outdoor-olive-500 rounded-xl text-white">
          <span class="text-xl">🌿</span>
        </div>
        <div>
          <div class="font-display font-bold text-lg text-outdoor-forest-600">Cerfaos</div>
          <div class="text-xs text-outdoor-forest-400">Outdoor Adventures</div>
        </div>
      </div>
      
      <button 
        onclick="closeMobileMenu()" 
        class="p-2 text-outdoor-forest-400 hover:text-outdoor-forest-600 hover:bg-outdoor-cream-50 rounded-lg transition-colors"
      >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Menu Content -->
    <div class="flex flex-col h-full">
      <div class="flex-1 px-6 py-8 overflow-y-auto">
        
        <!-- Main Navigation -->
        <nav class="space-y-6">
          
          <!-- Home -->
          <a 
            href="{{ url('/') }}" 
            class="flex items-center space-x-3 text-outdoor-forest-600 hover:text-outdoor-olive-600 font-medium transition-colors"
            onclick="closeMobileMenu()"
          >
            <span class="text-xl">🏠</span>
            <span>Accueil</span>
          </a>

          <!-- About Dropdown -->
          <div class="space-y-3">
            <button 
              class="flex items-center justify-between w-full text-outdoor-forest-600 font-medium"
              onclick="toggleMobileSubmenu('about')"
            >
              <div class="flex items-center space-x-3">
                <span class="text-xl">🌿</span>
                <span>À propos</span>
              </div>
              <svg id="about-arrow" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            
            <div id="about-submenu" class="hidden pl-8 space-y-3">
              <a href="{{ route('mon.histoire') }}" class="block text-outdoor-forest-500 hover:text-outdoor-olive-600 transition-colors" onclick="closeMobileMenu()">
                Mon Histoire
              </a>
              <a href="{{ route('mon.velo') }}" class="block text-outdoor-forest-500 hover:text-outdoor-olive-600 transition-colors" onclick="closeMobileMenu()">
                Mon Vélo
              </a>
              <a href="{{ route('itineraries.index') }}" class="block text-outdoor-forest-500 hover:text-outdoor-olive-600 transition-colors" onclick="closeMobileMenu()">
                Itinéraires
              </a>
            </div>
          </div>

          <!-- PPG -->
          <a 
            href="{{ route('ppg') }}" 
            class="flex items-center space-x-3 text-outdoor-forest-600 hover:text-outdoor-olive-600 font-medium transition-colors"
            onclick="closeMobileMenu()"
          >
            <span class="text-xl">💪</span>
            <span>PPG</span>
          </a>

          <!-- Itineraires -->
          <a 
            href="{{ route('itineraries.index') }}" 
            class="flex items-center space-x-3 text-outdoor-forest-600 hover:text-outdoor-olive-600 font-medium transition-colors"
            onclick="closeMobileMenu()"
          >
            <span class="text-xl">🗺️</span>
            <span>Itinéraires</span>
          </a>

          <!-- Sorties -->
          <a 
            href="{{ route('sorties.index') }}" 
            class="flex items-center space-x-3 text-outdoor-forest-600 hover:text-outdoor-olive-600 font-medium transition-colors"
            onclick="closeMobileMenu()"
          >
            <span class="text-xl">🚴‍♂️</span>
            <span>Sorties</span>
          </a>

          <!-- Blog -->
          <a 
            href="{{ url('/blog') }}" 
            class="flex items-center space-x-3 text-outdoor-forest-600 hover:text-outdoor-olive-600 font-medium transition-colors"
            onclick="closeMobileMenu()"
          >
            <span class="text-xl">📝</span>
            <span>Blog</span>
          </a>

          <!-- Contact -->
          <a 
            href="{{ route('contact.index') }}" 
            class="flex items-center space-x-3 text-outdoor-forest-600 hover:text-outdoor-olive-600 font-medium transition-colors"
            onclick="closeMobileMenu()"
          >
            <span class="text-xl">📞</span>
            <span>Contact</span>
          </a>
        </nav>

        <!-- Separator -->
        <div class="border-t border-outdoor-cream-200 my-8"></div>

        <!-- Auth Section -->
        <div class="space-y-4">
          @auth
            <div class="flex items-center space-x-3 p-4 bg-outdoor-cream-50 rounded-2xl">
              <div class="w-10 h-10 bg-outdoor-olive-100 rounded-full flex items-center justify-center">
                <span class="text-outdoor-olive-600 font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
              </div>
              <div>
                <div class="font-semibold text-outdoor-forest-600">{{ Auth::user()->name }}</div>
                <div class="text-sm text-outdoor-forest-400">Membre Cerfaos</div>
              </div>
            </div>
            
            <a 
              href="{{ route('dashboard') }}" 
              class="flex items-center space-x-3 text-outdoor-forest-600 hover:text-outdoor-olive-600 font-medium transition-colors"
              onclick="closeMobileMenu()"
            >
              <span class="text-xl">🏔️</span>
              <span>Mon Tableau de Bord</span>
            </a>
            
            <a 
              href="{{ route('admin.logout') }}" 
              class="flex items-center space-x-3 text-red-600 hover:text-red-700 font-medium transition-colors"
              onclick="closeMobileMenu()"
            >
              <span class="text-xl">🚪</span>
              <span>Déconnexion</span>
            </a>
          @else
            <a 
              href="{{ route('login') }}" 
              class="flex items-center space-x-3 text-outdoor-forest-600 hover:text-outdoor-olive-600 font-medium transition-colors"
              onclick="closeMobileMenu()"
            >
              <span class="text-xl">🔐</span>
              <span>Connexion</span>
            </a>
          @endauth
        </div>
      </div>

      <!-- Footer CTA -->
      <div class="p-6 border-t border-outdoor-cream-200 bg-outdoor-cream-50">
        <a 
          href="{{ route('contact.index') }}" 
          class="btn-primary w-full justify-center text-lg"
          onclick="closeMobileMenu()"
        >
          <span class="text-xl mr-2">🚀</span>
          Réserver une Aventure
        </a>
        
        <!-- Contact Info -->
        <div class="mt-4 text-center space-y-2">
          <div class="text-sm text-outdoor-forest-500">
            📱 +33 1 23 45 67 89
          </div>
          <div class="text-sm text-outdoor-forest-500">
            ✉️ hello@cerfaos.fr
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Mobile Menu Functions
function openMobileMenu() {
  const overlay = document.getElementById('mobile-menu-overlay');
  const panel = document.getElementById('mobile-menu-panel');
  
  if (overlay && panel) {
    overlay.style.display = 'block';
    setTimeout(() => {
      panel.classList.remove('translate-x-full');
    }, 10);
  }
}

function closeMobileMenu() {
  const overlay = document.getElementById('mobile-menu-overlay');
  const panel = document.getElementById('mobile-menu-panel');
  
  if (overlay && panel) {
    panel.classList.add('translate-x-full');
    setTimeout(() => {
      overlay.style.display = 'none';
    }, 300);
  }
}

function toggleMobileSubmenu(submenuId) {
  const submenu = document.getElementById(submenuId + '-submenu');
  const arrow = document.getElementById(submenuId + '-arrow');
  
  if (submenu && arrow) {
    submenu.classList.toggle('hidden');
    arrow.classList.toggle('rotate-180');
  }
}

// Handle mobile menu trigger from header
document.addEventListener('DOMContentLoaded', function() {
  const hamburgerBtn = document.getElementById('hamburger-btn');
  if (hamburgerBtn) {
    hamburgerBtn.addEventListener('click', openMobileMenu);
  }
});
</script>