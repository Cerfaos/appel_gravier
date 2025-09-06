@props(['ride'])

<div class="bg-gradient-to-br from-white via-outdoor-cream-50 to-white rounded-3xl shadow-2xl border-2 border-outdoor-forest-200/30 overflow-hidden hover:shadow-outdoor-brutal transition-all duration-500 group hover:-translate-y-2 hover:rotate-1 backdrop-blur-sm relative">
    {{-- Effet de brillance au hover --}}
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-outdoor-ochre-200/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
    
    {{-- Image de la sortie avec overlay dramatique --}}
    <div class="relative aspect-w-16 aspect-h-9 bg-gradient-to-br from-outdoor-forest-400 to-outdoor-forest-700 overflow-hidden">
        {{-- Overlay avec motif --}}
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-outdoor-forest-900/60 z-10"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M20 20c0 4.4-3.6 8-8 8s-8-3.6-8-8 3.6-8 8-8 8 3.6 8 8zm0-20c0 4.4-3.6 8-8 8s-8-3.6-8-8 3.6-8 8-8 8 3.6 8 8z"/%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        
        @if($ride->cover_image_path)
            <img src="{{ asset($ride->cover_image_path) }}" alt="{{ $ride->title }}" class="w-full h-48 object-cover rounded-t-lg">
        @else
            <div class="w-full h-56 bg-gradient-to-br from-outdoor-olive-500 via-outdoor-forest-600 to-outdoor-earth-700 flex items-center justify-center relative z-5">
                <div class="text-center text-white relative z-10">
                    <div class="text-6xl mb-3 filter drop-shadow-lg">🚴‍♂️</div>
                    <div class="text-lg font-bold tracking-wider">SORTIE VÉLO</div>
                    <div class="w-16 h-0.5 bg-outdoor-ochre-400 mx-auto mt-2"></div>
                </div>
            </div>
        @endif
        
        {{-- Date de la sortie --}}
        @if($ride->ride_date)
            <div class="absolute bottom-4 left-4 z-20">
                <div class="bg-outdoor-olive-600/95 text-white text-xs px-3 py-1.5 rounded-xl backdrop-blur-md border border-outdoor-olive-500/50 shadow-xl font-bold">
                    {{ \Carbon\Carbon::parse($ride->ride_date)->format('d/m/Y') }}
                </div>
            </div>
        @endif

        {{-- Nombre de médias --}}
        @if($ride->media_count > 0)
            <div class="absolute bottom-4 right-4 z-20">
                <div class="bg-outdoor-forest-800/95 text-outdoor-cream-100 text-xs px-3 py-1.5 rounded-xl backdrop-blur-md border border-outdoor-forest-600/50 shadow-xl font-bold flex items-center gap-1">
                    📸 {{ $ride->media_count }}
                </div>
            </div>
        @endif
    </div>

    {{-- Contenu de la carte --}}
    <div class="p-8 relative z-10">
        {{-- Titre et description --}}
        <div class="mb-6">
            <div class="flex items-start justify-between mb-3">
                <h3 class="text-2xl font-display font-black text-outdoor-forest-800 leading-tight line-clamp-2 group-hover:text-outdoor-olive-600 transition-colors duration-300 tracking-tight">
                    {{ $ride->title }}
                </h3>
                <div class="ml-3 w-8 h-8 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-ochre-600 rounded-full flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                    <span class="text-sm">🚴</span>
                </div>
            </div>
            
            @if($ride->experience)
                <p class="text-outdoor-forest-600 leading-relaxed line-clamp-3 font-medium">
                    {{ Str::limit($ride->experience, 130) }}
                </p>
            @endif
            
            {{-- Barre de séparation --}}
            <div class="w-full h-px bg-gradient-to-r from-transparent via-outdoor-forest-200 to-transparent my-4"></div>
        </div>

        {{-- Statistiques de la sortie --}}
        <div class="grid grid-cols-3 gap-4 mb-6">
            @if($ride->distance_km)
                <div class="group/stat relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-400 to-outdoor-olive-600 rounded-2xl blur-sm opacity-50"></div>
                    <div class="relative bg-gradient-to-br from-outdoor-olive-500 to-outdoor-olive-600 rounded-2xl p-4 text-center shadow-xl border border-outdoor-olive-400 transform group-hover/stat:scale-105 transition-all duration-300">
                        <div class="text-2xl font-black tracking-tighter text-outdoor-cream-50">
                            {{ number_format($ride->distance_km, 1) }}
                        </div>
                        <div class="text-xs font-bold tracking-widest uppercase text-outdoor-cream-100/90">KM</div>
                        <div class="absolute -top-2 -right-2 w-4 h-4 bg-outdoor-ochre-400 rounded-full"></div>
                    </div>
                </div>
            @endif

            @if($ride->elevation_gain_m)
                <div class="group/stat relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-earth-400 to-outdoor-earth-600 rounded-2xl blur-sm opacity-50"></div>
                    <div class="relative bg-gradient-to-br from-outdoor-earth-500 to-outdoor-earth-600 rounded-2xl p-4 text-center shadow-xl border border-outdoor-earth-400 transform group-hover/stat:scale-105 transition-all duration-300">
                        <div class="text-2xl font-black tracking-tighter text-outdoor-cream-50">
                            {{ number_format($ride->elevation_gain_m) }}
                        </div>
                        <div class="text-xs font-bold tracking-widest uppercase text-outdoor-cream-100/90">M</div>
                        <div class="absolute -top-2 -right-2 w-4 h-4 bg-outdoor-ochre-400 rounded-full"></div>
                    </div>
                </div>
            @endif

            @if($ride->moving_time_sec)
                <div class="group/stat relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-400 to-outdoor-ochre-600 rounded-2xl blur-sm opacity-50"></div>
                    <div class="relative bg-gradient-to-br from-outdoor-ochre-500 to-outdoor-ochre-600 rounded-2xl p-4 text-center shadow-xl border border-outdoor-ochre-400 transform group-hover/stat:scale-105 transition-all duration-300">
                        <div class="text-2xl font-black tracking-tighter text-outdoor-cream-50">
                            {{ gmdate('H:i', $ride->moving_time_sec) }}
                        </div>
                        <div class="text-xs font-bold tracking-widest uppercase text-outdoor-cream-100/90">TEMP</div>
                        <div class="absolute -top-2 -right-2 w-4 h-4 bg-outdoor-olive-400 rounded-full"></div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Météo si disponible --}}
        @if($ride->weather && is_array($ride->weather))
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-lg">🌤️</span>
                    <span class="text-sm font-semibold text-outdoor-forest-700">Conditions météo</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach(array_slice($ride->weather, 0, 3) as $condition)
                        <span class="inline-flex items-center px-2 py-1 bg-outdoor-cream-200 text-outdoor-forest-700 text-xs rounded-lg border border-outdoor-cream-300">
                            {{ $condition }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Bouton d'action --}}
        <div class="flex justify-center">
            <a href="{{ route('rides.show', $ride) }}" 
               class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-outdoor-olive-500 to-outdoor-olive-600 hover:from-outdoor-olive-600 hover:to-outdoor-olive-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 border-2 border-outdoor-olive-400">
                <span class="mr-2">Voir les détails</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>

    {{-- Effet de bordure au hover --}}
    <div class="absolute inset-0 border-2 border-transparent group-hover:border-outdoor-olive-300/50 rounded-3xl transition-all duration-500 pointer-events-none"></div>
</div>
