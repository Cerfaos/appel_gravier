@extends('admin.admin_master_outdoor')

@section('admin')
<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">🏕️</span>
      <div>
        <h1>Nouvelle Sortie/Expédition</h1>
        <p>Créer une nouvelle sortie d'aventure avec GPS et photos</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('admin.all.sortie') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour aux sorties
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('admin.all.sortie') }}" class="breadcrumb__link">Sorties</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Nouvelle</span>
  </div>

  <form id="sortieForm" action="{{ route('admin.store.sortie') }}" method="POST" enctype="multipart/form-data" x-data="improvedSortieUpload()">
    @csrf

    <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--cerfaos-space-8);">
      
      <!-- Colonne principale -->
      <div class="u-space-y-8">
        
        <!-- Informations de base -->
        <div class="card cerfaos-enhanced">
          <div class="card__header">
            <h2 class="card__title u-flex u-items-center u-gap-3">
              <span class="cerfaos-pulse" style="font-size: 1.5rem;">🏕️</span>
              Informations de base
            </h2>
          </div>
          <div class="card__content">
            
            <div class="u-grid" style="grid-template-columns: 1fr 1fr; gap: var(--cerfaos-space-6);">
              <!-- Titre -->
              <div class="form-field cerfaos-enhanced" style="grid-column: span 2;">
                <label for="title" class="form-field__label">
                  <span class="cerfaos-float">🏷️</span>
                  Titre de la sortie/expédition *
                </label>
                <div class="form-field__input">
                  <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}"
                    x-model="form.title"
                    placeholder="Ex: Expédition Chamonix-Zermatt, Trek du GR20..."
                    required
                  >
                  @error('title')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
                  <div class="form-field__help">
                    Donnez un nom évocateur à votre sortie/expédition
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

              <!-- Statut -->
              <div class="form-field cerfaos-enhanced">
                <label for="status" class="form-field__label">
                  <span class="cerfaos-float">👁️</span>
                  Statut de publication
                </label>
                <div class="form-field__input">
                  <select id="status" name="status" x-model="form.status">
                    <option value="draft">📝 Brouillon</option>
                    <option value="published">🌐 Publiée</option>
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
                  placeholder="Décrivez votre sortie : étapes, points d'intérêt, paysages, difficultés techniques, équipement recommandé..."
                  required>{{ old('description') }}</textarea>
                @error('description')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Une description détaillée aide les aventuriers à mieux préparer leur expédition
                </div>
              </div>
            </div>

            <!-- Localisation -->
            <div class="u-grid" style="grid-template-columns: 1fr 1fr; gap: var(--cerfaos-space-6);">
              <!-- Département -->
              <div class="form-field cerfaos-enhanced">
                <label for="departement" class="form-field__label">
                  <span class="cerfaos-float">🏛️</span>
                  Département
                </label>
                <div class="form-field__input">
                  <input 
                    type="text" 
                    id="departement" 
                    name="departement" 
                    value="{{ old('departement') }}"
                    x-model="form.departement"
                    placeholder="Ex: Haute-Savoie, Alpes-Maritimes..."
                  >
                  @error('departement')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
                  <div class="form-field__help">
                    Département français où se déroule la sortie
                  </div>
                </div>
              </div>

              <!-- Pays -->
              <div class="form-field cerfaos-enhanced">
                <label for="pays" class="form-field__label">
                  <span class="cerfaos-float">🌍</span>
                  Pays
                </label>
                <div class="form-field__input">
                  <select id="pays" name="pays" x-model="form.pays">
                    <option value="">Sélectionner un pays...</option>
                    <option value="France" {{ old('pays') == 'France' ? 'selected' : '' }}>🇫🇷 France</option>
                    <option value="Allemagne" {{ old('pays') == 'Allemagne' ? 'selected' : '' }}>🇩🇪 Allemagne</option>
                    <option value="Suisse" {{ old('pays') == 'Suisse' ? 'selected' : '' }}>🇨🇭 Suisse</option>
                    <option value="Italie" {{ old('pays') == 'Italie' ? 'selected' : '' }}>🇮🇹 Italie</option>
                    <option value="Espagne" {{ old('pays') == 'Espagne' ? 'selected' : '' }}>🇪🇸 Espagne</option>
                    <option value="Autriche" {{ old('pays') == 'Autriche' ? 'selected' : '' }}>🇦🇹 Autriche</option>
                    <option value="Autre" {{ old('pays') == 'Autre' ? 'selected' : '' }}>🌍 Autre</option>
                  </select>
                  @error('pays')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
                  <div class="form-field__help">
                    Pays où se situe la sortie
                  </div>
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
                  Partagez votre expérience personnelle de cette sortie
                </div>
              </div>
            </div>

            <!-- Durée réelle -->
            <div class="form-field cerfaos-enhanced">
              <label for="actual_duration_minutes" class="form-field__label">
                <span class="cerfaos-float">⏰</span>
                Durée réelle
              </label>
              <div class="form-field__input">
                <div class="u-flex u-gap-3 u-items-center">
                  <div class="u-flex u-items-center u-gap-2">
                    <input 
                      type="number" 
                      id="actual_duration_hours" 
                      name="actual_duration_hours" 
                      min="0" 
                      max="23" 
                      value="{{ old('actual_duration_hours') }}"
                      x-model="form.actualDurationHours"
                      placeholder="0"
                      class="form-control u-w-20">
                    <span class="u-text-sm">h</span>
                  </div>
                  <div class="u-flex u-items-center u-gap-2">
                    <input 
                      type="number" 
                      id="actual_duration_minutes" 
                      name="actual_duration_minutes_only" 
                      min="0" 
                      max="59" 
                      value="{{ old('actual_duration_minutes_only') }}"
                      x-model="form.actualDurationMinutes"
                      placeholder="0"
                      class="form-control u-w-20">
                    <span class="u-text-sm">min</span>
                  </div>
                </div>
                <!-- Hidden field for total minutes -->
                <input type="hidden" 
                       name="actual_duration_minutes" 
                       :value="(parseInt(form.actualDurationHours) || 0) * 60 + (parseInt(form.actualDurationMinutes) || 0)">
                @error('actual_duration_minutes')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Durée réelle de la sortie (distincte de l'estimation GPX)
                </div>
              </div>
            </div>

            <!-- Conditions météo -->
            <div class="form-field cerfaos-enhanced">
              <label class="form-field__label">
                <span class="cerfaos-float">🌤️</span>
                Conditions météo rencontrées
              </label>
              <div class="form-field__input">
                <div class="u-grid" style="grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: var(--cerfaos-space-3);">
                  <label class="checkbox-card">
                    <input type="checkbox" name="weather_conditions[]" value="ensoleille" {{ in_array('ensoleille', old('weather_conditions', [])) ? 'checked' : '' }}>
                    <div class="checkbox-card__content">
                      <span class="checkbox-card__icon">☀️</span>
                      <span class="checkbox-card__label">Ensoleillé</span>
                    </div>
                  </label>
                  <label class="checkbox-card">
                    <input type="checkbox" name="weather_conditions[]" value="nuageux" {{ in_array('nuageux', old('weather_conditions', [])) ? 'checked' : '' }}>
                    <div class="checkbox-card__content">
                      <span class="checkbox-card__icon">☁️</span>
                      <span class="checkbox-card__label">Nuageux</span>
                    </div>
                  </label>
                  <label class="checkbox-card">
                    <input type="checkbox" name="weather_conditions[]" value="pluie" {{ in_array('pluie', old('weather_conditions', [])) ? 'checked' : '' }}>
                    <div class="checkbox-card__content">
                      <span class="checkbox-card__icon">🌧️</span>
                      <span class="checkbox-card__label">Pluie</span>
                    </div>
                  </label>
                  <label class="checkbox-card">
                    <input type="checkbox" name="weather_conditions[]" value="vent" {{ in_array('vent', old('weather_conditions', [])) ? 'checked' : '' }}>
                    <div class="checkbox-card__content">
                      <span class="checkbox-card__icon">💨</span>
                      <span class="checkbox-card__label">Vent</span>
                    </div>
                  </label>
                  <label class="checkbox-card">
                    <input type="checkbox" name="weather_conditions[]" value="brouillard" {{ in_array('brouillard', old('weather_conditions', [])) ? 'checked' : '' }}>
                    <div class="checkbox-card__content">
                      <span class="checkbox-card__icon">🌫️</span>
                      <span class="checkbox-card__label">Brouillard</span>
                    </div>
                  </label>
                  <label class="checkbox-card">
                    <input type="checkbox" name="weather_conditions[]" value="neige" {{ in_array('neige', old('weather_conditions', [])) ? 'checked' : '' }}>
                    <div class="checkbox-card__content">
                      <span class="checkbox-card__icon">❄️</span>
                      <span class="checkbox-card__label">Neige</span>
                    </div>
                  </label>
                  <label class="checkbox-card">
                    <input type="checkbox" name="weather_conditions[]" value="orage" {{ in_array('orage', old('weather_conditions', [])) ? 'checked' : '' }}>
                    <div class="checkbox-card__content">
                      <span class="checkbox-card__icon">⛈️</span>
                      <span class="checkbox-card__label">Orage</span>
                    </div>
                  </label>
                  <label class="checkbox-card">
                    <input type="checkbox" name="weather_conditions[]" value="chaud" {{ in_array('chaud', old('weather_conditions', [])) ? 'checked' : '' }}>
                    <div class="checkbox-card__content">
                      <span class="checkbox-card__icon">🥵</span>
                      <span class="checkbox-card__label">Très chaud</span>
                    </div>
                  </label>
                  <label class="checkbox-card">
                    <input type="checkbox" name="weather_conditions[]" value="froid" {{ in_array('froid', old('weather_conditions', [])) ? 'checked' : '' }}>
                    <div class="checkbox-card__content">
                      <span class="checkbox-card__icon">🥶</span>
                      <span class="checkbox-card__label">Très froid</span>
                    </div>
                  </label>
                </div>
                @error('weather_conditions')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Sélectionnez toutes les conditions météo rencontrées pendant la sortie
                </div>
              </div>
            </div>

            <!-- Date de sortie -->
            <div class="u-mb-6">
              <label class="form-field__label" for="sortie_date">
                <span class="form-field__label-text">
                  📅 Date de la sortie
                </span>
              </label>
              <div class="form-field">
                <input
                  type="date"
                  id="sortie_date"
                  name="sortie_date"
                  class="form-control @error('sortie_date') form-control--error @enderror"
                  value="{{ old('sortie_date') }}"
                  placeholder="Sélectionnez la date de la sortie"
                >
                @error('sortie_date')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Date à laquelle la sortie a eu lieu (optionnel)
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

            <!-- Onglets -->
            <div class="tabs-nav" style="margin-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
              <button type="button" 
                      class="tab-btn"
                      :class="activeTab === 'upload' ? 'tab-btn--active' : ''"
                      @click="activeTab = 'upload'"
                      style="padding: 12px 16px; margin-right: 16px; border: none; background: none; cursor: pointer; border-bottom: 2px solid transparent; color: #6b7280; font-weight: 500; transition: all 0.2s;"
                      :style="activeTab === 'upload' ? 'border-bottom-color: #3b82f6; color: #3b82f6; font-weight: 600;' : ''">
                📤 Uploader nouvelles images
              </button>
              <button type="button" 
                      class="tab-btn"
                      :class="activeTab === 'gallery' ? 'tab-btn--active' : ''"
                      @click="activeTab = 'gallery'; $dispatch('tab-changed')"
                      style="padding: 12px 16px; border: none; background: none; cursor: pointer; border-bottom: 2px solid transparent; color: #6b7280; font-weight: 500; transition: all 0.2s;"
                      :style="activeTab === 'gallery' ? 'border-bottom-color: #3b82f6; color: #3b82f6; font-weight: 600;' : ''">
                🖼️ Galerie du mois
              </button>
            </div>

            <!-- Tab Upload -->
            <div x-show="activeTab === 'upload'" x-transition>
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
            </div>

            <!-- Tab Galerie du mois -->
            <div x-show="activeTab === 'gallery'" x-transition 
                 @tab-changed.window="if (activeTab === 'gallery' && monthlyImages.length === 0) loadMonthlyImages()"
                 x-init="if (activeTab === 'gallery') loadMonthlyImages()">
              <div class="monthly-gallery" style="min-height: 200px;">
                
                <!-- Chargement -->
                <div x-show="loadingImages" class="upload-zone__empty cerfaos-animate-fade-in" style="padding: 32px; text-align: center;">
                  <div style="font-size: 2rem; margin-bottom: 16px;" class="cerfaos-pulse">⏳</div>
                  <h6>Chargement des images du mois...</h6>
                </div>
                
                <!-- Si aucune image du mois -->
                <div x-show="!loadingImages && monthlyImages.length === 0" class="upload-zone__empty cerfaos-animate-fade-in" style="padding: 32px; text-align: center;">
                  <div style="font-size: 2rem; margin-bottom: 16px;">🗂️</div>
                  <h6>Aucune image disponible pour {{ now()->format('F Y') }}</h6>
                  <p class="u-text-muted">Créez d'abord une sortie en uploadant des images</p>
                </div>

                <!-- Tableau des images du mois -->
                <div x-show="monthlyImages.length > 0" class="monthly-images-table" style="background: white; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
                  <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f8fafc; border-bottom: 1px solid #e5e7eb;">
                      <tr>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #374151; width: 60px;"></th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #374151; width: 80px;">Aperçu</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #374151;">Nom / Légende</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #374151;">Sortie d'origine</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #374151;">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <template x-for="(image, index) in monthlyImages" :key="image.id">
                        <tr style="border-bottom: 1px solid #f3f4f6; transition: background-color 0.2s; cursor: pointer;"
                            :style="selectedImages.includes(image.id) ? 'background-color: #eff6ff;' : ''"
                            @click="toggleImageSelection(image.id)"
                            @mouseenter="$event.target.style.backgroundColor = selectedImages.includes(image.id) ? '#dbeafe' : '#f9fafb'"
                            @mouseleave="$event.target.style.backgroundColor = selectedImages.includes(image.id) ? '#eff6ff' : 'transparent'">
                          <!-- Checkbox -->
                          <td style="padding: 12px 16px; text-align: center;">
                            <div style="width: 20px; height: 20px; border: 2px solid #d1d5db; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;"
                                 :style="selectedImages.includes(image.id) ? 'background-color: #3b82f6; border-color: #3b82f6;' : ''">
                              <svg x-show="selectedImages.includes(image.id)" style="width: 12px; height: 12px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                              </svg>
                            </div>
                          </td>
                          <!-- Vignette -->
                          <td style="padding: 12px 16px;">
                            <div style="width: 60px; height: 60px; border-radius: 6px; overflow: hidden; border: 1px solid #e5e7eb;">
                              <img :src="image.url" :alt="image.caption || 'Image'" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                          </td>
                          <!-- Nom / Légende -->
                          <td style="padding: 12px 16px;">
                            <div style="font-weight: 500; color: #111827; margin-bottom: 2px;" x-text="image.caption"></div>
                            <div style="font-size: 12px; color: #6b7280;">
                              <span x-text="'ID: ' + image.id"></span>
                              <span x-show="image.used_count > 1" style="margin-left: 8px; color: #f59e0b;" x-text="'• Utilisée ' + image.used_count + ' fois'"></span>
                            </div>
                          </td>
                          <!-- Sortie d'origine -->
                          <td style="padding: 12px 16px;">
                            <div style="font-weight: 500; color: #111827; font-size: 14px;" x-text="image.sortie_title"></div>
                            <div x-show="image.used_count > 1" style="font-size: 12px; color: #6b7280; margin-top: 2px;">
                              <span style="color: #f59e0b;">↳ Également utilisée dans:</span>
                              <span x-text="image.used_in_sorties.replace(image.sortie_title, '').replace(/^,\s*/, '').replace(/,\s*$/, '')"></span>
                            </div>
                          </td>
                          <!-- Date -->
                          <td style="padding: 12px 16px;">
                            <div style="font-size: 14px; color: #6b7280;" x-text="image.sortie_date"></div>
                          </td>
                        </tr>
                      </template>
                    </tbody>
                  </table>
                </div>

                <!-- Info sélection -->
                <div x-show="selectedImages.length > 0" style="margin-top: 16px; padding: 12px; background: #eff6ff; border-radius: 6px;">
                  <small>
                    <span x-text="selectedImages.length"></span> image(s) sélectionnée(s) 
                    <button type="button" @click="selectedImages = []" style="margin-left: 8px; color: #dc2626; border: none; background: none; text-decoration: underline; cursor: pointer;">
                      Désélectionner tout
                    </button>
                  </small>
                </div>

              </div>
            </div>

            <!-- Hidden inputs for form submission -->
            <div style="display: none;">
              <template x-for="(image, index) in images" :key="'input-' + index">
                <div>
                  <input type="file" :name="'images[' + index + ']'" :id="'image-file-' + index">
                  <input type="hidden" :name="'image_captions[' + index + ']'" :value="image.caption">
                </div>
              </template>
              <input type="hidden" name="featured_image_index" :value="featuredImageIndex">
              
              <!-- Hidden inputs pour les images sélectionnées de la galerie -->
              <template x-for="imageId in selectedImages" :key="'selected-' + imageId">
                <input type="hidden" name="selected_monthly_images[]" :value="imageId">
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
              Publier la sortie
            </button>

            <button type="submit" 
                    onclick="document.getElementById('status').value='draft'"
                    class="btn btn-secondary btn-block cerfaos-enhanced cerfaos-hover-bounce u-flex u-items-center u-gap-2">
              <i data-feather="save" style="width: 16px; height: 16px;"></i>
              Sauvegarder en brouillon
            </button>

            <a href="{{ route('admin.all.sortie') }}" 
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

/* Checkbox Cards for Weather Conditions */
.checkbox-card {
  display: block;
  cursor: pointer;
  border-radius: var(--cerfaos-radius-md);
  border: 2px solid var(--cerfaos-border);
  background: var(--cerfaos-bg);
  transition: all 0.2s ease;
  position: relative;
}

.checkbox-card input[type="checkbox"] {
  display: none;
}

.checkbox-card__content {
  padding: var(--cerfaos-space-3);
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: var(--cerfaos-space-2);
}

.checkbox-card__icon {
  font-size: 1.5rem;
  display: block;
}

.checkbox-card__label {
  font-size: var(--cerfaos-font-size-sm);
  font-weight: 500;
  color: var(--cerfaos-text-secondary);
}

.checkbox-card:hover {
  border-color: var(--cerfaos-accent);
  background: var(--cerfaos-accent-light);
}

.checkbox-card input[type="checkbox"]:checked + .checkbox-card__content {
  background: var(--cerfaos-accent);
  color: white;
  border-radius: calc(var(--cerfaos-radius-md) - 2px);
}

.checkbox-card input[type="checkbox"]:checked + .checkbox-card__content .checkbox-card__label {
  color: white;
  font-weight: 600;
}

.checkbox-card input[type="checkbox"]:checked ~ .checkbox-card__content::after {
  content: "✓";
  position: absolute;
  top: var(--cerfaos-space-1);
  right: var(--cerfaos-space-1);
  width: 18px;
  height: 18px;
  background: white;
  color: var(--cerfaos-accent);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: bold;
}
</style>

<script>
function improvedSortieUpload() {
  return {
    // État du formulaire
    form: {
      title: '',
      description: '',
      departement: '',
      pays: '',
      personalComment: '',
      difficulty: '',
      status: 'draft',
      actualDurationHours: 0,
      actualDurationMinutes: 0
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
    
    // État de la galerie mensuelle
    activeTab: 'upload',
    monthlyImages: [],
    selectedImages: [],
    loadingImages: false,
    
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
            
            this.images.push(imageObj);
            
            // Auto-assigner les fichiers aux inputs cachés
            this.$nextTick(() => {
              this.assignFilesToInputs();
            });
          };
          reader.readAsDataURL(file);
        }
      });
      
      e.target.value = '';
    },
    
    removeImage(index) {
      this.images.splice(index, 1);
      if (this.featuredImageIndex >= this.images.length) {
        this.featuredImageIndex = Math.max(0, this.images.length - 1);
      }
      
      // Réassigner les fichiers
      this.$nextTick(() => {
        this.assignFilesToInputs();
      });
    },
    
    setFeaturedImage(index) {
      this.featuredImageIndex = index;
    },
    
    // Méthodes pour la galerie mensuelle
    async loadMonthlyImages() {
      this.loadingImages = true;
      console.log('Chargement des images du mois...');
      try {
        const response = await fetch('{{ route("admin.monthly.images") }}');
        console.log('Réponse API:', response.status, response.statusText);
        if (!response.ok) {
          throw new Error('Erreur HTTP: ' + response.status);
        }
        this.monthlyImages = await response.json();
        console.log('Images reçues:', this.monthlyImages);
      } catch (error) {
        console.error('Erreur lors du chargement des images:', error);
      } finally {
        this.loadingImages = false;
      }
    },
    
    toggleImageSelection(imageId) {
      const index = this.selectedImages.indexOf(imageId);
      if (index > -1) {
        this.selectedImages.splice(index, 1);
      } else {
        this.selectedImages.push(imageId);
      }
      console.log('Images sélectionnées:', this.selectedImages);
    },
    
    // Méthode améliorée pour assigner les fichiers
    assignFilesToInputs() {
      this.images.forEach((image, index) => {
        const fileInput = document.getElementById(`image-file-${index}`);
        if (fileInput && image.file) {
          // Créer un nouveau DataTransfer
          const dt = new DataTransfer();
          dt.items.add(image.file);
          fileInput.files = dt.files;
        }
      });
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
      console.log('Improved sortie upload initialized');
      
      // Event listener pour le formulaire
      const form = document.getElementById('sortieForm');
      if (form) {
        form.addEventListener('submit', (e) => {
          // S'assurer que les fichiers sont assignés avant soumission
          this.assignFilesToInputs();
        });
      }
    }
  }
}
</script>

@endsection