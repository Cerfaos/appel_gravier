<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Cerfaos - Outdoor Adventures & Hiking')</title>

  @yield('meta')

  <link rel="shortcut icon" href="{{ asset('frontend/assets/images/favicon.ico?v=' . time()) }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('frontend/assets/images/favicon.ico?v=' . time()) }}" type="image/x-icon">
  <!-- Favicon moderne pour tous les devices -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/assets/images/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/assets/images/favicon-16x16.png') }}">
  {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/assets/images/apple-touch-icon.png') }}"> --}}
  
  <!-- PWA Configuration -->
  {{-- <link rel="manifest" href="{{ asset('manifest.json') }}"> --}}
  <meta name="theme-color" content="#059669">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="Cerfaos">
  <meta name="msapplication-TileColor" content="#059669">
  <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
  <!--- End favicon-->

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200;12..96,300;12..96,400;12..96,500;12..96,600;12..96,700;12..96,800&display=swap" rel="stylesheet">

  <!-- Forest Premium Design System -->
  {{-- <link rel="stylesheet" href="{{ asset('css/archive/forest-premium-design-system.css') }}"> --}}
  
  <!-- Vite Assets with Outdoor Tailwind Theme -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <!-- Keep essential external libraries for animations and functionality -->
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
  
  <!-- Mobile Touch Optimizations -->
  <link rel="stylesheet" href="{{ asset('css/mobile-touch-optimizations.css') }}">
  
  <!-- Mobile No Animations - Performance optimale -->
  <link rel="stylesheet" href="{{ asset('css/mobile-no-animations.css') }}">
  
  <!-- Fix ciblé Hero & Features sections -->
  <link rel="stylesheet" href="{{ asset('css/mobile-hero-features-fix.css') }}">
</head>

<body class="antialiased">

  <!-- Outdoor-themed preloader -->
  <div class="preloader fixed inset-0 z-50 flex items-center justify-center bg-outdoor-cream-50" id="preloader">
    <div class="text-center">
      <div class="inline-block animate-gentle-bounce text-6xl mb-4">🌿</div>
      <div class="text-outdoor-forest-500 font-display text-lg">Loading Adventure...</div>
      <div class="flex space-x-2 justify-center mt-4">
        <div class="w-2 h-2 bg-outdoor-olive-500 rounded-full animate-bounce"></div>
        <div class="w-2 h-2 bg-outdoor-olive-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
        <div class="w-2 h-2 bg-outdoor-olive-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
      </div>
    </div>
  </div>

  <!-- Scroll to top button -->
  <div class="fixed bottom-8 right-8 z-40" id="scroll-to-top">
    <button class="bg-outdoor-olive-500 hover:bg-outdoor-olive-600 text-white p-3 rounded-full shadow-outdoor-lg transition-all duration-300 opacity-0 invisible" onclick="scrollToTop()">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
      </svg>
    </button>
  </div>



  <!-- Mobile Menu now integrated in header.blade.php -->


  <!-- Header -->
  @include('home.body.header')
  <!-- End header -->

  <!-- End mobile menu -->
  <!-- end cta -->


  @yield('home')
  @yield('content')


  <!-- Footer  -->
  @include('home.body.footer')






  <!-- Essential Scripts for Outdoor Theme -->
  <script src="{{ asset('frontend/assets/js/aos.js') }}"></script>
  <script src="{{ asset('js/mobile-touch-gestures.js') }}"></script>
  <script src="{{ asset('js/mobile-performance-optimizations.js') }}"></script>
  <!-- Script animations optimizer désactivé - remplacé par CSS no-animations -->
  <!-- <script src="{{ asset('js/mobile-animations-optimizer.js') }}"></script> -->
  
  <!-- Custom Outdoor JavaScript -->
  <script>
    // Configuration AOS avec désactivation mobile intelligente
    AOS.init({
      duration: window.innerWidth <= 768 ? 0 : 800,  // Pas d'animations sur mobile
      easing: 'ease-out',
      once: true,
      offset: window.innerWidth <= 768 ? 0 : 100,    // Pas d'offset mobile
      delay: 0,
      disable: function() {
        // Désactiver complètement les animations sur mobile et tablette
        return window.innerWidth <= 768 ? 'mobile' : false;
      }
    });

    // Système alternatif pour mobile : Affichage immédiat sans animations
    if (window.innerWidth <= 768) {
      // Forcer l'affichage immédiat de tous les éléments AOS
      setTimeout(function() {
        const aosElements = document.querySelectorAll('[data-aos]');
        aosElements.forEach(function(element) {
          element.classList.add('aos-animate');
          element.style.opacity = '1';
          element.style.transform = 'none';
          element.style.transition = 'none';
        });
      }, 100);
      
      console.log('📱 Animations désactivées sur mobile pour performance optimale');
    } else {
      console.log('💻 Animations AOS activées sur desktop');
    }

    // Preloader - Suppression immédiate sur mobile
    window.addEventListener('load', function() {
      const preloader = document.getElementById('preloader');
      if (preloader) {
        // Sur mobile, suppression immédiate sans transition
        if (window.innerWidth <= 768) {
          preloader.style.display = 'none';
          preloader.remove();
        } else {
          // Sur desktop, transition normale
          preloader.style.opacity = '0';
          setTimeout(() => {
            preloader.style.display = 'none';
          }, 300);
        }
      }
    });

    // SOLUTION RADICALE - Suppression voile translucide mobile
    if (window.innerWidth <= 768) {
      
      // Supprimer immédiatement TOUT ce qui peut créer un voile
      const forceVisibility = function() {
        // Supprimer preloader
        const preloaders = document.querySelectorAll('#preloader, .preloader, .loading, .loader');
        preloaders.forEach(el => {
          el.style.display = 'none';
          el.remove();
        });
        
        // Forcer visibilité de tous les éléments
        const allElements = document.querySelectorAll('*');
        allElements.forEach(el => {
          el.style.opacity = '1';
          el.style.visibility = 'visible';
          el.style.filter = 'none';
          el.style.backdropFilter = 'none';
        });
        
        // Supprimer overlays potentiels
        const overlays = document.querySelectorAll('.overlay, .backdrop, .mask, [class*="bg-opacity"]');
        overlays.forEach(el => {
          el.style.display = 'none';
          el.remove();
        });
        
        console.log('🔧 Force visibility mobile: voile translucide éliminé');
      };
      
      // Exécuter immédiatement et à intervalles
      forceVisibility();
      document.addEventListener('DOMContentLoaded', forceVisibility);
      setTimeout(forceVisibility, 100);
      setTimeout(forceVisibility, 500);
    }

    // Scroll to top functionality
    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Show/hide scroll to top button
    window.addEventListener('scroll', function() {
      const scrollBtn = document.querySelector('#scroll-to-top button');
      if (window.pageYOffset > 300) {
        scrollBtn.classList.remove('opacity-0', 'invisible');
      } else {
        scrollBtn.classList.add('opacity-0', 'invisible');
      }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Mobile menu toggle
    function toggleMobileMenu() {
      const mobileMenu = document.getElementById('mobile-menu');
      const hamburger = document.getElementById('hamburger-btn');
      
      if (mobileMenu.classList.contains('translate-x-full')) {
        mobileMenu.classList.remove('translate-x-full');
        hamburger.innerHTML = `
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        `;
      } else {
        mobileMenu.classList.add('translate-x-full');
        hamburger.innerHTML = `
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        `;
      }
    }

    // Add gentle animations on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate-fade-in-up');
        }
      });
    }, observerOptions);

    // Observe elements with fade-in class
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.fade-in-scroll').forEach(el => {
        observer.observe(el);
      });
    });
  </script>

  <!-- PWA Service Worker Registration -->
  <script>
    // Enregistrement du Service Worker pour PWA
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
          .then((registration) => {
            console.log('✅ Service Worker enregistré:', registration.scope);
            
            // Vérifier les mises à jour
            registration.addEventListener('updatefound', () => {
              const newWorker = registration.installing;
              if (newWorker) {
                newWorker.addEventListener('statechange', () => {
                  if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                    // Nouvelle version disponible
                    if (confirm('Une nouvelle version de Cerfaos est disponible. Recharger maintenant ?')) {
                      window.location.reload();
                    }
                  }
                });
              }
            });
          })
          .catch((error) => {
            console.log('❌ Échec de l\'enregistrement du Service Worker:', error);
          });
      });
    }

    // PWA Install Prompt
    let deferredPrompt;
    let installButton = null;

    window.addEventListener('beforeinstallprompt', (e) => {
      e.preventDefault();
      deferredPrompt = e;
      
      // Créer le bouton d'installation s'il n'existe pas
      if (!installButton) {
        installButton = document.createElement('button');
        installButton.innerHTML = '📱 Installer l\'app';
        installButton.style.cssText = `
          position: fixed;
          bottom: 20px;
          left: 50%;
          transform: translateX(-50%);
          background: #059669;
          color: white;
          border: none;
          padding: 12px 24px;
          border-radius: 25px;
          font-size: 14px;
          font-weight: 500;
          cursor: pointer;
          box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
          transition: all 0.3s ease;
          z-index: 1000;
          font-family: inherit;
        `;
        
        installButton.addEventListener('mouseover', () => {
          installButton.style.transform = 'translateX(-50%) translateY(-2px)';
          installButton.style.boxShadow = '0 6px 16px rgba(5, 150, 105, 0.4)';
        });
        
        installButton.addEventListener('mouseout', () => {
          installButton.style.transform = 'translateX(-50%)';
          installButton.style.boxShadow = '0 4px 12px rgba(5, 150, 105, 0.3)';
        });
        
        installButton.addEventListener('click', async () => {
          if (deferredPrompt) {
            deferredPrompt.prompt();
            const choiceResult = await deferredPrompt.userChoice;
            
            if (choiceResult.outcome === 'accepted') {
              console.log('✅ PWA installée par l\'utilisateur');
            }
            
            deferredPrompt = null;
            installButton.remove();
            installButton = null;
          }
        });
        
        // Afficher après un court délai
        setTimeout(() => {
          document.body.appendChild(installButton);
          
          // Masquer automatiquement après 10 secondes
          setTimeout(() => {
            if (installButton) {
              installButton.style.opacity = '0';
              setTimeout(() => {
                if (installButton) {
                  installButton.remove();
                  installButton = null;
                }
              }, 300);
            }
          }, 10000);
        }, 3000);
      }
    });

    // Masquer le bouton si l'app est déjà installée
    window.addEventListener('appinstalled', () => {
      console.log('✅ PWA installée avec succès');
      if (installButton) {
        installButton.remove();
        installButton = null;
      }
      deferredPrompt = null;
    });

    // Détection du mode standalone (app installée)
    if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone) {
      console.log('🚀 Application lancée en mode PWA');
      document.documentElement.classList.add('pwa-mode');
    }
  </script>

  @stack('scripts')

</body>
</html>