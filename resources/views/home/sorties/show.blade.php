@extends('home.body.home_master')

@section('title', $sortie->meta_title ?: $sortie->title . ' - Cerfaos')

@section('meta')
    <meta name="description" content="{{ $sortie->meta_description ?: Str::limit($sortie->description, 160) }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="{{ $sortie->meta_title ?: $sortie->title }}">
    <meta property="og:description" content="{{ $sortie->meta_description ?: Str::limit($sortie->description, 160) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($sortie->featuredImage)
        <meta property="og:image" content="{{ asset($sortie->featuredImage->image_path) }}">
    @endif
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $sortie->meta_title ?: $sortie->title }}">
    <meta name="twitter:description" content="{{ $sortie->meta_description ?: Str::limit($sortie->description, 160) }}">
    @if($sortie->featuredImage)
        <meta name="twitter:image" content="{{ asset($sortie->featuredImage->image_path) }}">
    @endif
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
<div x-data="sortieViewer()" class="bg-gray-50 min-h-screen">
    
    <!-- Hero Section avec image principale -->
    <section class="relative h-96 lg:h-[500px] overflow-hidden">
        @if($sortie->featuredImage)
            <img src="{{ asset($sortie->featuredImage->image_path) }}" 
                 alt="{{ $sortie->title }}" 
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-br from-outdoor-olive-400 via-outdoor-ochre-400 to-outdoor-earth-500"></div>
        @endif
        
        <!-- Overlay dégradé -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        
        <!-- Contenu hero -->
        <div class="absolute inset-0 flex items-end">
            <div class="container mx-auto px-4 pb-8 lg:pb-12">
                <div class="max-w-4xl">
                    <!-- Breadcrumb -->
                    <nav class="mb-4">
                        <ol class="flex items-center space-x-2 text-white/80 text-sm">
                            <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">🌿 Accueil</a></li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('sorties.index') }}" class="hover:text-white transition-colors">🏕️ Sorties</a>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-white">{{ Str::limit($sortie->title, 30) }}</span>
                            </li>
                        </ol>
                    </nav>
                    
                    <!-- Titre principal -->
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
                        {{ $sortie->title }}
                    </h1>
                    
                    <!-- Métadonnées -->
                    <div class="flex flex-wrap items-center gap-4 text-white/90">
                        @if($sortie->user)
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full overflow-hidden ring-1 ring-white/30">
                                    <img 
                                        src="{{ (!empty($sortie->user->photo)) ? url('upload/user_images/'.$sortie->user->photo) : url('upload/no_image.jpg') }}" 
                                        alt="{{ $sortie->user->name }}" 
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                                <span>{{ $sortie->user->name }}</span>
                            </div>
                        @endif
                        
                        @if($sortie->sortie_date && is_object($sortie->sortie_date))
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>📅 {{ $sortie->sortie_date->format('d M Y') }}</span>
                        </div>
                        @elseif($sortie->sortie_date)
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>📅 {{ \Carbon\Carbon::parse($sortie->sortie_date)->format('d M Y') }}</span>
                        </div>
                        @endif
                        
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Publié le {{ $sortie->published_at->format('d M Y') }}</span>
                        </div>
                        
                        <!-- Badge de difficulté -->
                        @if($sortie->difficulty_level)
                            <div class="flex items-center gap-2">
                                @if($sortie->difficulty_level === 'facile')
                                    <span class="px-3 py-1 bg-green-500 text-white text-sm font-medium rounded-full">
                                        🟢 Facile
                                    </span>
                                @elseif($sortie->difficulty_level === 'moyen')
                                    <span class="px-3 py-1 bg-orange-500 text-white text-sm font-medium rounded-full">
                                        🟡 Moyen
                                    </span>
                                @elseif($sortie->difficulty_level === 'difficile')
                                    <span class="px-3 py-1 bg-red-500 text-white text-sm font-medium rounded-full">
                                        🔴 Difficile
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contenu principal -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Colonne principale -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Section description -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="text-3xl mr-3">📝</span>
                            Description de la sortie
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                            <p>{{ $sortie->description }}</p>
                        </div>
                    </div>

                    <!-- Commentaire personnel -->
                    @if($sortie->personal_comment)
                    <div class="bg-gradient-to-r from-outdoor-ochre-50 to-outdoor-olive-50 rounded-3xl p-8 border-l-4 border-outdoor-ochre-400">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="text-3xl mr-3">💭</span>
                            Mon expérience
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed italic">
                            <p>{{ $sortie->personal_comment }}</p>
                        </div>
                        @if($sortie->user)
                            <div class="mt-4 flex items-center text-sm text-gray-600">
                                <div class="w-6 h-6 rounded-full overflow-hidden ring-1 ring-gray-300 mr-2">
                                    <img 
                                        src="{{ (!empty($sortie->user->photo)) ? url('upload/user_images/'.$sortie->user->photo) : url('upload/no_image.jpg') }}" 
                                        alt="{{ $sortie->user->name }}" 
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                                <span>— {{ $sortie->user->name }}</span>
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Localisation -->
                    @if($sortie->departement || $sortie->pays)
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="text-3xl mr-3">📍</span>
                            Localisation
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($sortie->departement)
                                <div class="bg-outdoor-cream-50 rounded-2xl p-6 border border-outdoor-cream-200">
                                    <div class="flex items-center text-lg font-semibold text-outdoor-forest-700 mb-2">
                                        <span class="text-2xl mr-3">🏛️</span>
                                        Département
                                    </div>
                                    <p class="text-outdoor-forest-600 text-xl">{{ $sortie->departement }}</p>
                                </div>
                            @endif
                            @if($sortie->pays)
                                <div class="bg-outdoor-cream-50 rounded-2xl p-6 border border-outdoor-cream-200">
                                    <div class="flex items-center text-lg font-semibold text-outdoor-forest-700 mb-2">
                                        <span class="text-2xl mr-3">🌍</span>
                                        Pays
                                    </div>
                                    <p class="text-outdoor-forest-600 text-xl flex items-center">
                                        @if($sortie->pays === 'France')🇫🇷
                                        @elseif($sortie->pays === 'Allemagne')🇩🇪
                                        @elseif($sortie->pays === 'Suisse')🇨🇭
                                        @elseif($sortie->pays === 'Italie')🇮🇹
                                        @elseif($sortie->pays === 'Espagne')🇪🇸
                                        @elseif($sortie->pays === 'Autriche')🇦🇹
                                        @else🌍
                                        @endif
                                        <span class="ml-2">{{ $sortie->pays }}</span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Carte GPX -->
                    @if($sortie->gpxPoints && $sortie->gpxPoints->count() > 0)
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="text-3xl mr-3">🗺️</span>
                            Tracé GPS de la sortie
                        </h2>
                        <div class="relative">
                            <div id="map" class="w-full h-96 rounded-xl border border-gray-200"></div>
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-2 text-sm text-gray-700 z-10">
                                {{ $sortie->gpxPoints->count() }} points GPS
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Galerie photos -->
                    @if($sortie->images && $sortie->images->count() > 0)
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="text-3xl mr-3">📸</span>
                            Galerie photos ({{ $sortie->images->count() }})
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($sortie->images as $image)
                                <div class="relative group cursor-pointer rounded-xl overflow-hidden" 
                                     @click="openLightbox('{{ asset($image->image_path) }}', '{{ $image->caption ?? '' }}')">
                                    <img src="{{ $image->medium_image }}" 
                                         alt="{{ $image->caption ?? 'Photo de la sortie' }}"
                                         class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                                    @if($image->caption)
                                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3">
                                            <p class="text-white text-sm">{{ $image->caption }}</p>
                                        </div>
                                    @endif
                                    @if($image->is_featured)
                                        <div class="absolute top-2 left-2 bg-outdoor-ochre-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            ★ Principale
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="bg-white/90 rounded-full p-2">
                                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                </div>
                
                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Statistiques GPS -->
                    @if($sortie->distance_km || $sortie->elevation_gain_m || $sortie->estimated_duration_minutes || $sortie->actual_duration_minutes || ($sortie->weather_conditions && count($sortie->weather_conditions) > 0))
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="text-2xl mr-2">📊</span>
                            Statistiques
                        </h3>
                        <div class="space-y-4">
                            @if($sortie->distance_km)
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200">
                                    <div class="flex items-center">
                                        <span class="text-xl mr-3">📏</span>
                                        <span class="text-gray-600">Distance</span>
                                    </div>
                                    <span class="font-bold text-green-600">{{ number_format($sortie->distance_km, 1) }} km</span>
                                </div>
                            @endif
                            
                            @if($sortie->elevation_gain_m)
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl border border-orange-200">
                                    <div class="flex items-center">
                                        <span class="text-xl mr-3">⛰️</span>
                                        <span class="text-gray-600">Dénivelé</span>
                                    </div>
                                    <span class="font-bold text-orange-600">+{{ $sortie->elevation_gain_m }}m</span>
                                </div>
                            @endif
                            
                            {{-- Durée réelle (priorité) ou estimée --}}
                            @if($sortie->actual_duration_minutes)
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200">
                                    <div class="flex items-center">
                                        <span class="text-xl mr-3">⏰</span>
                                        <span class="text-gray-600">Durée réelle</span>
                                    </div>
                                    <span class="font-bold text-green-600">
                                        {{ floor($sortie->actual_duration_minutes / 60) }}h{{ $sortie->actual_duration_minutes % 60 > 0 ? sprintf('%02d', $sortie->actual_duration_minutes % 60) : '' }}
                                    </span>
                                </div>
                            @elseif($sortie->estimated_duration_minutes)
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                                    <div class="flex items-center">
                                        <span class="text-xl mr-3">⏱️</span>
                                        <span class="text-gray-600">Durée estimée</span>
                                    </div>
                                    <span class="font-bold text-blue-600">
                                        {{ floor($sortie->estimated_duration_minutes / 60) }}h{{ $sortie->estimated_duration_minutes % 60 > 0 ? sprintf('%02d', $sortie->estimated_duration_minutes % 60) : '' }}
                                    </span>
                                </div>
                            @endif
                            
                            {{-- Conditions météo --}}
                            @if($sortie->weather_conditions && count($sortie->weather_conditions) > 0)
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-sky-50 to-sky-100 rounded-xl border border-sky-200">
                                    <div class="flex items-center">
                                        <span class="text-xl mr-3">🌤️</span>
                                        <span class="text-gray-600">Conditions météo</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @php
                                            $weatherIcons = [
                                                'ensoleille' => ['☀️', 'Ensoleillé'],
                                                'nuageux' => ['☁️', 'Nuageux'],
                                                'pluie' => ['🌧️', 'Pluie'],
                                                'vent' => ['💨', 'Vent'],
                                                'brouillard' => ['🌫️', 'Brouillard'],
                                                'neige' => ['❄️', 'Neige'],
                                                'orage' => ['⛈️', 'Orage'],
                                                'chaud' => ['🥵', 'Très chaud'],
                                                'froid' => ['🥶', 'Très froid']
                                            ];
                                        @endphp
                                        @foreach($sortie->weather_conditions as $weather)
                                            @if(isset($weatherIcons[$weather]))
                                                <span class="inline-flex items-center gap-1 bg-white/60 px-2 py-1 rounded-lg text-xs font-medium text-sky-700" title="{{ $weatherIcons[$weather][1] }}">
                                                    <span>{{ $weatherIcons[$weather][0] }}</span>
                                                    <span>{{ $weatherIcons[$weather][1] }}</span>
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Actions -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="text-2xl mr-2">⚡</span>
                            Actions
                        </h3>
                        <div class="space-y-3">
                            @if($sortie->gpx_file_path)
                                <a href="{{ asset('storage/' . $sortie->gpx_file_path) }}" 
                                   download
                                   class="flex items-center justify-center w-full px-4 py-3 bg-gradient-to-r from-outdoor-olive-500 to-outdoor-forest-600 hover:from-outdoor-olive-600 hover:to-outdoor-forest-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Télécharger GPX
                                </a>
                            @endif
                            
                            <button @click="window.print()"
                                    class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Imprimer
                            </button>
                            
                            <button @click="shareContent()"
                                    class="flex items-center justify-center w-full px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold rounded-xl transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                                Partager
                            </button>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="text-2xl mr-2">🧭</span>
                            Navigation
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('sorties.index') }}" 
                               class="flex items-center w-full px-4 py-3 bg-outdoor-cream-100 hover:bg-outdoor-cream-200 text-outdoor-forest-700 font-medium rounded-xl transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                </svg>
                                Toutes les sorties
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Découvrez aussi -->
    @php
        $relatedSorties = \App\Models\Sortie::where('status', 'published')
            ->where('id', '!=', $sortie->id)
            ->with(['featuredImage', 'user'])
            ->limit(3)
            ->get();
    @endphp

    @if($relatedSorties->count() > 0)
    <section class="bg-gradient-to-br from-outdoor-cream-100 to-outdoor-olive-50 py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-outdoor-forest-800 mb-4">
                        Découvrez aussi
                    </h2>
                    <p class="text-outdoor-forest-600 text-lg">
                        D'autres sorties qui pourraient vous intéresser
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($relatedSorties as $relatedSortie)
                        <x-sortie-card :sortie="$relatedSortie" />
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Lightbox pour les images -->
    <div x-show="lightboxOpen" 
         x-cloak
         @click="closeLightbox()"
         @keydown.escape.window="closeLightbox()"
         class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <img :src="lightboxImage" 
                 :alt="lightboxCaption"
                 class="max-w-full max-h-full object-contain rounded-lg">
            <div x-show="lightboxCaption" class="absolute bottom-0 left-0 right-0 bg-black/70 text-white p-4 rounded-b-lg">
                <p x-text="lightboxCaption" class="text-center"></p>
            </div>
            <button @click="closeLightbox()" 
                    class="absolute top-4 right-4 text-white hover:text-gray-300 text-3xl font-bold">
                ×
            </button>
        </div>
    </div>
    
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
function sortieViewer() {
    return {
        lightboxOpen: false,
        lightboxImage: '',
        lightboxCaption: '',
        
        openLightbox(image, caption) {
            this.lightboxImage = image;
            this.lightboxCaption = caption;
            this.lightboxOpen = true;
        },
        
        closeLightbox() {
            this.lightboxOpen = false;
            this.lightboxImage = '';
            this.lightboxCaption = '';
        },
        
        shareContent() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $sortie->title }}',
                    text: '{{ Str::limit($sortie->description, 100) }}',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Lien copié dans le presse-papier !');
                });
            }
        }
    }
}

// Initialiser la carte si des points GPX existent
@if($sortie->gpxPoints && $sortie->gpxPoints->count() > 0)
document.addEventListener('DOMContentLoaded', function() {
    // Données des points GPX
    const gpxPoints = @json($sortie->gpxPoints->map(function($point) {
        return [
            'latitude' => $point->latitude,
            'longitude' => $point->longitude,
            'elevation' => $point->elevation
        ];
    }));

    if (gpxPoints.length > 0) {
        // Créer la carte
        const map = L.map('map').setView([gpxPoints[0].latitude, gpxPoints[0].longitude], 13);

        // Ajouter le layer de tuiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Créer le tracé
        const latlngs = gpxPoints.map(point => [point.latitude, point.longitude]);
        
        // Ajouter la polyline
        const polyline = L.polyline(latlngs, {
            color: '#059669',
            weight: 4,
            opacity: 0.8
        }).addTo(map);

        // Ajouter les marqueurs de début et fin
        L.marker([gpxPoints[0].latitude, gpxPoints[0].longitude])
            .addTo(map)
            .bindPopup('<strong>Départ</strong><br>Alt: ' + (gpxPoints[0].elevation || 'N/A') + 'm')
            .openPopup();

        if (gpxPoints.length > 1) {
            const lastPoint = gpxPoints[gpxPoints.length - 1];
            L.marker([lastPoint.latitude, lastPoint.longitude])
                .addTo(map)
                .bindPopup('<strong>Arrivée</strong><br>Alt: ' + (lastPoint.elevation || 'N/A') + 'm');
        }

        // Adapter la vue pour montrer tout le tracé
        map.fitBounds(polyline.getBounds(), { padding: [20, 20] });
    }
});
@endif
</script>
@endsection