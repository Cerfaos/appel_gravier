@extends('admin.admin_master_outdoor')

@section('admin')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="page-content">
 <div class="container">

 <!-- start page title -->
 <div class="page-header">
     <div>
         <h4>Détail de la sortie/expédition</h4>
     </div>
     <div>
         <ol class="breadcrumb">
             <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
             <li><a href="{{ route('admin.all.sortie') }}">Sorties</a></li>
             <li>Détail</li>
         </ol>
     </div>
 </div>

 <!-- Informations principales -->
 <div class="content">
     <div>
         
         <!-- Carte -->
         @if($sortie->gpxPoints->count() > 0)
         <div class="card u-mt-4">
             <div class="card__header">
                 <h5>
                     <i data-feather="map"></i> Tracé GPX
                 </h5>
             </div>
             <div class="card__body">
                 <div id="map" style="height: 400px; border-radius: var(--radius-md);"></div>
             </div>
         </div>
         @endif

         <!-- Galerie d'images -->
         @if($sortie->images->count() > 0)
         <div class="card u-mt-4">
             <div class="card__header">
                 <h5>
                     <i data-feather="images"></i> Galerie ({{ $sortie->images->count() }} images)
                 </h5>
             </div>
             <div class="card__body">
                 <div class="u-grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: var(--sp-4);">
                     @foreach($sortie->images as $image)
                     <div style="position: relative; border-radius: var(--radius-md); overflow: hidden;">
                         <img src="{{ asset($image->image_path) }}" 
                              alt="Image de la sortie" 
                              style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;"
                              onclick="openImageModal('{{ asset($image->image_path) }}', '{{ $image->caption ?? '' }}')">
                         @if($image->is_featured)
                         <div class="badge badge--success" 
                              style="position: absolute; top: var(--sp-2); left: var(--sp-2);">
                             <i data-feather="star"></i> Principale
                         </div>
                         @endif
                         @if($image->caption)
                         <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: var(--sp-3); font-size: var(--font-size-sm);">
                             {{ $image->caption }}
                         </div>
                         @endif
                     </div>
                     @endforeach
                 </div>
             </div>
         </div>
         @endif

         <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--sp-6);">
             
             <!-- Colonne principale -->
             <div>
                 
                 <!-- Détails de la sortie -->
                 <div class="card">
                     <div class="card__header">
                         <div class="u-flex u-items-center u-gap-3">
                             <span style="font-size: 1.5rem;">🏕️</span>
                             <h5>{{ $sortie->title }}</h5>
                             @if($sortie->status === 'published')
                                 <span class="badge badge--success">
                                     <i data-feather="eye" style="width: 12px; height: 12px;"></i> Publiée
                                 </span>
                             @else
                                 <span class="badge badge--warning">
                                     <i data-feather="eye-off" style="width: 12px; height: 12px;"></i> Brouillon
                                 </span>
                             @endif
                         </div>
                     </div>
                     <div class="card__body">
                         
                         <!-- Description -->
                         <div class="u-mb-4">
                             <h6 style="color: var(--c-text-pri); margin-bottom: var(--sp-2);">
                                 <i data-feather="file-text"></i> Description
                             </h6>
                             <p style="line-height: 1.6;">{{ $sortie->description }}</p>
                         </div>

                         <!-- Commentaire personnel -->
                         @if($sortie->personal_comment)
                         <div class="u-mb-4">
                             <h6 style="color: var(--c-text-pri); margin-bottom: var(--sp-2);">
                                 <i data-feather="message-circle"></i> Commentaire personnel
                             </h6>
                             <div style="background: var(--c-bg-sec); border-left: 4px solid var(--c-accent); padding: var(--sp-4); border-radius: var(--radius-md);">
                                 <p style="line-height: 1.6; margin: 0;">{{ $sortie->personal_comment }}</p>
                             </div>
                         </div>
                         @endif

                         <!-- Localisation -->
                         @if($sortie->departement || $sortie->pays)
                         <div class="u-mb-4">
                             <h6 style="color: var(--c-text-pri); margin-bottom: var(--sp-2);">
                                 <i data-feather="map-pin"></i> Localisation
                             </h6>
                             <div class="u-flex u-gap-3">
                                 @if($sortie->departement)
                                 <span class="badge badge--info">
                                     🏛️ {{ $sortie->departement }}
                                 </span>
                                 @endif
                                 @if($sortie->pays)
                                 <span class="badge badge--secondary">
                                     @if($sortie->pays === 'France')🇫🇷
                                     @elseif($sortie->pays === 'Allemagne')🇩🇪
                                     @elseif($sortie->pays === 'Suisse')🇨🇭
                                     @elseif($sortie->pays === 'Italie')🇮🇹
                                     @elseif($sortie->pays === 'Espagne')🇪🇸
                                     @elseif($sortie->pays === 'Autriche')🇦🇹
                                     @else🌍
                                     @endif
                                     {{ $sortie->pays }}
                                 </span>
                                 @endif
                             </div>
                         </div>
                         @endif

                         <!-- Statistiques GPS -->
                         @if($sortie->distance_km || $sortie->elevation_gain_m || $sortie->estimated_duration_minutes)
                         <div>
                             <h6 style="color: var(--c-text-pri); margin-bottom: var(--sp-3);">
                                 <i data-feather="bar-chart-2"></i> Statistiques GPS
                             </h6>
                             <div class="u-grid" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: var(--sp-4);">
                                 
                                 @if($sortie->distance_km)
                                 <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: var(--sp-4); border-radius: var(--radius-md); text-align: center;">
                                     <div style="font-size: 1.5rem;">📏</div>
                                     <div style="font-size: 1.5rem; font-weight: 700; margin: var(--sp-2) 0;">{{ number_format($sortie->distance_km, 1) }}</div>
                                     <div style="font-size: var(--font-size-sm); opacity: 0.9;">Kilomètres</div>
                                 </div>
                                 @endif

                                 @if($sortie->elevation_gain_m)
                                 <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: var(--sp-4); border-radius: var(--radius-md); text-align: center;">
                                     <div style="font-size: 1.5rem;">⛰️</div>
                                     <div style="font-size: 1.5rem; font-weight: 700; margin: var(--sp-2) 0;">+{{ $sortie->elevation_gain_m }}</div>
                                     <div style="font-size: var(--font-size-sm); opacity: 0.9;">Dénivelé (m)</div>
                                 </div>
                                 @endif

                                 @if($sortie->estimated_duration_minutes)
                                 <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: var(--sp-4); border-radius: var(--radius-md); text-align: center;">
                                     <div style="font-size: 1.5rem;">⏱️</div>
                                     <div style="font-size: 1.5rem; font-weight: 700; margin: var(--sp-2) 0;">
                                         {{ floor($sortie->estimated_duration_minutes / 60) }}h{{ $sortie->estimated_duration_minutes % 60 > 0 ? sprintf('%02d', $sortie->estimated_duration_minutes % 60) : '' }}
                                     </div>
                                     <div style="font-size: var(--font-size-sm); opacity: 0.9;">Durée estimée</div>
                                 </div>
                                 @endif

                                 @if($sortie->gpxPoints->count() > 0)
                                 <div class="stat-card" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: var(--sp-4); border-radius: var(--radius-md); text-align: center;">
                                     <div style="font-size: 1.5rem;">📍</div>
                                     <div style="font-size: 1.5rem; font-weight: 700; margin: var(--sp-2) 0;">{{ $sortie->gpxPoints->count() }}</div>
                                     <div style="font-size: var(--font-size-sm); opacity: 0.9;">Points GPS</div>
                                 </div>
                                 @endif

                             </div>
                         </div>
                         @endif

                     </div>
                 </div>

             </div>

             <!-- Sidebar -->
             <div>
                 
                 <!-- Actions rapides -->
                 <div class="card">
                     <div class="card__header">
                         <h6>Actions</h6>
                     </div>
                     <div class="card__body">
                         <div class="u-space-y-3">
                             
                             @if($sortie->status === 'published')
                                 <a href="{{ route('sorties.show', $sortie->slug) }}" 
                                    target="_blank"
                                    class="btn btn-primary btn-block u-flex u-items-center u-gap-2">
                                     <i data-feather="external-link" style="width: 16px; height: 16px;"></i>
                                     Voir sur le site
                                 </a>
                             @endif
                             
                             <a href="{{ route('admin.edit.sortie', $sortie->id) }}" 
                                class="btn btn-secondary btn-block u-flex u-items-center u-gap-2">
                                 <i data-feather="edit" style="width: 16px; height: 16px;"></i>
                                 Modifier
                             </a>

                             @if($sortie->status === 'published')
                                 <form action="{{ route('admin.unpublish.sortie', $sortie->id) }}" method="POST">
                                     @csrf
                                     <button type="submit" 
                                             class="btn btn-warning btn-block u-flex u-items-center u-gap-2"
                                             onclick="return confirm('Voulez-vous dépublier cette sortie ?')">
                                         <i data-feather="eye-off" style="width: 16px; height: 16px;"></i>
                                         Dépublier
                                     </button>
                                 </form>
                             @else
                                 <form action="{{ route('admin.publish.sortie', $sortie->id) }}" method="POST">
                                     @csrf
                                     <button type="submit" 
                                             class="btn btn-success btn-block u-flex u-items-center u-gap-2"
                                             onclick="return confirm('Voulez-vous publier cette sortie ?')">
                                         <i data-feather="eye" style="width: 16px; height: 16px;"></i>
                                         Publier
                                     </button>
                                 </form>
                             @endif

                             @if($sortie->gpx_file_path)
                             <a href="{{ asset('storage/' . $sortie->gpx_file_path) }}" 
                                download 
                                class="btn btn-outline btn-block u-flex u-items-center u-gap-2">
                                 <i data-feather="download" style="width: 16px; height: 16px;"></i>
                                 Télécharger GPX
                             </a>
                             @endif

                         </div>
                     </div>
                 </div>

                 <!-- Informations -->
                 <div class="card u-mt-4">
                     <div class="card__header">
                         <h6>Informations</h6>
                     </div>
                     <div class="card__body">
                         <div class="u-space-y-3">
                             
                             <div class="u-flex u-justify-between u-items-center">
                                 <span class="u-text-muted">Difficulté:</span>
                                 @if($sortie->difficulty_level === 'facile')
                                     <span class="badge badge--success">🟢 Facile</span>
                                 @elseif($sortie->difficulty_level === 'moyen')
                                     <span class="badge badge--warning">🟡 Moyen</span>
                                 @elseif($sortie->difficulty_level === 'difficile')
                                     <span class="badge badge--danger">🔴 Difficile</span>
                                 @else
                                     <span class="u-text-muted">Non définie</span>
                                 @endif
                             </div>

                             <div class="u-flex u-justify-between u-items-center">
                                 <span class="u-text-muted">Créée le:</span>
                                 <span>{{ $sortie->created_at->format('d/m/Y à H:i') }}</span>
                             </div>

                             <div class="u-flex u-justify-between u-items-center">
                                 <span class="u-text-muted">Modifiée le:</span>
                                 <span>{{ $sortie->updated_at->format('d/m/Y à H:i') }}</span>
                             </div>

                             @if($sortie->published_at)
                             <div class="u-flex u-justify-between u-items-center">
                                 <span class="u-text-muted">Publiée le:</span>
                                 <span>{{ $sortie->published_at->format('d/m/Y à H:i') }}</span>
                             </div>
                             @endif

                             <div class="u-flex u-justify-between u-items-center">
                                 <span class="u-text-muted">Slug:</span>
                                 <code style="background: var(--c-bg-sec); padding: 0.2rem 0.4rem; border-radius: var(--radius-sm);">{{ $sortie->slug }}</code>
                             </div>

                             @if($sortie->user)
                             <div class="u-flex u-justify-between u-items-center">
                                 <span class="u-text-muted">Créée par:</span>
                                 <div class="u-flex u-items-center u-gap-2">
                                     <img src="{{ (!empty($sortie->user->photo)) ? url('upload/user_images/'.$sortie->user->photo) : url('upload/no_image.jpg') }}" 
                                          alt="{{ $sortie->user->name }}" 
                                          style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                                     <span>{{ $sortie->user->name }}</span>
                                 </div>
                             </div>
                             @endif

                         </div>
                     </div>
                 </div>

                 <!-- Coordonnées -->
                 @if($sortie->start_latitude && $sortie->start_longitude)
                 <div class="card u-mt-4">
                     <div class="card__header">
                         <h6>Coordonnées de départ</h6>
                     </div>
                     <div class="card__body">
                         <div class="u-space-y-2">
                             <div class="u-flex u-justify-between u-items-center">
                                 <span class="u-text-muted">Latitude:</span>
                                 <code style="background: var(--c-bg-sec); padding: 0.2rem 0.4rem; border-radius: var(--radius-sm);">{{ number_format($sortie->start_latitude, 6) }}</code>
                             </div>
                             <div class="u-flex u-justify-between u-items-center">
                                 <span class="u-text-muted">Longitude:</span>
                                 <code style="background: var(--c-bg-sec); padding: 0.2rem 0.4rem; border-radius: var(--radius-sm);">{{ number_format($sortie->start_longitude, 6) }}</code>
                             </div>
                         </div>
                     </div>
                 </div>
                 @endif

             </div>

         </div>

     </div>
 </div>

</div>

<!-- Modal pour les images -->
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 1000; cursor: pointer;" onclick="closeImageModal()">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%;">
        <img id="modalImage" style="max-width: 100%; max-height: 100%; border-radius: var(--radius-md);">
        <div id="modalCaption" style="color: white; text-align: center; padding: var(--sp-3); font-size: var(--font-size-lg);"></div>
    </div>
    <button onclick="closeImageModal()" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; color: white; font-size: 2rem; padding: 0.5rem 1rem; border-radius: 50%; cursor: pointer;">&times;</button>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Fonction pour ouvrir le modal d'image
function openImageModal(imageSrc, caption) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalCaption = document.getElementById('modalCaption');
    
    modalImage.src = imageSrc;
    modalCaption.textContent = caption;
    modal.style.display = 'block';
}

// Fonction pour fermer le modal d'image
function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}

// Initialiser la carte si des points GPX existent
@if($sortie->gpxPoints->count() > 0)
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
            color: '#3b82f6',
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

// Fermer le modal avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>

@endsection