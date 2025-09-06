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
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/assets/images/apple-touch-icon.png') }}">
  <!--- End favicon-->

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200;12..96,300;12..96,400;12..96,500;12..96,600;12..96,700;12..96,800&display=swap" rel="stylesheet">

  <!-- Forest Premium Design System -->
  <link rel="stylesheet" href="{{ asset('css/archive/forest-premium-design-system.css') }}">
  
  <!-- Vite Assets with Outdoor Tailwind Theme -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <!-- Keep essential external libraries for animations and functionality -->
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
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
  
  <!-- Custom Outdoor JavaScript -->
  <script>
    // Initialize AOS animations
    AOS.init({
      duration: 800,
      easing: 'ease-out',
      once: true,
      offset: 100
    });

    // Preloader
    window.addEventListener('load', function() {
      const preloader = document.getElementById('preloader');
      if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => {
          preloader.style.display = 'none';
        }, 300);
      }
    });

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

  @stack('scripts')

</body>
</html>