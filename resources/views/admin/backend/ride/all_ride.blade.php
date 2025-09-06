@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">🚴‍♂️</span>
      <div>
        <h1>Expéditions</h1>
        <p>Gérer toutes les sorties et aventures</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('admin.rides.create') }}" class="btn btn-primary u-flex u-items-center u-gap-2">
        <i data-feather="plus" style="width: 16px; height: 16px;"></i>
        Nouvelle Expédition
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Expéditions</span>
  </div>

  <!-- Stats Overview -->
  <div class="grid grid-cols-4" style="margin-bottom: var(--cerfaos-space-8); gap: var(--cerfaos-space-6);">
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">🏔️</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-text-primary);">{{ $rides->count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Expéditions</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">📏</div>
        <div>
          @php
            $totalDistance = $rides->sum('distance_km');
          @endphp
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-accent);">{{ number_format($totalDistance, 0) }} km</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Distance totale</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">⛰️</div>
        <div>
          @php
            $totalElevation = $rides->sum('elevation_gain_m');
          @endphp
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-success);">{{ number_format($totalElevation, 0) }} m</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Dénivelé total</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">🚀</div>
        <div>
          @php
            $avgSpeed = $rides->where('avg_speed_kmh', '>', 0)->avg('avg_speed_kmh');
          @endphp
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-warning);">{{ number_format($avgSpeed ?? 0, 1) }} km/h</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Vitesse moyenne</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Rides List -->
  <div class="card">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="list"></i>
        Liste des Expéditions
      </h2>
    </div>
    <div class="card__content" style="padding: 0;">
      @if($rides->count() > 0)
        <div style="overflow-x: auto;">
          <table class="table">
            <thead>
              <tr>
                <th>Expédition</th>
                <th>Date</th>
                <th>Distance</th>
                <th>Dénivelé</th>
                <th>Temps</th>
                <th>Vitesse</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rides as $ride)
              <tr>
                <td>
                  <div class="u-flex u-items-center u-gap-3">
                    @if($ride->cover_image_path)
                      <img src="{{ asset($ride->cover_image_path) }}" 
                           style="width: 50px; height: 50px; object-fit: cover; border-radius: var(--cerfaos-radius-md);"
                           alt="Vignette - {{ $ride->title }}">
                    @else
                      <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--cerfaos-accent), var(--cerfaos-accent-hover)); border-radius: var(--cerfaos-radius-md); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                        🚴‍♂️
                      </div>
                    @endif
                    <div>
                      <h6>{{ $ride->title }}</h6>
                      <div class="u-flex u-items-center u-gap-2">
                        <small class="u-text-muted">#{{ $ride->id }}</small>
                        @if($ride->gpx_path)
                          <span class="badge badge--success">GPX</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="u-flex u-flex-col">
                    <small>{{ $ride->ride_date->format('d/m/Y') }}</small>
                    <small class="u-text-muted">{{ $ride->ride_date->diffForHumans() }}</small>
                  </div>
                </td>
                <td>
                  <span class="badge badge--info">{{ number_format($ride->distance_km, 1) }} km</span>
                </td>
                <td>
                  <span class="badge badge--warning">{{ $ride->elevation_gain_m }} m</span>
                </td>
                <td>
                  <div style="font-family: monospace; background: var(--cerfaos-bg-subtle); padding: var(--cerfaos-space-2); border-radius: var(--cerfaos-radius-sm); font-size: var(--cerfaos-font-size-sm);">
                    {{ $ride->moving_time_hms }}
                  </div>
                </td>
                <td>
                  @if($ride->avg_speed_kmh > 0)
                    <span class="badge badge--secondary">{{ number_format($ride->avg_speed_kmh, 1) }} km/h</span>
                  @else
                    <span class="badge badge--muted">-</span>
                  @endif
                </td>
                <td>
                  <div class="u-flex u-gap-2">
                    <a href="{{ route('admin.rides.show', $ride) }}" 
                       class="btn btn-sm btn-secondary"
                       title="Voir détails">
                      <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                    </a>
                    <a href="{{ route('admin.rides.edit', $ride) }}" 
                       class="btn btn-sm btn-secondary"
                       title="Modifier">
                      <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                    </a>
                    <form action="{{ route('admin.rides.destroy', $ride) }}" 
                          method="POST"
                          style="display: inline;"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette expédition ? Cette action est irréversible.')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" 
                              class="btn btn-sm btn-danger"
                              title="Supprimer">
                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if($rides->hasPages())
          <div style="padding: var(--cerfaos-space-6); border-top: 1px solid var(--cerfaos-border);">
            {{ $rides->links() }}
          </div>
        @endif

      @else
        <div style="padding: var(--cerfaos-space-12); text-align: center;">
          <div style="font-size: 4rem; margin-bottom: var(--cerfaos-space-4);">🚴‍♂️</div>
          <h5 style="color: var(--cerfaos-text-primary); margin-bottom: var(--cerfaos-space-2);">Aucune expédition trouvée</h5>
          <p class="u-text-muted" style="margin-bottom: var(--cerfaos-space-6);">Commencez par planifier votre première sortie aventure.</p>
          <a href="{{ route('admin.rides.create') }}" class="btn btn-primary u-flex u-items-center u-gap-2" style="display: inline-flex;">
            <i data-feather="plus" style="width: 16px; height: 16px;"></i> 
            Planifier une Expédition
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