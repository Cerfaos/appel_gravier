@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">✏️</span>
      <div>
        <h1>Modifier la Catégorie</h1>
        <p>Mettre à jour "{{ $category->category_name }}"</p>
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
    <span class="breadcrumb__current">Modifier {{ $category->category_name }}</span>
  </div>

  <!-- Form Card -->
  <div class="card" style="margin-bottom: var(--cerfaos-space-8);">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="edit-3"></i>
        Modifier la Catégorie
      </h2>
    </div>
    <div class="card__content">

      <form action="{{ route('update.blog.category') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $category->id }}">

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
                  value="{{ old('category_name', $category->category_name) }}"
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

            <!-- Slug actuel -->
            <div class="form-field">
              <label class="form-field__label">
                <span>🔗</span>
                Slug actuel
              </label>
              <div class="form-field__input">
                <div style="padding: var(--cerfaos-space-4); background: var(--cerfaos-bg-subtle); border-radius: var(--cerfaos-radius-md); border: 1px solid var(--cerfaos-border);">
                  <div style="font-family: monospace; background: var(--cerfaos-bg-subtle); padding: var(--cerfaos-space-2); border-radius: var(--cerfaos-radius-sm); font-size: var(--cerfaos-font-size-sm); color: var(--cerfaos-text-secondary);">
                    {{ $category->category_slug }}
                  </div>
                </div>
                <div class="form-field__help">
                  Le slug sera automatiquement mis à jour en fonction du nouveau nom
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
                  <span class="badge badge--secondary">#{{ $category->id }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">📄 Articles:</span>
                  @php
                    $articleCount = \App\Models\BlogPost::where('blog_category_id', $category->id)->count();
                  @endphp
                  <span class="badge {{ $articleCount > 0 ? 'badge--success' : 'badge--muted' }}">
                    {{ $articleCount }} article{{ $articleCount > 1 ? 's' : '' }}
                  </span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">📅 Créé le:</span>
                  <span class="badge badge--info">{{ $category->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">🔄 Modifié le:</span>
                  <span class="badge badge--warning">{{ $category->updated_at->format('d/m/Y') }}</span>
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
                    <span>✅</span> Vérifiez l'orthographe du nom
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🔍</span> Assurez-vous qu'il reste unique
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🔗</span> Le slug sera mis à jour automatiquement
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>📄</span> Les articles existants seront préservés
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>✨</span> Pensez à la cohérence globale
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
            Mettre à Jour la Catégorie
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