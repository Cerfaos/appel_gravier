@extends('home.body.home_master')

@section('home')
<div class="bg-outdoor-cream-50 min-h-screen">
    <!-- Banner Title Section -->
    

    <!-- Hero Section PPG -->
    <section class="relative bg-gradient-to-r from-outdoor-forest-500 to-outdoor-earth-500 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-bold mb-6">
                            <span class="text-outdoor-cream-50">Préparation Physique</span><br>
                            <span class="text-outdoor-ochre-400">Globale</span>
                        </h1>
                        
                        <p class="text-xl md:text-2xl mb-8 text-outdoor-cream-50/90 leading-relaxed">
                            Développez une condition physique complète et adaptée aux activités outdoor. 
                            Un corps préparé, performant et résistant.
                        </p>
                        
                        <div class="flex flex-wrap gap-6 text-outdoor-cream-50/90 mb-8">
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt mr-2 text-outdoor-ochre-400"></i>
                                <span>Prévention des blessures</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-bolt mr-2 text-outdoor-ochre-400"></i>
                                <span>Performance optimisée</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-heart mr-2 text-outdoor-ochre-400"></i>
                                <span>Endurance renforcée</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-smile mr-2 text-outdoor-ochre-400"></i>
                                <span>Plaisir durable</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="#programmes" class="bg-outdoor-ochre-400 text-outdoor-forest-500 px-8 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-300 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Découvrir les programmes
                            </a>
                            <a href="#pourquoi" class="border-2 border-outdoor-ochre-400 text-outdoor-ochre-400 px-8 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-400 hover:text-outdoor-forest-500 transition-all duration-300">
                                Pourquoi la PPG ?
                            </a>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <!-- Background Gradient Cards -->
                        <div class="absolute inset-0 bg-outdoor-olive-300 rounded-2xl transform rotate-3 shadow-2xl"></div>
                        <div class="absolute inset-0 bg-outdoor-earth-300 rounded-2xl transform -rotate-1 shadow-xl opacity-70"></div>
                        
                        <!-- Main Image Container -->
                        <div class="relative bg-white rounded-2xl p-6 shadow-2xl">
                            <img 
                                src="{{ asset('frontend/assets/images/img_cerfaos/bandeau_ppg01.png') }}" 
                                alt="Préparation Physique Générale - Entraînement Outdoor" 
                                class="w-full h-80 object-cover rounded-xl"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                            />
                            <!-- Fallback content -->
                            <div class="w-full h-80 bg-outdoor-cream-100 rounded-xl flex items-center justify-center" style="display: none;">
                                <div class="text-center">
                                    <i class="fas fa-dumbbell text-6xl text-outdoor-ochre-400 mb-4"></i>
                                    <p class="text-outdoor-forest-500 font-semibold">Préparation Physique</p>
                                </div>
                            </div>
                        </div>
                        <!-- Floating stats -->
                        <div class="absolute -bottom-6 -left-6 bg-outdoor-ochre-400/20 backdrop-blur-sm text-outdoor-earth-500 p-4 rounded-xl shadow-lg border border-outdoor-ochre-400/20">
                            <div class="text-2xl font-bold">3</div>
                            <div class="text-sm">Programmes</div>
                        </div>
                        <div class="absolute -top-6 -right-6 bg-outdoor-ochre-400/20 backdrop-blur-sm text-outdoor-earth-500 p-4 rounded-xl shadow-lg border border-outdoor-ochre-400/20">
                            <div class="text-2xl font-bold">100%</div>
                            <div class="text-sm">Efficacité</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Programmes PPG -->
    <section id="programmes" class="py-24 bg-outdoor-cream-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="inline-block bg-outdoor-ochre-100 text-outdoor-earth-600 text-sm px-6 py-2 rounded-full font-semibold mb-4 border border-outdoor-ochre-300">
                        🎯 Nos Programmes
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Trois approches <span class="text-outdoor-ochre-400">complémentaires</span>
                    </h2>
                    <p class="text-xl text-outdoor-forest-400 max-w-4xl mx-auto leading-relaxed">
                        Chaque programme répond à un besoin spécifique de votre préparation physique. 
                        Combinez-les pour une approche complète et équilibrée.
                    </p>
                </div>

                <!-- Programmes Grid -->
                <div class="grid lg:grid-cols-3 gap-8">
                    
                    <!-- Fondation -->
                    <div class="group relative">
                        <div class="h-full outdoor-card transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative z-10">
                                <div class="text-center mb-6">
                                    <div class="relative inline-block">
                                        <div class="w-24 h-24 bg-gradient-to-br from-outdoor-olive-500 to-outdoor-forest-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                            <svg class="w-12 h-12 text-outdoor-cream-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                            </svg>
                                        </div>
                                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-outdoor-ochre-400 rounded-full flex items-center justify-center border border-outdoor-ochre-200 group-hover:scale-110 group-hover:bg-outdoor-ochre-300 transition-all duration-300">
                                            <span class="text-outdoor-forest-500 text-xs font-bold">1</span>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-black text-outdoor-forest-500 mb-2 group-hover:text-outdoor-forest-600 transition-colors duration-300">Fondation</h3>
                                    <p class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider group-hover:text-outdoor-ochre-600 transition-colors duration-300">Base Solide</p>
                                </div>
                                
                                <p class="text-outdoor-forest-400 mb-6 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Construisez des <strong class="text-outdoor-ochre-500 group-hover:text-outdoor-ochre-600 transition-colors duration-300">fondations solides</strong> avec un programme axé sur la stabilité, 
                                    la posture et le renforcement du core.
                                </p>
                                
                                <div class="space-y-3 mb-8">
                                    <div class="flex items-center text-sm text-outdoor-forest-400 bg-outdoor-cream-100 border border-outdoor-ochre-200 p-3 rounded-lg group-hover:bg-outdoor-cream-200 group-hover:border-outdoor-ochre-300 transition-all duration-300">
                                        <div class="w-2 h-2 bg-outdoor-olive-400 rounded-full mr-3 flex-shrink-0 group-hover:scale-125 transition-transform duration-300"></div>
                                        <span class="font-medium">Stabilité du tronc</span>
                                    </div>
                                    <div class="flex items-center text-sm text-outdoor-forest-400 bg-outdoor-cream-100 border border-outdoor-ochre-200 p-3 rounded-lg group-hover:bg-outdoor-cream-200 group-hover:border-outdoor-ochre-300 transition-all duration-300">
                                        <div class="w-2 h-2 bg-outdoor-ochre-400 rounded-full mr-3 flex-shrink-0 group-hover:scale-125 transition-transform duration-300"></div>
                                        <span class="font-medium">Correction posturale</span>
                                    </div>
                                    <div class="flex items-center text-sm text-outdoor-forest-400 bg-outdoor-cream-100 border border-outdoor-ochre-200 p-3 rounded-lg group-hover:bg-outdoor-cream-200 group-hover:border-outdoor-ochre-300 transition-all duration-300">
                                        <div class="w-2 h-2 bg-outdoor-earth-400 rounded-full mr-3 flex-shrink-0 group-hover:scale-125 transition-transform duration-300"></div>
                                        <span class="font-medium">Équilibre global</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('ppg.fondation') }}" class="block w-full bg-outdoor-olive-500 text-outdoor-cream-50 text-center py-4 font-bold rounded-lg hover:bg-outdoor-olive-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <span class="flex items-center justify-center">
                                        Découvrir Fondation
                                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Préparation -->
                    <div class="group relative">
                        <div class="h-full outdoor-card transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative z-10">
                                <div class="text-center mb-6">
                                    <div class="relative inline-block">
                                        <div class="w-24 h-24 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                            <svg class="w-12 h-12 text-outdoor-cream-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                        </div>
                                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-outdoor-olive-400 rounded-full flex items-center justify-center border border-outdoor-olive-200 group-hover:scale-110 group-hover:bg-outdoor-olive-300 transition-all duration-300">
                                            <span class="text-outdoor-cream-50 text-xs font-bold">2</span>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-black text-outdoor-forest-500 mb-2 group-hover:text-outdoor-forest-600 transition-colors duration-300">Préparation</h3>
                                    <p class="text-outdoor-earth-500 font-semibold text-sm uppercase tracking-wider group-hover:text-outdoor-earth-600 transition-colors duration-300">Performance</p>
                                </div>
                                
                                <p class="text-outdoor-forest-400 mb-6 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Développez une <strong class="text-outdoor-earth-500 group-hover:text-outdoor-earth-600 transition-colors duration-300">puissance explosive</strong> avec des entraînements 
                                    spécifiques qui transforment votre potentiel athlétique.
                                </p>
                                
                                <div class="space-y-3 mb-8">
                                    <div class="flex items-center text-sm text-outdoor-forest-400 bg-outdoor-cream-100 border border-outdoor-ochre-200 p-3 rounded-lg group-hover:bg-outdoor-cream-200 group-hover:border-outdoor-ochre-300 transition-all duration-300">
                                        <div class="w-2 h-2 bg-outdoor-ochre-400 rounded-full mr-3 flex-shrink-0 group-hover:scale-125 transition-transform duration-300"></div>
                                        <span class="font-medium">Force fonctionnelle</span>
                                    </div>
                                    <div class="flex items-center text-sm text-outdoor-forest-400 bg-outdoor-cream-100 border border-outdoor-ochre-200 p-3 rounded-lg group-hover:bg-outdoor-cream-200 group-hover:border-outdoor-ochre-300 transition-all duration-300">
                                        <div class="w-2 h-2 bg-outdoor-earth-400 rounded-full mr-3 flex-shrink-0 group-hover:scale-125 transition-transform duration-300"></div>
                                        <span class="font-medium">Endurance cardio</span>
                                    </div>
                                    <div class="flex items-center text-sm text-outdoor-forest-400 bg-outdoor-cream-100 border border-outdoor-ochre-200 p-3 rounded-lg group-hover:bg-outdoor-cream-200 group-hover:border-outdoor-ochre-300 transition-all duration-300">
                                        <div class="w-2 h-2 bg-outdoor-olive-400 rounded-full mr-3 flex-shrink-0 group-hover:scale-125 transition-transform duration-300"></div>
                                        <span class="font-medium">Puissance explosive</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('ppg.prepa') }}" class="block w-full bg-outdoor-ochre-400 text-outdoor-forest-500 text-center py-4 font-bold rounded-lg hover:bg-outdoor-ochre-300 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <span class="flex items-center justify-center">
                                        Découvrir la Préparation
                                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Récupération -->
                    <div class="group relative">
                        <div class="h-full outdoor-card transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-earth-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative z-10">
                                <div class="text-center mb-6">
                                    <div class="relative inline-block">
                                        <div class="w-24 h-24 bg-gradient-to-br from-outdoor-earth-500 to-outdoor-forest-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                            <svg class="w-12 h-12 text-outdoor-cream-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </div>
                                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-outdoor-earth-400 rounded-full flex items-center justify-center border border-outdoor-earth-200 group-hover:scale-110 group-hover:bg-outdoor-earth-300 transition-all duration-300">
                                            <span class="text-outdoor-cream-50 text-xs font-bold">3</span>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-black text-outdoor-forest-500 mb-2 group-hover:text-outdoor-forest-600 transition-colors duration-300">Récupération</h3>
                                    <p class="text-outdoor-earth-500 font-semibold text-sm uppercase tracking-wider group-hover:text-outdoor-earth-600 transition-colors duration-300">Régénération</p>
                                </div>
                                
                                <p class="text-outdoor-forest-400 mb-6 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Optimisez votre <strong class="text-outdoor-earth-500 group-hover:text-outdoor-earth-600 transition-colors duration-300">récupération active</strong> avec des techniques 
                                    avancées pour maintenir un corps performant et résilient.
                                </p>
                                
                                <div class="space-y-3 mb-8">
                                    <div class="flex items-center text-sm text-outdoor-forest-400 bg-outdoor-cream-100 border border-outdoor-ochre-200 p-3 rounded-lg group-hover:bg-outdoor-cream-200 group-hover:border-outdoor-ochre-300 transition-all duration-300">
                                        <div class="w-2 h-2 bg-outdoor-earth-400 rounded-full mr-3 flex-shrink-0 group-hover:scale-125 transition-transform duration-300"></div>
                                        <span class="font-medium">Étirements actifs</span>
                                    </div>
                                    <div class="flex items-center text-sm text-outdoor-forest-400 bg-outdoor-cream-100 border border-outdoor-ochre-200 p-3 rounded-lg group-hover:bg-outdoor-cream-200 group-hover:border-outdoor-ochre-300 transition-all duration-300">
                                        <div class="w-2 h-2 bg-outdoor-olive-400 rounded-full mr-3 flex-shrink-0 group-hover:scale-125 transition-transform duration-300"></div>
                                        <span class="font-medium">Mobilité articulaire</span>
                                    </div>
                                    <div class="flex items-center text-sm text-outdoor-forest-400 bg-outdoor-cream-100 border border-outdoor-ochre-200 p-3 rounded-lg group-hover:bg-outdoor-cream-200 group-hover:border-outdoor-ochre-300 transition-all duration-300">
                                        <div class="w-2 h-2 bg-outdoor-ochre-400 rounded-full mr-3 flex-shrink-0 group-hover:scale-125 transition-transform duration-300"></div>
                                        <span class="font-medium">Relâchement myofascial</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('ppg.recup') }}" class="block w-full bg-outdoor-earth-500 text-outdoor-cream-50 text-center py-4 font-bold rounded-lg hover:bg-outdoor-earth-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <span class="flex items-center justify-center">
                                        Découvrir la Récupération
                                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Pourquoi PPG -->
    <section id="pourquoi" class="py-24 bg-outdoor-forest-500">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-20">
                    <span class="inline-block bg-outdoor-ochre-100 text-outdoor-earth-600 text-sm px-6 py-2 rounded-full font-semibold mb-6 border border-outdoor-ochre-300">
                        🎯 L'Approche Scientifique
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-cream-50 mb-8">
                        Pourquoi la <span class="text-outdoor-ochre-400">PPG</span> ?
                    </h2>
                    <p class="text-xl md:text-2xl text-outdoor-cream-100 max-w-4xl mx-auto leading-relaxed">
                        La Préparation Physique Globale révolutionne votre approche de l'entraînement outdoor. 
                        Découvrez les <span class="text-outdoor-ochre-400 font-semibold">4 piliers scientifiques</span> qui transforment vos performances.
                    </p>
                </div>

                <!-- Benefits Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    
                    <!-- Prévention -->
                    <div class="group relative">
                        <div class="h-full bg-outdoor-cream-50 rounded-2xl p-8 shadow-lg border border-outdoor-ochre-200 transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative z-10 text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-outdoor-olive-500 to-outdoor-forest-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <svg class="w-10 h-10 text-outdoor-cream-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                
                                <h3 class="text-xl font-black text-outdoor-forest-500 mb-3">Prévention</h3>
                                <p class="text-outdoor-olive-500 font-semibold text-sm uppercase tracking-wider mb-4">Protection Active</p>
                                <p class="text-outdoor-forest-400 leading-relaxed">
                                    <strong class="text-outdoor-ochre-500">Réduisez de 70%</strong> les risques de blessures grâce à un corps correctement préparé et équilibré
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Performance -->
                    <div class="group relative">
                        <div class="h-full bg-outdoor-cream-50 rounded-2xl p-8 shadow-lg border border-outdoor-ochre-200 transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative z-10 text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <svg class="w-10 h-10 text-outdoor-cream-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                
                                <h3 class="text-xl font-black text-outdoor-forest-500 mb-3">Performance</h3>
                                <p class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider mb-4">Puissance Maximale</p>
                                <p class="text-outdoor-forest-400 leading-relaxed">
                                    <strong class="text-outdoor-earth-500">Améliorez jusqu'à 40%</strong> vos capacités physiques spécifiques à vos activités préférées
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Endurance -->
                    <div class="group relative">
                        <div class="h-full bg-outdoor-cream-50 rounded-2xl p-8 shadow-lg border border-outdoor-ochre-200 transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-earth-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative z-10 text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-outdoor-earth-500 to-outdoor-forest-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <svg class="w-10 h-10 text-outdoor-cream-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                
                                <h3 class="text-xl font-black text-outdoor-forest-500 mb-3">Endurance</h3>
                                <p class="text-outdoor-earth-500 font-semibold text-sm uppercase tracking-wider mb-4">Énergie Durable</p>
                                <p class="text-outdoor-forest-400 leading-relaxed">
                                    <strong class="text-outdoor-olive-500">Maintenez 60% plus</strong> longtemps votre énergie optimale lors de vos aventures
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Plaisir -->
                    <div class="group relative">
                        <div class="h-full bg-outdoor-cream-50 rounded-2xl p-8 shadow-lg border border-outdoor-ochre-200 transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative z-10 text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-outdoor-olive-400 to-outdoor-ochre-400 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <svg class="w-10 h-10 text-outdoor-cream-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                
                                <h3 class="text-xl font-black text-outdoor-forest-500 mb-3">Plaisir</h3>
                                <p class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider mb-4">Joie Durable</p>
                                <p class="text-outdoor-forest-400 leading-relaxed">
                                    <strong class="text-outdoor-ochre-400">Profitez pleinement</strong> de chaque aventure avec un corps qui vous suit dans tous vos défis
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="text-center mt-16">
                    <div class="inline-block bg-outdoor-cream-50 rounded-2xl p-8 shadow-xl border border-outdoor-ochre-200">
                        <h3 class="text-2xl font-black text-outdoor-forest-500 mb-4">
                            Prêt à transformer vos performances ?
                        </h3>
                        <p class="text-outdoor-forest-400 mb-6 max-w-md mx-auto">
                            Commencez votre parcours PPG dès aujourd'hui et découvrez votre véritable potentiel
                        </p>
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="{{ route('ppg.fondation') }}" class="bg-outdoor-ochre-400 text-outdoor-forest-500 px-6 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-300 transition-colors shadow-lg transform hover:scale-105">
                                Commencer par la Fondation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection