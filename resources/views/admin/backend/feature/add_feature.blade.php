@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">⚡</span>
      <div>
        <h1>Nouvelle Activité</h1>
        <p>Créer une nouvelle fonctionnalité ou activité</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('all.feature') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour aux activités
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('all.feature') }}" class="breadcrumb__link">Activités</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Nouvelle</span>
  </div>

  <!-- Form Card -->
  <div class="card" style="margin-bottom: var(--cerfaos-space-8);">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="zap"></i>
        Détails de l'Activité
      </h2>
    </div>
    <div class="card__content">

      <form action="{{ route('store.feature') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--cerfaos-space-8);">
          <div>
            
            <!-- Titre de l'activité -->
            <div class="form-field cerfaos-enhanced">
              <label for="title" class="form-field__label">
                <span class="cerfaos-float">⚡</span>
                Titre de l'activité *
              </label>
              <div class="form-field__input">
                <input 
                  type="text" 
                  id="title" 
                  name="title" 
                  value="{{ old('title') }}"
                  placeholder="Ex: Système de réservation, Gestion des photos..."
                  required
                >
                @error('title')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Un titre descriptif pour cette fonctionnalité
                </div>
              </div>
            </div>

            <!-- Icône -->
            <div class="form-field cerfaos-enhanced">
              <label for="icon" class="form-field__label">
                <span class="cerfaos-float">🎨</span>
                Icône *
              </label>
              <div class="form-field__input">
                <input 
                  type="text" 
                  id="icon" 
                  name="icon" 
                  value="{{ old('icon') }}"
                  placeholder="Ex: calendar, camera, settings..."
                  required
                >
                @error('icon')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Nom de l'icône Feather ou HTML/Unicode
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
                  placeholder="Décrivez cette fonctionnalité et son utilité..."
                  required>{{ old('description') }}</textarea>
                @error('description')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Expliquez l'objectif et les bénéfices de cette activité
                </div>
              </div>
            </div>

          </div>
          
          <!-- Sidebar avec informations complémentaires -->
          <div>
            <div class="card cerfaos-enhanced" style="margin-bottom: var(--cerfaos-space-6);">
              <div class="card__header">
                <h3 class="card__title u-flex u-items-center u-gap-2">
                  <span class="cerfaos-pulse">💡</span>
                  Conseils de Création
                </h3>
              </div>
              <div class="card__content">
                <ul class="u-list-none u-space-y-2 cerfaos-animate-stagger">
                  <li class="u-flex u-items-center u-gap-2 u-text-sm cerfaos-animate-fade-in-right">
                    <span class="cerfaos-hover-bounce">🎯</span> Utilisez un titre clair et explicite
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm cerfaos-animate-fade-in-right">
                    <span class="cerfaos-hover-bounce">🎨</span> Choisissez une icône représentative
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm cerfaos-animate-fade-in-right">
                    <span class="cerfaos-hover-bounce">📝</span> Rédigez une description complète
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm cerfaos-animate-fade-in-right">
                    <span class="cerfaos-hover-bounce">✨</span> Mettez en avant les avantages
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm cerfaos-animate-fade-in-right">
                    <span class="cerfaos-hover-bounce">🚀</span> Pensez à l'expérience utilisateur
                  </li>
                </ul>
              </div>
            </div>
            
            <div class="card cerfaos-enhanced">
              <div class="card__header">
                <h3 class="card__title u-flex u-items-center u-gap-2">
                  <span class="cerfaos-pulse">📊</span>
                  Statistiques
                </h3>
              </div>
              <div class="card__content u-space-y-3">
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">⚡ Activités totales:</span>
                  <span class="badge badge--primary cerfaos-shimmer">{{ \App\Models\Feature::count() ?? 0 }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">🎯 Avec icônes:</span>
                  <span class="badge badge--secondary cerfaos-shimmer">{{ \App\Models\Feature::whereNotNull('icon')->count() ?? 0 }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="form-actions u-flex u-gap-4">
          <button type="submit" class="btn btn-primary cerfaos-enhanced cerfaos-hover-glow u-flex u-items-center u-gap-2">
            <i data-feather="save" style="width: 16px; height: 16px;"></i>
            Créer l'Activité
          </button>
          <a href="{{ route('all.feature') }}" class="btn btn-secondary cerfaos-enhanced cerfaos-hover-bounce u-flex u-items-center u-gap-2">
            <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
            Annuler
          </a>
        </div>

      </form>
    </div>
  </div>

</div>

@endsection