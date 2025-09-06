@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">🚴‍♂️</span>
      <div>
        <h1>{{ $ride->title }}</h1>
        <p>Détails de l'expédition du {{ $ride->ride_date->format('d/m/Y') }}</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('admin.rides.index') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour aux expéditions
      </a>
      <a href="{{ route('admin.rides.edit', $ride) }}" class="btn btn-primary u-flex u-items-center u-gap-2">
        <i data-feather="edit" style="width: 16px; height: 16px;"></i>
        Modifier
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('admin.rides.index') }}" class="breadcrumb__link">Expéditions</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">{{ $ride->title }}</span>
  </div>

  <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--cerfaos-space-8); align-items: start;">
    
    <!-- Contenu principal -->
    <div>
      
      <!-- Image de couverture -->
      @if($ride->cover_image_path)
      <div class="card" style="margin-bottom: var(--cerfaos-space-6);">
        <div class="card__content" style="padding: 0;">
          <img src="{{ asset($ride->cover_image_path) }}" 
               alt="Image de couverture - {{ $ride->title }}"
               style="width: 100%; height: 300px; object-fit: cover; border-radius: var(--cerfaos-radius-lg);">
        </div>
      </div>
      @endif

      <!-- Informations principales -->
      <div class="card" style="margin-bottom: var(--cerfaos-space-6);">
        <div class="card__header">
          <h2 class="card__title">
            <i data-feather="info"></i>
            Informations de l'Expédition
          </h2>
        </div>
        <div class="card__content">
          
          <!-- Statistiques en grille -->
          <div class="u-grid" style="grid-template-columns: repeat(4, 1fr); gap: var(--cerfaos-space-4); margin-bottom: var(--cerfaos-space-6);">
            <div style="text-align: center; padding: var(--cerfaos-space-4); background: var(--cerfaos-bg-subtle); border-radius: var(--cerfaos-radius-md);">
              <div style="font-size: 1.5rem;">📏</div>
              <div style="font-size: var(--cerfaos-font-size-xl); font-weight: 700; color: var(--cerfaos-accent);">
                {{ number_format($ride->distance_km, 1) }}
              </div>
              <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">km</div>
            </div>
            
            <div style="text-align: center; padding: var(--cerfaos-space-4); background: var(--cerfaos-bg-subtle); border-radius: var(--cerfaos-radius-md);">
              <div style="font-size: 1.5rem;">⛰️</div>
              <div style="font-size: var(--cerfaos-font-size-xl); font-weight: 700; color: var(--cerfaos-success);">
                {{ $ride->elevation_gain_m }}
              </div>
              <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">m D+</div>
            </div>
            
            <div style="text-align: center; padding: var(--cerfaos-space-4); background: var(--cerfaos-bg-subtle); border-radius: var(--cerfaos-radius-md);">
              <div style="font-size: 1.5rem;">⏱️</div>
              <div style="font-size: var(--cerfaos-font-size-xl); font-weight: 700; color: var(--cerfaos-warning);">
                {{ $ride->moving_time_hms }}
              </div>
              <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">temps</div>
            </div>
            
            <div style="text-align: center; padding: var(--cerfaos-space-4); background: var(--cerfaos-bg-subtle); border-radius: var(--cerfaos-radius-md);">
              <div style="font-size: 1.5rem;">🚀</div>
              <div style="font-size: var(--cerfaos-font-size-xl); font-weight: 700; color: var(--cerfaos-info);">
                {{ number_format($ride->avg_speed_kmh, 1) }}
              </div>
              <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">km/h</div>
            </div>
          </div>

          <!-- Retour d'expérience -->
          @if($ride->experience)
          <div style="margin-bottom: var(--cerfaos-space-6);">
            <h6 style="margin-bottom: var(--cerfaos-space-3); display: flex; align-items: center; gap: var(--cerfaos-space-2);">
              <span>✨</span> Retour d'Expérience
            </h6>
            <div style="background: var(--cerfaos-bg-subtle); padding: var(--cerfaos-space-4); border-radius: var(--cerfaos-radius-md); border-left: 4px solid var(--cerfaos-accent);">
              {!! nl2br(e($ride->experience)) !!}
            </div>
          </div>
          @endif

          <!-- Fichier GPX -->
          @if($ride->gpx_path)
          <div style="margin-bottom: var(--cerfaos-space-6);">
            <div class="u-flex u-items-center u-justify-between u-gap-4">
              <h6 style="display: flex; align-items: center; gap: var(--cerfaos-space-2); margin: 0;">
                <span>🗺️</span> Fichier GPX
              </h6>
              <a href="{{ asset($ride->gpx_path) }}" 
                 download 
                 class="btn btn-sm btn-secondary u-flex u-items-center u-gap-2">
                <i data-feather="download" style="width: 14px; height: 14px;"></i>
                {{ basename($ride->gpx_path) }}
              </a>
            </div>
            
            <div class="card" style="margin-top: var(--cerfaos-space-4);">
              <div class="card__content" style="padding: 0;">
                <div id="gpx-map-{{ $ride->id }}" style="height: 400px; border-radius: var(--cerfaos-radius-lg);"></div>
              </div>
            </div>
          </div>
          @endif

        </div>
      </div>

      <!-- Galerie d'images -->
      @if($ride->media && $ride->media->count() > 0)
      <div class="card">
        <div class="card__header">
          <h2 class="card__title">
            <i data-feather="images"></i>
            Galerie ({{ $ride->media->count() }} média{{ $ride->media->count() > 1 ? 's' : '' }})
          </h2>
        </div>
        <div class="card__content">
          <div class="u-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--cerfaos-space-4);">
            @foreach($ride->media as $media)
            <div style="position: relative;">
              <img src="{{ asset($media->file_path) }}" 
                   alt="Media {{ $media->id }}"
                   style="width: 100%; height: 150px; object-fit: cover; border-radius: var(--cerfaos-radius-md);">
              <div style="position: absolute; top: var(--cerfaos-space-2); right: var(--cerfaos-space-2);">
                <span class="badge badge--secondary">#{{ $media->order }}</span>
              </div>
              @if($media->width && $media->height)
              <div style="position: absolute; bottom: var(--cerfaos-space-2); left: var(--cerfaos-space-2);">
                <span class="badge badge--muted">{{ $media->width }}×{{ $media->height }}</span>
              </div>
              @endif
            </div>
            @endforeach
          </div>
        </div>
      </div>
      @endif

    </div>

    <!-- Sidebar -->
    <div>
      
      <!-- Informations techniques -->
      <div class="card" style="margin-bottom: var(--cerfaos-space-6);">
        <div class="card__header">
          <h3 class="card__title u-flex u-items-center u-gap-2">
            <span>📊</span>
            Informations Techniques
          </h3>
        </div>
        <div class="card__content u-space-y-3">
          <div class="u-flex u-justify-between u-items-center">
            <span class="u-text-sm u-text-muted">ID:</span>
            <span class="badge badge--secondary">#{{ $ride->id }}</span>
          </div>
          <div class="u-flex u-justify-between u-items-center">
            <span class="u-text-sm u-text-muted">📅 Date:</span>
            <span class="badge badge--info">{{ $ride->ride_date->format('d/m/Y') }}</span>
          </div>
          <div class="u-flex u-justify-between u-items-center">
            <span class="u-text-sm u-text-muted">👤 Auteur:</span>
            <span class="badge badge--muted">{{ $ride->user->name ?? 'N/A' }}</span>
          </div>
          <div class="u-flex u-justify-between u-items-center">
            <span class="u-text-sm u-text-muted">🔗 Slug:</span>
            <span style="font-family: monospace; font-size: var(--cerfaos-font-size-xs);">{{ $ride->slug }}</span>
          </div>
          @if($ride->gpx_path)
          <div class="u-flex u-justify-between u-items-center">
            <span class="u-text-sm u-text-muted">🗺️ GPX:</span>
            <span class="badge badge--success">Présent</span>
          </div>
          @endif
          <div class="u-flex u-justify-between u-items-center">
            <span class="u-text-sm u-text-muted">📅 Créé le:</span>
            <span class="badge badge--warning">{{ $ride->created_at->format('d/m/Y') }}</span>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="card">
        <div class="card__header">
          <h3 class="card__title u-flex u-items-center u-gap-2">
            <span>⚡</span>
            Actions
          </h3>
        </div>
        <div class="card__content u-space-y-3">
          <a href="{{ route('rides.show', $ride) }}" 
             target="_blank"
             class="btn btn-sm btn-info u-flex u-items-center u-gap-2 u-w-full">
            <i data-feather="external-link" style="width: 14px; height: 14px;"></i>
            Voir sur le site
          </a>
          
          <a href="{{ route('admin.rides.edit', $ride) }}" 
             class="btn btn-sm btn-secondary u-flex u-items-center u-gap-2 u-w-full">
            <i data-feather="edit" style="width: 14px; height: 14px;"></i>
            Modifier l'expédition
          </a>
          
          <form action="{{ route('admin.rides.destroy', $ride) }}" 
                method="POST"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette expédition ? Cette action est irréversible.')"
                class="u-w-full">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="btn btn-sm btn-danger u-flex u-items-center u-gap-2 u-w-full">
              <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
              Supprimer l'expédition
            </button>
          </form>
        </div>
      </div>

    </div>
    
  </div>

</div>

@if($ride->gpx_path)
<!-- Scripts pour la carte GPX -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialiser la carte GPX
  var map = L.map('gpx-map-{{ $ride->id }}');
  
  // Ajouter les tuiles OpenStreetMap
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 18
  }).addTo(map);
  
  // Charger le contenu GPX directement depuis le serveur
  try {
    @php
    // Le chemin dans la DB est 'storage/rides/gpx/file.gpx'
    // Il faut le convertir vers 'storage/app/public/rides/gpx/file.gpx'
    $relativePath = str_replace('storage/', '', $ride->gpx_path);
    $gpxPath = storage_path('app/public/' . $relativePath);
    
    if (file_exists($gpxPath)) {
      $gpxContent = file_get_contents($gpxPath);
      echo "var gpxContent = " . json_encode($gpxContent) . ";";
    } else {
      echo "var gpxContent = null;";
    }
    @endphp
    
    if (gpxContent) {
      const parser = new DOMParser();
      const gpxDoc = parser.parseFromString(gpxContent, 'text/xml');
      
      // Extraire les points de track
      const trackPoints = gpxDoc.querySelectorAll('trkpt');
      const coordinates = [];
      
      trackPoints.forEach(point => {
        const lat = parseFloat(point.getAttribute('lat'));
        const lon = parseFloat(point.getAttribute('lon'));
        coordinates.push([lat, lon]);
      });
      
      if (coordinates.length > 0) {
        // Créer la polyline du tracé
        const trackLine = L.polyline(coordinates, {
          color: 'var(--cerfaos-accent)',
          weight: 4,
          opacity: 0.8
        }).addTo(map);
        
        // Ajuster la vue sur le tracé
        map.fitBounds(trackLine.getBounds(), {
          padding: [20, 20]
        });
        
        // Ajouter des marqueurs de début et fin
        if (coordinates.length > 1) {
          // Marqueur de début (vert)
          L.marker(coordinates[0], {
            icon: L.divIcon({
              className: 'custom-marker',
              html: '<div style="background: var(--cerfaos-success); width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
              iconSize: [20, 20],
              iconAnchor: [10, 10]
            })
          }).addTo(map).bindPopup('🏁 Départ de l\'expédition');
          
          // Marqueur de fin (rouge)
          L.marker(coordinates[coordinates.length - 1], {
            icon: L.divIcon({
              className: 'custom-marker',
              html: '<div style="background: var(--cerfaos-danger); width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
              iconSize: [20, 20],
              iconAnchor: [10, 10]
            })
          }).addTo(map).bindPopup('🎯 Arrivée de l\'expédition');
        }
        
        // Ajouter des informations sur le tracé
        const distance = {{ $ride->distance_km ?? 0 }};
        const elevation = {{ $ride->elevation_gain_m ?? 0 }};
        
        trackLine.bindPopup(`
          <div style="font-family: var(--cerfaos-font-family); padding: var(--cerfaos-space-2);">
            <h6 style="margin: 0 0 var(--cerfaos-space-2) 0;">🚴‍♂️ {{ $ride->title }}</h6>
            <p style="margin: 0;"><strong>📏 Distance:</strong> ${distance} km</p>
            <p style="margin: 0;"><strong>⛰️ Dénivelé:</strong> ${elevation} m</p>
          </div>
        `);
      }
    } else {
      // Fallback : centrer sur la France
      map.setView([46.603354, 1.888334], 6);
      
      L.marker([46.603354, 1.888334]).addTo(map)
        .bindPopup('<div style="text-align: center;"><h6>🗺️ Fichier GPX introuvable</h6><small>Le fichier GPX n\'a pas pu être chargé</small></div>')
        .openPopup();
    }
  } catch (error) {
    console.error('Error in GPX processing:', error);
    
    // Fallback : centrer sur la France
    map.setView([46.603354, 1.888334], 6);
    
    L.marker([46.603354, 1.888334]).addTo(map)
      .bindPopup('<div style="text-align: center;"><h6>❌ Erreur GPX</h6><small>Erreur lors du traitement du fichier</small></div>')
      .openPopup();
  }
});
</script>
@endif

@endsection