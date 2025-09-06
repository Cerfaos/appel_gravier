<!-- Outdoor Adventure Header -->
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-outdoor-cream-200 transition-all duration-300" id="main-header">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16 lg:h-20">
      
      <!-- Logo -->
      <div class="flex-shrink-0 flex items-center">
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
          <div class="flex items-center justify-center">
            <img src="{{ asset('frontend/assets/images/img_cerfaos/logo-vintage.png') }}" alt="Cerfaos Logo" class="h-12 w-auto">
          </div>
          <div>
            <div class="font-display font-bold text-xl text-outdoor-forest-600">Cerfaos</div>
            <div class="text-xs text-outdoor-forest-400 font-medium">L'appel du gravier</div>
          </div>
        </a>
      </div>

      <!-- Desktop Navigation -->
      <nav class="hidden lg:flex items-center space-x-8">
        <a href="{{ url('/') }}" class="nav-link">Accueil</a>
        
        <!-- Dropdown About -->
        <div class="relative group">
          <button class="nav-link flex items-center">
            Un café
            <svg class="ml-1 w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <div class="absolute top-full left-0 w-48 py-2 mt-2 bg-white border border-outdoor-cream-200 rounded-xl2 shadow-outdoor-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
            <a href="{{ route('mon.histoire') }}" class="block px-4 py-2 text-outdoor-forest-600 hover:bg-outdoor-cream-50 hover:text-outdoor-olive-600 transition-colors">Mon Histoire</a>
            <a href="{{ route('mon.velo') }}" class="block px-4 py-2 text-outdoor-forest-600 hover:bg-outdoor-cream-50 hover:text-outdoor-olive-600 transition-colors">Mon Vélo</a>
          </div>
        </div>

        <a href="{{ route('ppg') }}" class="nav-link">PPG</a>
        <a href="{{ route('itineraries.index') }}" class="nav-link">Itinéraires</a>
        <a href="{{ route('sorties.index') }}" class="nav-link">Sorties</a>
        <a href="{{ url('/blog') }}" class="nav-link">Blog</a>
        <a href="{{ route('contact.index') }}" class="nav-link">Contact</a>
      </nav>

      <!-- Right Side Actions -->
      <div class="flex items-center space-x-4">
        
        <!-- Auth Links -->
        @auth
          @php
            $profileData = App\Models\User::find(Auth::user()->id);
          @endphp
          <div class="relative group">
            <button class="flex items-center space-x-2 text-outdoor-forest-600 hover:text-outdoor-olive-600 transition-colors">
              <div class="w-8 h-8 rounded-full overflow-hidden ring-2 ring-outdoor-olive-200 hover:ring-outdoor-olive-300 transition-all duration-200">
                <img 
                  src="{{ (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" 
                  alt="{{ $profileData->name }}" 
                  class="w-full h-full object-cover"
                >
              </div>
              <span class="hidden md:inline font-medium">{{ $profileData->name }}</span>
            </button>
            <div class="absolute top-full right-0 w-48 py-2 mt-2 bg-white border border-outdoor-cream-200 rounded-xl2 shadow-outdoor-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
              @if($profileData->role === 'admin')
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-outdoor-forest-600 hover:bg-outdoor-cream-50 hover:text-outdoor-olive-600 transition-colors">Mon Tableau de Bord</a>
                <div class="border-t border-outdoor-cream-200 my-1"></div>
              @endif
              <a href="{{ route('admin.logout') }}" class="block px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">Déconnexion</a>
            </div>
          </div>
        @endauth

        <!-- CTA Button -->
       

        <!-- Mobile Menu Button -->
        <button 
          class="lg:hidden p-3 bg-white border border-gray-200 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl shadow-md transition-all duration-200" 
          id="hamburger-btn"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Menu Mobile Harmonie Charcoal/Gold -->
  <div id="mobile-menu" class="lg:hidden fixed inset-y-0 right-0 w-80 bg-gradient-to-br from-slate-50 to-stone-100 transform translate-x-full transition-all duration-400 ease-out z-50 shadow-2xl border-l-4 border-amber-600">
    
    <!-- Header Menu Mobile Charcoal/Gold -->
    <div class="bg-gradient-to-r from-slate-800 to-stone-800 px-6 py-5 border-b-2 border-amber-500">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-amber-500/20 backdrop-blur rounded-xl flex items-center justify-center ring-1 ring-amber-400/30">
            <img src="{{ asset('frontend/assets/images/img_cerfaos/logo-vintage.png') }}" alt="Cerfaos" class="h-6 w-auto filter brightness-0 invert">
          </div>
          <div>
            <div class="font-bold text-xl text-amber-100">Cerfaos</div>
            <div class="text-sm text-amber-200/80 font-medium">L'appel du gravier</div>
          </div>
        </div>
        <button onclick="toggleMobileMenu()" class="p-2 bg-amber-500/20 backdrop-blur rounded-xl hover:bg-amber-500/30 text-amber-100 hover:text-amber-50 transition-all duration-200 ring-1 ring-amber-400/20">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Navigation Mobile - Harmonie Charcoal/Gold -->
    <div class="flex-1 bg-gradient-to-b from-slate-50 to-stone-100 overflow-y-auto">
      <div class="p-6">
        <nav class="space-y-3">
          
          <!-- Accueil -->
          <a href="{{ url('/') }}" onclick="toggleMobileMenu()" class="mobile-nav-item-charcoal group">
            <div class="w-12 h-12 bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 ring-1 ring-amber-400/20">
              <svg class="w-6 h-6 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
            </div>
            <span class="text-lg font-bold text-slate-800">Accueil</span>
          </a>

          <!-- Un café avec sous-menu -->
          <div>
            <button onclick="toggleMobileSubmenu('cafe-submenu')" class="mobile-nav-item-charcoal w-full justify-between group">
              <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-600 to-amber-700 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 ring-1 ring-amber-500/30">
                  <svg class="w-6 h-6 text-amber-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                  </svg>
                </div>
                <span class="text-lg font-bold text-slate-800">Un café</span>
              </div>
              <svg id="cafe-arrow" class="w-5 h-5 text-amber-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            
            <!-- Sous-menu -->
            <div id="cafe-submenu" class="hidden ml-10 mt-3 space-y-2 pl-6 border-l-4 border-amber-500 bg-gradient-to-r from-amber-50 to-amber-100 rounded-r-xl py-4">
              <a href="{{ route('mon.histoire') }}" onclick="toggleMobileMenu()" class="mobile-nav-subitem-charcoal">
                <div class="flex items-center space-x-3">
                  <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                  <span class="font-medium text-slate-700">Mon Histoire</span>
                </div>
              </a>
              <a href="{{ route('mon.velo') }}" onclick="toggleMobileMenu()" class="mobile-nav-subitem-charcoal">
                <div class="flex items-center space-x-3">
                  <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                  <span class="font-medium text-slate-700">Mon Vélo</span>
                </div>
              </a>
            </div>
          </div>

          <!-- PPG -->
          <a href="{{ route('ppg') }}" onclick="toggleMobileMenu()" class="mobile-nav-item-charcoal group">
            <div class="w-12 h-12 bg-gradient-to-br from-stone-600 to-stone-700 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 ring-1 ring-amber-400/20">
              <svg class="w-6 h-6 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
              </svg>
            </div>
            <span class="text-lg font-bold text-slate-800">PPG</span>
          </a>

          <!-- Itinéraires -->
          <a href="{{ route('itineraries.index') }}" onclick="toggleMobileMenu()" class="mobile-nav-item-charcoal group">
            <div class="w-12 h-12 bg-gradient-to-br from-amber-700 to-amber-800 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 ring-1 ring-amber-500/30">
              <svg class="w-6 h-6 text-amber-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m-6 3l6-3"></path>
              </svg>
            </div>
            <span class="text-lg font-bold text-slate-800">Itinéraires</span>
          </a>

          <!-- Sorties -->
          <a href="{{ route('sorties.index') }}" onclick="toggleMobileMenu()" class="mobile-nav-item-charcoal group">
            <div class="w-12 h-12 bg-gradient-to-br from-slate-600 to-slate-700 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 ring-1 ring-amber-400/20">
              <svg class="w-6 h-6 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <span class="text-lg font-bold text-slate-800">Sorties</span>
          </a>

          <!-- Blog -->
          <a href="{{ url('/blog') }}" onclick="toggleMobileMenu()" class="mobile-nav-item-charcoal group">
            <div class="w-12 h-12 bg-gradient-to-br from-stone-700 to-stone-800 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 ring-1 ring-amber-400/20">
              <svg class="w-6 h-6 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
              </svg>
            </div>
            <span class="text-lg font-bold text-slate-800">Blog</span>
          </a>

          <!-- Contact -->
          <a href="{{ route('contact.index') }}" onclick="toggleMobileMenu()" class="mobile-nav-item-charcoal group">
            <div class="w-12 h-12 bg-gradient-to-br from-amber-800 to-amber-900 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 ring-1 ring-amber-500/30">
              <svg class="w-6 h-6 text-amber-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.828 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
            </div>
            <span class="text-lg font-bold text-slate-800">Contact</span>
          </a>
        </nav>

        <!-- Section Auth - Harmonie Charcoal/Gold -->
        <div class="mt-8 pt-6 border-t-2 border-amber-200">
          @auth
            <div class="bg-gradient-to-r from-slate-100 to-stone-100 rounded-xl p-5 mb-4 ring-1 ring-amber-300/30">
              <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-600 to-amber-700 rounded-full flex items-center justify-center text-amber-50 font-bold text-lg ring-2 ring-amber-500/30">
                  {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                  <div class="font-bold text-slate-800">{{ Auth::user()->name }}</div>
                  <div class="text-sm text-amber-700 font-medium">Membre Connecté</div>
                </div>
              </div>
            </div>
            <div class="space-y-3">
              @if(Auth::user()->role === 'admin')
                <a href="{{ route('dashboard') }}" onclick="toggleMobileMenu()" class="mobile-nav-item-charcoal group">
                  <div class="w-10 h-10 bg-gradient-to-br from-slate-600 to-slate-700 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 ring-1 ring-amber-400/20">
                    <svg class="w-5 h-5 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                  </div>
                  <span class="font-bold text-slate-700">Mon Compte</span>
                </a>
              @endif
              <a href="{{ route('admin.logout') }}" onclick="toggleMobileMenu()" class="mobile-nav-item-charcoal group">
                <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-700 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 ring-1 ring-red-400/20">
                  <svg class="w-5 h-5 text-red-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                </div>
                <span class="font-bold text-red-700">Déconnexion</span>
              </a>
            </div>
          @endauth
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Menu Overlay -->
  <div 
    id="mobile-menu-overlay" 
    class="lg:hidden fixed inset-0 bg-black bg-opacity-70 opacity-0 invisible transition-all duration-300 z-40"
    onclick="toggleMobileMenu()"
  ></div>
</header>

<script>
// Update mobile menu toggle to include overlay
function toggleMobileMenu() {
  const mobileMenu = document.getElementById('mobile-menu');
  const overlay = document.getElementById('mobile-menu-overlay');
  const hamburger = document.getElementById('hamburger-btn');
  
  if (mobileMenu.classList.contains('translate-x-full')) {
    mobileMenu.classList.remove('translate-x-full');
    overlay.classList.remove('opacity-0', 'invisible');
    hamburger.innerHTML = `
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    `;
  } else {
    mobileMenu.classList.add('translate-x-full');
    overlay.classList.add('opacity-0', 'invisible');
    hamburger.innerHTML = `
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    `;
  }
}

// Toggle mobile submenus
function toggleMobileSubmenu(submenuId) {
  const submenu = document.getElementById(submenuId);
  const arrow = document.getElementById(submenuId.replace('-submenu', '-arrow'));
  
  if (submenu.classList.contains('hidden')) {
    // Show submenu
    submenu.classList.remove('hidden');
    arrow.style.transform = 'rotate(180deg)';
  } else {
    // Hide submenu
    submenu.classList.add('hidden');
    arrow.style.transform = 'rotate(0deg)';
  }
}

// Initialize mobile menu button
document.getElementById('hamburger-btn').addEventListener('click', toggleMobileMenu);
</script>

<style>
/* Menu Mobile Harmonie Charcoal/Gold */
.mobile-nav-item-charcoal {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 18px 20px;
  color: #1e293b;
  font-weight: 700;
  border-radius: 16px;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  text-decoration: none;
  background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.6) 100%);
  border: 1px solid rgba(217, 119, 6, 0.1);
  position: relative;
  overflow: hidden;
  backdrop-filter: blur(8px);
}

.mobile-nav-item-charcoal:hover {
  color: #0f172a;
  background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.1) 100%);
  transform: translateX(12px) scale(1.02);
  box-shadow: 0 8px 24px rgba(217, 119, 6, 0.25), 0 4px 12px rgba(0, 0, 0, 0.1);
  border-color: rgba(217, 119, 6, 0.3);
}

.mobile-nav-item-charcoal:hover::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 5px;
  height: 100%;
  background: linear-gradient(to bottom, #d97706, #f59e0b);
  border-radius: 0 8px 8px 0;
  box-shadow: 0 0 10px rgba(245, 158, 11, 0.5);
}

.mobile-nav-subitem-charcoal {
  display: block;
  padding: 12px 20px;
  color: #475569;
  font-size: 15px;
  font-weight: 600;
  border-radius: 12px;
  transition: all 0.3s ease;
  text-decoration: none;
  background: linear-gradient(135deg, rgba(248, 250, 252, 0.5) 0%, rgba(241, 245, 249, 0.3) 100%);
  margin: 4px 0;
  border-left: 3px solid transparent;
}

.mobile-nav-subitem-charcoal:hover {
  color: #1e293b;
  background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.15) 100%);
  transform: translateX(8px);
  border-left-color: #f59e0b;
  box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
}

/* Background overlay pour mobile menu */
#mobile-menu {
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
  border-left: 4px solid #d97706 !important;
  box-shadow: -10px 0 50px rgba(0, 0, 0, 0.15) !important;
}

/* Header du menu mobile */
.bg-gradient-to-r.from-slate-800.to-stone-800 {
  background: linear-gradient(90deg, #1e293b 0%, #44403c 100%) !important;
  border-bottom: 2px solid #f59e0b !important;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2) !important;
}

/* Navigation background */
.bg-gradient-to-b.from-slate-50.to-stone-100 {
  background: linear-gradient(180deg, #f8fafc 0%, #f5f5f4 100%) !important;
}

/* Couleurs spécialisées */
.text-amber-100 {
  color: #fef3c7 !important;
}

.text-amber-200 {
  color: #fde68a !important;
}

.text-amber-600 {
  color: #d97706 !important;
}

.text-slate-700 {
  color: #334155 !important;
}

.text-slate-800 {
  color: #1e293b !important;
}

.text-red-700 {
  color: #b91c1c !important;
}

/* Rings et bordures dorées */
.ring-amber-400\/20 {
  box-shadow: 0 0 0 1px rgba(251, 191, 36, 0.2) !important;
}

.ring-amber-500\/30 {
  box-shadow: 0 0 0 1px rgba(245, 158, 11, 0.3) !important;
}

.border-amber-200 {
  border-color: #fde68a !important;
}

.border-amber-500 {
  border-color: #f59e0b !important;
}

/* Gradients d'arrière-plan pour les sous-menus */
.bg-gradient-to-r.from-amber-50.to-amber-100 {
  background: linear-gradient(90deg, #fffbeb 0%, #fef3c7 100%) !important;
  border-left: 4px solid #f59e0b !important;
}

/* Effet glassmorphism amélioré */
.bg-amber-500\/20 {
  background-color: rgba(245, 158, 11, 0.2) !important;
}

.bg-amber-500\/30 {
  background-color: rgba(245, 158, 11, 0.3) !important;
}

/* Animations supplémentaires */
@keyframes pulse-gold {
  0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
  50% { box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
}

.mobile-nav-item-charcoal:active {
  animation: pulse-gold 0.6s ease-out;
}
</style>