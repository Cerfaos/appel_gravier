@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">✏️</span>
      <div>
        <h1>Modifier l'Activité</h1>
        <p>Mettre à jour "{{ $feature->title }}"</p>
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
    <span class="breadcrumb__current">Modifier {{ $feature->title }}</span>
  </div>

  <!-- Form Card -->
  <div class="card" style="margin-bottom: var(--cerfaos-space-8);">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="edit-3"></i>
        Modifier l'Activité
      </h2>
    </div>
    <div class="card__content">

      <form action="{{ route('update.feature') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $feature->id }}">

        <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--cerfaos-space-8);">
          <div>
            
            <!-- Titre de l'activité -->
            <div class="form-field">
              <label for="title" class="form-field__label">
                <span>⚡</span>
                Titre de l'activité *
              </label>
              <div class="form-field__input">
                <input 
                  type="text" 
                  id="title" 
                  name="title" 
                  value="{{ old('title', $feature->title) }}"
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
            <div class="form-field">
              <label for="icon" class="form-field__label">
                <span>🎨</span>
                Icône *
              </label>
              <div class="form-field__input">
                <input 
                  type="text" 
                  id="icon" 
                  name="icon" 
                  value="{{ old('icon', $feature->icon) }}"
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
            <div class="form-field">
              <label for="description" class="form-field__label">
                <span>📝</span>
                Description *
              </label>
              <div class="form-field__input">
                <textarea 
                  id="description" 
                  name="description" 
                  rows="6"
                  placeholder="Décrivez cette fonctionnalité et son utilité..."
                  required>{{ old('description', $feature->description) }}</textarea>
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
                  <span class="badge badge--secondary">#{{ $feature->id }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">📅 Créé le:</span>
                  <span class="badge badge--info">{{ $feature->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">🔄 Modifié le:</span>
                  <span class="badge badge--warning">{{ $feature->updated_at->format('d/m/Y') }}</span>
                </div>
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
                    <span>✅</span> Vérifiez la cohérence du titre
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🎨</span> Testez l'affichage de l'icône
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>📝</span> Enrichissez la description si nécessaire
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>✨</span> Gardez l'utilité et la clarté
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🚀</span> Pensez à l'impact utilisateur
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
            Mettre à Jour l'Activité
          </button>
          <a href="{{ route('all.feature') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
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