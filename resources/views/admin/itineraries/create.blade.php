@extends('admin.admin_master_outdoor')

@section('admin')
<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">🏔️</span>
      <div>
        <h1>Nouvel Itinéraire</h1>
        <p>Créer un nouvel itinéraire d'aventure avec GPS et photos</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('admin.all.itinerary') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour aux itinéraires
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('admin.all.itinerary') }}" class="breadcrumb__link">Itinéraires</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Nouveau</span>
  </div>

  <form id="itineraryForm" action="{{ route('admin.store.itinerary') }}" method="POST" enctype="multipart/form-data" x-data="improvedItineraryUpload()">
    @csrf

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
                    value="{{ old('title') }}"
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
                  <div class="form-field__help">
                    Donnez un nom évocateur à votre itinéraire
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
                    <option value="facile">🟢 Facile - Accessible à tous</option>
                    <option value="moyen">🟡 Moyen - Bonne condition physique</option>
                    <option value="difficile">🔴 Difficile - Expérience requise</option>
                  </select>
                  @error('difficulty_level')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>

              <!-- Département -->
              <div class="form-field cerfaos-enhanced">
                <label for="departement" class="form-field__label">
                  <span class="cerfaos-float">🗺️</span>
                  Département
                </label>
                <div class="form-field__input">
                  <input 
                    type="text" 
                    id="departement" 
                    name="departement" 
                    x-model="form.departement"
                    placeholder="Ex: Bouches-du-Rhône, Var, Alpes-Maritimes..."
                  >
                  @error('departement')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>

              <!-- Pays -->
              <div class="form-field cerfaos-enhanced">
                <label for="pays" class="form-field__label">
                  <span class="cerfaos-float">🌍</span>
                  Pays
                </label>
                <div class="form-field__input">
                  <input 
                    type="text" 
                    id="pays" 
                    name="pays" 
                    x-model="form.pays"
                    placeholder="Ex: France, Italie, Espagne..."
                    value="France"
                  >
                  @error('pays')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
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
                    <option value="draft">📝 Brouillon</option>
                    <option value="published">🌐 Publié</option>
                  </select>
                  @error('status')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
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
                  required>{{ old('description') }}</textarea>
                @error('description')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
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
                  placeholder="Vos impressions, conseils personnels, anecdotes...">{{ old('personal_comment') }}</textarea>
                @error('personal_comment')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Partagez votre expérience personnelle de cet itinéraire
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Upload GPX -->
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h2 class="card__title u-flex u-items-center u-gap-3">
              <span class="cerfaos-pulse" style="font-size: 1.5rem;">🗺️</span>
              Fichier GPS (GPX)
            </h2>
          </div>
          <div class="card__content">
            
            <div class="upload-zone cerfaos-enhanced" 
                 @dragover.prevent="isDragOver = true"
                 @dragleave.prevent="isDragOver = false"
                 @drop.prevent="handleFileDrop($event)"
                 @click="$refs.gpxInput.click()"
                 :class="{'dragover': isDragOver, 'has-file': gpxFile}">
              
              <div x-show="!gpxFile" class="upload-zone__empty cerfaos-animate-fade-in">
                <div class="cerfaos-hover-bounce" style="font-size: 3rem; margin-bottom: var(--cerfaos-space-4);">🗺️</div>
                <h6>Glissez votre fichier GPX ici</h6>
                <p class="u-text-muted">ou cliquez pour parcourir vos fichiers</p>
                <small>Formats acceptés : .gpx, .xml • Max 10 Mo</small>
              </div>

              <div x-show="gpxFile" class="upload-zone__file cerfaos-animate-scale-in">
                <div class="u-flex u-items-center u-gap-4">
                  <div class="cerfaos-shimmer" style="width: 60px; height: 60px; background: var(--cerfaos-success); border-radius: var(--cerfaos-radius-lg); display: flex; align-items: center; justify-content: center;">
                    <span style="color: white; font-size: 1.5rem;">📊</span>
                  </div>
                  <div class="u-flex-1">
                    <h6 x-text="gpxFile ? gpxFile.name : ''"></h6>
                    <p class="u-text-muted" x-text="gpxFile ? formatFileSize(gpxFile.size) : ''"></p>
                  </div>
                  <button type="button" 
                          class="btn btn-sm btn-danger cerfaos-hover-glow"
                          @click.stop="removeGpxFile()">
                    <i data-feather="x"></i>
                  </button>
                </div>
                
                <div x-show="gpxStats.distance" class="u-mt-4 u-grid" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: var(--cerfaos-space-4);">
                  <div class="stat-mini cerfaos-enhanced">
                    <span class="stat-mini__icon">📏</span>
                    <span class="stat-mini__value" x-text="gpxStats.distance + ' km'"></span>
                    <span class="stat-mini__label">Distance</span>
                  </div>
                  <div class="stat-mini cerfaos-enhanced">
                    <span class="stat-mini__icon">⛰️</span>
                    <span class="stat-mini__value" x-text="'+' + gpxStats.elevation + 'm'"></span>
                    <span class="stat-mini__label">Dénivelé</span>
                  </div>
                  <div class="stat-mini cerfaos-enhanced">
                    <span class="stat-mini__icon">⏱️</span>
                    <span class="stat-mini__value" x-text="gpxStats.duration"></span>
                    <span class="stat-mini__label">Durée est.</span>
                  </div>
                </div>
              </div>

              <div x-show="gpxError" class="upload-zone__error cerfaos-animate-shake">
                <div class="u-flex u-items-center u-gap-3">
                  <i data-feather="alert-triangle" style="color: var(--cerfaos-danger);"></i>
                  <div>
                    <strong>Erreur de traitement</strong>
                    <p x-text="gpxError"></p>
                  </div>
                </div>
              </div>

            </div>

            <input type="file" 
                   x-ref="gpxInput"
                   name="gpx_file" 
                   accept=".gpx,.xml" 
                   style="display: none;"
                   x-show="false"
                   @change="handleFileSelect($event)">

          </div>
        </div>

        <!-- Upload Images -->
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h2 class="card__title u-flex u-items-center u-gap-3">
              <span class="cerfaos-pulse" style="font-size: 1.5rem;">📸</span>
              Galerie d'images
            </h2>
          </div>
          <div class="card__content">
            
            <div class="upload-zone cerfaos-enhanced" 
                 @click="$refs.imageInput.click()"
                 style="min-height: 200px;">
              
              <div x-show="images.length === 0" class="upload-zone__empty cerfaos-animate-fade-in">
                <div class="cerfaos-hover-bounce" style="font-size: 3rem; margin-bottom: var(--cerfaos-space-4);">📸</div>
                <h6>Ajoutez vos photos</h6>
                <p class="u-text-muted">Cliquez pour sélectionner des images</p>
                <small>Formats : JPG, PNG, WEBP • Max 5 Mo par image</small>
              </div>

              <div x-show="images.length > 0" class="images-grid cerfaos-animate-stagger">
                <template x-for="(image, index) in images" :key="index">
                  <div class="image-card cerfaos-enhanced cerfaos-animate-scale-in">
                    <div class="image-card__preview">
                      <img :src="image.url" :alt="'Image ' + (index + 1)" class="image-card__img">
                      <div class="image-card__overlay">
                        <button type="button" 
                                class="btn btn-sm btn-danger"
                                @click.stop="removeImage(index)">
                          <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                        </button>
                      </div>
                      <div x-show="index === featuredImageIndex" class="image-card__featured">
                        <span>★ Principale</span>
                      </div>
                    </div>
                    <div class="image-card__controls">
                      <input type="text" 
                             x-model="image.caption" 
                             placeholder="Légende de l'image..."
                             class="image-card__caption">
                      <button type="button" 
                              class="btn btn-sm"
                              :class="index === featuredImageIndex ? 'btn-primary' : 'btn-secondary'"
                              @click="setFeaturedImage(index)">
                        <i data-feather="star" style="width: 12px; height: 12px;"></i>
                        <span x-text="index === featuredImageIndex ? 'Principale' : 'Définir'"></span>
                      </button>
                    </div>
                  </div>
                </template>
              </div>

            </div>

            <input type="file" 
                   x-ref="imageInput"
                   name="images[]"
                   multiple 
                   accept="image/*" 
                   style="display: none;"
                   @change="handleImageSelect($event)">

            <!-- Hidden inputs for form submission -->
            <div style="display: none;">
              <!-- We'll use the main file input and handle multiple files -->
              <input type="hidden" name="featured_image_index" :value="featuredImageIndex">
              <!-- Image captions will be handled separately -->
              <template x-for="(image, index) in images" :key="'caption-' + index">
                <input type="hidden" :name="'image_captions[' + index + ']'" :value="image.caption">
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
                    onclick="document.getElementById('status').value='published'"
                    class="btn btn-primary btn-block cerfaos-enhanced cerfaos-hover-glow u-flex u-items-center u-gap-2"
                    :disabled="!canPublish">
              <i data-feather="globe" style="width: 16px; height: 16px;"></i>
              Publier l'itinéraire
            </button>

            <button type="submit" 
                    onclick="document.getElementById('status').value='draft'"
                    class="btn btn-secondary btn-block cerfaos-enhanced cerfaos-hover-bounce u-flex u-items-center u-gap-2">
              <i data-feather="save" style="width: 16px; height: 16px;"></i>
              Sauvegarder en brouillon
            </button>

            <a href="{{ route('admin.all.itinerary') }}" 
               class="btn btn-outline btn-block cerfaos-enhanced u-flex u-items-center u-gap-2">
              <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
              Annuler
            </a>

          </div>
        </div>

        <!-- Aide -->
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h3 class="card__title u-flex u-items-center u-gap-2">
              <span class="cerfaos-pulse">💡</span>
              Conseils
            </h3>
          </div>
          <div class="card__content">
            <ul class="u-list-none u-space-y-2 cerfaos-animate-stagger">
              <li class="u-flex u-items-center u-gap-2 u-text-sm cerfaos-animate-fade-in-right">
                <span class="cerfaos-hover-bounce">🗺️</span> Un fichier GPX améliore l'expérience
              </li>
              <li class="u-flex u-items-center u-gap-2 u-text-sm cerfaos-animate-fade-in-right">
                <span class="cerfaos-hover-bounce">📸</span> Ajoutez des photos inspirantes
              </li>
              <li class="u-flex u-items-center u-gap-2 u-text-sm cerfaos-animate-fade-in-right">
                <span class="cerfaos-hover-bounce">⭐</span> Définissez une image principale
              </li>
              <li class="u-flex u-items-center u-gap-2 u-text-sm cerfaos-animate-fade-in-right">
                <span class="cerfaos-hover-bounce">📝</span> Soyez précis dans la description
              </li>
            </ul>
          </div>
        </div>

        <!-- Statistiques -->
        <div class="card cerfaos-enhanced" x-show="gpxStats.distance">
          <div class="card__header">
            <h3 class="card__title u-flex u-items-center u-gap-2">
              <span class="cerfaos-pulse">📊</span>
              Statistiques GPS
            </h3>
          </div>
          <div class="card__content u-space-y-3">
            <div class="u-flex u-justify-between u-items-center">
              <span class="u-text-sm u-text-muted">📏 Distance:</span>
              <span class="badge badge--primary cerfaos-shimmer" x-text="gpxStats.distance + ' km'"></span>
            </div>
            <div class="u-flex u-justify-between u-items-center">
              <span class="u-text-sm u-text-muted">⛰️ Dénivelé:</span>
              <span class="badge badge--success cerfaos-shimmer" x-text="'+' + gpxStats.elevation + 'm'"></span>
            </div>
            <div class="u-flex u-justify-between u-items-center">
              <span class="u-text-sm u-text-muted">📍 Points GPS:</span>
              <span class="badge badge--info cerfaos-shimmer" x-text="gpxStats.points"></span>
            </div>
          </div>
        </div>

      </div>
    </div>

  </form>

</div>

<style>
.upload-zone {
  border: 2px dashed var(--cerfaos-border);
  border-radius: var(--cerfaos-radius-lg);
  padding: var(--cerfaos-space-8);
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

.upload-zone.dragover {
  border-color: var(--cerfaos-accent);
  background: var(--cerfaos-bg-accent-subtle);
  transform: scale(1.02);
}

.upload-zone.has-file {
  background: var(--cerfaos-bg-success-subtle);
  border-color: var(--cerfaos-success);
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
function improvedItineraryUpload() {
  return {
    // État du formulaire
    form: {
      title: '',
      description: '',
      personalComment: '',
      difficulty: '',
      departement: '',
      pays: 'France',
      status: 'draft'
    },
    
    // État du fichier GPX
    gpxFile: null,
    gpxProcessing: false,
    gpxError: null,
    gpxStats: {},
    isDragOver: false,
    
    // État des images
    images: [],
    featuredImageIndex: 0,
    
    // Computed
    get canPublish() {
      return this.form.title.trim() && this.form.description.trim();
    },
    
    // Méthodes GPX
    handleFileDrop(e) {
      this.isDragOver = false;
      const files = e.dataTransfer.files;
      if (files.length > 0) {
        this.processGpxFile(files[0]);
      }
    },
    
    handleFileSelect(e) {
      const file = e.target.files[0];
      if (file) {
        this.processGpxFile(file);
      }
    },
    
    async processGpxFile(file) {
      // Validation
      if (!file.name.toLowerCase().match(/\.(gpx|xml)$/)) {
        this.gpxError = 'Format de fichier non supporté. Utilisez un fichier .gpx ou .xml';
        return;
      }
      
      if (file.size > 10 * 1024 * 1024) { // 10 MB
        this.gpxError = 'Fichier trop volumineux. Maximum 10 Mo.';
        return;
      }
      
      this.gpxFile = file;
      this.gpxError = null;
      this.gpxProcessing = true;
      
      // Simulation des statistiques (à remplacer par un vrai parsing)
      setTimeout(() => {
        this.gpxStats = {
          distance: '12.5',
          elevation: '850',
          duration: '4h30',
          points: '1250'
        };
        this.gpxProcessing = false;
      }, 1500);
    },
    
    removeGpxFile() {
      this.gpxFile = null;
      this.gpxStats = {};
      this.gpxError = null;
      this.$refs.gpxInput.value = '';
    },
    
    // Méthodes images améliorées
    handleImageSelect(e) {
      const files = Array.from(e.target.files);
      
      // Clear existing images when new files are selected
      this.images = [];
      
      files.forEach((file, index) => {
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
            
            this.images.push(imageObj);
          };
          reader.readAsDataURL(file);
        }
      });
    },
    
    removeImage(index) {
      this.images.splice(index, 1);
      if (this.featuredImageIndex >= this.images.length) {
        this.featuredImageIndex = Math.max(0, this.images.length - 1);
      }
      
      // Clear and rebuild the file input
      if (this.images.length === 0) {
        this.$refs.imageInput.value = '';
      }
    },
    
    setFeaturedImage(index) {
      this.featuredImageIndex = index;
    },
    
    // Méthode améliorée pour assigner les fichiers
    assignFilesToInputs() {
      // Simple approach: We'll handle this differently
      // The files are already stored in the images array
      // and will be handled by a more direct approach
    },
    
    // Utilitaires
    formatFileSize(bytes) {
      if (bytes === 0) return '0 B';
      const k = 1024;
      const sizes = ['B', 'KB', 'MB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },
    
    // Initialisation
    init() {
      console.log('Improved itinerary upload initialized');
    }
  }
}
</script>

@endsection