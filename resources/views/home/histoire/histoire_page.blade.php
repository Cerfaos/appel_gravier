@extends('home.body.home_master')

@section('home')
<div class="bg-outdoor-cream-50 min-h-screen">
    <!-- Banner Title Section -->
    

    <!-- Hero Section Histoire -->
    <section class="relative bg-gradient-to-r from-outdoor-forest-500 to-outdoor-earth-500 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-bold mb-6">
                            <span class="text-outdoor-cream-50">Mon</span><br>
                            <span class="text-outdoor-ochre-400">Histoire Sportive</span>
                        </h1>
                        
                        <p class="text-xl md:text-2xl mb-8 text-outdoor-cream-50/90 leading-relaxed">
                            Découvrez mon parcours qui m'a mené vers l'aventure gravel et la passion du vélo.
                        </p>
                        
                        <div class="flex flex-wrap gap-6 text-outdoor-cream-50/90 mb-8">
                            <div class="flex items-center">
                                <i class="fas fa-mountain mr-2 text-outdoor-ochre-400"></i>
                                <span>Passion judo</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-bicycle mr-2 text-outdoor-ochre-400"></i>
                                <span>Découverte vélo</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2 text-outdoor-ochre-400"></i>
                                <span>Kmer & Eaux Vives</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-heart mr-2 text-outdoor-ochre-400"></i>
                                <span>Fièvre du combat</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-heart mr-2 text-outdoor-ochre-400"></i>
                                <span>Amour des eaux tumultueuses</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="#moments" class="bg-outdoor-ochre-400 text-outdoor-forest-500 px-8 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-300 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Découvrir mon parcours
                            </a>
                            <a href="#video" class="border-2 border-outdoor-ochre-400 text-outdoor-ochre-400 px-8 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-400 hover:text-outdoor-forest-500 transition-all duration-300">
                                Voir la vidéo
                            </a>
                        </div>
                    </div>
                    <div class="relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">

                    <div class="absolute inset-0 bg-outdoor-ochre-300 rounded-2xl transform rotate-3 shadow-2xl"></div>
                    <div class="absolute inset-0 bg-outdoor-earth-300 rounded-2xl transform -rotate-1 shadow-xl opacity-70"></div>
                    
                    <div class="relative bg-white rounded-2xl p-6 shadow-2xl">
                        <img 
                            src="{{ asset('frontend/assets/images/img_cerfaos/moizen.png') }}" 
                            alt="Préparation Physique Générale - Entraînement Outdoor" 
                            class="object-contain rounded-lg w-full mb-4"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                        />
                        <!-- Floating stats -->
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Vidéo -->
    <section id="video" class="py-24 bg-outdoor-cream-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="inline-block bg-outdoor-ochre-100 text-outdoor-earth-600 text-sm px-6 py-2 rounded-full font-semibold mb-4 border border-outdoor-ochre-300">
                        🎬 Mon Histoire
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Découvrez mon <span class="text-outdoor-ochre-400">parcours</span>
                    </h2>
                    <p class="text-xl text-outdoor-forest-400 max-w-4xl mx-auto leading-relaxed">
                        J'ai créé cette vidéo avec Midjourney. Je suis passionné par la création d'images et de vidéos,
                        utilisant tous les outils à ma disposition. 
                        Que ce soit avec une tablette graphique ou un simple crayon, je donne vie à mes idées puis les peaufine dans Photoshop, 
                        qui constitue mon environnement créatif de référence.un ordinateur accompagnent mes créations.
                    </p>
                </div>

                <!-- Vidéo -->
                <div class="relative">
                    <div class="w-full max-w-6xl mx-auto">
                        <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl border border-outdoor-ochre-200 relative group">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <video class="w-full h-full relative z-10" controls preload="metadata">
                                <source src="/frontend/assets/video/home-hero.mp4" type="video/mp4">
                                <p class="text-center p-8 text-outdoor-forest-600">
                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                </p>
                            </video>
                        </div>
                    </div>
                    
                    <!-- Raccourci direct -->
                    <div class="mt-6 text-center">
                        <a href="/frontend/assets/video/home-hero.mp4" 
                           target="_blank" 
                           class="btn-primary inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                            Télécharger la vidéo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Moments Clés -->
    <section id="moments" class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-20">
                    <span class="inline-block bg-outdoor-forest-100 text-outdoor-forest-600 text-sm px-6 py-2 rounded-full font-semibold mb-6 border border-outdoor-forest-300">
                        ⭐ Parcours
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Moments <span class="text-outdoor-ochre-400">Clés</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-outdoor-forest-400 max-w-4xl mx-auto leading-relaxed">
                        Les étapes marquantes qui ont forgé ma passion du sport et des défis.
                    </p>
                </div>

                <!-- Timeline des moments -->
                <div class="space-y-16">
                    
                    <!-- Moment 1 -->
                    <div class="group relative">
                        <div class="grid md:grid-cols-2 gap-12 items-center">
                            <div class="order-2 md:order-1">
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                                    <!-- Background Glow -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-forest-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <div class="relative z-10">
                                        <img src="{{ asset('frontend/assets/images/img_cerfaos/judo_enfant.png') }}" alt="Première randonnée" class="aspect-video object-contain rounded-lg w-full mb-4">
                                    </div>
                                </div>
                            </div>
                            <div class="order-1 md:order-2 space-y-4">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-outdoor-forest-500 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                        <i class="fas fa-mountain text-outdoor-cream-50 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-outdoor-forest-500 group-hover:text-outdoor-forest-600 transition-colors duration-300">
                                            Le Judo
                                        </h3>
                                        <span class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider">Mon ADN</span>
                                    </div>
                                </div>
                                
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    De 6 ans à 20 ans, j'ai léché du tatami, j'ai connu mes plus grandes joies et mes plus grandes épreuves.
                                    Ceinture noir à 15 ans, la 2° Dan à 18 ans, j'ai grandi et je suis devenu un adulte avec la philosophie de l'abnégation.
                                </p>
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Le judo m'a appris à m'affronter, à m'élever, à m'évoluer, à m'améliorer.
                                    mais aussi un <strong class="text-outdoor-ochre-500">mode de vie</strong> qui m'apportait équilibre et sérénité.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Moment 2 -->
                    <div class="group relative">
                        <div class="grid md:grid-cols-2 gap-12 items-center">
                            <div class="space-y-4">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                        <i class="fas fa-bicycle text-outdoor-cream-50 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-outdoor-forest-500 group-hover:text-outdoor-forest-600 transition-colors duration-300">
                                            La Découverte du Kayak
                                        </h3>
                                        <span class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider">Évasion</span>
                                    </div>
                                </div>
                                
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Après l'armée,  j'ai eu la chance de vivre ma plus belle réalisation : fonder une famille avec mes deux fils, mes amours éternels. C'est ensuite, à 40 ans, que j'ai découvert le kayak en eaux vives puis le kayak de mer. 
                                    Quel défi c'était à cet âge, <strong>   </strong> class="text-outdoor-ochre-500">mais quelle période extraordinaire et quelle ivresse !</strong>
                                </p>
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Chaque sortie en kayak est une nouvelle aventure, une occasion de découvrir des paysages époustouflants et de partager ces moments avec d'autres passionnés et amis.
                                </p>
                            </div>
                            <div>
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                                    <!-- Background Glow -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <div class="relative z-10">
                                        <img src="{{ asset('frontend/assets/images/img_cerfaos/moi_kmer.png') }}" alt="Première sortie vélo" class="aspect-video object-contain rounded-lg w-full mb-4">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Moment 3 -->
                    <div class="group relative">
                        <div class="grid md:grid-cols-2 gap-12 items-center">
                            <div class="order-2 md:order-1">
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                                    <!-- Background Glow -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-earth-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <div class="relative z-10">
                                        <img src="{{ asset('frontend/assets/images/img_cerfaos/moi_descente02.png') }}" alt="Communauté outdoor" class="aspect-video object-contain rounded-lg w-full mb-4">
                                    </div>
                                </div>
                            </div>
                            <div class="order-1 md:order-2 space-y-4">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-outdoor-earth-500 to-outdoor-forest-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                        <i class="fas fa-rocket text-outdoor-cream-50 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-outdoor-forest-500 group-hover:text-outdoor-forest-600 transition-colors duration-300">
                                            La Création de Cerfaos
                                        </h3>
                                        <span class="text-outdoor-earth-500 font-semibold text-sm uppercase tracking-wider">Nouveau Défi</span>
                                    </div>
                                </div>
                                
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Entre temps, j'ai fait de la boxe française et anglaise afin de retrouver l'esprit du combat. Seulement, je me suis lassé, cela ne me corresdait plus, envie d'autres sensations. <br>
                                    Fort de ces expériences, je réalise <strong class="text-outdoor-earth-500"> Cerfaos</strong>
                                    pour m’accompagner dans deux nouveaux défis : un projet web en Laravel/PHP, épaulé par Claude Code, et la découverte du gravel. 
                                    Concevoir une plateforme, c’est le plaisir du cerveau en ébullition ; enfourcher un vélo, c’est le langage des jambes.                                     
                                </p>
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Au fond, c’est un clin d’œil à feu mon père, passionné de deux-roues. Dans mon enfance, le vélo ne m’a pas séduit — trop contraignant, pensais-je.
                                    Mais je me souviens, attendri, des longues balades sur mon petit Gitane ocre.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Galerie -->
    <section class="py-24 bg-outdoor-cream-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="inline-block bg-outdoor-ochre-100 text-outdoor-earth-600 text-sm px-6 py-2 rounded-full font-semibold mb-4 border border-outdoor-ochre-300">
                        📸 Souvenirs
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Galerie de <span class="text-outdoor-ochre-400">Souvenirs</span>
                    </h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img src="{{ asset('frontend/assets/images/img_cerfaos/chute_canard.png') }}" alt="Souvenir 1" class="aspect-square object-contain rounded-3xl w-full h-full" loading="lazy">
                            <div class="absolute inset-0 bg-outdoor-forest-500/0 group-hover:bg-outdoor-forest-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img src="{{ asset('frontend/assets/images/img_cerfaos/manblue.png') }}" alt="Souvenir 2" class="aspect-square object-contain rounded-3xl w-full h-full" loading="lazy">
                            <div class="absolute inset-0 bg-outdoor-forest-500/0 group-hover:bg-outdoor-forest-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img src="{{ asset('frontend/assets/images/img_cerfaos/man_pompe.png') }}" alt="Souvenir 3" class="aspect-square object-contain rounded-3xl w-full h-full" loading="lazy">
                            <div class="absolute inset-0 bg-outdoor-forest-500/0 group-hover:bg-outdoor-forest-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img src="{{ asset('frontend/assets/images/img_cerfaos/moi_jaune.png') }}" alt="Souvenir 4" class="aspect-square object-contain rounded-3xl w-full h-full" loading="lazy">
                            <div class="absolute inset-0 bg-outdoor-forest-500/0 group-hover:bg-outdoor-forest-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img src="{{ asset('frontend/assets/images/img_cerfaos/moi_vert.png') }}" alt="Souvenir 5" class="aspect-square object-contain rounded-3xl w-full h-full" loading="lazy">
                            <div class="absolute inset-0 bg-outdoor-forest-500/0 group-hover:bg-outdoor-forest-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img src="{{ asset('frontend/assets/images/img_cerfaos/moi_brun.png') }}" alt="Souvenir 6" class="aspect-square object-contain rounded-3xl w-full h-full" loading="lazy">
                            <div class="absolute inset-0 bg-outdoor-forest-500/0 group-hover:bg-outdoor-forest-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Conclusion -->
    <section class="py-24 bg-outdoor-forest-500">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-20">
                    <span class="inline-block bg-outdoor-ochre-100 text-outdoor-earth-600 text-sm px-6 py-2 rounded-full font-semibold mb-6 border border-outdoor-ochre-300">
                        🚀 L'Avenir
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-cream-50 mb-8">
                        L'Aventure <span class="text-outdoor-ochre-400">Continue</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-outdoor-cream-100 max-w-4xl mx-auto leading-relaxed">
                        Chaque jour apporte son lot de nouvelles découvertes et d'expériences enrichissantes. 
                        L'outdoor n'est pas qu'une passion, c'est un mode de vie qui m'apporte équilibre, 
                        sérénité et une connexion profonde avec la nature.
                    </p>
                </div>

                <!-- Call to Action -->
                <div class="text-center">
                    <div class="inline-block bg-outdoor-cream-50 rounded-2xl p-8 shadow-xl border border-outdoor-ochre-200">
                        <h3 class="text-2xl font-black text-outdoor-forest-500 mb-4">
                            Rejoignez l'aventure !
                        </h3>
                        <p class="text-outdoor-forest-400 mb-6 max-w-md mx-auto">
                            Découvrez ensemble les merveilles qui nous entourent et partageons nos expériences outdoor.
                        </p>
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="{{ url('/') }}" class="bg-outdoor-ochre-400 text-outdoor-forest-500 px-6 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-300 transition-colors shadow-lg transform hover:scale-105">
                                Explorer CERFAOS
                            </a>
                            <a href="{{ url('/contact') }}" class="border-2 border-outdoor-forest-500 text-outdoor-forest-500 px-6 py-3 rounded-lg font-semibold hover:bg-outdoor-forest-500 hover:text-outdoor-cream-50 transition-all duration-300">
                                Me Contacter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection