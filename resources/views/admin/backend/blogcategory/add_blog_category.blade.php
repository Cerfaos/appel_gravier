@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">✨</span>
      <div>
        <h1>Nouvelle Catégorie</h1>
        <p>Créer une catégorie pour organiser vos articles</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('all.blog.category') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour aux catégories
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('all.blog.category') }}" class="breadcrumb__link">Catégories</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Nouvelle</span>
  </div>

  <!-- Form Card -->
  <div class="card" style="margin-bottom: var(--cerfaos-space-8);">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="folder-plus"></i>
        Détails de la Catégorie
      </h2>
    </div>
    <div class="card__content">

      <form action="{{ route('store.blog.category') }}" method="post">
        @csrf

        <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--cerfaos-space-8);">
          <div>
            
            <!-- Nom de la catégorie -->
            <div class="form-field">
              <label for="category_name" class="form-field__label">
                <span>🏷️</span>
                Nom de la catégorie *
              </label>
              <div class="form-field__input">
                <input 
                  type="text" 
                  id="category_name" 
                  name="category_name" 
                  value="{{ old('category_name') }}"
                  placeholder="Ex: Vélo de montagne, Randonnée, Aventure..."
                  required
                >
                @error('category_name')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Le nom de la catégorie doit être unique et descriptif
                </div>
              </div>
            </div>

          </div>
          
          <!-- Sidebar avec informations complémentaires -->
          <div>
            <div class="card" style="margin-bottom: var(--cerfaos-space-6);">
              <div class="card__header">
                <h3 class="card__title u-flex u-items-center u-gap-2">
                  <span>💡</span>
                  Conseils de Création
                </h3>
              </div>
              <div class="card__content">
                <ul class="u-list-none u-space-y-2">
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🎯</span> Choisissez un nom clair et précis
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🔍</span> Vérifiez qu'il n'existe pas déjà
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>📝</span> Le slug sera généré automatiquement
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🗂️</span> Facilitera l'organisation des articles
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>✨</span> Pensez à la navigation des visiteurs
                  </li>
                </ul>
              </div>
            </div>
            
            <div class="card">
              <div class="card__header">
                <h3 class="card__title u-flex u-items-center u-gap-2">
                  <span>📊</span>
                  Statistiques
                </h3>
              </div>
              <div class="card__content u-space-y-3">
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">🏷️ Catégories total:</span>
                  <span class="badge badge--primary">{{ \App\Models\BlogCategory::count() }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">📄 Articles total:</span>
                  <span class="badge badge--secondary">{{ \App\Models\BlogPost::count() }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="form-actions u-flex u-gap-4">
          <button type="submit" class="btn btn-primary u-flex u-items-center u-gap-2">
            <i data-feather="save" style="width: 16px; height: 16px;"></i>
            Créer la Catégorie
          </button>
          <a href="{{ route('all.blog.category') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
            <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
            Annuler
          </a>
        </div>

      </form>
    </div>
  </div>

</div>

@endsection