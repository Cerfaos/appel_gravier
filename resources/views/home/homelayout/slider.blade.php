

<!-- Outdoor Adventure Hero Section -->
<section class="relative min-h-screen flex items-center bg-gradient-to-br from-white via-outdoor-olive-50 to-outdoor-earth-100 overflow-hidden">
  
  <!-- Enhanced Background Patterns -->
  <div class="absolute inset-0">
    <!-- Animated gradient background -->
    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-100/60 via-outdoor-earth-100/50 to-outdoor-forest-100/40 animate-gradient-slow"></div>
    
    <!-- Geometric patterns -->
    <div class="absolute inset-0 opacity-10">
      <div class="absolute top-20 left-20 w-32 h-32 bg-outdoor-olive-300 rounded-full blur-3xl animate-float"></div>
      <div class="absolute top-40 right-32 w-24 h-24 bg-outdoor-earth-300 rounded-full blur-2xl animate-float-delayed"></div>
      <div class="absolute bottom-32 left-1/3 w-20 h-20 bg-outdoor-ochre-300 rounded-full blur-xl animate-float-slow"></div>
    </div>
    
    <!-- Mesh pattern overlay -->
    <div class="absolute inset-0 opacity-5 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23606c38" fill-opacity="0.3"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
  </div>

  <!-- Decorative Elements -->
  <div class="absolute top-20 left-10 text-6xl opacity-20 animate-sway">🌲</div>
  <div class="absolute bottom-40 right-20 text-4xl opacity-30 animate-gentle-bounce" style="animation-delay: 0.5s">🏔️</div>
  <div class="absolute top-1/3 right-10 text-3xl opacity-25 animate-sway" style="animation-delay: 1s">🍃</div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      
      <!-- Content -->
      <div class="space-y-8" data-aos="fade-up" data-aos-duration="800">
        
        <!-- Badge -->
        <div class="inline-flex items-center space-x-2 bg-outdoor-olive-100 text-outdoor-olive-700 px-4 py-2 rounded-full text-sm font-medium">
          <span class="text-lg">🌿</span>
          <span>Aventures Authentiques</span>
        </div>

        <!-- Title -->
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-display font-bold text-outdoor-forest-600 leading-tight">
          {{ $slider->title }}
         <!--  Découvrez l'<span class="text-outdoor-olive-500">Aventure</span>
        <br>qui vous attend  -->
          
        </h1>

        <!-- Description -->
        <p class="text-xl text-outdoor-forest-400 max-w-lg leading-relaxed">
          {{ $slider->description }}
        </p>

        <!-- Floating Stats -->
        <div class="flex flex-wrap gap-6 mb-8" data-aos="fade-up" data-aos-delay="300">
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl px-4 py-3 shadow-lg border border-outdoor-olive-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center space-x-3">
              <div class="w-8 h-8 bg-outdoor-olive-100 rounded-full flex items-center justify-center">
                <span class="text-sm">🏔️</span>
              </div>
              <div>
                <div class="font-bold text-outdoor-forest-600 text-lg">15+</div>
                <div class="text-xs text-outdoor-forest-400">Années d'expérience</div>
              </div>
            </div>
          </div>
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl px-4 py-3 shadow-lg border border-outdoor-olive-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center space-x-3">
              <div class="w-8 h-8 bg-outdoor-earth-100 rounded-full flex items-center justify-center">
                <span class="text-sm">🥾</span>
              </div>
              <div>
                <div class="font-bold text-outdoor-forest-600 text-lg">500+</div>
                <div class="text-xs text-outdoor-forest-400">Aventuriers guidés</div>
              </div>
            </div>
          </div>
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl px-4 py-3 shadow-lg border border-outdoor-olive-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center space-x-3">
              <div class="w-8 h-8 bg-outdoor-ochre-100 rounded-full flex items-center justify-center">
                <span class="text-sm">🗺️</span>
              </div>
              <div>
                <div class="font-bold text-outdoor-forest-600 text-lg">50+</div>
                <div class="text-xs text-outdoor-forest-400">Itinéraires uniques</div>
              </div>
            </div>
          </div>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4" data-aos="fade-up" data-aos-delay="400">
          <a href="{{ $slider->link }}" class="btn-primary text-lg px-8 py-4">
            🥾 Découvrir nos Aventures
          </a>
          <a href="{{ $slider->link }}" class="btn-outline text-lg px-8 py-4">
            📖 Mon Histoire
          </a>
        </div>

        <!-- Trust Indicators -->
        
      </div>

      <!-- Visual -->
      <div class="relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
        
        <!-- Main Image Container -->
        <div class="relative">
          
          <!-- Background Gradient Card -->
          <div class="absolute inset-0 bg-outdoor-sunset rounded-4xl transform rotate-3 shadow-outdoor-2xl"></div>
          <div class="absolute inset-0 bg-outdoor-forest rounded-4xl transform -rotate-1 shadow-outdoor-xl opacity-20"></div>
          
          <!-- Main Image -->
          <div class="relative bg-white rounded-4xl p-8 shadow-outdoor-2xl">
            <img 
              src="{{ asset($slider->image) }}" 
              alt="Cerfaos Outdoor Adventures" 
              class="w-full h-auto rounded-3xl"
            />
            
            <!-- Floating Achievement Cards -->
            <div class="absolute -top-4 -right-4 bg-white rounded-2xl p-4 shadow-xl border border-outdoor-olive-100 transform rotate-6 hover:rotate-3 transition-transform duration-300">
              <div class="flex items-center space-x-2">
                <span class="text-2xl">🏆</span>
                <div>
                  <div class="text-sm font-bold text-outdoor-forest-600">Guide Certifié</div>
                  <div class="text-xs text-outdoor-forest-400">FFME & UIAGM</div>
                </div>
              </div>
            </div>
            
            <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl p-4 shadow-xl border border-outdoor-earth-100 transform -rotate-6 hover:-rotate-3 transition-transform duration-300">
              <div class="flex items-center space-x-2">
                <span class="text-2xl">⭐</span>
                <div>
                  <div class="text-sm font-bold text-outdoor-forest-600">4.9/5</div>
                  <div class="text-xs text-outdoor-forest-400">150+ Avis</div>
                </div>
              </div>
            </div>
            
          </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute -z-10 top-1/4 -right-8 w-32 h-32 bg-outdoor-ochre-200 rounded-full opacity-20 blur-2xl"></div>
        <div class="absolute -z-10 bottom-1/4 -left-8 w-40 h-40 bg-outdoor-olive-200 rounded-full opacity-20 blur-2xl"></div>
      </div>
    </div>
  </div>

  
</section>