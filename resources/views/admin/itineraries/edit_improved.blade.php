@extends('admin.admin_master_outdoor')

@section('admin')
<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">✏️</span>
      <div>
        <h1>Modifier l'Itinéraire</h1>
        <p>Modification de "{{ $itinerary->title }}"</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      @if($itinerary->status === 'published')
        <a href="{{ route('itineraries.show', $itinerary->slug) }}" 
           target="_blank"
           class="btn btn-secondary u-flex u-items-center u-gap-2">
          <i data-feather="external-link" style="width: 16px; height: 16px;"></i>
          Voir sur le site
        </a>
      @endif
      <a href="{{ route('admin.all.itinerary') }}" class="btn btn-outline u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour à la liste
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('admin.all.itinerary') }}" class="breadcrumb__link">Itinéraires</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">{{ $itinerary->title }}</span>
  </div>

  @if ($errors->any())
    <div class="alert alert--danger cerfaos-animate-shake" style="margin-bottom: var(--cerfaos-space-6);">
      <div class="u-flex u-items-center u-gap-3">
        <i data-feather="alert-triangle" style="color: var(--cerfaos-danger);"></i>
        <div>
          <strong>Erreurs de validation</strong>
          <ul class="u-mt-2 u-space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif

  <form action="{{ route('admin.update.itinerary') }}" method="POST" enctype="multipart/form-data" id="itineraryForm" x-data="improvedItineraryEdit()">
    @csrf
    <input type="hidden" name="id" value="{{ $itinerary->id }}">

    <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--cerfaos-space-8);">
      
      <!-- Colonne principale -->
      <div class="u-space-y-8">
        
        <!-- Informations de base -->
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h2 class="card__title u-flex u-items-center u-gap-3">
              <span class="cerfaos-pulse" style="font-size: 1.5rem;">🏔️</span>
              Informations de base
            </h2>
          </div>
          <div class="card__content">
            
            <div class="u-grid" style="grid-template-columns: 1fr 1fr; gap: var(--cerfaos-space-6);">
              <!-- Titre -->
              <div class="form-field cerfaos-enhanced" style="grid-column: span 2;">
                <label for="title" class="form-field__label">
                  <span class="cerfaos-float">🏷️</span>
                  Titre de l'itinéraire *
                </label>
                <div class="form-field__input">
                  <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $itinerary->title) }}"
                    x-model="form.title"
                    placeholder="Ex: Tour du Mont-Blanc, Traversée des Écrins..."
                    required
                  >
                  @error('title')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>

              <!-- Slug -->
              <div class="form-field cerfaos-enhanced" style="grid-column: span 2;">
                <label for="slug" class="form-field__label">
                  <span class="cerfaos-float">🔗</span>
                  URL (Slug)
                </label>
                <div class="form-field__input">
                  <input 
                    type="text" 
                    id="slug" 
                    name="slug" 
                    value="{{ old('slug', $itinerary->slug) }}"
                    placeholder="url-de-l-itineraire"
                    readonly
                  >
                  <div class="form-field__help">
                    L'URL est générée automatiquement à partir du titre
                  </div>
                </div>
              </div>

              <!-- Difficulté -->
              <div class="form-field cerfaos-enhanced">
                <label for="difficulty_level" class="form-field__label">
                  <span class="cerfaos-float">⚡</span>
                  Difficulté
                </label>
                <div class="form-field__input">
                  <select id="difficulty_level" name="difficulty_level" x-model="form.difficulty">
                    <option value="">Sélectionner...</option>
                    <option value="facile" {{ old('difficulty_level', $itinerary->difficulty_level) == 'facile' ? 'selected' : '' }}>
                      🟢 Facile - Accessible à tous
                    </option>
                    <option value="moyen" {{ old('difficulty_level', $itinerary->difficulty_level) == 'moyen' ? 'selected' : '' }}>
                      🟡 Moyen - Bonne condition physique
                    </option>
                    <option value="difficile" {{ old('difficulty_level', $itinerary->difficulty_level) == 'difficile' ? 'selected' : '' }}>
                      🔴 Difficile - Expérience requise
                    </option>
                  </select>
                </div>
              </div>

              <!-- Statut -->
              <div class="form-field cerfaos-enhanced">
                <label for="status" class="form-field__label">
                  <span class="cerfaos-float">👁️</span>
                  Statut de publication
                </label>
                <div class="form-field__input">
                  <select id="status" name="status" x-model="form.status">
                    <option value="draft" {{ old('status', $itinerary->status) == 'draft' ? 'selected' : '' }}>
                      📝 Brouillon
                    </option>
                    <option value="published" {{ old('status', $itinerary->status) == 'published' ? 'selected' : '' }}>
                      🌐 Publié
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Description -->
            <div class="form-field cerfaos-enhanced">
              <label for="description" class="form-field__label">
                <span class="cerfaos-float">📝</span>
                Description *
              </label>
              <div class="form-field__input">
                <textarea 
                  id="description" 
                  name="description" 
                  rows="6"
                  x-model="form.description"
                  placeholder="Décrivez votre itinéraire : points d'intérêt, paysages, difficultés techniques, équipement recommandé..."
                  required>{{ old('description', $itinerary->description) }}</textarea>
                <div class="form-field__help">
                  Une description détaillée aide les randonneurs à mieux préparer leur sortie
                </div>
              </div>
            </div>

            <!-- Commentaire personnel -->
            <div class="form-field cerfaos-enhanced">
              <label for="personal_comment" class="form-field__label">
                <span class="cerfaos-float">💭</span>
                Commentaire personnel
              </label>
              <div class="form-field__input">
                <textarea 
                  id="personal_comment" 
                  name="personal_comment" 
                  rows="4"
                  x-model="form.personalComment"
                  placeholder="Vos impressions, conseils personnels, anecdotes...">{{ old('personal_comment', $itinerary->personal_comment) }}</textarea>
                <div class="form-field__help">
                  Partagez votre expérience personnelle de cet itinéraire
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Statistiques existantes -->
        @if($itinerary->distance_km || $itinerary->elevation_gain_m)
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h2 class="card__title u-flex u-items-center u-gap-3">
              <span class="cerfaos-pulse" style="font-size: 1.5rem;">📊</span>
              Statistiques GPS actuelles
            </h2>
          </div>
          <div class="card__content">
            <div class="u-grid" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: var(--cerfaos-space-4);">
              @if($itinerary->distance_km)
              <div class="stat-mini cerfaos-enhanced">
                <span class="stat-mini__icon">📏</span>
                <span class="stat-mini__value">{{ number_format($itinerary->distance_km, 1) }} km</span>
                <span class="stat-mini__label">Distance</span>
              </div>
              @endif
              
              @if($itinerary->elevation_gain_m)
              <div class="stat-mini cerfaos-enhanced">
                <span class="stat-mini__icon">⛰️</span>
                <span class="stat-mini__value">+{{ $itinerary->elevation_gain_m }}m</span>
                <span class="stat-mini__label">Dénivelé</span>
              </div>
              @endif
              
              @if($itinerary->estimated_duration_minutes)
              <div class="stat-mini cerfaos-enhanced">
                <span class="stat-mini__icon">⏱️</span>
                <span class="stat-mini__value">{{ floor($itinerary->estimated_duration_minutes / 60) }}h{{ $itinerary->estimated_duration_minutes % 60 }}</span>
                <span class="stat-mini__label">Durée est.</span>
              </div>
              @endif
              
              @if($itinerary->gpxPoints && $itinerary->gpxPoints->count())
              <div class="stat-mini cerfaos-enhanced">
                <span class="stat-mini__icon">📍</span>
                <span class="stat-mini__value">{{ $itinerary->gpxPoints->count() }}</span>
                <span class="stat-mini__label">Points GPS</span>
              </div>
              @endif
            </div>
            
            @if($itinerary->gpx_file_path)
            <div class="u-mt-4 u-flex u-items-center u-gap-3 u-p-4" style="background: var(--cerfaos-bg-success-subtle); border-radius: var(--cerfaos-radius-md); border: 1px solid var(--cerfaos-success);">
              <div style="font-size: 2rem;">🗺️</div>
              <div>
                <strong>Fichier GPX actuel</strong>
                <p class="u-text-muted u-text-sm">{{ basename($itinerary->gpx_file_path) }}</p>
              </div>
            </div>
            @endif
          </div>
        </div>
        @endif

        <!-- Galerie d'images existantes -->
        @if($itinerary->images && $itinerary->images->count() > 0)
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h2 class="card__title u-flex u-items-center u-gap-3">
              <span class="cerfaos-pulse" style="font-size: 1.5rem;">📸</span>
              Galerie d'images ({{ $itinerary->images->count() }})
            </h2>
          </div>
          <div class="card__content">
            
            <div class="images-grid cerfaos-animate-stagger">
              @foreach($itinerary->images as $image)
              <div class="image-card cerfaos-enhanced cerfaos-animate-scale-in">
                <div class="image-card__preview">
                  <img src="{{ asset($image->image_path) }}" 
                       alt="Image {{ $loop->iteration }}" 
                       class="image-card__img">
                  <div class="image-card__overlay">
                    <a href="{{ route('admin.delete.itinerary.image', $image->id) }}"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Supprimer cette image ?')">
                      <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                    </a>
                  </div>
                  @if($image->is_featured)
                  <div class="image-card__featured">
                    <span>★ Principale</span>
                  </div>
                  @endif
                </div>
                <div class="image-card__controls">
                  <input type="text" 
                         name="image_captions[{{ $image->id }}]" 
                         value="{{ $image->caption }}"
                         placeholder="Légende de l'image..."
                         class="image-card__caption">
                  <div class="u-flex u-gap-2">
                    @if(!$image->is_featured)
                    <form action="{{ route('admin.set.featured.itinerary.image', $image->id) }}" method="POST" style="display: inline;">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-secondary">
                        <i data-feather="star" style="width: 12px; height: 12px;"></i>
                        Principale
                      </button>
                    </form>
                    @else
                    <span class="btn btn-sm btn-primary">
                      <i data-feather="star" style="width: 12px; height: 12px;"></i>
                      Principale
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              @endforeach
            </div>

          </div>
        </div>
        @endif

        <!-- Upload de nouvelles images -->
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h2 class="card__title u-flex u-items-center u-gap-3">
              <span class="cerfaos-pulse" style="font-size: 1.5rem;">📷</span>
              Ajouter de nouvelles images
            </h2>
          </div>
          <div class="card__content">
            
            <div class="upload-zone cerfaos-enhanced" 
                 @click="$refs.imageInput.click()"
                 style="min-height: 150px;">
              
              <div x-show="newImages.length === 0" class="upload-zone__empty cerfaos-animate-fade-in">
                <div class="cerfaos-hover-bounce" style="font-size: 2.5rem; margin-bottom: var(--cerfaos-space-3);">📸</div>
                <h6>Ajouter de nouvelles photos</h6>
                <p class="u-text-muted">Cliquez pour sélectionner des images</p>
                <small>Formats : JPG, PNG, WEBP • Max 5 Mo par image</small>
              </div>

              <div x-show="newImages.length > 0" class="images-grid cerfaos-animate-stagger">
                <template x-for="(image, index) in newImages" :key="index">
                  <div class="image-card cerfaos-enhanced cerfaos-animate-scale-in">
                    <div class="image-card__preview">
                      <img :src="image.url" :alt="'Nouvelle image ' + (index + 1)" class="image-card__img">
                      <div class="image-card__overlay">
                        <button type="button" 
                                class="btn btn-sm btn-danger"
                                @click.stop="removeNewImage(index)">
                          <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                        </button>
                      </div>
                      <div class="image-card__new">
                        <span>🆕 Nouvelle</span>
                      </div>
                    </div>
                    <div class="image-card__controls">
                      <input type="text" 
                             x-model="image.caption" 
                             placeholder="Légende de l'image..."
                             class="image-card__caption">
                    </div>
                  </div>
                </template>
              </div>

            </div>

            <input type="file" 
                   x-ref="imageInput"
                   multiple 
                   accept="image/*" 
                   style="display: none;"
                   @change="handleNewImageSelect($event)">

            <!-- Hidden inputs for new images -->
            <div style="display: none;">
              <template x-for="(image, index) in newImages" :key="'new-input-' + index">
                <div>
                  <input type="file" :name="'new_images[' + index + ']'" :id="'new-image-file-' + index">
                  <input type="hidden" :name="'new_image_captions[' + index + ']'" :value="image.caption">
                </div>
              </template>
            </div>

          </div>
        </div>

      </div>

      <!-- Sidebar -->
      <div class="u-space-y-6">
        
        <!-- Actions -->
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h3 class="card__title u-flex u-items-center u-gap-2">
              <span class="cerfaos-pulse">💾</span>
              Actions
            </h3>
          </div>
          <div class="card__content u-space-y-4">
            
            <button type="submit" 
                    class="btn btn-primary btn-block cerfaos-enhanced cerfaos-hover-glow u-flex u-items-center u-gap-2">
              <i data-feather="save" style="width: 16px; height: 16px;"></i>
              Sauvegarder les modifications
            </button>

            <div class="u-flex u-gap-2">
              @if($itinerary->status === 'published')
                <form action="{{ route('admin.unpublish.itinerary', $itinerary->id) }}" method="POST" style="flex: 1;">
                  @csrf
                  <button type="submit" 
                          class="btn btn-warning btn-block cerfaos-enhanced u-flex u-items-center u-gap-2"
                          onclick="return confirm('Dépublier cet itinéraire ?')">
                    <i data-feather="eye-off" style="width: 16px; height: 16px;"></i>
                    Dépublier
                  </button>
                </form>
              @else
                <form action="{{ route('admin.publish.itinerary', $itinerary->id) }}" method="POST" style="flex: 1;">
                  @csrf
                  <button type="submit" 
                          class="btn btn-success btn-block cerfaos-enhanced u-flex u-items-center u-gap-2"
                          onclick="return confirm('Publier cet itinéraire ?')">
                    <i data-feather="globe" style="width: 16px; height: 16px;"></i>
                    Publier
                  </button>
                </form>
              @endif
              
              <form action="{{ route('admin.delete.itinerary', $itinerary->id) }}" method="GET" style="flex: 1;">
                <button type="submit" 
                        class="btn btn-danger btn-block cerfaos-enhanced u-flex u-items-center u-gap-2"
                        onclick="return confirm('Supprimer définitivement cet itinéraire ?')">
                  <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                  Supprimer
                </button>
              </form>
            </div>

            <a href="{{ route('admin.all.itinerary') }}" 
               class="btn btn-outline btn-block cerfaos-enhanced u-flex u-items-center u-gap-2">
              <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
              Annuler les modifications
            </a>

          </div>
        </div>

        <!-- Informations -->
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h3 class="card__title u-flex u-items-center u-gap-2">
              <span class="cerfaos-pulse">ℹ️</span>
              Informations
            </h3>
          </div>
          <div class="card__content u-space-y-3">
            <div class="u-flex u-justify-between u-items-center">
              <span class="u-text-sm u-text-muted">🆔 ID:</span>
              <span class="badge badge--secondary">#{{ $itinerary->id }}</span>
            </div>
            <div class="u-flex u-justify-between u-items-center">
              <span class="u-text-sm u-text-muted">👤 Auteur:</span>
              <span class="badge badge--info">{{ $itinerary->user ? $itinerary->user->name : 'Inconnu' }}</span>
            </div>
            <div class="u-flex u-justify-between u-items-center">
              <span class="u-text-sm u-text-muted">📅 Créé le:</span>
              <span class="u-text-sm">{{ $itinerary->created_at->format('d/m/Y à H:i') }}</span>
            </div>
            <div class="u-flex u-justify-between u-items-center">
              <span class="u-text-sm u-text-muted">✏️ Modifié le:</span>
              <span class="u-text-sm">{{ $itinerary->updated_at->format('d/m/Y à H:i') }}</span>
            </div>
            @if($itinerary->published_at)
            <div class="u-flex u-justify-between u-items-center">
              <span class="u-text-sm u-text-muted">🌐 Publié le:</span>
              <span class="u-text-sm">{{ $itinerary->published_at->format('d/m/Y à H:i') }}</span>
            </div>
            @endif
          </div>
        </div>

        <!-- SEO -->
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h3 class="card__title u-flex u-items-center u-gap-2">
              <span class="cerfaos-pulse">🔍</span>
              Référencement (SEO)
            </h3>
          </div>
          <div class="card__content u-space-y-4">
            
            <div class="form-field cerfaos-enhanced">
              <label for="meta_title" class="form-field__label">
                <span class="cerfaos-float">📑</span>
                Titre SEO
              </label>
              <div class="form-field__input">
                <input 
                  type="text" 
                  id="meta_title" 
                  name="meta_title" 
                  value="{{ old('meta_title', $itinerary->meta_title) }}"
                  maxlength="60"
                  placeholder="Titre pour les moteurs de recherche"
                >
                <div class="form-field__help">
                  Laissez vide pour utiliser le titre principal
                </div>
              </div>
            </div>

            <div class="form-field cerfaos-enhanced">
              <label for="meta_description" class="form-field__label">
                <span class="cerfaos-float">📄</span>
                Description SEO
              </label>
              <div class="form-field__input">
                <textarea 
                  id="meta_description" 
                  name="meta_description" 
                  rows="3"
                  maxlength="160"
                  placeholder="Description pour les moteurs de recherche">{{ old('meta_description', $itinerary->meta_description) }}</textarea>
                <div class="form-field__help">
                  Description visible dans les résultats Google
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

  </form>

</div>

<style>
.image-card__new {
  position: absolute;
  top: var(--cerfaos-space-2);
  left: var(--cerfaos-space-2);
  background: var(--cerfaos-info);
  color: white;
  padding: var(--cerfaos-space-1) var(--cerfaos-space-2);
  border-radius: var(--cerfaos-radius-sm);
  font-size: var(--cerfaos-font-size-xs);
  font-weight: 600;
}

/* Réutilisation des styles de la page de création */
.upload-zone {
  border: 2px dashed var(--cerfaos-border);
  border-radius: var(--cerfaos-radius-lg);
  padding: var(--cerfaos-space-6);
  cursor: pointer;
  transition: all 0.3s ease;
  background: var(--cerfaos-bg-subtle);
  text-align: center;
}

.upload-zone:hover {
  border-color: var(--cerfaos-accent);
  background: var(--cerfaos-bg-subtle);
  transform: translateY(-2px);
}

.images-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: var(--cerfaos-space-4);
}

.image-card {
  background: var(--cerfaos-bg);
  border: 1px solid var(--cerfaos-border);
  border-radius: var(--cerfaos-radius-md);
  overflow: hidden;
  transition: all 0.3s ease;
}

.image-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--cerfaos-shadow-lg);
}

.image-card__preview {
  position: relative;
  width: 100%;
  height: 120px;
  overflow: hidden;
}

.image-card__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-card__overlay {
  position: absolute;
  top: var(--cerfaos-space-2);
  right: var(--cerfaos-space-2);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.image-card:hover .image-card__overlay {
  opacity: 1;
}

.image-card__featured {
  position: absolute;
  bottom: var(--cerfaos-space-2);
  left: var(--cerfaos-space-2);
  background: var(--cerfaos-accent);
  color: white;
  padding: var(--cerfaos-space-1) var(--cerfaos-space-2);
  border-radius: var(--cerfaos-radius-sm);
  font-size: var(--cerfaos-font-size-xs);
  font-weight: 600;
}

.image-card__controls {
  padding: var(--cerfaos-space-3);
  display: flex;
  flex-direction: column;
  gap: var(--cerfaos-space-2);
}

.image-card__caption {
  border: 1px solid var(--cerfaos-border);
  border-radius: var(--cerfaos-radius-sm);
  padding: var(--cerfaos-space-2);
  font-size: var(--cerfaos-font-size-sm);
}

.stat-mini {
  text-align: center;
  padding: var(--cerfaos-space-3);
  background: var(--cerfaos-bg);
  border: 1px solid var(--cerfaos-border);
  border-radius: var(--cerfaos-radius-md);
  display: flex;
  flex-direction: column;
  gap: var(--cerfaos-space-1);
}

.stat-mini__icon {
  font-size: 1.5rem;
}

.stat-mini__value {
  font-weight: 700;
  font-size: var(--cerfaos-font-size-lg);
  color: var(--cerfaos-text-primary);
}

.stat-mini__label {
  font-size: var(--cerfaos-font-size-xs);
  color: var(--cerfaos-text-muted);
  text-transform: uppercase;
  letter-spacing: 0.05em;
}
</style>

<script>
function improvedItineraryEdit() {
  return {
    // État du formulaire
    form: {
      title: '{{ $itinerary->title }}',
      description: '{{ $itinerary->description }}',
      personalComment: '{{ $itinerary->personal_comment }}',
      difficulty: '{{ $itinerary->difficulty_level }}',
      status: '{{ $itinerary->status }}'
    },
    
    // État des nouvelles images
    newImages: [],
    
    // Méthodes pour les nouvelles images
    handleNewImageSelect(e) {
      const files = Array.from(e.target.files);
      
      files.forEach(file => {
        if (file.type.startsWith('image/')) {
          if (file.size > 5 * 1024 * 1024) { // 5 MB
            alert(`Image "${file.name}" trop volumineuse. Maximum 5 Mo.`);
            return;
          }
          
          const reader = new FileReader();
          reader.onload = (e) => {
            const imageObj = {
              file: file,
              url: e.target.result,
              caption: '',
              name: file.name
            };
            
            this.newImages.push(imageObj);
            
            // Auto-assigner les fichiers aux inputs cachés
            this.$nextTick(() => {
              this.assignNewFilesToInputs();
            });
          };
          reader.readAsDataURL(file);
        }
      });
      
      e.target.value = '';
    },
    
    removeNewImage(index) {
      this.newImages.splice(index, 1);
      
      // Réassigner les fichiers
      this.$nextTick(() => {
        this.assignNewFilesToInputs();
      });
    },
    
    // Méthode pour assigner les nouveaux fichiers
    assignNewFilesToInputs() {
      this.newImages.forEach((image, index) => {
        const fileInput = document.getElementById(`new-image-file-${index}`);
        if (fileInput && image.file) {
          // Créer un nouveau DataTransfer
          const dt = new DataTransfer();
          dt.items.add(image.file);
          fileInput.files = dt.files;
        }
      });
    },
    
    // Initialisation
    init() {
      console.log('Improved itinerary edit initialized');
      
      // Event listener pour le formulaire
      const form = document.getElementById('itineraryForm');
      if (form) {
        form.addEventListener('submit', (e) => {
          // S'assurer que les nouveaux fichiers sont assignés avant soumission
          this.assignNewFilesToInputs();
        });
      }
    }
  }
}
</script>

@endsection