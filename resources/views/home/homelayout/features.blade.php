
<!-- Outdoor Activities Section -->
<section id="services" class="py-20 lg:py-32 relative overflow-hidden" style="background: white;">
  
  <!-- Enhanced Background - Version mobile et desktop -->
  <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-50/30 via-white to-outdoor-earth-50 md:opacity-100 opacity-50"></div>
  
  <!-- Animated background elements - Simplifiés sur mobile -->
  <div class="absolute inset-0">
    <div class="absolute top-10 right-10 w-20 h-20 md:w-40 md:h-40 bg-outdoor-olive-200 rounded-full blur-2xl md:blur-3xl opacity-10 md:opacity-20 md:animate-pulse-slow"></div>
    <div class="absolute bottom-20 left-20 w-16 h-16 md:w-32 md:h-32 bg-outdoor-earth-200 rounded-full blur-xl md:blur-2xl opacity-5 md:opacity-15 md:animate-float"></div>
    <div class="absolute top-1/2 left-1/4 w-12 h-12 md:w-24 md:h-24 bg-outdoor-ochre-200 rounded-full blur-lg md:blur-xl opacity-5 md:opacity-10 md:animate-float-delayed"></div>
  </div>
  
  <!-- Pattern overlay - Très subtil sur mobile -->
  <div class="absolute inset-0 opacity-2 md:opacity-5 bg-[url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23606c38" fill-opacity="0.4" fill-rule="evenodd"%3E%3Cpath d="m0 40 40-40H20L0 20M40 40V20L20 40"/%3E%3C/g%3E%3C/svg%3E')]"></div>
  
  <!-- Decorative Elements - Cachés sur mobile pour économiser l'espace -->
  <div class="absolute top-10 right-10 text-6xl opacity-10 animate-sway hidden md:block">🏔️</div>
  <div class="absolute bottom-20 left-20 text-4xl opacity-10 animate-gentle-bounce hidden md:block">🌲</div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Section Header -->
    <div class="text-center mb-16" data-aos="fade-up">
      <div class="inline-flex items-center space-x-2 bg-outdoor-olive-100 text-outdoor-olive-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
        <span class="text-lg">🎯</span>
        <span>Mes Activités</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-display font-bold text-outdoor-forest-600 mb-6">
        Aventures qui me tirent vers le haut (et vers la sieste)
      </h2>
      <p class="text-xl text-outdoor-forest-400 max-w-3xl mx-auto">
        Découvrez des activités plein air calibrées pour débuter sans se cramer.
      </p>
    </div>

    <!-- Activities Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      @if($features && $features->count() > 0)
        @foreach($features as $index => $feature)
          <div class="card-outdoor group hover:scale-105 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 relative overflow-hidden" data-aos="fade-up" data-aos-duration="{{ 500 + ($index * 200) }}">
            <!-- Gradient overlay on hover - Visible sur tous devices -->
            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-500/5 to-outdoor-earth-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative">
            <div class="text-center">
              <div class="w-16 h-16 bg-outdoor-olive-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-outdoor-olive-200 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                @if($feature->icon)
                  @if(str_starts_with($feature->icon, 'fa'))
                    <i class="{{ $feature->icon }} text-3xl text-outdoor-olive-600"></i>
                  @else
                    <span class="text-3xl">{{ $feature->icon }}</span>
                  @endif
                @else
                  <span class="text-3xl">🎯</span>
                @endif
              </div>
              <h4 class="font-display font-semibold text-xl mb-4 text-outdoor-forest-600">
                {{ $feature->title }}
              </h4>
              <p class="text-outdoor-forest-400 mb-6">
                {{ $feature->description }}
              </p>
              <div class="flex items-center justify-center space-x-4 text-sm text-outdoor-forest-300 group-hover:text-outdoor-forest-500 transition-colors">
                <span class="flex items-center">
                  <span class="w-2 h-2 bg-green-500 rounded-full mr-2 group-hover:animate-pulse"></span>
                  Disponible
                </span>
                <span class="flex items-center">
                  <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 group-hover:animate-pulse" style="animation-delay: 0.2s;"></span>
                  Expert
                </span>
              </div>
              
              <!-- Action indicator appears on hover -->
              <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
                <div class="w-8 h-8 bg-outdoor-olive-500 rounded-full flex items-center justify-center text-white shadow-lg">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </div>
              </div>
            </div>
            </div>
          </div>
        @endforeach
      @else
        <!-- Contenu par défaut si aucune feature n'est trouvée -->
        <div class="col-span-full text-center py-12">
          <div class="text-6xl mb-4">🎯</div>
          <h3 class="text-2xl font-display font-semibold text-outdoor-forest-600 mb-4">
            Bientôt de nouvelles activités !
          </h3>
          <p class="text-outdoor-forest-400">
            Nos équipes préparent de formidables aventures pour vous. Restez connectés !
          </p>
        </div>
      @endif
    </div>

    <!-- CTA Section -->
   
  </div>

  <!-- Floating Action -->
  <div class="absolute bottom-8 right-8">
    <div class="bg-outdoor-olive-500 text-white p-4 rounded-full shadow-outdoor-lg animate-gentle-bounce cursor-pointer" title="Guide d'activités">
      <span class="text-2xl">🧭</span>
    </div>
  </div>
</section>