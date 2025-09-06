@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">👤</span>
      <div>
        <h1>Section à Propos</h1>
        <p>Gérer le contenu de la section "À propos" de votre site</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('add.clarify') }}" class="btn btn-primary u-flex u-items-center u-gap-2">
        <i data-feather="plus" style="width: 16px; height: 16px;"></i>
        Nouveau Clarify
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Section À Propos</span>
  </div>

  <!-- Stats Overview -->
  <div class="grid grid-cols-3 cerfaos-animate-stagger" style="margin-bottom: var(--cerfaos-space-8); gap: var(--cerfaos-space-6);">
    <div class="card cerfaos-enhanced stat-card cerfaos-hover-lift">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div class="cerfaos-float" style="font-size: 2rem;">👤</div>
        <div>
          <div class="stat-number" style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-text-primary);">{{ $clarifies->count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Contenus totaux</div>
        </div>
      </div>
    </div>
    
    <div class="card cerfaos-enhanced stat-card cerfaos-hover-lift">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div class="cerfaos-float" style="font-size: 2rem;">✅</div>
        <div>
          <div class="stat-number" style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-accent);">{{ $clarifies->where('is_active', true)->count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Actifs</div>
        </div>
      </div>
    </div>

    <div class="card cerfaos-enhanced stat-card cerfaos-hover-lift">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div class="cerfaos-float" style="font-size: 2rem;">🖼️</div>
        <div>
          <div class="stat-number" style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-accent);">{{ $clarifies->whereNotNull('image')->count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Avec images</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="card cerfaos-enhanced">
    <div class="card__content">
      
      @if(session('success'))
        <div class="notification notification--success" style="margin-bottom: var(--cerfaos-space-6);">
          <div class="notification__content">
            <i data-feather="check-circle" class="notification__icon"></i>
            <span>{{ session('success') }}</span>
          </div>
        </div>
      @endif

      @if($clarifies->count() > 0)
        <div class="data-table-container">
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Statut</th>
                <th>Image</th>
                <th>Features</th>
                <th>Créé le</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clarifies as $clarify)
                <tr class="cerfaos-hover-row">
                  <td>
                    <div class="u-flex u-items-center u-gap-3">
                      <span class="badge badge--primary">#{{ $clarify->id }}</span>
                    </div>
                  </td>
                  <td>
                    <div class="u-flex u-items-center u-gap-3">
                      <div>
                        <div class="font-medium text-primary">{{ Str::limit($clarify->title, 50) }}</div>
                        @if($clarify->subtitle)
                          <div class="u-text-muted u-text-sm">{{ Str::limit($clarify->subtitle, 60) }}</div>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td>
                    @if($clarify->is_active)
                      <span class="badge badge--success">Actif</span>
                    @else
                      <span class="badge badge--secondary">Inactif</span>
                    @endif
                  </td>
                  <td>
                    @if($clarify->image)
                      <img src="{{ asset('storage/' . $clarify->image) }}" alt="Image" class="w-12 h-12 object-cover rounded-lg">
                    @else
                      <span class="u-text-muted">Aucune image</span>
                    @endif
                  </td>
                  <td>
                    <div class="u-text-sm u-text-muted">
                      {{ $clarify->features ? count(array_filter($clarify->features, fn($f) => !empty($f['title']))) : 0 }} features
                    </div>
                  </td>
                  <td class="u-text-sm u-text-muted">
                    {{ $clarify->created_at->format('d/m/Y H:i') }}
                  </td>
                  <td>
                    <div class="action-buttons u-flex u-items-center u-justify-center u-gap-2">
                      <a href="{{ route('show.clarify', $clarify->id) }}" class="btn btn-sm btn-secondary" title="Voir">
                        <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                      </a>
                      <a href="{{ route('edit.clarify', $clarify->id) }}" class="btn btn-sm btn-primary" title="Modifier">
                        <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                      </a>
                      <a href="{{ route('delete.clarify', $clarify->id) }}" 
                         class="btn btn-sm btn-danger" 
                         onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce clarify ?')"
                         title="Supprimer">
                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="empty-state">
          <div class="empty-state__icon">👤</div>
          <h3 class="empty-state__title">Aucun contenu trouvé</h3>
          <p class="empty-state__description">Créez votre premier contenu "À propos" pour commencer.</p>
          <a href="{{ route('add.clarify') }}" class="btn btn-primary">
            <i data-feather="plus" style="width: 16px; height: 16px;"></i>
            Créer un Clarify
          </a>
        </div>
      @endif

    </div>
  </div>
</div>

@endsection