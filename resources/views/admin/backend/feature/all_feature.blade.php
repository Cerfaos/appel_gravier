@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">⚡</span>
      <div>
        <h1>Activités</h1>
        <p>Gérer toutes les fonctionnalités et activités</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('add.feature') }}" class="btn btn-primary u-flex u-items-center u-gap-2">
        <i data-feather="plus" style="width: 16px; height: 16px;"></i>
        Nouvelle Activité
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Activités</span>
  </div>

  <!-- Stats Overview -->
  <div class="grid grid-cols-3 cerfaos-animate-stagger" style="margin-bottom: var(--cerfaos-space-8); gap: var(--cerfaos-space-6);">
    <div class="card cerfaos-enhanced stat-card cerfaos-hover-lift">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div class="cerfaos-float" style="font-size: 2rem;">⚡</div>
        <div>
          <div class="stat-number" style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-text-primary);">{{ $feature->count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Activités totales</div>
        </div>
      </div>
    </div>
    
    <div class="card cerfaos-enhanced stat-card cerfaos-hover-lift">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div class="cerfaos-float" style="font-size: 2rem;">🎯</div>
        <div>
          <div class="stat-number" style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-accent);">{{ $feature->where('icon', '!=', null)->count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Avec icônes</div>
        </div>
      </div>
    </div>
    
    <div class="card cerfaos-enhanced stat-card cerfaos-hover-lift">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div class="cerfaos-float" style="font-size: 2rem;">📝</div>
        <div>
          @php
            $avgLength = $feature->avg(function($item) { return strlen($item->description); });
          @endphp
          <div class="stat-number" style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-success);">{{ number_format($avgLength ?? 0, 0) }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Longueur moyenne</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Features List -->
  <div class="card cerfaos-enhanced">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="list"></i>
        Liste des Activités
      </h2>
    </div>
    <div class="card__content" style="padding: 0;">
      @if($feature->count() > 0)
        <div style="overflow-x: auto;">
          <table class="table cerfaos-enhanced">
            <thead>
              <tr>
                <th>#</th>
                <th>Activité</th>
                <th>Icon</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($feature as $key => $item)
              <tr>
                <td>
                  <span class="badge badge--secondary cerfaos-pulse">#{{ $key + 1 }}</span>
                </td>
                <td>
                  <div class="u-flex u-items-center u-gap-3">
                    <div class="cerfaos-gradient-bronze cerfaos-hover-scale" style="width: 40px; height: 40px; border-radius: var(--cerfaos-radius-md); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                      ⚡
                    </div>
                    <div>
                      <h6>{{ $item->title }}</h6>
                      <small class="u-text-muted">ID: {{ $item->id }}</small>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="cerfaos-shimmer" style="background: var(--cerfaos-bg-subtle); padding: var(--cerfaos-space-2); border-radius: var(--cerfaos-radius-sm); font-family: var(--cerfaos-font-mono); font-size: var(--cerfaos-font-size-sm);">
                    {{ $item->icon ?: '-' }}
                  </div>
                </td>
                <td>
                  <div style="max-width: 300px;">
                    <span>{{ Str::limit($item->description, 80, '...') }}</span>
                  </div>
                </td>
                <td>
                  <div class="u-flex u-gap-2">
                    <a href="{{ route('edit.feature', $item->id) }}" 
                       class="btn btn-sm btn-secondary cerfaos-enhanced cerfaos-hover-bounce"
                       title="Modifier">
                      <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                    </a>
                    <a href="{{ route('delete.feature', $item->id) }}" 
                       class="btn btn-sm btn-danger cerfaos-enhanced cerfaos-hover-bounce"
                       title="Supprimer"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ? Cette action est irréversible.')">
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
        <div class="cerfaos-animate-bounce-in" style="padding: var(--cerfaos-space-12); text-align: center;">
          <div class="cerfaos-pulse" style="font-size: 4rem; margin-bottom: var(--cerfaos-space-4);">⚡</div>
          <h5 style="color: var(--cerfaos-text-primary); margin-bottom: var(--cerfaos-space-2);">Aucune activité trouvée</h5>
          <p class="u-text-muted" style="margin-bottom: var(--cerfaos-space-6);">Commencez par créer votre première activité.</p>
          <a href="{{ route('add.feature') }}" class="btn btn-primary cerfaos-enhanced cerfaos-hover-glow u-flex u-items-center u-gap-2" style="display: inline-flex;">
            <i data-feather="plus" style="width: 16px; height: 16px;"></i> 
            Créer une Activité
          </a>
        </div>
      @endif
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert--success" style="position: fixed; top: var(--cerfaos-space-6); right: var(--cerfaos-space-6); z-index: 1000;">
      <strong>Succès!</strong> {{ session('success') }}
    </div>
  @endif

</div>

@endsection