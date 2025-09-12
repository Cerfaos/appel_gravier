<!-- 3 BLOCS PRINCIPAUX - Style Outdoor Cohérent -->
<section id="main-content" class="py-20 lg:py-32 relative overflow-hidden" style="background-color: #232f15 !important;">
    
    <!-- Enhanced Background - Dégradé vertical vers couleur footer exacte -->
    <div class="absolute inset-0 hidden md:block" style="background: linear-gradient(to bottom, rgba(96, 108, 56, 0.3), rgba(40, 54, 24, 0.6), #232f15) !important;"></div>
    

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Grid 3 blocs - Style outdoor -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Bloc Itinéraires -->
            <div id="itineraires" class="card-outdoor group hover:scale-105 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 relative overflow-hidden" data-aos="fade-up" data-aos-duration="500">
                <!-- Gradient overlay on hover - MASQUÉ SUR MOBILE -->
                <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-500/5 to-outdoor-earth-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 hidden md:block"></div>
                
                <div class="relative text-center">
                    <!-- Icon section -->
                    <div class="w-20 h-20 bg-outdoor-olive-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-outdoor-olive-200 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-10 h-10 text-outdoor-olive-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    
                    <!-- Badge compteur -->
                    <div class="inline-flex items-center space-x-2 bg-outdoor-olive-100 text-outdoor-olive-700 px-3 py-1 rounded-full text-sm font-medium mb-4">
                        <span>Itinéraires</span>
                    </div>

                    <!-- Title -->
                    <h4 class="font-display font-semibold text-2xl mb-4 text-outdoor-forest-600">
                        Les parcours à découvrir
                    </h4>
                    
                    <!-- Description -->
                    <p class="text-outdoor-forest-400 mb-6 leading-relaxed">
                        Découvrez des itinéraires triés sur le volet, GPX à l’appui, pour vous guider vers les plus beaux coins d'Alsace pour commencer.
                    </p>
                    
                    
                    <!-- Status indicators -->
                    <div class="flex items-center justify-center space-x-4 text-sm text-outdoor-forest-300 group-hover:text-outdoor-forest-500 transition-colors mb-6">
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 group-hover:animate-pulse"></span>
                            Disponible
                        </span>
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 group-hover:animate-pulse" style="animation-delay: 0.2s;"></span>
                            GPS Ready
                        </span>
                    </div>
                    
                    <!-- Action Button -->
                    <a href="{{ route('itineraries.index') }}" class="inline-flex items-center px-6 py-3 bg-outdoor-olive-500 text-white rounded-xl hover:bg-outdoor-olive-600 transition-all duration-300 font-medium group-hover:shadow-lg">
                        Explorer les itinéraires
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

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

            <!-- Bloc Sorties -->
            <div id="sorties" class="card-outdoor group hover:scale-105 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 relative overflow-hidden" data-aos="fade-up" data-aos-duration="700">
                <!-- Gradient overlay on hover - MASQUÉ SUR MOBILE -->
                <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-500/5 to-outdoor-earth-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 hidden md:block"></div>
                
                <div class="relative text-center">
                    <!-- Icon section -->
                    <div class="w-20 h-20 bg-outdoor-earth-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-outdoor-earth-200 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-10 h-10 text-outdoor-earth-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    
                    <!-- Badge compteur -->
                    <div class="inline-flex items-center space-x-2 bg-outdoor-earth-100 text-outdoor-earth-700 px-3 py-1 rounded-full text-sm font-medium mb-4">
                        <span>Sorties</span>
                    </div>

                    <!-- Title -->
                    <h4 class="font-display font-semibold text-2xl mb-4 text-outdoor-forest-600">
                        Mes sorties
                    </h4>
                    
                    <!-- Description -->
                    <p class="text-outdoor-forest-400 mb-6 leading-relaxed">
                        Suivez-moi : sorties au fil des saisons, statistiques claires, récits vivants et petites grandes mésaventures.
                    </p>
                    
                    
                    <!-- Status indicators -->
                    <div class="flex items-center justify-center space-x-4 text-sm text-outdoor-forest-300 group-hover:text-outdoor-forest-500 transition-colors mb-6">
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 group-hover:animate-pulse"></span>
                            Disponible
                        </span>
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-orange-500 rounded-full mr-2 group-hover:animate-pulse" style="animation-delay: 0.2s;"></span>
                            Débutant
                        </span>
                    </div>
                    
                    <!-- Action Button -->
                    <a href="{{ route('sorties.index') }}" class="inline-flex items-center px-6 py-3 bg-outdoor-earth-500 text-white rounded-xl hover:bg-outdoor-earth-600 transition-all duration-300 font-medium group-hover:shadow-lg">
                        Rejoindre les sorties
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <!-- Action indicator appears on hover -->
                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
                        <div class="w-8 h-8 bg-outdoor-earth-500 rounded-full flex items-center justify-center text-white shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bloc Blog -->
            <div id="blog" class="card-outdoor group hover:scale-105 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 relative overflow-hidden" data-aos="fade-up" data-aos-duration="900">
                <!-- Gradient overlay on hover - MASQUÉ SUR MOBILE -->
                <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-500/5 to-outdoor-earth-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 hidden md:block"></div>
                
                <div class="relative text-center">
                    <!-- Icon section -->
                    <div class="w-20 h-20 bg-outdoor-ochre-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-outdoor-ochre-200 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-10 h-10 text-outdoor-ochre-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    
                    <!-- Badge compteur -->
                    <div class="inline-flex items-center space-x-2 bg-outdoor-ochre-100 text-outdoor-ochre-700 px-3 py-1 rounded-full text-sm font-medium mb-4">
                        <span>Articles</span>
                    </div>

                    <!-- Title -->
                    <h4 class="font-display font-semibold text-2xl mb-4 text-outdoor-forest-600">
                        Mes billets de partage
                    </h4>
                    
                    <!-- Description -->
                    <p class="text-outdoor-forest-400 mb-6 leading-relaxed">
                        Prenez le temps de lire : billets d’humeur, histoires de terrain et quelques déboires racontés avec le sourire.
                    </p>
                    
                    
                    <!-- Status indicators -->
                    <div class="flex items-center justify-center space-x-4 text-sm text-outdoor-forest-300 group-hover:text-outdoor-forest-500 transition-colors mb-6">
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 group-hover:animate-pulse"></span>
                            Disponible
                        </span>
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-2 group-hover:animate-pulse" style="animation-delay: 0.2s;"></span>
                            Honnête
                        </span>
                    </div>
                    
                    <!-- Action Button -->
                    <a href="{{ url('/blog') }}" class="inline-flex items-center px-6 py-3 bg-outdoor-ochre-500 text-white rounded-xl hover:bg-outdoor-ochre-600 transition-all duration-300 font-medium group-hover:shadow-lg">
                        Lire mes infos
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <!-- Action indicator appears on hover -->
                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
                        <div class="w-8 h-8 bg-outdoor-ochre-500 rounded-full flex items-center justify-center text-white shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>