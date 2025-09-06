@extends('admin.admin_master_outdoor')

@section('admin')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="page-content">
 <div class="container">

 <!-- start page title -->
 <div class="page-header">
     <div>
         <h4>Détail de l'itinéraire</h4>
     </div>
     <div>
         <ol class="breadcrumb">
             <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
             <li><a href="{{ route('admin.all.itinerary') }}">Itinéraires</a></li>
             <li>Détail</li>
         </ol>
     </div>
 </div>

 <!-- Informations principales -->
 <div class="content">
     <div>
         
         <!-- Carte -->
         @if($itinerary->gpxPoints->count() > 0)
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
         @if($itinerary->images->count() > 0)
         <div class="card u-mt-4">
             <div class="card__header">
                 <h5>
                     <i data-feather="images"></i> Galerie ({{ $itinerary->images->count() }} images)
                 </h5>
             </div>
             <div class="card__body">
                 <div class="u-grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: var(--sp-4);">
                     @foreach($itinerary->images as $image)
                     <div>
                         <div class="card" style="overflow: hidden;">
                             <img src="{{ asset($image->image_path) }}" 
                                  style="width: 100%; height: 150px; object-fit: cover; cursor: pointer;"
                                  alt="Image {{ $loop->iteration }}"
                                  onclick="showImageModal('{{ asset($image->image_path) }}', '{{ $image->caption }}')"
                             @if($image->is_featured)
                             <div style="position: absolute; top: var(--sp-2); right: var(--sp-2);">
                                 <span class="badge badge--gold">★ Principale</span>
                             </div>
                             @endif
                             @if($image->caption)
                             <div class="card__footer">
                                 <small>{{ $image->caption }}</small>
                             </div>
                             @endif
                         </div>
                     </div>
                     @endforeach
                 </div>
             </div>
         </div>
         @endif

         <!-- Description -->
         <div class="card u-mt-4">
             <div class="card__header">
                 <h5>
                     <i data-feather="info"></i> Description
                 </h5>
             </div>
             <div class="card__body">
                 <div class="u-mt-4">
                     <h6>Description :</h6>
                     <p>{{ $itinerary->description }}</p>
                 </div>
                 
                 @if($itinerary->personal_comment)
                 <div class="u-mt-4">
                     <h6>Commentaire personnel :</h6>
                     <p style="font-style: italic; color: var(--c-text-mut);">{{ $itinerary->personal_comment }}</p>
                 </div>
                 @endif
             </div>
         </div>

     <div>
         
         <!-- Actions -->
         <div class="card u-mt-4">
             <div class="card__header">
                 <h6>Actions</h6>
             </div>
             <div class="card__body">
                 <div class="u-flex u-gap-4">
                     <a href="{{ route('admin.edit.itinerary', $itinerary->id) }}" class="btn btn-primary">
                         <i data-feather="edit"></i> Modifier
                     </a>
                     
                     <a href="{{ route('admin.all.itinerary') }}" class="btn btn-secondary">
                         <i data-feather="arrow-left"></i> Retour à la liste
                     </a>
                     
                     @if($itinerary->status === 'published')
                     <a href="{{ route('itineraries.show', $itinerary->slug) }}" 
                        target="_blank" 
                        class="btn btn--outline">
                         <i data-feather="external-link"></i> Voir sur le site
                     </a>
                     @endif
                 </div>
             </div>
         </div>

         <!-- Informations générales -->
         <div class="card u-mt-4">
             <div class="card__header">
                 <h6>Informations générales</h6>
             </div>
             <div class="card__body">
                 <div class="u-flex u-gap-4" style="flex-direction: column;">
                     <div><strong>Titre :</strong><br>{{ $itinerary->title }}</div>
                     <div><strong>Slug :</strong><br><code>{{ $itinerary->slug }}</code></div>
                     <div><strong>Difficulté :</strong><br>
                         @if($itinerary->difficulty_level === 'facile')
                         <span class="badge badge--gold">Facile</span>
                         @elseif($itinerary->difficulty_level === 'moyen')
                         <span class="badge badge--bronze">Moyen</span>
                         @elseif($itinerary->difficulty_level === 'difficile')
                         <span class="badge badge--danger">Difficile</span>
                         @endif
                     </div>
                     <div><strong>Statut :</strong><br>
                         @if($itinerary->status === 'published')
                         <span class="badge badge--gold">Publié</span>
                         @else
                         <span class="badge badge--bronze">Brouillon</span>
                         @endif
                     </div>
                     <div><strong>Auteur :</strong><br>{{ $itinerary->user->name ?? 'Inconnu' }}</div>
                 </div>
             </div>
         </div>

         <!-- Statistiques GPX -->
         @if($itinerary->gpx_file_path)
         <div class="card u-mt-4">
             <div class="card__header">
                 <h6>Statistiques GPX</h6>
             </div>
             <div class="card__body">
                 <div class="u-flex u-gap-4" style="flex-direction: column;">
                     @if($itinerary->distance_km)
                     <div class="u-flex u-gap-2">
                         <i data-feather="map" style="color: var(--c-gold);"></i>
                         <strong>Distance :</strong> {{ number_format($itinerary->distance_km, 2) }} km
                     </div>
                     @endif
                     @if($itinerary->elevation_gain_m)
                     <div class="u-flex u-gap-2">
                         <i data-feather="mountain" style="color: var(--c-success);"></i>
                         <strong>D+ :</strong> {{ $itinerary->elevation_gain_m }}m
                     </div>
                     @endif
                     @if($itinerary->elevation_loss_m)
                     <div class="u-flex u-gap-2">
                         <i data-feather="mountain" style="color: var(--c-info);"></i>
                         <strong>D- :</strong> -{{ $itinerary->elevation_loss_m }}m
                     </div>
                     @endif
                     @if($itinerary->estimated_duration_minutes)
                     <div class="u-flex u-gap-2">
                         <i data-feather="clock" style="color: var(--c-bronze);"></i>
                         <strong>Durée estimée :</strong> {{ intval($itinerary->estimated_duration_minutes / 60) }}h{{ $itinerary->estimated_duration_minutes % 60 }}min
                     </div>
                     @endif
                     @if($itinerary->gpxPoints->count() > 0)
                     <div class="u-flex u-gap-2">
                         <i data-feather="map-pin" style="color: var(--c-info);"></i>
                         <strong>Points GPS :</strong> {{ $itinerary->gpxPoints->count() }}
                     </div>
                     @endif
                 </div>
             </div>
         </div>
         @endif

         <!-- Métadonnées -->
         <div class="card u-mt-4">
             <div class="card__header">
                 <h6>Métadonnées</h6>
             </div>
             <div class="card__body">
                 <div class="u-flex u-gap-4" style="flex-direction: column;">
                     <div><strong>Créé le :</strong><br>{{ $itinerary->created_at->format('d/m/Y à H:i') }}</div>
                     <div><strong>Modifié le :</strong><br>{{ $itinerary->updated_at->format('d/m/Y à H:i') }}</div>
                     @if($itinerary->published_at)
                     <div><strong>Publié le :</strong><br>{{ $itinerary->published_at->format('d/m/Y à H:i') }}</div>
                     @endif
                 </div>
             </div>
         </div>
     </div>
 </div>
 </div>
</div>

<!-- Modal pour afficher les images en grand -->
<div class="modal fade" id="imageModal" tabindex="-1">
 <div class="modal-dialog modal-lg modal-dialog-centered">
 <div class="modal-content">
 <div class="modal-header">
 <h5 class="modal-title" id="imageModalLabel">Image</h5>
 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
 </div>
 <div>
 <img id="modalImage" src="" class="img-fluid" alt="">
 <p id="modalCaption"></p>
 </div>
 </div>
 </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
 
 @if($itinerary->gpxPoints->count() > 0)
 // Initialiser la carte
 var map = L.map('map');
 
 // Ajouter les tuiles OpenStreetMap
 L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
 attribution: '© OpenStreetMap contributors',
 maxZoom: 18
 }).addTo(map);
 
 // Points GPS
 var gpxPoints = @json($itinerary->gpxPoints->map(function($point) {
 return [$point->latitude, $point->longitude, $point->elevation];
 }));
 
 if (gpxPoints.length > 0) {
 // Créer la polyline
 var latlngs = gpxPoints.map(function(point) {
 return [point[0], point[1]];
 });
 
 var polyline = L.polyline(latlngs, {
 color: '#e74c3c',
 weight: 4,
 opacity: 0.8
 }).addTo(map);
 
 // Marqueurs de départ et arrivée
 var startPoint = latlngs[0];
 var endPoint = latlngs[latlngs.length - 1];
 
 L.marker(startPoint)
 .addTo(map)
 .bindPopup('🏁 Départ')
 .openPopup();
 
 L.marker(endPoint)
 .addTo(map)
 .bindPopup('🏆 Arrivée');
 
 // Ajuster la vue sur le tracé
 map.fitBounds(polyline.getBounds(), {
 padding: [20, 20]
 });
 }
 @endif
 
 // Fonction pour afficher les images en modal
 window.showImageModal = function(src, caption) {
 document.getElementById('modalImage').src = src;
 document.getElementById('modalCaption').textContent = caption || '';
 var modal = new bootstrap.Modal(document.getElementById('imageModal'));
 modal.show();
 };
});
</script>
@endsection