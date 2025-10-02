@props(['sortie'])

<div class="bg-gradient-to-br from-white via-outdoor-cream-50 to-white rounded-3xl lg:rounded-3xl rounded-2xl shadow-lg lg:shadow-2xl border-2 border-outdoor-forest-200/30 overflow-hidden hover:shadow-outdoor-brutal transition-all duration-300 lg:duration-500 group lg:hover:-translate-y-2 lg:hover:rotate-1 backdrop-blur-sm relative">
    {{-- Effet de brillance au hover --}}
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-outdoor-ochre-200/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
    {{-- Image de la sortie avec overlay dramatique --}}
    <div class="relative aspect-w-16 aspect-h-9 bg-gradient-to-br from-outdoor-forest-400 to-outdoor-forest-700 overflow-hidden">
        {{-- Overlay avec motif --}}
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-outdoor-forest-900/60 z-10"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M20 20c0 4.4-3.6 8-8 8s-8-3.6-8-8 3.6-8 8-8 8 3.6 8 8zm0-20c0 4.4-3.6 8-8 8s-8-3.6-8-8 3.6-8 8-8 8 3.6 8 8z"/%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        
        @if($sortie->featuredImage && $sortie->featuredImage->image_path)
            <img src="{{ $sortie->featuredImage->medium_image }}"
                 alt="{{ $sortie->title }}"
                 loading="lazy"
                 class="w-full h-48 md:h-56 object-cover lg:group-hover:scale-110 transition-transform duration-500 relative z-5">
        @else
            <div class="w-full h-56 bg-gradient-to-br from-outdoor-olive-500 via-outdoor-forest-600 to-outdoor-earth-700 flex items-center justify-center relative z-5">
                <div class="text-center text-white relative z-10">
                    <div class="text-6xl mb-3 filter drop-shadow-lg">🏕️</div>
                    <div class="text-lg font-bold tracking-wider">EXPÉDITION OUTDOOR</div>
                    <div class="w-16 h-0.5 bg-outdoor-ochre-400 mx-auto mt-2"></div>
                </div>
            </div>
        @endif
        
        {{-- Badge de difficulté repositionné en bas de l'image --}}
        @if($sortie->difficulty_level)
            <div class="absolute bottom-4 left-4 z-20">
                @if($sortie->difficulty_level === 'facile')
                    <div class="relative">
                        <div class="absolute inset-0 bg-green-400 rounded-xl blur-sm"></div>
                        <span class="relative inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-black bg-green-500 text-white shadow-2xl border border-green-400 transform group-hover:scale-105 transition-transform duration-300">
                            ⚡ FACILE
                        </span>
                    </div>
                @elseif($sortie->difficulty_level === 'moyen')
                    <div class="relative">
                        <div class="absolute inset-0 bg-orange-400 rounded-xl blur-sm"></div>
                        <span class="relative inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-black bg-orange-500 text-white shadow-2xl border border-orange-400 transform group-hover:scale-105 transition-transform duration-300">
                            🔥 MOYEN
                        </span>
                    </div>
                @elseif($sortie->difficulty_level === 'difficile')
                    <div class="relative">
                        <div class="absolute inset-0 bg-red-400 rounded-xl blur-sm"></div>
                        <span class="relative inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-black bg-red-500 text-white shadow-2xl border border-red-400 transform group-hover:scale-105 transition-transform duration-300">
                            💀 EXPERT
                        </span>
                    </div>
                @endif
            </div>
        @endif

        {{-- Date de publication repositionnée en bas à droite --}}
        @if($sortie->published_at)
            <div class="absolute bottom-4 right-4 z-20">
                <div class="bg-outdoor-forest-800/95 text-outdoor-cream-100 text-xs px-3 py-1.5 rounded-xl backdrop-blur-md border border-outdoor-forest-600/50 shadow-xl font-bold">
                    {{ $sortie->published_at->format('d/m/Y') }}
                </div>
            </div>
        @endif
    </div>

    {{-- Contenu de la carte avec plus de punch --}}
    <div class="p-4 md:p-6 lg:p-8 relative z-10">
        {{-- Titre et description --}}
        <div class="mb-6">
            <div class="flex items-start justify-between mb-3">
                <h3 class="text-lg md:text-xl lg:text-2xl font-display font-black text-outdoor-forest-800 leading-tight line-clamp-2 lg:group-hover:text-outdoor-olive-600 transition-colors duration-300 tracking-tight">
                    {{ $sortie->title }}
                </h3>
                <div class="ml-3 w-8 h-8 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-ochre-600 rounded-full flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                    <span class="text-sm">🏕️</span>
                </div>
            </div>
            
            <p class="text-sm md:text-base text-outdoor-forest-600 leading-relaxed line-clamp-2 md:line-clamp-3 font-medium">
                {{ Str::limit($sortie->description, 130) }}
            </p>
            
            {{-- Barre de séparation --}}
            <div class="w-full h-px bg-gradient-to-r from-transparent via-outdoor-forest-200 to-transparent my-4"></div>
        </div>

        {{-- Statistiques impactantes --}}
        @if($sortie->distance_km || $sortie->elevation_gain_m || $sortie->estimated_duration_minutes)
        <div class="grid grid-cols-3 gap-2 md:gap-3 lg:gap-4 mb-4 md:mb-6">
            @if($sortie->distance_km)
                <div class="group/stat relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-400 to-outdoor-olive-600 rounded-2xl blur-sm opacity-50"></div>
                    <div class="relative bg-gradient-to-br from-outdoor-olive-500 to-outdoor-olive-600 rounded-lg md:rounded-xl lg:rounded-2xl p-2 md:p-3 lg:p-4 text-center shadow-lg md:shadow-xl border border-outdoor-olive-400 lg:transform lg:group-hover/stat:scale-105 transition-all duration-300">
                        <div class="text-lg md:text-xl lg:text-2xl font-black tracking-tighter text-outdoor-cream-50">
                            {{ number_format($sortie->distance_km, 1) }}
                        </div>
                        <div class="text-xs font-bold tracking-widest uppercase text-outdoor-cream-100/90">KM</div>
                        <div class="absolute -top-2 -right-2 w-4 h-4 bg-outdoor-ochre-400 rounded-full"></div>
                    </div>
                </div>
            @else
                <div class="bg-outdoor-cream-100 rounded-2xl p-4 text-center border-2 border-dashed border-outdoor-cream-300 opacity-60">
                    <div class="text-2xl font-black text-outdoor-forest-300">-</div>
                    <div class="text-xs font-bold tracking-widest uppercase text-outdoor-forest-400">KM</div>
                </div>
            @endif

            @if($sortie->elevation_gain_m)
                <div class="group/stat relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-earth-400 to-outdoor-earth-600 rounded-2xl blur-sm opacity-50"></div>
                    <div class="relative bg-gradient-to-br from-outdoor-earth-500 to-outdoor-earth-600 rounded-lg md:rounded-xl lg:rounded-2xl p-2 md:p-3 lg:p-4 text-center shadow-lg md:shadow-xl border border-outdoor-earth-400 lg:transform lg:group-hover/stat:scale-105 transition-all duration-300">
                        <div class="text-lg md:text-xl lg:text-2xl font-black tracking-tighter text-outdoor-cream-50">
                            +{{ $sortie->elevation_gain_m }}
                        </div>
                        <div class="text-xs font-bold tracking-widest uppercase text-outdoor-cream-100/90">D+</div>
                        <div class="absolute -top-2 -right-2 w-4 h-4 bg-outdoor-ochre-400 rounded-full hidden lg:block"></div>
                    </div>
                </div>
            @else
                <div class="bg-outdoor-cream-100 rounded-lg md:rounded-xl lg:rounded-2xl p-2 md:p-3 lg:p-4 text-center border-2 border-dashed border-outdoor-cream-300 opacity-60">
                    <div class="text-lg md:text-xl lg:text-2xl font-black text-outdoor-forest-300">-</div>
                    <div class="text-xs font-bold tracking-widest uppercase text-outdoor-forest-400">M</div>
                </div>
            @endif

            @if($sortie->estimated_duration_minutes)
                <div class="group/stat relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-ochre-600 rounded-2xl blur-sm opacity-50"></div>
                    <div class="relative bg-gradient-to-br from-outdoor-ochre-500 to-outdoor-ochre-600 rounded-lg md:rounded-xl lg:rounded-2xl p-2 md:p-3 lg:p-4 text-center shadow-lg md:shadow-xl border border-outdoor-ochre-400 lg:transform lg:group-hover/stat:scale-105 transition-all duration-300">
                        <div class="text-lg md:text-xl lg:text-2xl font-black tracking-tighter text-outdoor-cream-50">
                            {{ floor($sortie->estimated_duration_minutes / 60) }}h{{ $sortie->estimated_duration_minutes % 60 > 0 ? sprintf('%02d', $sortie->estimated_duration_minutes % 60) : '' }}
                        </div>
                        <div class="text-xs font-bold tracking-widest uppercase text-outdoor-cream-100/90">DURÉE</div>
                        <div class="absolute -top-2 -right-2 w-4 h-4 bg-outdoor-olive-400 rounded-full hidden lg:block"></div>
                    </div>
                </div>
            @else
                <div class="bg-outdoor-cream-100 rounded-lg md:rounded-xl lg:rounded-2xl p-2 md:p-3 lg:p-4 text-center border-2 border-dashed border-outdoor-cream-300 opacity-60">
                    <div class="text-lg md:text-xl lg:text-2xl font-black text-outdoor-forest-300">-</div>
                    <div class="text-xs font-bold tracking-widest uppercase text-outdoor-forest-400">H</div>
                </div>
            @endif
        </div>
        @endif

        {{-- Métadonnées stylées --}}
        <div class="flex items-center justify-between mb-6 px-2">
            @if($sortie->user)
                <div class="flex items-center bg-outdoor-cream-100 px-3 py-2 rounded-xl border border-outdoor-cream-200">
                    <div class="w-6 h-6 rounded-full overflow-hidden ring-1 ring-outdoor-forest-300 mr-2">
                        <img 
                            src="{{ (!empty($sortie->user->photo)) ? url('upload/user_images/'.$sortie->user->photo) : url('upload/no_image.jpg') }}" 
                            alt="{{ $sortie->user->name }}" 
                            class="w-full h-full object-cover"
                        >
                    </div>
                    <span class="text-sm font-bold text-outdoor-forest-700">{{ $sortie->user->name }}</span>
                </div>
            @endif
            
            @if($sortie->images->count() > 0)
                <div class="flex items-center bg-outdoor-ochre-100 px-3 py-2 rounded-xl border border-outdoor-ochre-200">
                    <div class="w-6 h-6 bg-gradient-to-br from-outdoor-ochre-500 to-outdoor-ochre-600 rounded-full flex items-center justify-center mr-2">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-outdoor-forest-700">{{ $sortie->images->count() }} photo{{ $sortie->images->count() > 1 ? 's' : '' }}</span>
                </div>
            @endif
        </div>

        {{-- Actions ultra-dynamiques --}}
        <div class="flex gap-4">
            <div class="flex-1 relative group/btn">
                <div class="absolute inset-0 bg-gradient-to-r from-outdoor-forest-600 to-outdoor-forest-800 rounded-2xl blur-sm group-hover/btn:blur-md transition-all duration-300"></div>
                <a href="{{ route('sorties.show', $sortie->slug) }}" 
                   class="relative flex items-center justify-center px-4 py-3 bg-gradient-to-r from-outdoor-forest-700 to-outdoor-forest-900 hover:from-outdoor-forest-800 hover:to-black text-white font-bold text-sm rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 hover:scale-105 border-2 border-outdoor-forest-600 group-hover/btn:border-outdoor-forest-400">
                    <span class="mr-2">🚀</span>
                    <span>DÉCOUVRIR</span>
                    <svg class="ml-2 w-4 h-4 group-hover/btn:translate-x-1 group-hover/btn:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            @if($sortie->gpx_file_path)
                <div class="relative group/gpx">
                    <div class="absolute inset-0 bg-gradient-to-r from-outdoor-olive-500 to-outdoor-olive-700 rounded-2xl blur-sm group-hover/gpx:blur-md transition-all duration-300"></div>
                    <a href="{{ asset('storage/' . $sortie->gpx_file_path) }}" 
                       download
                       class="relative inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-outdoor-olive-600 to-outdoor-olive-800 hover:from-outdoor-olive-700 hover:to-outdoor-olive-900 text-white font-bold rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 hover:scale-105 border-2 border-outdoor-olive-500 group-hover/gpx:border-outdoor-olive-300"
                       title="Télécharger le fichier GPX">
                        <span class="text-lg">📥</span>
                        <svg class="w-4 h-4 ml-1 group-hover/gpx:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>