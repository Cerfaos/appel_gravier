@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">✏️</span>
      <div>
        <h1>Modifier l'Expédition</h1>
        <p>Mettre à jour "{{ $ride->title }}"</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('admin.rides.index') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour aux expéditions
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('admin.rides.index') }}" class="breadcrumb__link">Expéditions</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Modifier {{ $ride->title }}</span>
  </div>

  <!-- Form Card -->
  <div class="card" style="margin-bottom: var(--cerfaos-space-8);">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="edit-3"></i>
        Modifier l'Expédition
      </h2>
    </div>
    <div class="card__content">

      <form action="{{ route('admin.rides.update', $ride) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--cerfaos-space-8);">
          <div>
            
            <!-- Titre de la sortie -->
            <div class="form-field">
              <label for="title" class="form-field__label">
                <span>🏔️</span>
                Titre de l'expédition *
              </label>
              <div class="form-field__input">
                <input 
                  type="text" 
                  id="title" 
                  name="title" 
                  value="{{ old('title', $ride->title) }}"
                  placeholder="Ex: Tour du Lac Léman, Ascension du Mont-Blanc..."
                  required
                >
                @error('title')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Un titre évocateur pour votre aventure
                </div>
              </div>
            </div>

            <!-- Date de la sortie -->
            <div class="form-field">
              <label for="ride_date" class="form-field__label">
                <span>📅</span>
                Date de l'expédition *
              </label>
              <div class="form-field__input">
                <input 
                  type="date" 
                  id="ride_date" 
                  name="ride_date" 
                  value="{{ old('ride_date', $ride->ride_date->format('Y-m-d')) }}"
                  required
                >
                @error('ride_date')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>

            <!-- Informations techniques -->
            <div class="u-grid" style="grid-template-columns: 1fr 1fr; gap: var(--cerfaos-space-4);">
              <div class="form-field">
                <label for="distance_km" class="form-field__label">
                  <span>📏</span>
                  Distance (km) *
                </label>
                <div class="form-field__input">
                  <input 
                    type="number" 
                    id="distance_km" 
                    name="distance_km" 
                    step="0.1"
                    value="{{ old('distance_km', $ride->distance_km) }}"
                    placeholder="0.0"
                    required
                  >
                  @error('distance_km')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>

              <div class="form-field">
                <label for="elevation_gain_m" class="form-field__label">
                  <span>⛰️</span>
                  Dénivelé positif (m)
                </label>
                <div class="form-field__input">
                  <input 
                    type="number" 
                    id="elevation_gain_m" 
                    name="elevation_gain_m" 
                    value="{{ old('elevation_gain_m', $ride->elevation_gain_m) }}"
                    placeholder="500"
                  >
                  @error('elevation_gain_m')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Temps de déplacement -->
            <div class="u-grid" style="grid-template-columns: 1fr 1fr; gap: var(--cerfaos-space-4);">
              <div class="form-field">
                <label for="moving_time" class="form-field__label">
                  <span>⏱️</span>
                  Temps de déplacement *
                </label>
                <div class="form-field__input">
                  <input 
                    type="time" 
                    id="moving_time" 
                    name="moving_time" 
                    value="{{ old('moving_time', $ride->moving_time_sec ? sprintf('%02d:%02d', floor($ride->moving_time_sec / 3600), floor(($ride->moving_time_sec % 3600) / 60)) : '') }}"
                    required
                  >
                  @error('moving_time')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
                  <div class="form-field__help">
                    Temps en mouvement (GPS)
                  </div>
                </div>
              </div>

              <div class="form-field">
                <label for="total_time" class="form-field__label">
                  <span>🕐</span>
                  Temps réel total
                </label>
                <div class="form-field__input">
                  <input 
                    type="time" 
                    id="total_time" 
                    name="total_time" 
                    value="{{ old('total_time', $ride->total_time_sec ? sprintf('%02d:%02d', floor($ride->total_time_sec / 3600), floor(($ride->total_time_sec % 3600) / 60)) : '') }}"
                  >
                  @error('total_time')
                  <div class="form-field__error">
                    <i data-feather="alert-circle"></i>
                    {{ $message }}
                  </div>
                  @enderror
                  <div class="form-field__help">
                    Temps total avec pauses
                  </div>
                </div>
              </div>
            </div>

            <!-- Image de couverture actuelle -->
            @if($ride->cover_image_path)
            <div class="form-field">
              <label class="form-field__label">
                <span>🖼️</span>
                Image de couverture actuelle
              </label>
              <div class="form-field__input">
                <div style="padding: var(--cerfaos-space-4); background: var(--cerfaos-bg-subtle); border-radius: var(--cerfaos-radius-md); border: 1px solid var(--cerfaos-border);">
                  <img src="{{ asset($ride->cover_image_path) }}" 
                    alt="Image de couverture actuelle de {{ $ride->title }}" 
                    style="max-width: 200px; border-radius: var(--cerfaos-radius-sm);">
                </div>
              </div>
            </div>
            @endif

            <!-- Nouvelle image de couverture -->
            <div class="form-field">
              <label for="cover_image" class="form-field__label">
                <span>📸</span>
                Changer l'image de couverture (optionnel)
              </label>
              <div class="form-field__input">
                <input 
                  type="file" 
                  id="cover_image" 
                  name="cover_image" 
                  accept="image/*"
                >
                @error('cover_image')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Laissez vide pour conserver l'image actuelle
                </div>
              </div>
            </div>

            <!-- Fichier GPX -->
            <div class="form-field">
              <label for="gpx" class="form-field__label">
                <span>🗺️</span>
                Fichier GPX (optionnel)
              </label>
              <div class="form-field__input">
                <input 
                  type="file" 
                  id="gpx" 
                  name="gpx" 
                  accept=".gpx,.xml"
                >
                @error('gpx')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                @if($ride->gpx_path)
                  <div class="form-field__help">
                    Fichier actuel: {{ basename($ride->gpx_path) }} - Laissez vide pour conserver
                  </div>
                @else
                  <div class="form-field__help">
                    Fichier GPX contenant le tracé
                  </div>
                @endif
              </div>
            </div>

            <!-- Retour d'expérience -->
            <div class="form-field">
              <label for="experience" class="form-field__label">
                <span>✨</span>
                Retour d'expérience
              </label>
              <div class="form-field__input">
                <textarea 
                  id="experience" 
                  name="experience" 
                  rows="6"
                  placeholder="Décrivez votre expérience lors de cette expédition...">{{ old('experience', $ride->experience) }}</textarea>
                @error('experience')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Partagez vos sensations et découvertes
                </div>
              </div>
            </div>

          </div>
          
          <!-- Sidebar avec informations complémentaires -->
          <div>
            <div class="card" style="margin-bottom: var(--cerfaos-space-6);">
              <div class="card__header">
                <h3 class="card__title u-flex u-items-center u-gap-2">
                  <span>📊</span>
                  Informations
                </h3>
              </div>
              <div class="card__content u-space-y-3">
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">ID:</span>
                  <span class="badge badge--secondary">#{{ $ride->id }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">📅 Créé le:</span>
                  <span class="badge badge--info">{{ $ride->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">🔄 Modifié le:</span>
                  <span class="badge badge--warning">{{ $ride->updated_at->format('d/m/Y') }}</span>
                </div>
                @if($ride->gpx_path)
                  <div class="u-flex u-justify-between u-items-center">
                    <span class="u-text-sm u-text-muted">🗺️ GPX:</span>
                    <span class="badge badge--success">Présent</span>
                  </div>
                @endif
              </div>
            </div>
            
            <div class="card">
              <div class="card__header">
                <h3 class="card__title u-flex u-items-center u-gap-2">
                  <span>💡</span>
                  Conseils de Modification
                </h3>
              </div>
              <div class="card__content">
                <ul class="u-list-none u-space-y-2">
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>✅</span> Vérifiez l'orthographe du titre
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>📊</span> Ajustez les données techniques si nécessaire
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>📸</span> Changez l'image si elle n'est plus appropriée
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>✨</span> Enrichissez le retour d'expérience
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🗺️</span> Gardez l'authenticité de l'aventure
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="form-actions u-flex u-gap-4">
          <button type="submit" class="btn btn-primary u-flex u-items-center u-gap-2">
            <i data-feather="save" style="width: 16px; height: 16px;"></i>
            Mettre à Jour l'Expédition
          </button>
          <a href="{{ route('admin.rides.show', $ride) }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
            <i data-feather="eye" style="width: 16px; height: 16px;"></i>
            Voir l'Expédition
          </a>
          <a href="{{ route('admin.rides.index') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
            <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
            Annuler
          </a>
        </div>

      </form>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert--success" style="position: fixed; top: var(--cerfaos-space-6); right: var(--cerfaos-space-6); z-index: 1000;">
      <strong>Succès!</strong> {{ session('success') }}
    </div>
  @endif

</div>

@endsection