
<!-- Section Itinéraires GPX Améliorée -->
<section class="py-20 bg-gradient-to-br from-outdoor-cream-50 via-outdoor-olive-50 to-outdoor-cream-100 relative">
  <!-- Motifs de fond -->
  <div class="absolute inset-0 opacity-5">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23606c38" fill-opacity="0.4"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <!-- En-tête de section avec plus de contraste -->
      <div class="text-center mb-16">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-outdoor-forest-700 to-outdoor-forest-900 rounded-3xl mb-8 shadow-xl border-2 border-outdoor-forest-800">
              <svg class="w-10 h-10 text-outdoor-cream-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
              </svg>
          </div>
          
          <div class="relative inline-block">
              <h2 class="text-4xl font-display font-bold text-outdoor-forest-700 sm:text-5xl mb-6 relative z-10">
                  {!! \App\Models\HomeContent::getValue('itineraries_title', 'content', 'Découvrez nos <span class="text-transparent bg-clip-text bg-gradient-to-r from-outdoor-olive-600 to-outdoor-ochre-600">itinéraires GPX</span>') !!}
              </h2>
              <!-- Soulignement décoratif -->
              <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-outdoor-olive-500 to-outdoor-ochre-500 rounded-full"></div>
          </div>
          
          <p class="text-xl text-outdoor-forest-600 max-w-3xl mx-auto leading-relaxed mt-8">
              {{ \App\Models\HomeContent::getValue('itineraries_subtitle', 'content', 'Explorez notre collection d\'itinéraires soigneusement sélectionnés pour vos aventures outdoor. Téléchargez les tracés GPX et partez à la découverte de nouveaux horizons !') }}
          </p>
      </div>

      <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
          <div>
              <!-- Fonctionnalités -->
              
              <div class="grid gap-8">
                  <div class="flex items-start p-8 bg-white/90 backdrop-blur-sm rounded-3xl border-2 border-outdoor-cream-300 hover:border-outdoor-olive-300 hover:shadow-xl transition-all duration-300 group">
                      <div class="flex-shrink-0">
                          <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-outdoor-olive-500 to-outdoor-olive-600 rounded-2xl shadow-md group-hover:scale-110 transition-transform duration-300">
                              <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                              </svg>
                          </div>
                      </div>
                      <div class="ml-6">
                          <h3 class="text-xl font-bold text-outdoor-forest-800 mb-2">Cartes interactives</h3>
                          <p class="text-outdoor-forest-600 leading-relaxed">Visualisez chaque parcours en détail avec nos cartes interactives haute définition</p>
                      </div>
                  </div>
                  
                  <div class="flex items-start p-8 bg-white/90 backdrop-blur-sm rounded-3xl border-2 border-outdoor-cream-300 hover:border-outdoor-ochre-300 hover:shadow-xl transition-all duration-300 group">
                      <div class="flex-shrink-0">
                          <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-outdoor-ochre-500 to-outdoor-ochre-600 rounded-2xl shadow-md group-hover:scale-110 transition-transform duration-300">
                              <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                              </svg>
                          </div>
                      </div>
                      <div class="ml-6">
                          <h3 class="text-xl font-bold text-outdoor-forest-800 mb-2">Profils de dénivelé</h3>
                          <p class="text-outdoor-forest-600 leading-relaxed">Analysez les difficultés et l'effort requis pour chaque parcours avec précision</p>
                      </div>
                  </div>
                  
                  <div class="flex items-start p-8 bg-white/90 backdrop-blur-sm rounded-3xl border-2 border-outdoor-cream-300 hover:border-outdoor-earth-300 hover:shadow-xl transition-all duration-300 group">
                      <div class="flex-shrink-0">
                          <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-outdoor-earth-500 to-outdoor-earth-600 rounded-2xl shadow-md group-hover:scale-110 transition-transform duration-300">
                              <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                              </svg>
                          </div>
                      </div>
                      <div class="ml-6">
                          <h3 class="text-xl font-bold text-outdoor-forest-800 mb-2">Téléchargement GPX</h3>
                          <p class="text-outdoor-forest-600 leading-relaxed">Compatible avec tous les GPS et applications de randonnée modernes</p>
                      </div>
                  </div>
              </div>
              
              <div class="mt-12 flex flex-col sm:flex-row gap-6">
                  <a href="{{ route('itineraries.index') }}" 
                     class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-outdoor-olive-600 to-outdoor-olive-700 hover:from-outdoor-olive-700 hover:to-outdoor-olive-800 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                      <span class="text-lg">Explorer les itinéraires</span>
                      <svg class="ml-3 w-6 h-6 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                      </svg>
                  </a>
                  
                 
              </div>
          </div>
          
          <div class="mt-16 lg:mt-0">
              <!-- Image d'illustration avec plus de contraste -->
              <div class="relative">
                  <!-- Éléments décoratifs avec plus de contraste -->
                  <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-ochre-600 rounded-3xl transform rotate-3 shadow-2xl opacity-80"></div>
                  <div class="absolute inset-0 bg-gradient-to-br from-outdoor-forest-600 to-outdoor-forest-800 rounded-3xl transform -rotate-2 shadow-xl opacity-60"></div>
                  
                  <div class="relative bg-white p-8 rounded-3xl shadow-2xl border-4 border-white">
                      <img src="{{ asset('frontend/assets/images/img_cerfaos/vertical_rouge.png') }}" 
                           alt="Itinéraires Cerfaos - Découvrez nos parcours outdoor" 
                           class="w-full h-full object-cover rounded-2xl shadow-lg">
                      
                      <!-- Badge décoratif -->
                     
                  </div>
                  
                  <!-- Statistiques flottantes -->
                 
                  
                 
              </div>
          </div>
      </div>
      
      <!-- Derniers itinéraires avec contraste amélioré -->
      @if(isset($latestItineraries) && $latestItineraries->count() > 0)
          <div class="mt-24">
              <div class="text-center mb-16">
                  <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-outdoor-ochre-500 to-outdoor-ochre-600 rounded-2xl mb-6 shadow-lg">
                      <span class="text-2xl">✨</span>
                  </div>
                  <h3 class="text-3xl font-display font-bold text-outdoor-forest-800 mb-6">Derniers itinéraires ajoutés</h3>
                  <p class="text-xl text-outdoor-forest-600 max-w-2xl mx-auto leading-relaxed">Découvrez les nouvelles aventures qui vous attendent, fraîchement ajoutées à notre collection</p>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                  @foreach($latestItineraries as $itinerary)
                      <div class="transform hover:scale-105 transition-transform duration-300">
                          <x-itinerary-card :itinerary="$itinerary" />
                      </div>
                  @endforeach
              </div>
              
              <div class="text-center mt-12">
                  <a href="{{ route('itineraries.index') }}" 
                     class="group inline-flex items-center justify-center px-10 py-5 border-3 border-outdoor-forest-600 hover:border-outdoor-forest-700 bg-white hover:bg-outdoor-forest-50 text-outdoor-forest-700 hover:text-outdoor-forest-800 font-bold text-lg rounded-3xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                      <span>Voir tous les itinéraires</span>
                      <svg class="ml-3 w-6 h-6 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                      </svg>
                  </a>
              </div>
          </div>
      @endif
  </div>
</section>