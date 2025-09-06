<!-- Section Separator -->
<div class="h-20 bg-gradient-to-b from-outdoor-olive-50 via-outdoor-ochre-50 to-outdoor-cream-50 relative">
  <div class="absolute inset-0">
    <div class="h-full bg-gradient-to-r from-outdoor-olive-100/10 via-transparent to-outdoor-ochre-100/10"></div>
  </div>
</div>

<!-- Customer Reviews Section -->
<section class="py-20 lg:py-32 bg-outdoor-cream-50 relative overflow-hidden border-t-2 border-outdoor-cream-200">

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header -->
    <div class="text-center mb-16" data-aos="fade-up">
      
      <!-- Badge -->
      <div class="inline-flex items-center space-x-2 bg-outdoor-ochre-100 text-outdoor-ochre-700 px-4 py-2 rounded-full text-sm font-medium mb-6">
        <span class="text-lg">🗣️</span>
        <span>Témoignages</span>
      </div>

      <h2 class="text-4xl md:text-5xl font-display font-bold text-outdoor-forest-600 leading-tight">
        Nos <span class="text-outdoor-ochre-500">aventuriers</span> témoignent
      </h2>
    </div>

    <!-- Reviews Slider -->
    <div class="relative" data-aos="fade-up" data-aos-duration="800">
      
      @php
        $review = App\Models\Review::latest()->get();
      @endphp

      @if($review && $review->count() > 0)
        <!-- Swiper Container -->
        <div class="swiper reviews-swiper">
          <div class="swiper-wrapper">
            
            @foreach ($review as $item)
          <div class="swiper-slide">
            <!-- Review Card -->
            <div class="bg-white rounded-3xl p-8 shadow-outdoor-lg hover:shadow-outdoor-xl transition-all duration-300 group h-full">
              <div class="mb-6">
                <!-- Stars Rating -->
                <div class="flex items-center space-x-1 mb-4">
                  <span class="text-yellow-400">⭐</span>
                  <span class="text-yellow-400">⭐</span>
                  <span class="text-yellow-400">⭐</span>
                  <span class="text-yellow-400">⭐</span>
                  <span class="text-yellow-400">⭐</span>
                </div>
                
                <!-- Review Message -->
                <p class="text-outdoor-forest-400 leading-relaxed text-lg">
                  "{{ $item->message }}"
                </p>
              </div>
              
              <!-- Author Info -->
              <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-outdoor-olive-100 rounded-full flex items-center justify-center overflow-hidden">
                  @if($item->image && $item->image !== 'upload/no_image.jpg' && file_exists(public_path($item->image)))
                    <img src="{{ asset($item->image) }}" alt="Photo de {{ $item->name }}" class="w-full h-full object-cover" loading="lazy">
                  @else
                    <!-- Avatar par défaut avec initiales -->
                    <div class="w-full h-full bg-gradient-to-br from-outdoor-olive-400 to-outdoor-olive-600 flex items-center justify-center">
                      <span class="text-white font-bold text-lg">
                        {{ strtoupper(substr($item->name, 0, 1)) }}
                      </span>
                    </div>
                  @endif
                </div>
                <div>
                  <h4 class="font-semibold text-outdoor-forest-600 text-lg">{{ $item->name }}</h4>
                  <p class="text-sm text-outdoor-forest-400">{{ $item->position }}</p>
                </div>
              </div>
            </div>
          </div>
            @endforeach
            
          </div>
        </div>

        <!-- Pagination Dots -->
        <div class="reviews-pagination flex justify-center mt-8 space-x-3"></div>
        
      @else
        <!-- Message si aucun avis -->
        <div class="text-center py-16">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-outdoor-ochre-100 rounded-full mb-6">
            <span class="text-4xl">💬</span>
          </div>
          <h3 class="text-2xl font-display font-semibold text-outdoor-forest-600 mb-4">
            Bientôt des témoignages !
          </h3>
          <p class="text-outdoor-forest-400 max-w-md mx-auto">
            Nos premiers aventuriers préparent leurs retours d'expérience. Restez connectés pour découvrir leurs histoires !
          </p>
        </div>
      @endif
      
    </div>
  </div>
</section>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize Reviews Slider
  const reviewsSwiper = new Swiper('.reviews-swiper', {
    // Configuration du slider
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    
    // Autoplay automatique
    autoplay: {
      delay: 4000, // Change toutes les 4 secondes
      disableOnInteraction: false, // Continue après interaction
      pauseOnMouseEnter: true, // Pause au survol
    },
    
    // Responsive breakpoints
    breakpoints: {
      640: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
    },
    
    // Pagination par points
    pagination: {
      el: '.reviews-pagination',
      clickable: true,
      renderBullet: function (index, className) {
        return '<span class="' + className + ' w-4 h-4 bg-outdoor-forest-300 rounded-full transition-all duration-300 hover:bg-outdoor-ochre-500 cursor-pointer"></span>';
      },
    },
    
    // Effets de transition
    effect: 'slide',
    speed: 800,
    
    // Auto-height pour uniformiser la hauteur
    autoHeight: true,
    
    // Transition plus fluide
    cssEase: 'ease-in-out',
  });
  
  // Pause autoplay on hover pour une meilleure UX
  const swiperContainer = document.querySelector('.reviews-swiper');
  swiperContainer.addEventListener('mouseenter', () => {
    reviewsSwiper.autoplay.stop();
  });
  
  swiperContainer.addEventListener('mouseleave', () => {
    reviewsSwiper.autoplay.start();
  });
});
</script>

<style>
/* Styles personnalisés pour le slider automatique */
.swiper-slide {
  height: auto;
}

.swiper-pagination-bullet {
  background: #606c38 !important;
  opacity: 0.3;
  transition: all 0.3s ease;
  margin: 0 6px !important;
}

.swiper-pagination-bullet-active {
  opacity: 1;
  background: #dda15e !important;
  transform: scale(1.3);
}

/* Animation d'entrée pour les slides */
.swiper-slide-active {
  animation: slideIn 0.8s ease-out;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

/* Effet de fade pour les slides inactifs */
.swiper-slide {
  opacity: 0.7;
  transition: opacity 0.3s ease;
}

.swiper-slide-active {
  opacity: 1;
}

/* Hover effect sur les cartes */
.swiper-slide:hover .bg-white {
  transform: translateY(-5px);
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>