@extends('home.body.home_master')

@section('title', $itinerary->meta_title ?: $itinerary->title . ' - Cerfaos')

@section('meta')
    <meta name="description" content="{{ $itinerary->meta_description ?: Str::limit($itinerary->description, 160) }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="{{ $itinerary->meta_title ?: $itinerary->title }}">
    <meta property="og:description" content="{{ $itinerary->meta_description ?: Str::limit($itinerary->description, 160) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($itinerary->featuredImage)
        <meta property="og:image" content="{{ asset($itinerary->featuredImage->image_path) }}">
    @endif
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $itinerary->meta_title ?: $itinerary->title }}">
    <meta name="twitter:description" content="{{ $itinerary->meta_description ?: Str::limit($itinerary->description, 160) }}">
    @if($itinerary->featuredImage)
        <meta name="twitter:image" content="{{ asset($itinerary->featuredImage->image_path) }}">
    @endif
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
<div x-data="itineraryViewer()" class="bg-gray-50 min-h-screen">
    
    <!-- Hero Section avec image principale -->
    <section class="relative h-96 lg:h-[500px] overflow-hidden">
        @if($itinerary->featuredImage)
            <img src="{{ asset($itinerary->featuredImage->image_path) }}" 
                 alt="{{ $itinerary->title }}" 
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
                                <a href="{{ route('itineraries.index') }}" class="hover:text-white transition-colors">🏔️ Itinéraires</a>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-white">{{ Str::limit($itinerary->title, 30) }}</span>
                            </li>
                        </ol>
                    </nav>
                    
                    <!-- Titre principal -->
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
                        {{ $itinerary->title }}
                    </h1>
                    
                    <!-- Métadonnées -->
                    <div class="flex flex-wrap items-center gap-4 text-white/90">
                        @if($itinerary->user)
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full overflow-hidden ring-1 ring-white/30">
                                    <img 
                                        src="{{ (!empty($itinerary->user->photo)) ? url('upload/user_images/'.$itinerary->user->photo) : url('upload/no_image.jpg') }}" 
                                        alt="{{ $itinerary->user->name }}" 
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                                <span>{{ $itinerary->user->name }}</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $itinerary->published_at->format('d M Y') }}</span>
                        </div>
                        
                        <!-- Badge de difficulté -->
                        @if($itinerary->difficulty_level)
                            <div class="flex items-center gap-2">
                                @if($itinerary->difficulty_level === 'facile')
                                    <span class="px-3 py-1 bg-green-500 text-white text-sm font-medium rounded-full">
                                        🟢 Facile
                                    </span>
                                @elseif($itinerary->difficulty_level === 'moyen')
                                    <span class="px-3 py-1 bg-yellow-500 text-white text-sm font-medium rounded-full">
                                        🟡 Moyen
                                    </span>
                                @elseif($itinerary->difficulty_level === 'difficile')
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
    <div class="container mx-auto px-4 py-8 lg:py-12">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-3 gap-8">
                
                <!-- Colonne principale - Article -->
                <div class="lg:col-span-2">
                    
                    <!-- Statistiques rapides si GPX disponible -->
                    @if($itinerary->gpx_file_path && ($itinerary->distance_km || $itinerary->elevation_gain_m))
                    <div class="card-outdoor mb-8">
                        <h3 class="text-lg font-semibold text-outdoor-forest-600 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-outdoor-olive-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            📊 Données du tracé
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @if($itinerary->distance_km)
                                <div class="text-center p-3 bg-outdoor-olive-50 rounded-lg">
                                    <div class="text-2xl mb-2">📏</div>
                                    <div class="font-bold text-lg text-outdoor-olive-600">{{ number_format($itinerary->distance_km, 1) }} km</div>
                                    <div class="text-sm text-outdoor-forest-500">Distance</div>
                                </div>
                            @endif
                            
                            @if($itinerary->elevation_gain_m)
                                <div class="text-center p-3 bg-outdoor-ochre-50 rounded-lg">
                                    <div class="text-2xl mb-2">⬆️</div>
                                    <div class="font-bold text-lg text-outdoor-ochre-600">+{{ $itinerary->elevation_gain_m }}m</div>
                                    <div class="text-sm text-outdoor-forest-500">Dénivelé +</div>
                                </div>
                            @endif
                            
                            @if($itinerary->elevation_loss_m)
                                <div class="text-center p-3 bg-outdoor-earth-50 rounded-lg">
                                    <div class="text-2xl mb-2">⬇️</div>
                                    <div class="font-bold text-lg text-outdoor-earth-600">-{{ $itinerary->elevation_loss_m }}m</div>
                                    <div class="text-sm text-outdoor-forest-500">Dénivelé -</div>
                                </div>
                            @endif
                            
                            @if($itinerary->estimated_duration_minutes)
                                <div class="text-center p-3 bg-outdoor-olive-50 rounded-xl border border-outdoor-olive-100">
                                    <div class="text-2xl mb-2">⏱️</div>
                                    <div class="font-bold text-lg text-outdoor-olive-600">
                                        {{ intval($itinerary->estimated_duration_minutes / 60) }}h{{ str_pad($itinerary->estimated_duration_minutes % 60, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="text-sm text-outdoor-forest-500">Durée estimée</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Description principale -->
                    <article class="card-outdoor mb-8">
                        <div class="prose prose-lg max-w-none">
                            <h2 class="text-2xl font-bold text-outdoor-forest-600 mb-4 flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-outdoor-olive-100 text-outdoor-olive-600 rounded-lg mr-3 text-lg">📝</span>
                                Description
                            </h2>
                            <div class="text-outdoor-forest-700 leading-relaxed whitespace-pre-wrap text-base">{{ $itinerary->description }}</div>
                        </div>
                    </article>

                    <!-- Commentaire personnel si présent -->
                    @if($itinerary->personal_comment)
                    <div class="bg-gradient-to-r from-outdoor-cream-50 to-outdoor-olive-50 rounded-2xl border border-outdoor-olive-100 p-6 lg:p-8 mb-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="text-4xl">💭</div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-outdoor-forest-600 mb-2">Retour d'expérience</h3>
                                <div class="text-outdoor-forest-700 leading-relaxed whitespace-pre-wrap">{{ $itinerary->personal_comment }}</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Carte interactive si GPX disponible -->
                    @if($itinerary->gpxPoints->count() > 0)
                    <div class="card-outdoor mb-8">
                        <h3 class="text-xl font-bold text-outdoor-forest-600 mb-4 flex items-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-outdoor-olive-100 text-outdoor-olive-600 rounded-lg mr-3 text-lg">🗺️</span>
                            Carte interactive
                        </h3>
                        <div id="itinerary-map" class="w-full h-96 rounded-lg overflow-hidden bg-gray-100"></div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <button @click="centerOnStart()" class="inline-flex items-center px-3 py-1 bg-outdoor-olive-100 text-outdoor-olive-700 text-sm font-medium rounded-full hover:bg-outdoor-olive-200 transition-colors">
                                🏁 Départ
                            </button>
                            <button @click="centerOnEnd()" class="inline-flex items-center px-3 py-1 bg-outdoor-earth-100 text-outdoor-earth-700 text-sm font-medium rounded-full hover:bg-outdoor-earth-200 transition-colors">
                                🏆 Arrivée
                            </button>
                            <button @click="fitToTrack()" class="inline-flex items-center px-3 py-1 bg-outdoor-olive-100 text-outdoor-olive-700 text-sm font-medium rounded-full hover:bg-outdoor-olive-200 transition-colors">
                                🔍 Vue complète
                            </button>
                        </div>
                    </div>
                    @endif

                    <!-- Galerie d'images -->
                    @if($itinerary->images->count() > 0)
                    <div class="card-outdoor mb-8">
                        <h3 class="text-xl font-bold text-outdoor-forest-600 mb-6 flex items-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-outdoor-ochre-100 text-outdoor-ochre-600 rounded-lg mr-3 text-lg">📷</span>
                            Galerie photos ({{ $itinerary->images->count() }} images)
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($itinerary->images as $image)
                                <div class="group cursor-pointer relative" @click="openImageModal('{{ $image->detail_image }}', '{{ $image->caption }}')">
                                    @if($image->is_featured)
                                        <div class="absolute top-2 left-2 z-10">
                                            <span class="px-2 py-1 bg-outdoor-olive-500 text-white text-xs font-medium rounded">⭐ Principale</span>
                                        </div>
                                    @endif
                                    <div class="aspect-w-16 aspect-h-10 bg-gray-200 rounded-lg overflow-hidden">
                                        <img src="{{ $image->main_image }}" 
                                             alt="{{ $image->caption ?: 'Photo de l\'itinéraire' }}" 
                                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    @if($image->caption)
                                        <p class="mt-2 text-sm text-gray-600">{{ $image->caption }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif


                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    
                    <!-- Actions rapides -->
                    <div class="card-outdoor mb-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-outdoor-forest-600 mb-4 flex items-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-outdoor-ochre-100 text-outdoor-ochre-600 rounded-lg mr-3 text-lg">⚡</span>
                            Actions rapides
                        </h3>
                        
                        <div class="space-y-3">
                            @if($itinerary->gpx_file_path)
                                <a href="{{ asset($itinerary->gpx_file_path) }}" 
                                   download 
                                   class="flex items-center justify-center w-full px-4 py-3 bg-outdoor-olive-500 hover:bg-outdoor-olive-600 text-white font-medium rounded-lg transition-colors">
                                    📥 Télécharger le GPX
                                </a>
                            @endif
                            
                            <button @click="shareItinerary()" 
                                    class="flex items-center justify-center w-full px-4 py-3 bg-outdoor-cream-100 hover:bg-outdoor-cream-200 text-outdoor-forest-700 font-medium rounded-lg transition-colors">
                                🔗 Partager
                            </button>
                            
                            <button @click="printItinerary()" 
                                    class="flex items-center justify-center w-full px-4 py-3 bg-outdoor-cream-100 hover:bg-outdoor-cream-200 text-outdoor-forest-700 font-medium rounded-lg transition-colors">
                                🖨️ Imprimer
                            </button>
                            
                            <a href="{{ route('itineraries.index') }}" 
                               class="flex items-center justify-center w-full px-4 py-3 bg-outdoor-cream-100 hover:bg-outdoor-cream-200 text-outdoor-forest-700 font-medium rounded-lg transition-colors">
                                ← Tous les itinéraires
                            </a>
                        </div>
                        
                        <!-- Informations complémentaires -->
                        <div class="mt-6 pt-6 border-t border-outdoor-cream-200">
                            <h4 class="font-medium text-outdoor-forest-600 mb-3">ℹ️ Informations</h4>
                            <div class="space-y-2 text-sm text-outdoor-forest-600">
                                <div class="flex justify-between">
                                    <span>Publié le</span>
                                    <span>{{ $itinerary->published_at->format('d/m/Y') }}</span>
                                </div>
                                @if($itinerary->updated_at->gt($itinerary->published_at))
                                    <div class="flex justify-between">
                                        <span>Mis à jour le</span>
                                        <span>{{ $itinerary->updated_at->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                                @if($itinerary->gpxPoints->count() > 0)
                                    <div class="flex justify-between">
                                        <span>Points GPS</span>
                                        <span>{{ number_format($itinerary->gpxPoints->count()) }}</span>
                                    </div>
                                @endif
                                @if($itinerary->user)
                                    <div class="flex justify-between">
                                        <span>Auteur</span>
                                        <span>{{ $itinerary->user->name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Autres itinéraires recommandés -->
                    @php
                        $relatedItineraries = App\Models\Itinerary::where('status', 'published')
                            ->where('id', '!=', $itinerary->id)
                            ->when($itinerary->difficulty_level, function($query, $difficulty) {
                                return $query->where('difficulty_level', $difficulty);
                            })
                            ->with('featuredImage')
                            ->limit(3)
                            ->get();
                    @endphp

                    <!-- Localisation -->
                    @if($itinerary->departement || $itinerary->pays)
                    <div class="card-outdoor mb-6">
                        <h3 class="text-lg font-semibold text-outdoor-forest-600 mb-4 flex items-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-outdoor-earth-100 text-outdoor-earth-600 rounded-lg mr-3 text-lg">📍</span>
                            Localisation
                        </h3>
                        
                        <div class="space-y-3">
                            @if($itinerary->departement)
                                <div class="flex items-center space-x-3 p-3 bg-outdoor-cream-50 rounded-lg">
                                    <div class="text-lg">🏞️</div>
                                    <div>
                                        <div class="text-sm text-outdoor-forest-500">Département</div>
                                        <div class="font-medium text-outdoor-forest-700">{{ $itinerary->departement }}</div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($itinerary->pays)
                                <div class="flex items-center space-x-3 p-3 bg-outdoor-cream-50 rounded-lg">
                                    <div class="text-lg">🌍</div>
                                    <div>
                                        <div class="text-sm text-outdoor-forest-500">Pays</div>
                                        <div class="font-medium text-outdoor-forest-700">{{ $itinerary->pays }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($relatedItineraries->count() > 0)
                    <div class="card-outdoor">
                        <h3 class="text-lg font-semibold text-outdoor-forest-600 mb-4 flex items-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-outdoor-olive-100 text-outdoor-olive-600 rounded-lg mr-3 text-lg">🧭</span>
                            Découvrez aussi
                        </h3>
                        
                        <div class="space-y-4">
                            @foreach($relatedItineraries as $related)
                                <a href="{{ route('itineraries.show', $related->slug) }}" 
                                   class="block group">
                                    <div class="flex space-x-3">
                                        @if($related->featuredImage)
                                            <img src="{{ asset($related->featuredImage->image_path) }}" 
                                                 alt="{{ $related->title }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-16 bg-outdoor-cream-100 rounded-lg flex items-center justify-center">
                                                🏔️
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-outdoor-forest-700 group-hover:text-outdoor-olive-600 transition-colors line-clamp-2">
                                                {{ $related->title }}
                                            </h4>
                                            <div class="flex items-center mt-1 space-x-2">
                                                @if($related->difficulty_level)
                                                    @if($related->difficulty_level === 'facile')
                                                        <span class="text-xs text-outdoor-olive-600 font-medium">🟢 Facile</span>
                                                    @elseif($related->difficulty_level === 'moyen')
                                                        <span class="text-xs text-outdoor-ochre-600 font-medium">🟡 Moyen</span>
                                                    @elseif($related->difficulty_level === 'difficile')
                                                        <span class="text-xs text-outdoor-earth-600 font-medium">🔴 Difficile</span>
                                                    @endif
                                                @endif
                                                @if($related->distance_km)
                                                    <span class="text-xs text-outdoor-forest-500">📏 {{ number_format($related->distance_km, 1) }} km</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal pour les images -->
<div x-show="showImageModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-black opacity-75" @click="closeImageModal()"></div>
        
        <div class="relative max-w-4xl max-h-full bg-white rounded-lg shadow-xl">
            <div class="absolute top-4 right-4 z-10">
                <button @click="closeImageModal()" 
                        class="text-white bg-black bg-opacity-50 hover:bg-opacity-75 rounded-full p-2 transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            
            <img :src="modalImage.src" :alt="modalImage.caption" class="w-full max-h-screen object-contain rounded-lg">
            
            <div x-show="modalImage.caption" class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4 rounded-b-lg">
                <p x-text="modalImage.caption" class="text-center"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
function itineraryViewer() {
    return {
        showImageModal: false,
        modalImage: { src: '', caption: '' },
        map: null,
        polyline: null,
        startMarker: null,
        endMarker: null,
        
        init() {
            this.initMap();
        },
        
        initMap() {
            @if($itinerary->gpxPoints->count() > 0)
            // Initialiser la carte
            this.map = L.map('itinerary-map');
            
            // Ajouter les tuiles OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(this.map);
            
            // Points GPS
            const gpxPoints = @json($itinerary->gpxPoints->map(function($point) {
                return [$point->latitude, $point->longitude, $point->elevation];
            }));
            
            if (gpxPoints.length > 0) {
                // Créer la polyline
                const latlngs = gpxPoints.map(point => [point[0], point[1]]);
                
                this.polyline = L.polyline(latlngs, {
                    color: '#606c38',
                    weight: 4,
                    opacity: 0.8
                }).addTo(this.map);
                
                // Marqueurs de départ et arrivée
                const startPoint = latlngs[0];
                const endPoint = latlngs[latlngs.length - 1];
                
                this.startMarker = L.marker(startPoint).addTo(this.map)
                    .bindPopup('🏁 Départ');
                
                this.endMarker = L.marker(endPoint).addTo(this.map)
                    .bindPopup('🏆 Arrivée');
                
                // Ajuster la vue sur le tracé
                this.map.fitBounds(this.polyline.getBounds(), {
                    padding: [20, 20]
                });
            }
            @endif
        },
        
        centerOnStart() {
            if (this.startMarker) {
                this.map.setView(this.startMarker.getLatLng(), 15);
                this.startMarker.openPopup();
            }
        },
        
        centerOnEnd() {
            if (this.endMarker) {
                this.map.setView(this.endMarker.getLatLng(), 15);
                this.endMarker.openPopup();
            }
        },
        
        fitToTrack() {
            if (this.polyline) {
                this.map.fitBounds(this.polyline.getBounds(), {
                    padding: [20, 20]
                });
            }
        },
        
        openImageModal(src, caption) {
            this.modalImage = { src, caption };
            this.showImageModal = true;
            document.body.classList.add('overflow-hidden');
        },
        
        closeImageModal() {
            this.showImageModal = false;
            document.body.classList.remove('overflow-hidden');
        },
        
        shareItinerary() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $itinerary->title }}',
                    text: '{{ Str::limit($itinerary->description, 100) }}',
                    url: window.location.href
                });
            } else {
                // Fallback : copier l'URL
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('🔗 URL copiée dans le presse-papiers !');
                });
            }
        },
        
        printItinerary() {
            window.print();
        }
    }
}
</script>

<style>
@media print {
    .bg-gray-50 {
        background: white !important;
    }
    
    .shadow-sm,
    .shadow-xl {
        box-shadow: none !important;
    }
    
    .sticky {
        position: static !important;
    }
}
</style>
@endpush