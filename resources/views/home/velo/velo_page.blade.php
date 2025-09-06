@extends('home.body.home_master')

@push('head')
<!-- Préchargement des images critiques -->
<link rel="preload" href="{{ asset('frontend/assets/images/img_cerfaos/velo.png') }}" as="image">
<link rel="preload" href="{{ asset('frontend/assets/images/img_cerfaos/moi_pluie.png') }}" as="image">
<link rel="preload" href="{{ asset('frontend/assets/images/img_cerfaos/chute_edelweis.png') }}" as="image">
<link rel="preload" href="{{ asset('frontend/assets/images/img_cerfaos/man_rock.png') }}" as="image">
@endpush

@section('home')
<div class="bg-outdoor-cream-50 min-h-screen">
    <!-- Banner Title Section -->
    

    <!-- Hero Section Vélo -->
    <section class="relative bg-gradient-to-r from-outdoor-olive-500 to-outdoor-earth-500 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-bold mb-6">
                            <span class="text-outdoor-cream-50">Mon</span><br>
                            <span class="text-outdoor-ochre-400">Elfe de route</span>
                        </h1>
                        
                        <p class="text-xl md:text-2xl mb-8 text-outdoor-cream-50/90 leading-relaxed">
                            Découvrez mon fidèle compagnon de route et les aventures que nous partageons ensemble
                        </p>
                        
                        <div class="flex flex-wrap gap-6 text-outdoor-cream-50/90 mb-8">
                            <div class="flex items-center">
                                <i class="fas fa-bicycle mr-2 text-outdoor-ochre-400"></i>
                                <span>Un vélo ou un cheval ?</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-mountain mr-2 text-outdoor-ochre-400"></i>
                                <span>Terrain varié</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-route mr-2 text-outdoor-ochre-400"></i>
                                <span>Kilométrage du mystère</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-trophy mr-2 text-outdoor-ochre-400"></i>
                                <span>Sortir loin, revenir toujours</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="#caracteristiques" class="bg-outdoor-ochre-400 text-outdoor-forest-500 px-8 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-300 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Découvrir le vélo
                            </a>
                            <a href="#video" class="border-2 border-outdoor-ochre-400 text-outdoor-ochre-400 px-8 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-400 hover:text-outdoor-forest-500 transition-all duration-300">
                                Voir Elves Mori
                            </a>
                        </div>
                    </div>

                    <div class="relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">

                        <div class="absolute inset-0 bg-outdoor-ochre-300 rounded-2xl transform rotate-3 shadow-2xl"></div>
                        <div class="absolute inset-0 bg-outdoor-earth-300 rounded-2xl transform -rotate-1 shadow-xl opacity-70"></div>
                    
                    <div class="relative bg-white rounded-2xl p-6 shadow-2xl">
                        <img 
                            src="{{ asset('frontend/assets/images/img_cerfaos/velo.png') }}" 
                            alt="Préparation Physique Générale - Entraînement Outdoor" 
                            class="w-full h-80 object-contain rounded-xl"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                        />
                        <!-- Floating stats -->
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Caractéristiques -->
    <section id="caracteristiques" class="py-24 bg-outdoor-cream-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="inline-block bg-outdoor-olive-100 text-outdoor-forest-600 text-sm px-6 py-2 rounded-full font-semibold mb-4 border border-outdoor-olive-300">
                        ⚙️ Technique
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Caractéristiques <span class="text-outdoor-ochre-400">Techniques</span>
                    </h2>
                    <p class="text-xl text-outdoor-forest-400 max-w-4xl mx-auto leading-relaxed">
                        Un vélo conçu pour l'aventure, optimisé pour les terrains variés et les longues distances.
                    </p>
                </div>

                <!-- Caractéristiques Grid -->
                <div class="grid md:grid-cols-3 gap-8">
                    
                    <!-- Cadre -->
                    <div class="group relative">
                        <div class="h-full card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative z-10 text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-outdoor-olive-500 to-outdoor-forest-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <svg class="w-10 h-10 text-outdoor-cream-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                
                                <h3 class="text-xl font-black text-outdoor-forest-500 mb-3">Cadre</h3>
                                <p class="text-outdoor-olive-500 font-semibold text-sm uppercase tracking-wider mb-4">Structure</p>
                                <p class="text-outdoor-forest-400 leading-relaxed">
                                    Aluminium léger et <strong class="text-outdoor-ochre-500">robuste</strong>, parfait pour les terrains variés
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Roues -->
                    <div class="group relative">
                        <div class="h-full card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative z-10 text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <svg class="w-10 h-10 text-outdoor-cream-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                
                                <h3 class="text-xl font-black text-outdoor-forest-500 mb-3">Roues</h3>
                                <p class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider mb-4">Performance</p>
                                <p class="text-outdoor-forest-400 leading-relaxed">
                                    <strong class="text-outdoor-earth-500">29 pouces</strong> avec pneus tout-terrain pour une excellente adhérence
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Suspension -->
                    <div class="group relative">
                        <div class="h-full card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-earth-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative z-10 text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-outdoor-earth-500 to-outdoor-forest-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                    <svg class="w-10 h-10 text-outdoor-cream-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                
                                <h3 class="text-xl font-black text-outdoor-forest-500 mb-3">Suspension</h3>
                                <p class="text-outdoor-earth-500 font-semibold text-sm uppercase tracking-wider mb-4">Confort</p>
                                <p class="text-outdoor-forest-400 leading-relaxed">
                                    Fourche suspendue pour <strong class="text-outdoor-olive-500">absorber les chocs</strong> sur terrains difficiles
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Vidéo YouTube -->
    <section id="video" class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="inline-block bg-outdoor-ochre-100 text-outdoor-earth-600 text-sm px-6 py-2 rounded-full font-semibold mb-4 border border-outdoor-ochre-300">
                        🎬 En Action
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Mon vélo <span class="text-outdoor-ochre-400">en action</span>
                    </h2>
                    <p class="text-xl text-outdoor-forest-400 max-w-4xl mx-auto leading-relaxed">
                        Une vidéo qui présente mon vélo, ses performances et quelques-unes de nos aventures 
                        partagées sur les sentiers de montagne.
                    </p>
                </div>

                <!-- Vidéo avec cadre moderne -->
                <div class="relative">
                    <div class="w-full max-w-6xl mx-auto flex justify-center">
                        <div class="relative group">
                            <!-- Cadre décoratif avec ombre et bordure -->
                            <div class="absolute -inset-4 bg-gradient-to-r from-outdoor-olive-200 via-outdoor-cream-100 to-outdoor-ochre-200 rounded-3xl blur-sm opacity-75 group-hover:opacity-100 transition duration-500"></div>
                            
                            <!-- Cadre principal -->
                            <div class="relative bg-gradient-to-br from-outdoor-cream-50 to-outdoor-cream-100 rounded-3xl p-6 shadow-2xl border-2 border-outdoor-olive-200">
                                <!-- Background Glow -->
                                <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl"></div>
                                
                                <div class="relative z-10">
                                    <!-- Iframe YouTube -->
                                                    <div id="youtube-container" class="aspect-video rounded-2xl overflow-hidden">
                                        <div id="youtube-placeholder" class="relative bg-outdoor-cream-100 flex items-center justify-center cursor-pointer hover:bg-outdoor-cream-200 transition-colors duration-300 w-full h-full group" onclick="loadYouTubeVideo()">
                                            <div class="text-center">
                                                <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center mb-4 mx-auto group-hover:scale-110 transition-transform duration-300">
                                                    <i class="fas fa-play text-white text-2xl ml-1"></i>
                                                </div>
                                                <h3 class="text-xl font-bold text-outdoor-forest-500 mb-2">Voir la vidéo</h3>
                                                <p class="text-outdoor-forest-400">Cliquez pour charger la vidéo YouTube</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <script>
                                    function loadYouTubeVideo() {
                                        const container = document.getElementById('youtube-container');
                                        const iframe = document.createElement('iframe');
                                        iframe.src = 'https://www.youtube.com/embed/GvA2bht4H2c?start=28&autoplay=1';
                                        iframe.title = 'YouTube video player';
                                        iframe.frameBorder = '0';
                                        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                                        iframe.allowFullscreen = true;
                                        iframe.className = 'w-full h-full';
                                        container.innerHTML = '';
                                        container.appendChild(iframe);
                                    }
                                    </script>
                                    
                                    <!-- Légende sous la vidéo -->
                                    <div class="text-center mt-4">
                                        <p class="text-sm text-outdoor-forest-600 italic">
                                            Découvrez les aventures partagées avec mon fidèle compagnon de route
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Aventures Partagées -->
    <section class="py-24 bg-outdoor-cream-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-20">
                    <span class="inline-block bg-outdoor-forest-100 text-outdoor-forest-600 text-sm px-6 py-2 rounded-full font-semibold mb-6 border border-outdoor-forest-300">
                        🚵 Aventures
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Nos Aventures <span class="text-outdoor-ochre-400">Partagées</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-outdoor-forest-400 max-w-4xl mx-auto leading-relaxed">
                        Découvrez les moments marquants de nos explorations communes sur les sentiers.
                    </p>
                </div>

                <!-- Timeline des aventures -->
                <div class="space-y-16">

                    
                    
                    <!-- Aventure 1 -->
                    <div class="group relative">
                        <div class="grid md:grid-cols-2 gap-12 items-center">
                            <div class="order-2 md:order-1">
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                                    <!-- Background Glow -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <div class="relative z-10">
                                        <img src= "{{ asset('frontend/assets/images/img_cerfaos/moi_pluie.png') }}" alt="Première grande sortie" class="aspect-video object-contain rounded-lg w-full mb-4" loading="lazy">
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="order-1 md:order-2 space-y-4">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-outdoor-olive-500 to-outdoor-forest-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                        <i class="fas fa-route text-outdoor-cream-50 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-outdoor-forest-500 group-hover:text-outdoor-forest-600 transition-colors duration-300">
                                            La Première Grande Sortie
                                        </h3>
                                        <span class="text-outdoor-olive-500 font-semibold text-sm uppercase tracking-wider">Découverte</span>
                                    </div>
                                </div>
                                
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Notre première aventure ensemble nous a menés sur les sentiers de montagne. 
                                    Le vélo s'est révélé être un <strong class="text-outdoor-ochre-500">compagnon parfait</strong>, capable de nous emmener 
                                    dans des endroits inaccessibles autrement.
                                </p>
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Cette sortie de 50 kilomètres nous a permis de découvrir des paysages 
                                    époustouflants et de tester nos limites ensemble.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Aventure 2 -->
                    <div class="group relative">
                        <div class="grid md:grid-cols-2 gap-12 items-center">
                            <div class="space-y-4">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                        <i class="fas fa-mountain text-outdoor-cream-50 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-outdoor-forest-500 group-hover:text-outdoor-forest-600 transition-colors duration-300">
                                            L'Exploration des Crêtes
                                        </h3>
                                        <span class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider">Défi</span>
                                    </div>
                                </div>
                                
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Les crêtes montagneuses offrent des <strong class="text-outdoor-ochre-500">vues panoramiques</strong> exceptionnelles. 
                                    Avec mon vélo, j'ai pu accéder à des points de vue qui semblaient 
                                    inaccessibles.
                                </p>
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Chaque montée est un défi, chaque descente une récompense. 
                                    Le vélo transforme chaque sortie en véritable aventure.
                                </p>
                            </div>
                            <div>
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                                    <!-- Background Glow -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <div class="relative z-10">
                                        <img src="{{ asset('frontend/assets/images/img_cerfaos/chute_edelweis.png') }}" alt="Vue depuis les crêtes" class="aspect-video object-contain rounded-lg w-full mb-4" loading="lazy">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aventure 3 -->
                    <div class="group relative">
                        <div class="grid md:grid-cols-2 gap-12 items-center">
                            <div class="order-2 md:order-1">
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                                    <!-- Background Glow -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-earth-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <div class="relative z-10">
                                        <img src="{{ asset('frontend/assets/images/img_cerfaos/man_rock.png') }}" alt="Traversée de rivière" class="aspect-video object-contain rounded-lg w-full mb-4" loading="lazy">

                                    </div>
                                </div>
                            </div>
                            <div class="order-1 md:order-2 space-y-4">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-outdoor-earth-500 to-outdoor-forest-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                        <i class="fas fa-water text-outdoor-cream-50 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-outdoor-forest-500 group-hover:text-outdoor-forest-600 transition-colors duration-300">
                                            La Traversée de Rivière
                                        </h3>
                                        <span class="text-outdoor-earth-500 font-semibold text-sm uppercase tracking-wider">Complicité</span>
                                    </div>
                                </div>
                                
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Certains passages nécessitent de porter le vélo, mais c'est aussi 
                                    l'occasion de créer des <strong class="text-outdoor-earth-500">souvenirs uniques</strong>. La traversée de rivière 
                                    reste l'un de nos moments les plus mémorables.
                                </p>
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Ces défis nous rapprochent et renforcent notre complicité. 
                                    Chaque obstacle surmonté ensemble nous rend plus forts.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Galerie Photos -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="inline-block bg-outdoor-ochre-100 text-outdoor-earth-600 text-sm px-6 py-2 rounded-full font-semibold mb-4 border border-outdoor-ochre-300">
                        📷 Galerie
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Photos de <span class="text-outdoor-ochre-400">Vélo</span>
                    </h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_descente.png') }}" alt="Vélo 1" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/chute_canard.png') }}" alt="Vélo 2" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_jaune.png') }}" alt="Vélo 3" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_bleu.png') }}" alt="Vélo 4" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_vert.png') }}" alt="Vélo 5" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_brun.png') }}" alt="Vélo 6" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_bureau.png') }}" alt="Vélo 7" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_crevaison.png') }}" alt="Vélo 8" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Conclusion -->
    <section class="py-24 bg-outdoor-olive-500">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-20">
                    <span class="inline-block bg-outdoor-ochre-100 text-outdoor-earth-600 text-sm px-6 py-2 rounded-full font-semibold mb-6 border border-outdoor-ochre-300">
                        🚴 Prochaines Aventures
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-cream-50 mb-8">
                        L'Aventure <span class="text-outdoor-ochre-400">Continue</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-outdoor-cream-100 max-w-4xl mx-auto leading-relaxed">
                        Avec mon vélo, chaque nouvelle sortie est une opportunité de découvrir de nouveaux horizons, 
                        de repousser mes limites et de créer des souvenirs inoubliables.
                    </p>
                </div>

                <!-- Call to Action -->
                <div class="text-center">
                    <div class="inline-block bg-outdoor-cream-50 rounded-2xl p-8 shadow-xl border border-outdoor-ochre-200">
                        <h3 class="text-2xl font-black text-outdoor-forest-500 mb-4">
                            Partez à l'aventure !
                        </h3>
                        <p class="text-outdoor-forest-400 mb-6 max-w-md mx-auto">
                            L'aventure ne fait que commencer, et nous sommes prêts à explorer ensemble 
                            les merveilles qui nous attendent sur les sentiers.
                        </p>
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="{{ url('/itineraires') }}" class="bg-outdoor-ochre-400 text-outdoor-forest-500 px-6 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-300 transition-colors shadow-lg transform hover:scale-105">
                                Découvrir les itinéraires
                            </a>
                            <a href="{{ url('/sorties') }}" class="border-2 border-outdoor-forest-500 text-outdoor-forest-500 px-6 py-3 rounded-lg font-semibold hover:bg-outdoor-forest-500 hover:text-outdoor-cream-50 transition-all duration-300">
                                Voir les sorties
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Script d'optimisation du chargement -->
<script>
// Optimisation du chargement paresseux pour les images de galerie
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer pour les images
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('opacity-0');
                img.classList.add('opacity-100');
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '50px'
    });

    // Observer toutes les images de galerie
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
});
</script>

@endsection