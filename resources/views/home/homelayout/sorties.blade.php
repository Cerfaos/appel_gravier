
<!-- Section Sorties/Expéditions Améliorée -->
<section class="py-20 bg-gradient-to-br from-outdoor-cream-50 via-outdoor-olive-50 to-outdoor-cream-100 relative">
  <!-- Motifs de fond -->
  <div class="absolute inset-0 opacity-5">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23606c38" fill-opacity="0.4"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <!-- En-tête de section avec plus de contraste -->
      <div class="text-center mb-16">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-outdoor-forest-700 to-outdoor-forest-900 rounded-3xl mb-8 shadow-xl border-2 border-outdoor-forest-800">
              <span class="text-4xl">🏕️</span>
          </div>
          
          <div class="relative inline-block">
              <h2 class="text-4xl font-display font-bold text-outdoor-forest-700 sm:text-5xl mb-6 relative z-10">
                  {!! \App\Models\HomeContent::getValue('sorties_title', 'content', 'Nos <span class="text-transparent bg-clip-text bg-gradient-to-r from-outdoor-olive-600 to-outdoor-ochre-600">sorties & expéditions</span>') !!}
              </h2>
              <!-- Soulignement décoratif -->
              <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-outdoor-olive-500 to-outdoor-ochre-500 rounded-full"></div>
          </div>
          
          <p class="text-xl text-outdoor-forest-600 max-w-3xl mx-auto leading-relaxed mt-8">
              {{ \App\Models\HomeContent::getValue('sorties_subtitle', 'content', 'Découvrez nos sorties organisées et expéditions exceptionnelles. Des treks multi-jours aux aventures collectives, rejoignez-nous pour vivre des moments inoubliables !') }}
          </p>
      </div>

      <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
          <div>
              <!-- Fonctionnalités -->
              
              <div class="grid gap-8">
                  <div class="flex items-start p-8 bg-white/90 backdrop-blur-sm rounded-3xl border-2 border-outdoor-cream-300 hover:border-outdoor-olive-300 hover:shadow-xl transition-all duration-300 group">
                      <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-outdoor-olive-500 to-outdoor-forest-600 rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform duration-300">
                          <span class="text-3xl">🎒</span>
                      </div>
                      <div>
                          <h3 class="text-2xl font-display font-bold text-outdoor-forest-700 mb-3">
                              Sorties organisées
                          </h3>
                          <p class="text-outdoor-forest-600 leading-relaxed text-lg">
                              Participez à nos sorties collectives. 
                              Matériel, logistique et sécurité assurés par soi-même.
                          </p>
                      </div>
                  </div>
                  
                  <div class="flex items-start p-8 bg-white/90 backdrop-blur-sm rounded-3xl border-2 border-outdoor-cream-300 hover:border-outdoor-olive-300 hover:shadow-xl transition-all duration-300 group">
                      <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-outdoor-ochre-500 to-outdoor-earth-600 rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform duration-300">
                          <span class="text-3xl">🏔️</span>
                      </div>
                      <div>
                          <h3 class="text-2xl font-display font-bold text-outdoor-forest-700 mb-3">
                              Expéditions exceptionnelles
                          </h3>
                          <p class="text-outdoor-forest-600 leading-relaxed text-lg">
                              Des aventures multi-jours dans des environnements exceptionnels. 
                              Treks, bivouacs et découvertes en groupe dans les plus beaux massifs vosgiens.
                          </p>
                      </div>
                  </div>
                  
                  <div class="flex items-start p-8 bg-white/90 backdrop-blur-sm rounded-3xl border-2 border-outdoor-cream-300 hover:border-outdoor-olive-300 hover:shadow-xl transition-all duration-300 group">
                      <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-outdoor-earth-500 to-outdoor-forest-700 rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform duration-300">
                          <span class="text-3xl">🗺️</span>
                      </div>
                      <div>
                          <h3 class="text-2xl font-display font-bold text-outdoor-forest-700 mb-3">
                              Tracés GPS inclus
                          </h3>
                          <p class="text-outdoor-forest-600 leading-relaxed text-lg">
                              Chaque sortie est accompagnée de son tracé GPX détaillé. 
                              Téléchargez les parcours et préparez votre aventure en toute sérénité.
                          </p>
                      </div>
                  </div>
              </div>
          </div>
          
          <div class="mt-12 lg:mt-0">
              <!-- Grille des dernières sorties -->
              @if($latestSorties && $latestSorties->count() > 0)
                  <div class="grid gap-6">
                      @foreach($latestSorties->take(3) as $index => $sortie)
                          <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 group border border-outdoor-cream-200 hover:border-outdoor-olive-300" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                              <div class="flex items-center space-x-4">
                                  <!-- Image de la sortie -->
                                  <div class="flex-shrink-0 w-20 h-20 rounded-2xl overflow-hidden bg-gradient-to-br from-outdoor-olive-400 to-outdoor-forest-600">
                                      @if($sortie->featuredImage)
                                          <img src="{{ $sortie->featuredImage->medium_image }}" 
                                               alt="{{ $sortie->title }}" 
                                               class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                               loading="lazy">
                                      @else
                                          <div class="w-full h-full flex items-center justify-center">
                                              <span class="text-3xl text-white">🏕️</span>
                                          </div>
                                      @endif
                                  </div>
                                  
                                  <!-- Contenu -->
                                  <div class="flex-grow min-w-0">
                                      <h4 class="text-xl font-display font-bold text-outdoor-forest-700 mb-2 truncate group-hover:text-outdoor-olive-600 transition-colors">
                                          {{ $sortie->title }}
                                      </h4>
                                      
                                      <!-- Statistiques -->
                                      <div class="flex items-center space-x-4 mb-2">
                                          @if($sortie->distance_km)
                                              <div class="flex items-center text-sm text-outdoor-forest-500">
                                                  <span class="mr-1">📏</span>
                                                  <span>{{ number_format($sortie->distance_km, 1) }}km</span>
                                              </div>
                                          @endif
                                          @if($sortie->difficulty_level)
                                              <div class="flex items-center text-sm text-outdoor-forest-500">
                                                  @if($sortie->difficulty_level === 'facile')
                                                      <span class="mr-1">🟢</span>
                                                  @elseif($sortie->difficulty_level === 'moyen')
                                                      <span class="mr-1">🟡</span>
                                                  @elseif($sortie->difficulty_level === 'difficile')
                                                      <span class="mr-1">🔴</span>
                                                  @endif
                                                  <span class="capitalize">{{ $sortie->difficulty_level }}</span>
                                              </div>
                                          @endif
                                      </div>
                                      
                                      <!-- Description courte -->
                                      <p class="text-sm text-outdoor-forest-500 line-clamp-2 leading-relaxed">
                                          {{ Str::limit($sortie->description, 100) }}
                                      </p>
                                  </div>
                                  
                                  <!-- Flèche -->
                                  <div class="flex-shrink-0">
                                      <div class="w-8 h-8 bg-outdoor-olive-100 rounded-full flex items-center justify-center group-hover:bg-outdoor-olive-200 transition-colors">
                                          <svg class="w-4 h-4 text-outdoor-olive-600 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                          </svg>
                                      </div>
                                  </div>
                              </div>
                              
                              <!-- Lien invisible pour toute la carte -->
                              <a href="{{ route('sorties.show', $sortie->slug) }}" class="absolute inset-0 z-10"></a>
                          </div>
                      @endforeach
                  </div>
              @else
                  <!-- Message par défaut si aucune sortie -->
                
              @endif
          </div>
      </div>
      
      <!-- Section CTA -->
      <div class="text-center mt-20" data-aos="fade-up" data-aos-delay="400">
          <div class="bg-gradient-to-r from-outdoor-olive-600/10 via-outdoor-ochre-600/10 to-outdoor-earth-600/10 rounded-3xl p-12 backdrop-blur-sm border border-outdoor-cream-300">
              <h3 class="text-3xl font-display font-bold text-outdoor-forest-700 mb-6">
                  Prêt pour l'aventure  ?
              </h3>
              <p class="text-xl text-outdoor-forest-600 mb-8 max-w-2xl mx-auto">
                  Rejoignez nos sorties organisées et vivez des expériences inoubliables en groupe avec des passionnés d'outdoor comme vous.
              </p>
              <div class="flex flex-col sm:flex-row gap-4 justify-center">
                  <a href="{{ route('sorties.index') }}" 
                     class="inline-flex items-center space-x-2 bg-gradient-to-r from-outdoor-olive-500 to-outdoor-forest-600 hover:from-outdoor-olive-600 hover:to-outdoor-forest-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                      <span>🏕️</span>
                      <span>Toutes les Sorties</span>
                  </a>
                  <a href="{{ route('itineraries.index') }}" 
                     class="inline-flex items-center space-x-2 bg-white hover:bg-outdoor-cream-50 text-outdoor-forest-700 font-bold py-4 px-8 rounded-xl border-2 border-outdoor-cream-300 hover:border-outdoor-olive-300 transition-all duration-300 transform hover:-translate-y-1">
                      <span>🗺️</span>
                      <span>Itinéraires Individuels</span>
                  </a>
              </div>
          </div>
      </div>
  </div>
</section>