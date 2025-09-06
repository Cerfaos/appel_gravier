@extends('home.body.home_master')

@section('title', 'Tous les itinéraires - Cerfaos')

@section('home')
<div class="min-h-screen bg-outdoor-cream-50">
    
    {{-- Hero Section Amélioré avec Image Bandeau --}}
    <section class="relative bg-gradient-to-br from-outdoor-olive-600 via-outdoor-olive-700 to-outdoor-forest-800 text-white py-20 lg:py-28 overflow-hidden">
        {{-- Image bandeau en arrière-plan --}}
        <div class="absolute inset-0">
            <img src="{{ asset('frontend/assets/images/img_cerfaos/bandeau_iti.png') }}" 
                 alt="Bandeau Itinéraires" 
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
                        <span class="animate-pulse">🗺️</span>
                        <span>{{ $itineraries->total() ?? 0 }} itinéraires disponibles</span>
                    </div>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-display font-bold mb-8 leading-tight">
                        
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-outdoor-ochre-400 to-outdoor-ochre-200">
                            Découvrez nos Itinéraires
                        </span>
                    </h1>
                    <p class="text-xl md:text-2xl text-outdoor-cream-100 leading-relaxed mb-12 max-w-4xl mx-auto">
                        Explorez notre collection complète d'itinéraires de randonnée et d'aventure outdoor. 
                        Chaque parcours est accompagné de son tracé GPX et de toutes les informations pratiques pour votre prochaine aventure.
                    </p>
                </div>

                {{-- Catégories avec animations --}}
                <div class="flex flex-wrap justify-center gap-4 mb-8" data-aos="fade-up" data-aos-delay="400">
                    <div class="group flex items-center px-6 py-3 bg-outdoor-olive-500/40 backdrop-blur-sm rounded-full hover:bg-outdoor-olive-500/60 transition-all duration-300 border border-outdoor-olive-400/30 hover:border-outdoor-olive-300/50 cursor-pointer">
                        <span class="text-2xl mr-3 group-hover:scale-110 transition-transform duration-300">🚶</span>
                        <span class="font-medium">Randonnée pédestre</span>
                    </div>
                    <div class="group flex items-center px-6 py-3 bg-outdoor-olive-500/40 backdrop-blur-sm rounded-full hover:bg-outdoor-olive-500/60 transition-all duration-300 border border-outdoor-olive-400/30 hover:border-outdoor-olive-300/50 cursor-pointer">
                        <span class="text-2xl mr-3 group-hover:scale-110 transition-transform duration-300">🚴</span>
                        <span class="font-medium">Cyclotourisme</span>
                    </div>
                    <div class="group flex items-center px-6 py-3 bg-outdoor-olive-500/40 backdrop-blur-sm rounded-full hover:bg-outdoor-olive-500/60 transition-all duration-300 border border-outdoor-olive-400/30 hover:border-outdoor-olive-300/50 cursor-pointer">
                        <span class="text-2xl mr-3 group-hover:scale-110 transition-transform duration-300">🏔️</span>
                        <span class="font-medium">Montagne</span>
                    </div>
                </div>

                {{-- CTA scroll hint --}}
                <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                    <div class="inline-flex flex-col items-center text-outdoor-cream-200 hover:text-white transition-colors cursor-pointer group">
                        <span class="text-sm font-medium mb-2">Parcourir les itinéraires</span>
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
        
        {{-- Filtres et recherche améliorés --}}
        <div class="max-w-6xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="200">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-outdoor-lg border border-outdoor-cream-200/60 p-8 lg:p-10 hover:shadow-outdoor-xl transition-all duration-300" x-data="itineraryFilters()">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-outdoor-olive-500 to-outdoor-forest-600 rounded-2xl flex items-center justify-center">
                            <span class="text-2xl">🔍</span>
                        </div>
                        <div>
                            <h2 class="text-2xl lg:text-3xl font-display font-bold text-outdoor-forest-700">
                                Trouvez votre aventure
                            </h2>
                            <p class="text-outdoor-forest-500 text-sm">Filtrez et découvrez l'itinéraire parfait</p>
                        </div>
                    </div>
                    <button @click="resetFilters()" 
                            class="inline-flex items-center space-x-2 px-4 py-2 text-sm text-outdoor-olive-600 hover:text-outdoor-olive-700 hover:bg-outdoor-olive-50 font-medium rounded-xl transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Réinitialiser</span>
                    </button>
                </div>
                
                <form method="GET" action="{{ route('itineraries.index') }}" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                        {{-- Recherche --}}
                        <div>
                            <label class="block text-sm font-medium text-outdoor-forest-700 mb-2">
                                🔎 Recherche
                            </label>
                            <input type="text" 
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Nom de l'itinéraire..."
                                   class="w-full rounded-xl border-outdoor-cream-300 shadow-outdoor-sm focus:border-outdoor-olive-500 focus:ring-outdoor-olive-500">
                        </div>
                        
                        
                        
                        {{-- Difficulté --}}
                        <div>
                            <label class="block text-sm font-medium text-outdoor-forest-700 mb-2">
                                ⛰️ Difficulté
                            </label>
                            <select name="difficulty" 
                                    class="w-full rounded-xl border-outdoor-cream-300 shadow-outdoor-sm focus:border-outdoor-olive-500 focus:ring-outdoor-olive-500">
                                <option value="">Toutes</option>
                                <option value="facile" {{ request('difficulty') === 'facile' ? 'selected' : '' }}>
                                    🟢 Facile
                                </option>
                                <option value="moyen" {{ request('difficulty') === 'moyen' ? 'selected' : '' }}>
                                    🟡 Moyen
                                </option>
                                <option value="difficile" {{ request('difficulty') === 'difficile' ? 'selected' : '' }}>
                                    🔴 Difficile
                                </option>
                            </select>
                        </div>
                        
                        {{-- Distance --}}
                        <div>
                            <label class="block text-sm font-medium text-outdoor-forest-700 mb-2">
                                📏 Distance
                            </label>
                            <select name="distance" 
                                    class="w-full rounded-xl border-outdoor-cream-300 shadow-outdoor-sm focus:border-outdoor-olive-500 focus:ring-outdoor-olive-500">
                                <option value="">Toutes</option>
                                <option value="0-5" {{ request('distance') === '0-5' ? 'selected' : '' }}>
                                    0 - 5 km
                                </option>
                                <option value="5-10" {{ request('distance') === '5-10' ? 'selected' : '' }}>
                                    5 - 10 km
                                </option>
                                <option value="10-20" {{ request('distance') === '10-20' ? 'selected' : '' }}>
                                    10 - 20 km
                                </option>
                                <option value="20-50" {{ request('distance') === '20-50' ? 'selected' : '' }}>
                                    20 - 50 km
                                </option>
                                <option value="50+" {{ request('distance') === '50+' ? 'selected' : '' }}>
                                    50+ km
                                </option>
                            </select>
                        </div>
                        
                        {{-- Tri --}}
                        <div>
                            <label class="block text-sm font-medium text-outdoor-forest-700 mb-2">
                                📊 Trier par
                            </label>
                            <select name="sort" 
                                    class="w-full rounded-xl border-outdoor-cream-300 shadow-outdoor-sm focus:border-outdoor-olive-500 focus:ring-outdoor-olive-500">
                                <option value="published_at_desc" {{ request('sort', 'published_at_desc') === 'published_at_desc' ? 'selected' : '' }}>
                                    Plus récents
                                </option>
                                <option value="published_at_asc" {{ request('sort') === 'published_at_asc' ? 'selected' : '' }}>
                                    Plus anciens
                                </option>
                                <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>
                                    Nom A-Z
                                </option>
                                <option value="distance_asc" {{ request('sort') === 'distance_asc' ? 'selected' : '' }}>
                                    Distance croissante
                                </option>
                                <option value="distance_desc" {{ request('sort') === 'distance_desc' ? 'selected' : '' }}>
                                    Distance décroissante
                                </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-3 justify-center">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-outdoor-olive-600 hover:bg-outdoor-olive-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-outdoor-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Filtrer
                        </button>
                        
                        @if(request()->hasAny(['search', 'departement', 'pays', 'difficulty', 'distance', 'sort']) && request('sort') !== 'published_at_desc')
                        <a href="{{ route('itineraries.index') }}" 
                           class="inline-flex items-center px-4 py-3 bg-outdoor-cream-200 hover:bg-outdoor-cream-300 text-outdoor-forest-700 font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Effacer
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Statistiques et résultats --}}
        <div class="max-w-6xl mx-auto">
            @if($itineraries->count() > 0)
                <div class="mb-8">
                    <div class="bg-outdoor-olive-100 border border-outdoor-olive-200 rounded-xl p-4">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl">📍</span>
                                <p class="text-outdoor-forest-700 font-medium">
                                    {{ $itineraries->total() }} itinéraire{{ $itineraries->total() > 1 ? 's' : '' }} trouvé{{ $itineraries->total() > 1 ? 's' : '' }}
                                    @if(request()->hasAny(['search', 'departement', 'pays', 'difficulty', 'distance']))
                                        <span class="text-outdoor-olive-600">avec vos critères</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="flex flex-wrap gap-3 text-sm">
                                @if(request('search'))
                                    <span class="inline-flex items-center px-3 py-1 bg-outdoor-olive-600 text-white rounded-full">
                                        🔎 {{ request('search') }}
                                    </span>
                                @endif
                                @if(request('departement'))
                                    <span class="inline-flex items-center px-3 py-1 bg-outdoor-olive-600 text-white rounded-full">
                                        🏞️ {{ request('departement') }}
                                    </span>
                                @endif
                                @if(request('pays'))
                                    <span class="inline-flex items-center px-3 py-1 bg-outdoor-olive-600 text-white rounded-full">
                                        🌍 {{ request('pays') }}
                                    </span>
                                @endif
                                @if(request('difficulty'))
                                    <span class="inline-flex items-center px-3 py-1 bg-outdoor-olive-600 text-white rounded-full">
                                        @if(request('difficulty') === 'facile') 🟢 
                                        @elseif(request('difficulty') === 'moyen') 🟡 
                                        @else 🔴 @endif
                                        {{ ucfirst(request('difficulty')) }}
                                    </span>
                                @endif
                                @if(request('distance'))
                                    <span class="inline-flex items-center px-3 py-1 bg-outdoor-olive-600 text-white rounded-full">
                                        📏 {{ request('distance') }} km
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Grille des itinéraires avec animations --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12" data-aos="fade-up" data-aos-delay="400">
                    @foreach($itineraries as $index => $itinerary)
                        <div data-aos="fade-up" data-aos-delay="{{ 100 + ($index % 6) * 100 }}">
                            <x-itinerary-card :itinerary="$itinerary" />
                        </div>
                    @endforeach
                </div>

                {{-- Pagination améliorée --}}
                <div class="flex justify-center" data-aos="fade-up" data-aos-delay="600">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-outdoor-lg border border-outdoor-cream-200/60 p-8 hover:shadow-outdoor-xl transition-all duration-300">
                        <div class="flex items-center justify-center space-x-2 mb-4">
                            <div class="w-2 h-2 bg-outdoor-olive-400 rounded-full"></div>
                            <div class="w-2 h-2 bg-outdoor-ochre-400 rounded-full"></div>
                            <div class="w-2 h-2 bg-outdoor-earth-400 rounded-full"></div>
                        </div>
                        {{ $itineraries->withQueryString()->links() }}
                    </div>
                </div>
                
            @else
                {{-- Message vide amélioré --}}
                <div class="text-center py-20" data-aos="fade-up">
                    <div class="bg-gradient-to-br from-white/90 to-outdoor-cream-50/90 backdrop-blur-sm rounded-3xl shadow-outdoor-xl border border-outdoor-cream-200/60 p-16 max-w-2xl mx-auto">
                        {{-- Animation d'émoji --}}
                        <div class="relative inline-block mb-8">
                            <div class="text-8xl animate-bounce">🏔️</div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-outdoor-ochre-400 rounded-full animate-pulse"></div>
                        </div>
                        
                        <h3 class="text-3xl font-display font-bold text-outdoor-forest-700 mb-6">
                            @if(request()->hasAny(['search', 'departement', 'pays', 'difficulty', 'distance']))
                                Aucune aventure trouvée 🧭
                            @else
                                Nos aventures arrivent bientôt ! ⏰
                            @endif
                        </h3>
                        
                        <p class="text-lg text-outdoor-forest-600 mb-10 leading-relaxed">
                            @if(request()->hasAny(['search', 'departement', 'pays', 'difficulty', 'distance']))
                                Aucun itinéraire ne correspond à vos critères de recherche. 
                                Essayez d'ajuster vos filtres pour découvrir de nouvelles possibilités d'aventure.
                            @else
                                Notre équipe d'explorateurs prépare soigneusement une collection exceptionnelle d'itinéraires outdoor. 
                                Revenez bientôt pour découvrir des parcours inoubliables !
                            @endif
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            @if(request()->hasAny(['search', 'departement', 'pays', 'difficulty', 'distance']))
                                <a href="{{ route('itineraries.index') }}" 
                                   class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-outdoor-olive-600 to-outdoor-olive-700 text-white font-semibold rounded-2xl hover:from-outdoor-olive-700 hover:to-outdoor-olive-800 transition-all duration-300 shadow-outdoor-md hover:shadow-outdoor-lg transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-3 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Voir tous les itinéraires
                                </a>
                            @endif
                            
                            <a href="{{ route('home') }}" 
                               class="group inline-flex items-center justify-center px-8 py-4 bg-outdoor-cream-200 hover:bg-outdoor-cream-300 text-outdoor-forest-700 font-semibold rounded-2xl transition-all duration-300 shadow-outdoor-sm hover:shadow-outdoor-md transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-3 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Retour à l'accueil
                            </a>
                        </div>

                        {{-- Suggestions d'actions --}}
                        @if(!request()->hasAny(['search', 'departement', 'pays', 'difficulty', 'distance']))
                            <div class="mt-10 pt-8 border-t border-outdoor-cream-200">
                                <p class="text-sm text-outdoor-forest-500 mb-4">En attendant, explorez :</p>
                                <div class="flex flex-wrap justify-center gap-3">
                                    <a href="{{ route('mon.histoire') }}" class="inline-flex items-center px-4 py-2 bg-outdoor-olive-100 hover:bg-outdoor-olive-200 text-outdoor-olive-700 text-sm rounded-full transition-colors">
                                        📖 Mon histoire
                                    </a>
                                    <a href="{{ route('mon.velo') }}" class="inline-flex items-center px-4 py-2 bg-outdoor-ochre-100 hover:bg-outdoor-ochre-200 text-outdoor-ochre-700 text-sm rounded-full transition-colors">
                                        🚴 Mon vélo
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- AOS Animation Library --}}
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
// Initialize AOS animations
AOS.init({
    duration: 800,
    easing: 'ease-out-cubic',
    once: true,
    offset: 50,
});

// Itinerary filters functionality
function itineraryFilters() {
    return {
        resetFilters() {
            // Reset all form fields
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[name="search"]');
            const selects = form.querySelectorAll('select');
            
            inputs.forEach(input => input.value = '');
            selects.forEach(select => select.selectedIndex = 0);
        }
    }
}

// Smooth scroll for CTA scroll hint
document.addEventListener('DOMContentLoaded', function() {
    const scrollHint = document.querySelector('.group');
    if (scrollHint) {
        scrollHint.addEventListener('click', function() {
            const filtersSection = document.querySelector('[data-aos="fade-up"][data-aos-delay="200"]');
            if (filtersSection) {
                filtersSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
});
</script>
@endsection