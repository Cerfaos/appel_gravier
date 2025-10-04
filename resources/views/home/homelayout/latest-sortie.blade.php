<!-- SECTION DERNIÈRE SORTIE - Pleine largeur avec image de fond -->
@if($latestSorties && $latestSorties->isNotEmpty())
@php
    $latestSortie = $latestSorties->first();
@endphp
<section class="fullpage-section relative min-h-screen text-white overflow-hidden">
    <!-- Image de fond de la sortie -->
    @if($latestSortie->featuredImage && $latestSortie->featuredImage->image_path)
        <div class="absolute inset-0 w-full h-full bg-no-repeat will-change-transform"
             style="background-image: url('{{ asset($latestSortie->featuredImage->image_path) }}');
                    background-size: cover;
                    background-position: center center;
                    background-attachment: scroll;">
        </div>
    @elseif($latestSortie->images && $latestSortie->images->isNotEmpty())
        <!-- Fallback: première image disponible -->
        <div class="absolute inset-0 w-full h-full bg-no-repeat will-change-transform"
             style="background-image: url('{{ asset($latestSortie->images->first()->image_path) }}');
                    background-size: cover;
                    background-position: center center;
                    background-attachment: scroll;">
        </div>
    @endif

    <!-- Overlay gradient pour lisibilité (inversé par rapport à l'article) -->
    <div class="absolute inset-0 bg-gradient-to-l from-black/70 via-black/50 to-black/30"></div>

    <!-- Contenu aligné à droite -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full min-h-screen flex items-center justify-end">
        <div class="max-w-2xl text-right">
            <!-- Badge difficulté -->
            @if($latestSortie->difficulty_level)
            <span class="inline-block px-4 py-2
                @if($latestSortie->difficulty_level == 'facile') bg-green-500/90
                @elseif($latestSortie->difficulty_level == 'moyen') bg-yellow-500/90
                @elseif($latestSortie->difficulty_level == 'difficile') bg-orange-500/90
                @else bg-red-500/90
                @endif
                backdrop-blur-sm text-white rounded-full text-sm font-semibold mb-4">
                {{ ucfirst($latestSortie->difficulty_level) }}
            </span>
            @endif

            <!-- Surtitre -->
            <p class="text-outdoor-sand-200 text-sm md:text-base uppercase tracking-wider mb-3">
                Dernière Sortie
            </p>

            <!-- Titre de la sortie -->
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 text-white">
                {{ $latestSortie->title }}
            </h2>

            <!-- Description courte -->
            @if($latestSortie->description)
            <p class="text-lg md:text-xl text-white/90 mb-8 leading-relaxed">
                {{ Str::limit($latestSortie->description, 150) }}
            </p>
            @endif

            <!-- Métadonnées de la sortie -->
            <div class="flex flex-wrap items-center justify-end gap-4 text-white/80 text-sm mb-8">
                <!-- Date -->
                @if($latestSortie->sortie_date)
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $latestSortie->sortie_date->format('d M Y') }}</span>
                </div>
                @endif

                <!-- Distance -->
                @if($latestSortie->distance_km)
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span>{{ number_format($latestSortie->distance_km, 1) }} km</span>
                </div>
                @endif

                <!-- Dénivelé -->
                @if($latestSortie->elevation_gain_m)
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span>{{ number_format($latestSortie->elevation_gain_m) }} m D+</span>
                </div>
                @endif

                <!-- Département -->
                @if($latestSortie->departement)
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $latestSortie->departement }}</span>
                </div>
                @endif
            </div>

            <!-- CTA Button -->
            <a href="{{ route('sorties.show', $latestSortie->slug) }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-white text-outdoor-forest-700 rounded-lg font-semibold shadow-xl hover:bg-outdoor-sand-100 hover:scale-105 transition-all duration-300 group">
                <span>Découvrir la sortie</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif
