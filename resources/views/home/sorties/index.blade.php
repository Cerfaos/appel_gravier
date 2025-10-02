@extends('home.body.home_master')

@section('title', 'Toutes les sorties/expéditions - Cerfaos')

@section('home')
<div class="min-h-screen bg-outdoor-cream-50">
    
    {{-- Hero Section Amélioré avec Image Bandeau --}}
    <section class="relative bg-gradient-to-br from-outdoor-olive-600 via-outdoor-olive-700 to-outdoor-forest-800 text-white py-20 lg:py-28 overflow-hidden">
        {{-- Image bandeau en arrière-plan --}}
        <div class="absolute inset-0">
            <img src="{{ asset('frontend/assets/images/img_cerfaos/bandeau_sorties.png') }}" 
                 alt="Bandeau Sorties/Expéditions" 
                 class="w-full h-full object-cover opacity-70">
            <div class="absolute inset-0 bg-black/30"></div>
        </div>
        
        {{-- Background elements --}}
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute top-0 left-0 w-96 h-96 bg-outdoor-ochre-500/20 rounded-full blur-3xl transform -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-outdoor-olive-400/20 rounded-full blur-3xl transform translate-x-1/2 translate-y-1/2"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-10"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-5xl mx-auto">
                {{-- Badge animé --}}
                <div class="text-center mb-8" data-aos="fade-down">
                    <div class="inline-flex items-center space-x-2 bg-outdoor-olive-500/30 backdrop-blur-sm text-outdoor-cream-100 px-6 py-3 rounded-full text-sm font-medium border border-outdoor-olive-400/30">
                        <span class="animate-pulse">🏕️</span>
                        <span>{{ $sorties->total() ?? 0 }} sorties/expéditions disponibles</span>
                    </div>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-6 md:mb-8 leading-tight">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-outdoor-ochre-400 to-outdoor-ochre-200">
                            Nos Sorties & Expéditions
                        </span>
                    </h1>
                    <p class="text-base md:text-lg lg:text-xl text-outdoor-cream-100 leading-relaxed mb-8 md:mb-12 max-w-3xl mx-auto px-4">
                        Découvrez nos sorties organisées et expéditions d'aventure.
                        Des treks multi-jours aux expéditions exceptionnelles, trouvez votre prochaine aventure collective.
                    </p>
                </div>

                {{-- Catégories avec animations --}}
                <div class="flex flex-wrap justify-center gap-4 mb-8" data-aos="fade-up" data-aos-delay="400">
                    <div class="group flex items-center px-6 py-3 bg-outdoor-olive-500/40 backdrop-blur-sm rounded-full hover:bg-outdoor-olive-500/60 transition-all duration-300 border border-outdoor-olive-400/30 hover:border-outdoor-olive-300/50 cursor-pointer">
                        <span class="text-2xl mr-3 group-hover:scale-110 transition-transform duration-300">🏕️</span>
                        <span class="font-medium">Treks & Expéditions</span>
                    </div>
                    <div class="group flex items-center px-6 py-3 bg-outdoor-olive-500/40 backdrop-blur-sm rounded-full hover:bg-outdoor-olive-500/60 transition-all duration-300 border border-outdoor-olive-400/30 hover:border-outdoor-olive-300/50 cursor-pointer">
                        <span class="text-2xl mr-3 group-hover:scale-110 transition-transform duration-300">🎒</span>
                        <span class="font-medium">Sorties organisées</span>
                    </div>
                    <div class="group flex items-center px-6 py-3 bg-outdoor-olive-500/40 backdrop-blur-sm rounded-full hover:bg-outdoor-olive-500/60 transition-all duration-300 border border-outdoor-olive-400/30 hover:border-outdoor-olive-300/50 cursor-pointer">
                        <span class="text-2xl mr-3 group-hover:scale-110 transition-transform duration-300">🌄</span>
                        <span class="font-medium">Aventures exceptionnelles</span>
                    </div>
                </div>

                {{-- CTA scroll hint --}}
                <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                    <div class="inline-flex flex-col items-center text-outdoor-cream-200 hover:text-white transition-colors cursor-pointer group">
                        <span class="text-sm font-medium mb-2">Explorer les sorties</span>
                        <div class="w-6 h-10 border-2 border-outdoor-cream-200 group-hover:border-white rounded-full flex justify-center">
                            <div class="w-1 h-3 bg-outdoor-cream-200 group-hover:bg-white rounded-full mt-2 animate-bounce"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contenu principal --}}
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-7xl mx-auto">
            
            {{-- Compteur de résultats --}}
            <div class="flex items-center justify-between mb-8" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center space-x-4">
                    <h3 class="text-2xl font-display font-bold text-outdoor-forest-800">
                        @if($sorties->count() > 0)
                            {{ $sorties->total() }} sortie{{ $sorties->total() > 1 ? 's' : '' }} trouvée{{ $sorties->total() > 1 ? 's' : '' }}
                        @else
                            Aucune sortie trouvée
                        @endif
                    </h3>
                    @if(request()->hasAny(['search', 'departement', 'pays', 'difficulty', 'distance']))
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-outdoor-forest-500">Filtres actifs:</span>
                            @if(request('search'))
                                <span class="inline-flex items-center px-3 py-1 text-sm bg-outdoor-olive-100 text-outdoor-olive-800 rounded-full">
                                    Recherche: "{{ request('search') }}"
                                </span>
                            @endif
                            @if(request('departement'))
                                <span class="inline-flex items-center px-3 py-1 text-sm bg-outdoor-olive-100 text-outdoor-olive-800 rounded-full">
                                    🏛️ {{ request('departement') }}
                                </span>
                            @endif
                            @if(request('pays'))
                                <span class="inline-flex items-center px-3 py-1 text-sm bg-outdoor-olive-100 text-outdoor-olive-800 rounded-full">
                                    🌍 {{ request('pays') }}
                                </span>
                            @endif
                            @if(request('difficulty'))
                                <span class="inline-flex items-center px-3 py-1 text-sm bg-outdoor-olive-100 text-outdoor-olive-800 rounded-full">
                                    @if(request('difficulty') === 'facile')🟢 Facile
                                    @elseif(request('difficulty') === 'moyen')🟡 Moyen
                                    @elseif(request('difficulty') === 'difficile')🔴 Difficile
                                    @endif
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Statistiques cumulées --}}
            @if($stats && $stats->total_sorties > 0)
                <div class="mb-8" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-outdoor-lg border border-outdoor-cream-200/60 p-8">
                        <h3 class="text-2xl font-display font-bold text-outdoor-forest-700 mb-6 text-center">
                            📊 Statistiques cumulées des sorties
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="text-center p-4 bg-outdoor-olive-50 rounded-2xl">
                                <div class="text-2xl font-bold text-outdoor-olive-600">
                                    {{ number_format($stats->total_distance, 1) }} km
                                </div>
                                <div class="text-sm text-outdoor-forest-600 mt-1">Distance totale</div>
                            </div>
                            <div class="text-center p-4 bg-outdoor-ochre-50 rounded-2xl">
                                <div class="text-2xl font-bold text-outdoor-ochre-600">
                                    @php
                                        $totalMinutes = $stats->total_time_minutes;
                                        $hours = floor($totalMinutes / 60);
                                        $minutes = $totalMinutes % 60;
                                    @endphp
                                    @if($hours > 0){{ $hours }}h @endif{{ $minutes }}min
                                </div>
                                <div class="text-sm text-outdoor-forest-600 mt-1">Temps total réel</div>
                            </div>
                            <div class="text-center p-4 bg-outdoor-earth-50 rounded-2xl">
                                <div class="text-2xl font-bold text-outdoor-earth-600">
                                    {{ number_format($stats->total_elevation) }}m
                                </div>
                                <div class="text-sm text-outdoor-forest-600 mt-1">Dénivelé cumulé</div>
                            </div>
                            <div class="text-center p-4 bg-outdoor-forest-50 rounded-2xl">
                                <div class="text-2xl font-bold text-outdoor-forest-600">
                                    {{ $stats->total_sorties }}
                                </div>
                                <div class="text-sm text-outdoor-forest-600 mt-1">Nombre de sorties</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Système d'onglets pour organiser les données --}}
            <div class="mb-8" data-aos="fade-up" data-aos-delay="350" x-data="{ activeTab: 'sorties' }">
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-outdoor-lg border border-outdoor-cream-200/60 overflow-hidden">
                    
                    {{-- Onglets de navigation --}}
                    <div class="flex border-b border-outdoor-cream-200">
                        <button @click="activeTab = 'sorties'" 
                                :class="activeTab === 'sorties' ? 'bg-outdoor-olive-500 text-white' : 'bg-outdoor-cream-50 text-outdoor-forest-600 hover:bg-outdoor-cream-100'" 
                                class="flex-1 px-6 py-4 font-semibold text-center transition-all duration-200 border-r border-outdoor-cream-200">
                            <div class="flex items-center justify-center space-x-2">
                                <span class="text-lg">🏕️</span>
                                <span>Liste des Sorties</span>
                                <span class="bg-outdoor-olive-100 text-outdoor-olive-700 px-2 py-1 rounded-full text-xs ml-2">{{ $sorties->total() }}</span>
                            </div>
                        </button>
                        <button @click="activeTab = 'monthly'" 
                                :class="activeTab === 'monthly' ? 'bg-outdoor-olive-500 text-white' : 'bg-outdoor-cream-50 text-outdoor-forest-600 hover:bg-outdoor-cream-100'" 
                                class="flex-1 px-6 py-4 font-semibold text-center transition-all duration-200 border-r border-outdoor-cream-200">
                            <div class="flex items-center justify-center space-x-2">
                                <span class="text-lg">📅</span>
                                <span>Stats Mensuelles</span>
                            </div>
                        </button>
                        <button @click="activeTab = 'yearly'" 
                                :class="activeTab === 'yearly' ? 'bg-outdoor-olive-500 text-white' : 'bg-outdoor-cream-50 text-outdoor-forest-600 hover:bg-outdoor-cream-100'" 
                                class="flex-1 px-6 py-4 font-semibold text-center transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <span class="text-lg">🗓️</span>
                                <span>Stats Annuelles</span>
                            </div>
                        </button>
                    </div>

                    {{-- Contenu des onglets --}}
                    <div class="p-6">
                        
                        {{-- Onglet: Liste des sorties --}}
                        <div x-show="activeTab === 'sorties'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            @if($sorties->count() > 0)
                                {{-- Options de tri et filtrage rapide --}}
                                <div class="space-y-3 mb-4">
                                    <div class="flex flex-wrap items-center justify-between gap-4 p-4 bg-outdoor-cream-50 rounded-xl">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-medium text-outdoor-forest-600">Tri:</span>
                                                <select onchange="window.location.href = this.value" class="text-sm border-outdoor-cream-300 rounded-lg focus:ring-outdoor-olive-500 focus:border-outdoor-olive-500">
                                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'published_at_desc']) }}" {{ request('sort', 'published_at_desc') === 'published_at_desc' ? 'selected' : '' }}>Plus récentes</option>
                                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'published_at_asc']) }}" {{ request('sort') === 'published_at_asc' ? 'selected' : '' }}>Plus anciennes</option>
                                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'distance_desc']) }}" {{ request('sort') === 'distance_desc' ? 'selected' : '' }}>Distance ↓</option>
                                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'distance_asc']) }}" {{ request('sort') === 'distance_asc' ? 'selected' : '' }}>Distance ↑</option>
                                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'title_asc']) }}" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>Nom A-Z</option>
                                                </select>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-medium text-outdoor-forest-600">Limite:</span>
                                                <select onchange="window.location.href = this.value" class="text-sm border-outdoor-cream-300 rounded-lg focus:ring-outdoor-olive-500 focus:border-outdoor-olive-500">
                                                    <option value="{{ request()->fullUrlWithQuery(['per_page' => '12']) }}" {{ request('per_page', '12') == '12' ? 'selected' : '' }}>12</option>
                                                    <option value="{{ request()->fullUrlWithQuery(['per_page' => '24']) }}" {{ request('per_page') == '24' ? 'selected' : '' }}>24</option>
                                                    <option value="{{ request()->fullUrlWithQuery(['per_page' => '48']) }}" {{ request('per_page') == '48' ? 'selected' : '' }}>48</option>
                                                    <option value="{{ request()->fullUrlWithQuery(['per_page' => '100']) }}" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="text-sm text-outdoor-forest-500">
                                            Page {{ $sorties->currentPage() }} sur {{ $sorties->lastPage() }} ({{ $sorties->total() }} sorties)
                                        </div>
                                    </div>
                                    
                                    {{-- Filtres avancés (collapsibles) --}}
                                    <div x-data="{ showFilters: false }" class="bg-white border border-outdoor-cream-200 rounded-xl">
                                        <button @click="showFilters = !showFilters" class="w-full px-4 py-3 flex items-center justify-between text-left">
                                            <span class="text-sm font-medium text-outdoor-forest-700">Filtres avancés</span>
                                            <svg :class="{ 'rotate-180': showFilters }" class="w-4 h-4 text-outdoor-forest-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div x-show="showFilters" x-collapse class="px-4 pb-4 border-t border-outdoor-cream-200">
                                            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-outdoor-forest-700 mb-1">Recherche</label>
                                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Titre, lieu..." class="w-full text-sm border-outdoor-cream-300 rounded-lg focus:ring-outdoor-olive-500 focus:border-outdoor-olive-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-outdoor-forest-700 mb-1">Département</label>
                                                    <select name="departement" class="w-full text-sm border-outdoor-cream-300 rounded-lg focus:ring-outdoor-olive-500 focus:border-outdoor-olive-500">
                                                        <option value="">Tous les départements</option>
                                                        @php
                                                        $departements = $sorties->pluck('departement')->filter()->unique()->sort();
                                                        @endphp
                                                        @foreach($departements as $dept)
                                                            <option value="{{ $dept }}" {{ request('departement') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-outdoor-forest-700 mb-1">Distance</label>
                                                    <select name="distance" class="w-full text-sm border-outdoor-cream-300 rounded-lg focus:ring-outdoor-olive-500 focus:border-outdoor-olive-500">
                                                        <option value="">Toutes distances</option>
                                                        <option value="0-5" {{ request('distance') === '0-5' ? 'selected' : '' }}>0 - 5 km</option>
                                                        <option value="5-10" {{ request('distance') === '5-10' ? 'selected' : '' }}>5 - 10 km</option>
                                                        <option value="10-20" {{ request('distance') === '10-20' ? 'selected' : '' }}>10 - 20 km</option>
                                                        <option value="20-50" {{ request('distance') === '20-50' ? 'selected' : '' }}>20 - 50 km</option>
                                                        <option value="50+" {{ request('distance') === '50+' ? 'selected' : '' }}>50+ km</option>
                                                    </select>
                                                </div>
                                                <div class="flex items-end">
                                                    <button type="submit" class="w-full px-4 py-2 bg-outdoor-olive-600 text-white text-sm rounded-lg hover:bg-outdoor-olive-700 transition-colors">
                                                        Appliquer
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tableau compact - Desktop uniquement --}}
                                <div class="hidden md:block overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-outdoor-olive-100 text-outdoor-olive-800">
                                            <tr>
                                                <th class="px-4 py-3 text-left font-semibold">Sortie</th>
                                                <th class="px-4 py-3 text-center font-semibold">📏 Distance</th>
                                                <th class="px-4 py-3 text-center font-semibold">⏱️ Durée</th>
                                                <th class="px-4 py-3 text-center font-semibold">📈 D+</th>
                                                <th class="px-4 py-3 text-center font-semibold">🎯 Niveau</th>
                                                <th class="px-4 py-3 text-center font-semibold">🌤️ Météo</th>
                                                <th class="px-4 py-3 text-center font-semibold">📍 Lieu</th>
                                                <th class="px-4 py-3 text-center font-semibold">📅 Date</th>
                                                <th class="px-4 py-3 text-center font-semibold">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-outdoor-cream-200">
                                            @foreach($sorties as $sortie)
                                                <tr class="hover:bg-outdoor-cream-50 transition-colors duration-200">
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                @if($sortie->featuredImage)
                                                                    <img src="{{ $sortie->featuredImage->medium_image }}" 
                                                                         alt="{{ $sortie->title }}" 
                                                                         class="w-10 h-10 rounded-lg object-cover">
                                                                @else
                                                                    <div class="w-10 h-10 bg-outdoor-olive-100 rounded-lg flex items-center justify-center">
                                                                        <span class="text-outdoor-olive-600 text-lg">🏕️</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <div class="font-medium text-outdoor-forest-700">{{ Str::limit($sortie->title, 30) }}</div>
                                                                @if($sortie->description)
                                                                    <div class="text-xs text-outdoor-forest-500">{{ Str::limit($sortie->description, 40) }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        @if($sortie->distance_km)
                                                            <span class="font-semibold text-outdoor-olive-600 text-sm">{{ number_format($sortie->distance_km, 1) }}km</span>
                                                        @else
                                                            <span class="text-outdoor-forest-400 text-sm">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        @if($sortie->actual_duration_minutes)
                                                            @php
                                                                $hours = floor($sortie->actual_duration_minutes / 60);
                                                                $minutes = $sortie->actual_duration_minutes % 60;
                                                            @endphp
                                                            <div class="flex flex-col items-center">
                                                                <span class="font-semibold text-outdoor-ochre-600 text-sm">
                                                                    @if($hours > 0)
                                                                        {{ $hours }}h
                                                                    @endif
                                                                    {{ $minutes }}min
                                                                </span>
                                                                <span class="text-xs text-outdoor-forest-400">réelle</span>
                                                            </div>
                                                        @else
                                                            <span class="text-outdoor-forest-400 text-sm">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        @if($sortie->elevation_gain_m)
                                                            <span class="font-semibold text-outdoor-earth-600 text-sm">{{ number_format($sortie->elevation_gain_m) }}m</span>
                                                        @else
                                                            <span class="text-outdoor-forest-400 text-sm">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        @if($sortie->difficulty_level === 'facile')
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                                🟢 Facile
                                                            </span>
                                                        @elseif($sortie->difficulty_level === 'moyen')
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                                🟡 Moyen
                                                            </span>
                                                        @elseif($sortie->difficulty_level === 'difficile')
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                                🔴 Difficile
                                                            </span>
                                                        @else
                                                            <span class="text-outdoor-forest-400 text-xs">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        @if($sortie->weather_conditions && count($sortie->weather_conditions) > 0)
                                                            <div class="flex flex-wrap justify-center gap-1">
                                                                @php
                                                                    $weatherIcons = [
                                                                        'ensoleille' => '☀️',
                                                                        'nuageux' => '☁️',
                                                                        'pluie' => '🌧️',
                                                                        'vent' => '💨',
                                                                        'brouillard' => '🌫️',
                                                                        'neige' => '❄️',
                                                                        'orage' => '⛈️',
                                                                        'chaud' => '🥵',
                                                                        'froid' => '🥶'
                                                                    ];
                                                                @endphp
                                                                @foreach($sortie->weather_conditions as $weather)
                                                                    @if(isset($weatherIcons[$weather]))
                                                                        <span class="text-sm" title="{{ ucfirst($weather) }}">{{ $weatherIcons[$weather] }}</span>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <span class="text-outdoor-forest-400 text-sm">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <div class="text-xs">
                                                            @if($sortie->departement)
                                                                <div class="font-medium text-outdoor-forest-700">{{ $sortie->departement }}</div>
                                                            @endif
                                                            @if($sortie->pays)
                                                                <div class="text-outdoor-forest-500">{{ $sortie->pays }}</div>
                                                            @endif
                                                            @if(!$sortie->departement && !$sortie->pays)
                                                                <span class="text-outdoor-forest-400">-</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        @if($sortie->sortie_date)
                                                            <div class="text-xs">
                                                                <div class="font-medium text-outdoor-forest-700">📅 {{ $sortie->sortie_date->format('d/m/Y') }}</div>
                                                                <div class="text-outdoor-forest-500 text-xs">Date sortie</div>
                                                            </div>
                                                        @elseif($sortie->published_at)
                                                            <div class="text-xs">
                                                                <div class="font-medium text-outdoor-forest-700">{{ $sortie->published_at->format('d/m/Y') }}</div>
                                                                <div class="text-outdoor-forest-500 text-xs">Publication</div>
                                                            </div>
                                                        @else
                                                            <span class="text-outdoor-forest-400 text-xs">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <a href="{{ route('sorties.show', $sortie->slug) }}" 
                                                           class="inline-flex items-center px-3 py-1 bg-outdoor-olive-500 hover:bg-outdoor-olive-600 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                            Voir
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Cartes Mobile - Affichage optimisé pour petits écrans --}}
                                <div class="md:hidden space-y-4">
                                    @foreach($sorties as $sortie)
                                        <div class="bg-white border border-outdoor-cream-200 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-200">
                                            {{-- Image et titre --}}
                                            <div class="flex items-start p-4 space-x-3 border-b border-outdoor-cream-100">
                                                <div class="flex-shrink-0">
                                                    @if($sortie->featuredImage)
                                                        <img src="{{ $sortie->featuredImage->medium_image }}"
                                                             alt="{{ $sortie->title }}"
                                                             class="w-16 h-16 rounded-xl object-cover">
                                                    @else
                                                        <div class="w-16 h-16 bg-outdoor-olive-100 rounded-xl flex items-center justify-center">
                                                            <span class="text-2xl">🏕️</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="font-bold text-outdoor-forest-700 text-base leading-tight mb-1">
                                                        {{ $sortie->title }}
                                                    </h3>
                                                    @if($sortie->description)
                                                        <p class="text-xs text-outdoor-forest-500 line-clamp-2">
                                                            {{ Str::limit($sortie->description, 60) }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Statistiques en grille --}}
                                            <div class="grid grid-cols-3 gap-2 p-3 bg-outdoor-cream-50">
                                                {{-- Distance --}}
                                                <div class="text-center">
                                                    <div class="text-xl font-black text-outdoor-olive-600">
                                                        {{ $sortie->distance_km ? number_format($sortie->distance_km, 1) : '-' }}
                                                    </div>
                                                    <div class="text-xs text-outdoor-forest-500 font-medium">km</div>
                                                </div>

                                                {{-- Durée --}}
                                                <div class="text-center">
                                                    @if($sortie->actual_duration_minutes)
                                                        @php
                                                            $hours = floor($sortie->actual_duration_minutes / 60);
                                                            $minutes = $sortie->actual_duration_minutes % 60;
                                                        @endphp
                                                        <div class="text-xl font-black text-outdoor-ochre-600">
                                                            @if($hours > 0){{ $hours }}h@endif{{ $minutes }}
                                                        </div>
                                                        <div class="text-xs text-outdoor-forest-500 font-medium">
                                                            @if($hours > 0)min@else minutes@endif
                                                        </div>
                                                    @else
                                                        <div class="text-xl font-black text-outdoor-forest-400">-</div>
                                                        <div class="text-xs text-outdoor-forest-400">durée</div>
                                                    @endif
                                                </div>

                                                {{-- Dénivelé --}}
                                                <div class="text-center">
                                                    <div class="text-xl font-black text-outdoor-earth-600">
                                                        {{ $sortie->elevation_gain_m ? number_format($sortie->elevation_gain_m) : '-' }}
                                                    </div>
                                                    <div class="text-xs text-outdoor-forest-500 font-medium">D+ (m)</div>
                                                </div>
                                            </div>

                                            {{-- Informations détaillées --}}
                                            <div class="p-4 space-y-3">
                                                {{-- Difficulté et Météo --}}
                                                <div class="flex items-center justify-between">
                                                    {{-- Niveau --}}
                                                    <div>
                                                        @if($sortie->difficulty_level === 'facile')
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                                🟢 Facile
                                                            </span>
                                                        @elseif($sortie->difficulty_level === 'moyen')
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                                                🟡 Moyen
                                                            </span>
                                                        @elseif($sortie->difficulty_level === 'difficile')
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                                🔴 Difficile
                                                            </span>
                                                        @endif
                                                    </div>

                                                    {{-- Météo --}}
                                                    @if($sortie->weather_conditions && count($sortie->weather_conditions) > 0)
                                                        <div class="flex gap-1">
                                                            @php
                                                                $weatherIcons = [
                                                                    'ensoleille' => '☀️',
                                                                    'nuageux' => '☁️',
                                                                    'pluie' => '🌧️',
                                                                    'vent' => '💨',
                                                                    'brouillard' => '🌫️',
                                                                    'neige' => '❄️',
                                                                    'orage' => '⛈️',
                                                                    'chaud' => '🥵',
                                                                    'froid' => '🥶'
                                                                ];
                                                            @endphp
                                                            @foreach(array_slice($sortie->weather_conditions, 0, 3) as $weather)
                                                                @if(isset($weatherIcons[$weather]))
                                                                    <span class="text-lg">{{ $weatherIcons[$weather] }}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Lieu et Date --}}
                                                <div class="flex items-center justify-between text-xs text-outdoor-forest-600">
                                                    <div class="flex items-center space-x-1">
                                                        <span>📍</span>
                                                        <span class="font-medium">
                                                            @if($sortie->departement)
                                                                {{ $sortie->departement }}
                                                            @elseif($sortie->pays)
                                                                {{ $sortie->pays }}
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center space-x-1">
                                                        <span>📅</span>
                                                        <span class="font-medium">
                                                            @if($sortie->sortie_date)
                                                                {{ $sortie->sortie_date->format('d/m/Y') }}
                                                            @elseif($sortie->published_at)
                                                                {{ $sortie->published_at->format('d/m/Y') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                {{-- Bouton Voir --}}
                                                <a href="{{ route('sorties.show', $sortie->slug) }}"
                                                   class="block w-full bg-outdoor-olive-500 hover:bg-outdoor-olive-600 text-white text-center font-semibold py-3 rounded-xl transition-colors duration-200 min-h-[48px] flex items-center justify-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Voir la sortie
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Pagination compacte --}}
                                <div class="flex justify-center mt-4 p-4 bg-outdoor-cream-50 rounded-xl">
                                    {{ $sorties->appends(request()->query())->links() }}
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <span class="text-4xl mb-4 block">🏕️</span>
                                    <p class="text-outdoor-forest-500">Aucune sortie trouvée</p>
                                </div>
                            @endif
                        </div>

                        {{-- Onglet: Statistiques mensuelles --}}
                        <div x-show="activeTab === 'monthly'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div x-data="{ selectedYear: '{{ date('Y') }}' }">
                                <div class="flex items-center justify-center mb-6 space-x-4">
                                    <h4 class="text-xl font-display font-bold text-outdoor-forest-700">
                                        📅 Statistiques mensuelles
                                    </h4>
                                    <select x-model="selectedYear" class="text-sm border-outdoor-cream-300 rounded-lg focus:ring-outdoor-olive-500 focus:border-outdoor-olive-500">
                                        @foreach($monthlyStats as $year => $months)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                @foreach($monthlyStats as $year => $months)
                                    <div x-show="selectedYear == '{{ $year }}'" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @php
                                            $monthNames = [
                                                1 => 'Jan', 2 => 'Fév', 3 => 'Mar', 4 => 'Avr',
                                                5 => 'Mai', 6 => 'Juin', 7 => 'Juil', 8 => 'Aoû',
                                                9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Déc'
                                            ];
                                            $monthsData = $months->keyBy('month');
                                        @endphp
                                        @for($month = 1; $month <= 12; $month++)
                                            @php
                                                $monthData = $monthsData->get($month);
                                            @endphp
                                            <div class="p-4 {{ $monthData ? 'bg-outdoor-olive-50 border-outdoor-olive-200' : 'bg-outdoor-cream-50 border-outdoor-cream-200' }} border rounded-xl text-center transition-all hover:shadow-md">
                                                <div class="font-bold text-outdoor-forest-700 mb-2">{{ $monthNames[$month] }}</div>
                                                @if($monthData)
                                                    <div class="text-lg font-bold text-outdoor-olive-600">{{ $monthData->sorties_count }}</div>
                                                    <div class="text-xs text-outdoor-forest-500">sortie{{ $monthData->sorties_count > 1 ? 's' : '' }}</div>
                                                    @if($monthData->distance)
                                                        <div class="text-xs text-outdoor-forest-600 mt-1">
                                                            <div>{{ number_format($monthData->distance, 1) }}km</div>
                                                            @if($monthData->duration_minutes)
                                                                @php
                                                                    $hours = floor($monthData->duration_minutes / 60);
                                                                    $minutes = $monthData->duration_minutes % 60;
                                                                @endphp
                                                                <div>@if($hours > 0){{ $hours }}h @endif{{ $minutes }}min</div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="text-lg font-bold text-outdoor-forest-300">0</div>
                                                    <div class="text-xs text-outdoor-forest-400">sortie</div>
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Onglet: Statistiques annuelles --}}
                        <div x-show="activeTab === 'yearly'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="text-center mb-6">
                                <h4 class="text-xl font-display font-bold text-outdoor-forest-700">
                                    🗓️ Statistiques par année
                                </h4>
                                <p class="text-outdoor-forest-500 text-sm">Évolution des performances au fil des années</p>
                            </div>

                            <div class="space-y-3">
                                @if(isset($yearlyStats) && $yearlyStats->count() > 0)
                                    @php $counter = 0; @endphp
                                    @foreach($yearlyStats as $year => $yearData)
                                        @if($counter < 10)
                                        @php
                                            $totalMinutes = $yearData->duration_minutes ?? 0;
                                            $hours = floor($totalMinutes / 60);
                                            $minutes = $totalMinutes % 60;
                                            $counter++;
                                        @endphp
                                        <div class="border border-outdoor-cream-200 rounded-xl p-4 bg-gradient-to-r from-outdoor-olive-50 to-outdoor-ochre-50">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="flex items-center space-x-4">
                                                    <h5 class="text-lg font-bold text-outdoor-forest-700">{{ $year }}</h5>
                                                    <span class="bg-outdoor-olive-100 text-outdoor-olive-700 px-3 py-1 rounded-full text-sm font-semibold">
                                                        {{ $yearData->sorties_count }} sortie{{ $yearData->sorties_count > 1 ? 's' : '' }}
                                                    </span>
                                                </div>
                                                <div class="text-sm text-outdoor-forest-600">
                                                    <span class="font-medium">{{ number_format($yearData->distance, 0) }}km</span>
                                                    <span class="mx-2">•</span>
                                                    {{ $totalMinutes == 0 ? '0h' : '' }}{{ $hours > 0 ? $hours . 'h' : '' }}{{ $minutes > 0 ? $minutes . 'min' : '' }}
                                                </div>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                                <div class="p-3 bg-outdoor-olive-50 rounded-lg">
                                                    <div class="font-bold text-lg text-outdoor-olive-600">{{ number_format($yearData->distance, 1) }}</div>
                                                    <div class="text-xs text-outdoor-forest-500">Kilomètres</div>
                                                </div>
                                                <div class="p-3 bg-outdoor-ochre-50 rounded-lg">
                                                    <div class="font-bold text-lg text-outdoor-ochre-600">
                                                        {{ $totalMinutes == 0 ? '0h' : '' }}{{ $hours > 0 ? $hours . 'h' : '' }}{{ $minutes > 0 ? $minutes . 'min' : '' }}
                                                    </div>
                                                    <div class="text-xs text-outdoor-forest-500">Temps total</div>
                                                </div>
                                                <div class="p-3 bg-outdoor-earth-50 rounded-lg">
                                                    <div class="font-bold text-lg text-outdoor-earth-600">
                                                        {{ $yearData->elevation ? number_format($yearData->elevation) : '0' }}
                                                    </div>
                                                    <div class="text-xs text-outdoor-forest-500">Dénivelé (m)</div>
                                                </div>
                                                <div class="p-3 bg-outdoor-forest-50 rounded-lg">
                                                    <div class="font-bold text-lg text-outdoor-forest-600">
                                                        {{ $yearData->distance ? number_format($yearData->distance / $yearData->sorties_count, 1) : '0' }}
                                                    </div>
                                                    <div class="text-xs text-outdoor-forest-500">Km moyen</div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="text-center py-8">
                                        <span class="text-4xl mb-4 block">📊</span>
                                        <p class="text-outdoor-forest-500">Aucune donnée disponible</p>
                                    </div>
                                @endif

                                @if($yearlyStats->count() > 10)
                                    <div class="text-center p-4 bg-outdoor-cream-50 rounded-xl">
                                        <p class="text-outdoor-forest-500 text-sm">{{ $yearlyStats->count() - 10 }} années supplémentaires disponibles</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Aucun résultat si pas de sorties --}}
            @if($sorties->count() == 0)
                <div class="text-center py-16" data-aos="fade-up" data-aos-delay="400">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-outdoor-cream-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-4xl">🏕️</span>
                        </div>
                        <h3 class="text-2xl font-display font-bold text-outdoor-forest-700 mb-4">
                            Aucune sortie trouvée
                        </h3>
                        <p class="text-outdoor-forest-500 mb-8">
                            @if(request()->hasAny(['search', 'departement', 'pays', 'difficulty', 'distance']))
                                Essayez de modifier vos critères de recherche ou 
                                <button onclick="document.getElementById('filterForm').reset(); window.location.href = '{{ route('sorties.index') }}';" 
                                        class="text-outdoor-olive-600 hover:text-outdoor-olive-700 font-medium underline">
                                    réinitialisez les filtres
                                </button>.
                            @else
                                Il n'y a pas encore de sorties/expéditions disponibles.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'departement', 'pays', 'difficulty', 'distance']))
                            <a href="{{ route('sorties.index') }}" 
                               class="inline-flex items-center space-x-2 bg-outdoor-olive-500 hover:bg-outdoor-olive-600 text-white font-bold py-3 px-6 rounded-xl transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span>Voir toutes les sorties</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Script pour les filtres --}}
<script>
function sortieFilters() {
    return {
        filters: {
            search: '{{ request("search") }}',
            departement: '{{ request("departement") }}',
            pays: '{{ request("pays") }}',
            difficulty: '{{ request("difficulty") }}',
            distance: '{{ request("distance") }}',
            sort: '{{ request("sort", "published_at_desc") }}'
        },
        
        resetFilters() {
            this.filters = {
                search: '',
                departement: '',
                pays: '',
                difficulty: '',
                distance: '',
                sort: 'published_at_desc'
            };
            
            // Reset form inputs
            const form = document.getElementById('filterForm');
            form.reset();
            
            // Navigate to clean URL
            window.location.href = '{{ route("sorties.index") }}';
        }
    }
}

// Auto-submit form on select changes
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    const selects = form.querySelectorAll('select');
    
    selects.forEach(select => {
        select.addEventListener('change', () => {
            form.submit();
        });
    });
});
</script>
@endsection