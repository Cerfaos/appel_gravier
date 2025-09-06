@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">💬</span>
      <div>
        <h1>Carnet de Témoignages</h1>
        <p>Les récits d'aventure de notre communauté d'explorateurs</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('add.review') }}" class="btn btn-primary u-flex u-items-center u-gap-2">
        <i data-feather="plus" style="width: 16px; height: 16px;"></i>
        Nouveau Témoignage
      </a>
    </div>
  </div>

  <!-- Stats Overview -->
  <div class="grid grid-cols-4" style="margin-bottom: var(--cerfaos-space-8); gap: var(--cerfaos-space-6);">
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">💭</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-text-primary);">{{ $review->count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Témoignages</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">🏔️</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-text-primary);">{{ $review->where('position', 'like', '%guide%')->count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Guides</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">⭐</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-success);">4.8/5</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Note moyenne</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">📈</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-success);">+12%</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Ce mois</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Reviews List -->
  <div class="card">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="message-circle"></i>
        Récits de Nos Aventuriers
      </h2>
    </div>
    <div class="card__content" style="padding: 0;">
      @if($review->count() > 0)
        <div style="overflow-x: auto;">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Aventurier</th>
                <th>Spécialité</th>
                <th>Portrait</th>
                <th>Récit</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($review as $key => $item)
              <tr>
                <td>{{ $key + 1 }}</td>
                <td>
                  <div class="u-flex u-items-center u-gap-2">
                    <span>🏔️</span>
                    <div>
                      <h6>{{ $item->name }}</h6>
                      <small class="u-text-muted">Aventurier</small>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge badge--secondary">
                    <span>🎯</span> {{ $item->position }}
                  </span>
                </td>
                <td>
                  <img src="{{ asset($item->image) }}" 
                    alt="Portrait {{ $item->name }}" 
                    class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                </td>
                <td>
                  <div style="max-width: 200px;">
                    <small>{{ Str::limit($item->message, 60, '...') }}</small>
                  </div>
                </td>
                <td>
                  <div class="u-flex u-gap-2">
                    <a href="{{ route('edit.review', $item->id) }}" 
                       class="btn btn-sm btn-secondary"
                       title="Modifier">
                      <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                    </a>
                    <a href="{{ route('delete.review', $item->id) }}" 
                       class="btn btn-sm btn-danger"
                       title="Supprimer"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce témoignage ? Cette action est irréversible.')"
                       id="delete">
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
        <div style="padding: var(--cerfaos-space-12); text-align: center;">
          <div style="font-size: 4rem; margin-bottom: var(--cerfaos-space-4);">💭</div>
          <h5 style="color: var(--cerfaos-text-primary); margin-bottom: var(--cerfaos-space-2);">Aucun témoignage trouvé</h5>
          <p class="u-text-muted" style="margin-bottom: var(--cerfaos-space-6);">Commencez par ajouter votre premier témoignage d'aventurier.</p>
          <a href="{{ route('add.review') }}" class="btn btn-primary u-flex u-items-center u-gap-2" style="display: inline-flex;">
            <i data-feather="plus" style="width: 16px; height: 16px;"></i> 
            Ajouter un Témoignage
          </a>
        </div>
      @endif
    </div>
  </div>

</div>
@endsection