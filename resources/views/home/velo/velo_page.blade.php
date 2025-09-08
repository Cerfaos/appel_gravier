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
    
    <!-- Hero Section Gravel YoCyclo -->
    <section class="relative bg-gradient-to-r from-outdoor-olive-500 to-outdoor-earth-500 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-bold mb-6">
                            <span class="text-outdoor-cream-50">Mon Gravel</span><br>
                            <span class="text-outdoor-ochre-400">YoCyclo</span>
                        </h1>
                        
                        <p class="text-xl md:text-2xl mb-8 text-outdoor-cream-50/90 leading-relaxed">
                            Quand l'artisanat rencontre la performance : découvrez mon compagnon de route né des mains expertes de Yoann Chevallet
                        </p>
                        
                        <div class="flex flex-wrap gap-6 text-outdoor-cream-50/90 mb-8">
                            <div class="flex items-center">
                                <i class="fas fa-hammer mr-2 text-outdoor-ochre-400"></i>
                                <span>Artisanat sur mesure</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-mountain mr-2 text-outdoor-ochre-400"></i>
                                <span>Terrain polyvalent</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-euro-sign mr-2 text-outdoor-ochre-400"></i>
                                <span>Budget maîtrisé</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-heart mr-2 text-outdoor-ochre-400"></i>
                                <span>Passion partagée</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="#composants" class="bg-outdoor-ochre-400 text-outdoor-forest-500 px-8 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-300 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Découvrir les composants
                            </a>
                            <a href="#video" class="border-2 border-outdoor-ochre-400 text-outdoor-ochre-400 px-8 py-3 rounded-lg font-semibold hover:bg-outdoor-ochre-400 hover:text-outdoor-forest-500 transition-all duration-300">
                                Voir en action
                            </a>
                        </div>
                    </div>

                    <div class="relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                        <div class="absolute inset-0 bg-outdoor-ochre-300 rounded-2xl transform rotate-3 shadow-2xl"></div>
                        <div class="absolute inset-0 bg-outdoor-earth-300 rounded-2xl transform -rotate-1 shadow-xl opacity-70"></div>
                    
                        <div class="relative bg-white rounded-2xl p-6 shadow-2xl">
                            <img 
                                src="{{ asset('frontend/assets/images/img_cerfaos/velo.png') }}" 
                                alt="Gravel YoCyclo - Assemblage artisanal par Yoann Chevallet" 
                                class="w-full h-80 object-contain rounded-xl"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Introduction & Philosophie -->
    <section class="py-24 bg-outdoor-cream-50">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-12">
                    <span class="inline-block bg-outdoor-olive-100 text-outdoor-forest-600 text-sm px-6 py-2 rounded-full font-semibold mb-4 border border-outdoor-olive-300">
                        🔧 Artisanat
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-6">
                        L'Art du Vélo <span class="text-outdoor-ochre-400">Sur Mesure</span>
                    </h2>
                </div>

                <!-- Introduction avec citation Yoann -->
                <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-6 mb-12">
                    <div class="lg:col-span-2 md:col-span-2">
                        <div class="card-outdoor h-full">
                            <p class="text-lg text-outdoor-forest-400 leading-relaxed mb-4">
                                Dans l'univers passionnant du cyclisme, il existe deux philosophies distinctes : les vélos produits en série et ceux façonnés pièce par pièce avec une attention particulière. Mon gravel, né des mains expertes de Yoann Chevallet dans l'atelier YoCyclo, incarne parfaitement cette seconde approche tout en respectant une <strong class="text-outdoor-ochre-500">maîtrise budgétaire intelligente</strong>.
                            </p>
                            <p class="text-base text-outdoor-forest-400 leading-relaxed">
                                Dès le premier regard, son cadre Elves Mori AeroX Black & Chameleon captive par sa robe changeante qui joue avec la lumière. Mais au-delà de cette beauté visuelle, chaque composant raconte une histoire de performance et de fiabilité.
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <div class="card-outdoor h-full bg-gradient-to-br from-outdoor-olive-100 to-outdoor-cream-100 border-l-4 border-outdoor-ochre-400">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-outdoor-ochre-400 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-quote-left text-outdoor-forest-500 text-sm"></i>
                                </div>
                                <h4 class="font-bold text-outdoor-forest-500 text-sm">L'accompagnement Yoann</h4>
                            </div>
                            <p class="text-outdoor-forest-400 italic leading-relaxed text-sm">
                                "Tout au long de nos échanges par mail, Yoann a su me guider avec justesse dans chaque choix de composant. Il a parfaitement cerné mes besoins : mon inexpérience, ma recherche de confort et polyvalence, sans oublier le budget."
                            </p>
                        </div>
                    </div>
                    
                    <!-- Colonne Logo YoCyclo -->
                    <div class="flex items-center justify-center">
                        <a href="https://www.yocyclo.fr" target="_blank" rel="noopener noreferrer" class="block w-full">
                            <div class="card-outdoor h-full bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200 hover:border-outdoor-ochre-300 text-center flex flex-col items-center justify-center p-4 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                                <img 
                                    src="https://v-images.cdnsw.com/Root/fzpb7/Logo-Final-Yo-Cyclo-01-1-new-2.png?s=YqFAl3Fj&webp_compatible=1" 
                                    alt="YoCyclo - Atelier de vélos sur mesure" 
                                    class="h-24 w-auto mb-4 hover:scale-105 transition-transform duration-300"
                                    loading="lazy"
                                />
                                <p class="text-sm font-semibold text-outdoor-ochre-600 mb-1">YoCyclo</p>
                                <p class="text-xs text-outdoor-forest-400">Atelier artisanal</p>
                                <div class="flex items-center justify-center mt-2">
                                    <p class="text-xs text-outdoor-ochre-500 font-medium mr-1">Visitez le site</p>
                                    <i class="fas fa-external-link-alt text-outdoor-ochre-500 text-xs"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Composants Principaux -->
    <section id="composants" class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="inline-block bg-outdoor-ochre-100 text-outdoor-earth-600 text-sm px-6 py-2 rounded-full font-semibold mb-4 border border-outdoor-ochre-300">
                        ⚙️ Composants
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Chaque Pièce <span class="text-outdoor-ochre-400">Raconte une Histoire</span>
                    </h2>
                    <p class="text-xl text-outdoor-forest-400 max-w-4xl mx-auto leading-relaxed">
                        Découvrez les composants soigneusement sélectionnés qui font de ce gravel un compagnon d'exception
                    </p>
                </div>

                <!-- Grille des Composants -->
                <div class="space-y-16">
                    
                    <!-- Cadre Elves Mori -->
                    <div class="group relative">
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8 items-center">
                            <!-- Contenu principal -->
                            <div class="lg:col-span-2">
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 h-full">
                                    <div class="flex items-center mb-6">
                                        <div class="w-16 h-16 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mr-4">
                                            <i class="fas fa-bicycle text-outdoor-cream-50 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-outdoor-forest-500">Cadre Elves Mori AeroX</h3>
                                            <span class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider">Le Cœur - Taille 49</span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-outdoor-forest-400 leading-relaxed mb-4">
                                        Le fondement de ce projet repose sur un cadre carbone T800/T1000 d'exception. Sa géométrie "long reach" associée à une direction basse garantit une <strong class="text-outdoor-ochre-500">stabilité rassurante</strong> dans les descentes techniques tout en préservant la réactivité nécessaire aux relances dynamiques.
                                    </p>
                                    
                                    <div class="bg-outdoor-cream-50 p-4 rounded-lg mb-4">
                                        <h4 class="font-bold text-outdoor-forest-500 mb-2">🏔️ Sur le terrain</h4>
                                        <p class="text-outdoor-forest-400 text-sm">
                                            Ce cadre révèle sa personnalité dès les premiers coups de pédale. Il excelle particulièrement sur les portions rapides, où sa rigidité se transforme en pure efficacité.
                                        </p>
                                    </div>


                                    <div class="grid grid-cols-3 gap-3 text-sm">
                                        <div class="bg-outdoor-ochre-100 p-3 rounded-lg text-center">
                                            <div class="font-bold text-outdoor-forest-500">Matériau</div>
                                            <div class="text-outdoor-ochre-600">Carbone T800/T1000</div>
                                        </div>
                                        <div class="bg-outdoor-ochre-100 p-3 rounded-lg text-center">
                                            <div class="font-bold text-outdoor-forest-500">Géométrie</div>
                                            <div class="text-outdoor-ochre-600">Long reach</div>
                                        </div>
                                        <div class="bg-outdoor-ochre-100 p-3 rounded-lg text-center">
                                            <div class="font-bold text-outdoor-forest-500">Finition</div>
                                            <div class="text-outdoor-ochre-600">Black & Chameleon</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Colonne des cadres latéraux -->
                            <div class="lg:col-span-1 flex flex-col justify-center space-y-4">
                                <!-- Cadre Entretien -->
                                <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200">
                                    <div class="flex items-center gap-4">
                                        <!-- Image à gauche -->
                                        <div class="flex-shrink-0">
                                            <img 
                                                src="{{ asset('frontend/assets/images/img_cerfaos/logo-vintage.png') }}" 
                                                alt="Entretien du cadre Elves Mori" 
                                                class="w-20 h-20 object-cover rounded-lg border-2 border-outdoor-ochre-300 shadow-md"
                                                loading="lazy"
                                            />
                                        </div>
                                        
                                        <!-- Contenu à droite -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center mb-2">
                                                <i class="fas fa-wrench text-lg text-outdoor-ochre-500 mr-2"></i>
                                                <h4 class="font-bold text-outdoor-forest-500">Entretien</h4>
                                            </div>
                                            <ul class="text-xs text-outdoor-forest-400 space-y-1">
                                                <li>• Nettoyage + Pâte carbone</li>
                                                <li>• Contrôle couples</li>
                                                <li>• Inspection chute</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cadre Constructeur -->
                                <div>
                                    <a href="https://www.elvesbike.com/more.php?lm=47&id=188" target="_blank" rel="noopener noreferrer" class="block">
                                        <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200 hover:border-outdoor-ochre-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                                            <div class="flex items-center gap-4">
                                                <!-- Image à gauche -->
                                                <div class="flex-shrink-0">
                                                    <img 
                                                        src="https://www.elvesbike.com/attach/202412/1734983957612705260.jpg" 
                                                        alt="Elves Bike - Constructeur" 
                                                        class="w-20 h-20 object-cover rounded-lg border-2 border-outdoor-ochre-300 shadow-md hover:scale-105 transition-transform duration-300"
                                                        loading="lazy"
                                                    />
                                                </div>
                                                
                                                <!-- Contenu à droite -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center mb-1">
                                                        <h4 class="font-bold text-outdoor-forest-500 mr-2">Constructeur</h4>
                                                        <i class="fas fa-external-link-alt text-outdoor-ochre-500 text-xs"></i>
                                                    </div>
                                                    <p class="text-sm text-outdoor-forest-400 font-medium mb-1">
                                                        Elves Bike
                                                    </p>
                                                    <p class="text-xs text-outdoor-forest-400 opacity-75">
                                                        Cliquez pour visiter
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transmission Sensah -->
                    <div class="group relative">
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8 items-center">
                            <!-- Contenu principal -->
                            <div class="lg:col-span-2">
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 h-full">
                                    <div class="flex items-center mb-6">
                                        <div class="w-16 h-16 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mr-4">
                                            <i class="fas fa-cogs text-outdoor-cream-50 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-outdoor-forest-500">Transmission Sensah SRX Pro G12</h3>
                                            <span class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider">Le Mouvement</span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-outdoor-forest-400 leading-relaxed mb-4">
                                        Le choix d'une transmission 1x12 n'est jamais anodin sur un gravel. Ici, la Sensah SRX Pro G12 apporte cette <strong class="text-outdoor-ochre-500">simplicité recherchée</strong> sans compromis sur la polyvalence. Son étagement généreux de 11-50 dents, combiné au pédalier PR3 de 42 dents, offre une plage de développements remarquablement étendue.
                                    </p>
                                    
                                    <div class="bg-outdoor-cream-50 p-4 rounded-lg">
                                        <h4 class="font-bold text-outdoor-forest-500 mb-2">🏔️ Philosophy terrain</h4>
                                        <p class="text-outdoor-forest-400 text-sm">
                                            Cette transmission révèle toute sa pertinence dans les ascensions interminables où le pignon de 50 dents devient un véritable allié. Elle séduira particulièrement les cyclistes qui refusent de choisir entre capacité de grimpée et efficacité sur route.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Colonne des cadres latéraux -->
                            <div class="lg:col-span-1 flex flex-col justify-center space-y-4">
                                <!-- Cadre Caractéristiques -->
                                <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200">
                                    <div class="flex items-center gap-4">
                                        <!-- Image à gauche -->
                                        <div class="flex-shrink-0">
                                            <img 
                                                src="{{ asset('frontend/assets/images/img_cerfaos/logo-vintage.png') }}" 
                                                alt="Transmission Sensah" 
                                                class="w-20 h-20 object-cover rounded-lg border-2 border-outdoor-ochre-300 shadow-md"
                                                loading="lazy"
                                            />
                                        </div>
                                        
                                        <!-- Contenu à droite -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center mb-2">
                                                <i class="fas fa-cogs text-lg text-outdoor-ochre-500 mr-2"></i>
                                                <h4 class="font-bold text-outdoor-forest-500">Caractéristiques</h4>
                                            </div>
                                            <div class="space-y-1 text-xs text-outdoor-forest-400">
                                                <div><span class="font-semibold">Config:</span> 1x12 vitesses</div>
                                                <div><span class="font-semibold">Cassette:</span> 11-50 dents</div>
                                                <div><span class="font-semibold">Pédalier:</span> PR3 42 dents</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cadre Constructeur -->
                                <div>
                                    <a href="https://www.sensahsmart.com/productinfo/3149373.html" target="_blank" rel="noopener noreferrer" class="block">
                                        <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200 hover:border-outdoor-ochre-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                                            <div class="flex items-center gap-4">
                                                <!-- Image à gauche -->
                                                <div class="flex-shrink-0">
                                                    <img 
                                                        src="https://img.wanwang.xin/contents/sitefiles2027/10138146/images/53672961.png" 
                                                        alt="Elves Bike - Constructeur" 
                                                        class="w-20 h-20 object-cover rounded-lg border-2 border-outdoor-ochre-300 shadow-md hover:scale-105 transition-transform duration-300"
                                                        loading="lazy"
                                                    />
                                                </div>
                                                
                                                <!-- Contenu à droite -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center mb-1">
                                                        <h4 class="font-bold text-outdoor-forest-500 mr-2">Constructeur</h4>
                                                        <i class="fas fa-external-link-alt text-outdoor-ochre-500 text-xs"></i>
                                                    </div>
                                                    <p class="text-sm text-outdoor-forest-400 font-medium mb-1">
                                                        Sensah
                                                    </p>
                                                    <p class="text-xs text-outdoor-forest-400 opacity-75">
                                                        Cliquez pour visiter
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Freins Onirii -->
                    <div class="group relative">
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8 items-center">
                            <!-- Contenu principal -->
                            <div class="lg:col-span-2">
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 h-full">
                                    <div class="flex items-center mb-6">
                                        <div class="w-16 h-16 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mr-4">
                                            <i class="fas fa-hand-paper text-outdoor-cream-50 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-outdoor-forest-500">Freins Onirii BR-05</h3>
                                            <span class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider">La Sécurité</span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-outdoor-forest-400 leading-relaxed mb-4">
                                        Les freins Onirii BR-05 représentent une approche intelligente du freinage gravel. Ce <strong class="text-outdoor-ochre-500">système hybride</strong> marie la simplicité du câble pour la commande à la puissance de l'hydraulique pour l'efficacité. Le design CNC témoigne d'une précision d'usinage remarquable.
                                    </p>
                                    
                                    <div class="bg-outdoor-cream-50 p-4 rounded-lg">
                                        <h4 class="font-bold text-outdoor-forest-500 mb-2">🏔️ Performance terrain</h4>
                                        <p class="text-outdoor-forest-400 text-sm">
                                            La précision de ces freins confine au chirurgical, particulièrement appréciable dans les descentes techniques ou les virages serrés. Ils inspirent une confiance totale.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Colonne des cadres latéraux -->
                            <div class="lg:col-span-1 flex flex-col justify-center space-y-4">
                                <!-- Cadre Système -->
                                <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200">
                                    <div class="flex items-center gap-4">
                                        <!-- Image à gauche -->
                                        <div class="flex-shrink-0">
                                            <img 
                                                src="{{ asset('frontend/assets/images/img_cerfaos/logo-vintage.png') }}" 
                                                alt="Freins Onirii" 
                                                class="w-20 h-20 object-cover rounded-lg border-2 border-outdoor-ochre-300 shadow-md"
                                                loading="lazy"
                                            />
                                        </div>
                                        
                                        <!-- Contenu à droite -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center mb-2">
                                                <i class="fas fa-tools text-lg text-outdoor-ochre-500 mr-2"></i>
                                                <h4 class="font-bold text-outdoor-forest-500">Système</h4>
                                            </div>
                                            <ul class="text-xs text-outdoor-forest-400 space-y-1">
                                                <li>• Hybride câble/hydraulique</li>
                                                <li>• Disques 160 mm</li>
                                                <li>• Compatible Shimano XT</li>
                                                <li>• Entretien simplifié</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cadre Constructeur -->
                                <div>
                                    <a href="https://www.oniriibike.com/products/onirii-mechanical-wire-pull-hydraulic-disc-brake-calipers-flat-mount-oil-disc-brake-for-road-bike-gravel-bicycle-new" target="_blank" rel="noopener noreferrer" class="block">
                                        <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200 hover:border-outdoor-ochre-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                                            <div class="flex items-center gap-4">
                                                <!-- Image à gauche -->
                                                <div class="flex-shrink-0">
                                                    <img 
                                                        src="https://www.oniriibike.com/cdn/shop/files/8_58ab766f-162a-400a-98dd-d1dcf7cd829b.jpg?v=1744006114&width=1946" 
                                                        alt="Elves Bike - Constructeur" 
                                                        class="w-20 h-20 object-cover rounded-lg border-2 border-outdoor-ochre-300 shadow-md hover:scale-105 transition-transform duration-300"
                                                        loading="lazy"
                                                    />
                                                </div>
                                                
                                                <!-- Contenu à droite -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center mb-1">
                                                        <h4 class="font-bold text-outdoor-forest-500 mr-2">Constructeur</h4>
                                                        <i class="fas fa-external-link-alt text-outdoor-ochre-500 text-xs"></i>
                                                    </div>
                                                    <p class="text-sm text-outdoor-forest-400 font-medium mb-1">
                                                        Onirii
                                                    </p>
                                                    <p class="text-xs text-outdoor-forest-400 opacity-75">
                                                        Cliquez pour visiter
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Roues DT Swiss -->
                    <div class="group relative">
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8 items-center">
                            <!-- Contenu principal -->
                            <div class="lg:col-span-2">
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 h-full">
                                    <div class="flex items-center mb-6">
                                        <div class="w-16 h-16 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mr-4">
                                            <i class="fas fa-circle text-outdoor-cream-50 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-outdoor-forest-500">Roues DT Swiss R470 DB</h3>
                                            <span class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider">Les Appuis</span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-outdoor-forest-400 leading-relaxed mb-4">
                                        La réputation de DT Swiss n'est plus à faire, et ces R470 DB confirment l'excellence de la marque. Leurs jantes en aluminium de 21 mm de largeur interne offrent un excellent <strong class="text-outdoor-ochre-500">compromis entre rigidité et confort</strong>, parfaitement adaptées aux pneus jusqu'à 45 mm en configuration tubeless.
                                    </p>
                                    
                                    <div class="bg-outdoor-cream-50 p-4 rounded-lg">
                                        <h4 class="font-bold text-outdoor-forest-500 mb-2">🏔️ Comportement</h4>
                                        <p class="text-outdoor-forest-400 text-sm">
                                            Ces roues excellent dans l'absorption des kilomètres sans générer de vibrations parasites. Elles trouvent le juste équilibre entre performance et endurance.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Colonne des cadres latéraux -->
                            <div class="lg:col-span-1 flex flex-col justify-center space-y-4">
                                <!-- Cadre Spécifications -->
                                <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200">
                                    <div class="flex items-center gap-4">
                                        <!-- Image à gauche -->
                                        <div class="flex-shrink-0">
                                            <img 
                                                src="{{ asset('frontend/assets/images/img_cerfaos/logo-vintage.png') }}" 
                                                alt="Roues DT Swiss" 
                                                class="w-20 h-20 object-cover rounded-lg border-2 border-outdoor-ochre-300 shadow-md"
                                                loading="lazy"
                                            />
                                        </div>
                                        
                                        <!-- Contenu à droite -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center mb-2">
                                                <i class="fas fa-circle text-lg text-outdoor-ochre-500 mr-2"></i>
                                                <h4 class="font-bold text-outdoor-forest-500">Spécifications</h4>
                                            </div>
                                            <div class="space-y-1 text-xs text-outdoor-forest-400">
                                                <div><span class="font-semibold">Matériau:</span> Aluminium</div>
                                                <div><span class="font-semibold">Largeur:</span> 21 mm interne</div>
                                                <div><span class="font-semibold">Compatible:</span> Tubeless 45mm</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cadre Constructeur -->
                                <div>
                                    <a href="https://www.dtswiss.com/fr/composants/jantes-route/endurance/r-470" target="_blank" rel="noopener noreferrer" class="block">
                                        <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200 hover:border-outdoor-ochre-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                                            <div class="flex items-center gap-4">
                                                <!-- Image à gauche -->
                                                <div class="flex-shrink-0">
                                                    <img 
                                                        src="https://d2a13k6araex7u.cloudfront.net/ido/00/00/00/00/00/00/00/00/70/00/06/23/5/3217/image-thumb__3217__product-stage/PHO_RDR047DPN24S001543_WEB_SHO_001@2x.webp" 
                                                        alt="Elves Bike - Constructeur" 
                                                        class="w-20 h-20 object-cover rounded-lg border-2 border-outdoor-ochre-300 shadow-md hover:scale-105 transition-transform duration-300"
                                                        loading="lazy"
                                                    />
                                                </div>
                                                
                                                <!-- Contenu à droite -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center mb-1">
                                                        <h4 class="font-bold text-outdoor-forest-500 mr-2">Constructeur</h4>
                                                        <i class="fas fa-external-link-alt text-outdoor-ochre-500 text-xs"></i>
                                                    </div>
                                                    <p class="text-sm text-outdoor-forest-400 font-medium mb-1">
                                                        DT Swiss
                                                    </p>
                                                    <p class="text-xs text-outdoor-forest-400 opacity-75">
                                                        Cliquez pour visiter
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selle Selle Italia -->
                    <div class="group relative">
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8 items-center">
                            <!-- Contenu principal -->
                            <div class="lg:col-span-2">
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 h-full">
                                    <div class="flex items-center mb-6">
                                        <div class="w-16 h-16 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-2xl flex items-center justify-center mr-4">
                                            <i class="fas fa-chair text-outdoor-cream-50 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-outdoor-forest-500">Selle Italia Max SLR Gel Superflow</h3>
                                            <span class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider">Le Confort</span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-outdoor-forest-400 leading-relaxed mb-4">
                                        Cette Selle Italia avec rails en titane TI 316 incarne l'excellence italienne en matière de confort cycliste. Sa technologie Fiber-tek associée au gel de confort et à l'amortisseur intégré transforme les <strong class="text-outdoor-ochre-500">longues distances en plaisir pur</strong>.
                                    </p>
                                    
                                    <div class="bg-outdoor-cream-50 p-4 rounded-lg">
                                        <h4 class="font-bold text-outdoor-forest-500 mb-2">🏔️ Philosophie confort</h4>
                                        <p class="text-outdoor-forest-400 text-sm">
                                            Cette selle révèle tout son potentiel lors des sorties de plusieurs heures. Son gel absorbe les vibrations les plus tenaces, tandis que sa forme étudiée préserve la circulation sanguine.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Colonne des cadres latéraux -->
                            <div class="lg:col-span-1 flex flex-col justify-center space-y-4">
                                <!-- Cadre Technologies -->
                                <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200">
                                    <div class="flex items-center gap-4">
                                        <!-- Image à gauche -->
                                        <div class="flex-shrink-0">
                                            <img 
                                                src="{{ asset('frontend/assets/images/img_cerfaos/logo-vintage.png') }}" 
                                                alt="Selle Italia" 
                                                class="w-20 h-20 object-cover rounded-lg border-2 border-outdoor-ochre-300 shadow-md"
                                                loading="lazy"
                                            />
                                        </div>
                                        
                                        <!-- Contenu à droite -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center mb-2">
                                                <i class="fas fa-gem text-lg text-outdoor-ochre-500 mr-2"></i>
                                                <h4 class="font-bold text-outdoor-forest-500">Technologies</h4>
                                            </div>
                                            <ul class="text-xs text-outdoor-forest-400 space-y-1">
                                                <li>• Rails Titane TI 316</li>
                                                <li>• Fiber-tek + Gel</li>
                                                <li>• Découpe Superflow</li>
                                                <li>• Amortisseur intégré</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cadre Constructeur -->
                                <div>
                                    <a href="https://www.selleitalia.com/max-slr-gel-ti-316-superflow/" target="_blank" rel="noopener noreferrer" class="block">
                                        <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200 hover:border-outdoor-ochre-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                                            <div class="flex items-center gap-4">
                                                <!-- Image à gauche -->
                                                <div class="flex-shrink-0">
                                                    <img 
                                                        src="https://cdn11.bigcommerce.com/s-ubg9970srq/images/stencil/1280w/products/130/2815/044H901IKC001_MAX_SLR_Gel_TI_316_Superflow_L3_THREE_QUARTER__66171.1756450908.jpg?c=1" 
                                                        alt="Elves Bike - Constructeur" 
                                                        class="w-20 h-20 object-cover rounded-lg border-2 border-outdoor-ochre-300 shadow-md hover:scale-105 transition-transform duration-300"
                                                        loading="lazy"
                                                    />
                                                </div>
                                                
                                                <!-- Contenu à droite -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center mb-1">
                                                        <h4 class="font-bold text-outdoor-forest-500 mr-2">Constructeur</h4>
                                                        <i class="fas fa-external-link-alt text-outdoor-ochre-500 text-xs"></i>
                                                    </div>
                                                    <p class="text-sm text-outdoor-forest-400 font-medium mb-1">
                                                        Selle Italia
                                                    </p>
                                                    <p class="text-xs text-outdoor-forest-400 opacity-75">
                                                        Cliquez pour visiter
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Vidéo YouTube -->
    <section id="video" class="py-24 bg-outdoor-cream-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="inline-block bg-outdoor-ochre-100 text-outdoor-earth-600 text-sm px-6 py-2 rounded-full font-semibold mb-4 border border-outdoor-ochre-300">
                        🎬 En Action
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Découvrez <span class="text-outdoor-ochre-400">Elves Mori</span>
                    </h2>
                    <p class="text-xl text-outdoor-forest-400 max-w-4xl mx-auto leading-relaxed">
                        Une présentation de la marque et des technologies qui équipent mon gravel YoCyclo
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
                                                <h3 class="text-xl font-bold text-outdoor-forest-500 mb-2">Découvrir Elves Mori</h3>
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
                                            Découvrez la philosophie et l'innovation derrière la marque Elves
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

    <!-- Section Philosophie & Budget -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <!-- Header -->
                <div class="text-center mb-20">
                    <span class="inline-block bg-outdoor-forest-100 text-outdoor-forest-600 text-sm px-6 py-2 rounded-full font-semibold mb-6 border border-outdoor-forest-300">
                        💰 Philosophie
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-forest-500 mb-8">
                        Artisanat et <span class="text-outdoor-ochre-400">Maîtrise Budgétaire</span>
                    </h2>
                </div>

                <!-- Cards Philosophy -->
                <div class="grid md:grid-cols-2 gap-12 mb-16">
                    <div class="card-outdoor bg-gradient-to-br from-outdoor-olive-50 to-outdoor-cream-50 border-2 border-outdoor-olive-200">
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-outdoor-olive-500 to-outdoor-forest-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-handshake text-outdoor-cream-50 text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-outdoor-forest-500">L'Accompagnement Humain</h3>
                        </div>
                        <p class="text-outdoor-forest-400 leading-relaxed mb-4">
                            Ce qui fait vraiment la différence, c'est l'accompagnement humain. L'expertise de Yoann, sa capacité à traduire des besoins parfois flous en choix techniques précis, et sa patience face à un néophyte du gravel constituent la véritable valeur ajoutée.
                        </p>
                        <p class="text-outdoor-forest-400 leading-relaxed">
                            Cette relation de confiance transforme l'achat d'un vélo en véritable <strong class="text-outdoor-olive-500">projet collaboratif</strong>.
                        </p>
                    </div>

                    <div class="card-outdoor bg-gradient-to-br from-outdoor-ochre-50 to-outdoor-cream-50 border-2 border-outdoor-ochre-200">
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-earth-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calculator text-outdoor-cream-50 text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-outdoor-forest-500">Budget Optimisé</h3>
                        </div>
                        <p class="text-outdoor-forest-400 leading-relaxed mb-4">
                            L'approche artisanale de YoCyclo permet un contrôle total du budget en évitant le surcoût des grandes marques tout en garantissant un niveau de performance équivalent, voire supérieur.
                        </p>
                        <p class="text-outdoor-forest-400 leading-relaxed">
                            Cette philosophie du <strong class="text-outdoor-ochre-500">"juste nécessaire"</strong> évite les composants gadgets pour se concentrer sur l'essentiel.
                        </p>
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
                                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="relative z-10">
                                        <img src="{{ asset('frontend/assets/images/img_cerfaos/moi_pluie.png') }}" alt="Première grande sortie gravel" class="aspect-video object-contain rounded-lg w-full mb-4" loading="lazy">
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
                                            Première Sortie Gravel
                                        </h3>
                                        <span class="text-outdoor-olive-500 font-semibold text-sm uppercase tracking-wider">Découverte</span>
                                    </div>
                                </div>
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Notre première aventure ensemble nous a menés sur les chemins blancs d'Alsace. Le gravel s'est révélé être un <strong class="text-outdoor-ochre-500">compagnon parfait</strong>, capable de nous emmener dans des endroits inaccessibles autrement.
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
                                            Exploration des Crêtes
                                        </h3>
                                        <span class="text-outdoor-ochre-500 font-semibold text-sm uppercase tracking-wider">Défi</span>
                                    </div>
                                </div>
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Les crêtes vosgiennes offrent des <strong class="text-outdoor-ochre-500">vues panoramiques</strong> exceptionnelles. Avec mon gravel YoCyclo, j'ai pu accéder à des points de vue qui semblaient inaccessibles.
                                </p>
                            </div>
                            <div>
                                <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 relative overflow-hidden">
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
                                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-earth-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="relative z-10">
                                        <img src="{{ asset('frontend/assets/images/img_cerfaos/man_rock.png') }}" alt="Exploration terrain technique" class="aspect-video object-contain rounded-lg w-full mb-4" loading="lazy">
                                    </div>
                                </div>
                            </div>
                            <div class="order-1 md:order-2 space-y-4">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-outdoor-earth-500 to-outdoor-forest-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                        <i class="fas fa-hiking text-outdoor-cream-50 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-outdoor-forest-500 group-hover:text-outdoor-forest-600 transition-colors duration-300">
                                            Terrain Technique
                                        </h3>
                                        <span class="text-outdoor-earth-500 font-semibold text-sm uppercase tracking-wider">Complicité</span>
                                    </div>
                                </div>
                                <p class="text-outdoor-forest-400 leading-relaxed group-hover:text-outdoor-forest-500 transition-colors duration-300">
                                    Certains passages nécessitent de porter le vélo, mais c'est aussi l'occasion de créer des <strong class="text-outdoor-earth-500">souvenirs uniques</strong>. Ces défis nous rapprochent et renforcent notre complicité.
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
                        Moments <span class="text-outdoor-ochre-400">Capturés</span>
                    </h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_descente.png') }}" alt="Gravel en descente" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/chute_canard.png') }}" alt="Pause nature" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_jaune.png') }}" alt="Couleurs d'automne" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_bleu.png') }}" alt="Ciel bleu" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_vert.png') }}" alt="Verdure estivale" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_brun.png') }}" alt="Terre et sentiers" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_bureau.png') }}" alt="Préparation sortie" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
                            <div class="absolute inset-0 bg-outdoor-olive-500/0 group-hover:bg-outdoor-olive-500/20 transition-colors duration-300 rounded-3xl"></div>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="card-outdoor transform group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300 p-0">
                            <img data-src="{{ asset('frontend/assets/images/img_cerfaos/moi_crevaison.png') }}" alt="Réparation terrain" class="aspect-square object-contain rounded-3xl w-full h-full opacity-0 transition-opacity duration-500">
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
                        🚴 Conclusion
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-outdoor-cream-50 mb-8">
                        L'Aventure <span class="text-outdoor-ochre-400">Continue</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-outdoor-cream-100 max-w-4xl mx-auto leading-relaxed mb-12">
                        Ce montage YoCyclo transcende la simple notion de vélo pour devenir une véritable œuvre d'artisanat cycliste. Un compagnon de route qui ne se contente pas de rouler, mais qui raconte une histoire à chaque tour de roue, celle d'une <strong class="text-outdoor-ochre-400">collaboration réussie entre artisan passionné et cycliste en devenir</strong>.
                    </p>
                </div>

                <!-- Call to Action -->
                <div class="text-center">
                    <div class="inline-block bg-outdoor-cream-50 rounded-2xl p-8 shadow-xl border border-outdoor-ochre-200">
                        <h3 class="text-2xl font-black text-outdoor-forest-500 mb-4">
                            Partez à l'aventure !
                        </h3>
                        <p class="text-outdoor-forest-400 mb-6 max-w-md mx-auto">
                            L'aventure ne fait que commencer, et nous sommes prêts à explorer ensemble les merveilles qui nous attendent sur les sentiers.
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