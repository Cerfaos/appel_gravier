@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">👤</span>
      <div>
        <h1>Section à Propos</h1>
        <p>Gérer le contenu de la section "à propos" de votre page d'accueil</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('about.content.preview') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="eye" style="width: 16px; height: 16px;"></i>
        Aperçu
      </a>
      <form action="{{ route('about.content.reset') }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir réinitialiser toute la section ? Cette action est irréversible.')">
        @csrf
        <button type="submit" class="btn btn-warning u-flex u-items-center u-gap-2">
          <i data-feather="refresh-ccw" style="width: 16px; height: 16px;"></i>
          Réinitialiser
        </button>
      </form>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Section À Propos</span>
  </div>

  @if(session('success'))
    <div class="notification notification--success" style="margin-bottom: var(--cerfaos-space-6);">
      <div class="notification__content">
        <i data-feather="check-circle" class="notification__icon"></i>
        <span>{{ session('success') }}</span>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="notification notification--error" style="margin-bottom: var(--cerfaos-space-6);">
      <div class="notification__content">
        <i data-feather="alert-circle" class="notification__icon"></i>
        <span>{{ session('error') }}</span>
      </div>
    </div>
  @endif

  <!-- Dashboard statistiques -->
  <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--cerfaos-space-4); margin-bottom: var(--cerfaos-space-6);">
    
    <div class="stat-card card cerfaos-enhanced">
      <div class="card__content" style="text-align: center;">
        <div style="font-size: 2rem; margin-bottom: var(--cerfaos-space-2);">📊</div>
        <div style="font-size: 2rem; font-weight: bold; color: var(--cerfaos-primary);">{{ $stats['total_items'] ?? 0 }}</div>
        <div style="color: var(--cerfaos-text-muted); font-size: 0.9rem;">Éléments configurés</div>
      </div>
    </div>

    <div class="stat-card card cerfaos-enhanced">
      <div class="card__content" style="text-align: center;">
        <div style="font-size: 2rem; margin-bottom: var(--cerfaos-space-2);">⭐</div>
        <div style="font-size: 2rem; font-weight: bold; color: var(--cerfaos-accent);">{{ $stats['features_count'] ?? 0 }}</div>
        <div style="color: var(--cerfaos-text-muted); font-size: 0.9rem;">Features actives</div>
      </div>
    </div>

    <div class="stat-card card cerfaos-enhanced">
      <div class="card__content" style="text-align: center;">
        <div style="font-size: 2rem; margin-bottom: var(--cerfaos-space-2);">🕒</div>
        <div style="font-size: 1.2rem; font-weight: bold; color: var(--cerfaos-success);">
          {{ $stats['last_updated'] ? $stats['last_updated']->format('d/m/Y') : 'Jamais' }}
        </div>
        <div style="color: var(--cerfaos-text-muted); font-size: 0.9rem;">Dernière mise à jour</div>
      </div>
    </div>

    <div class="stat-card card cerfaos-enhanced">
      <div class="card__content" style="text-align: center;">
        <div style="font-size: 2rem; margin-bottom: var(--cerfaos-space-2);">✅</div>
        <div style="font-size: 1.2rem; font-weight: bold; color: var(--cerfaos-info);">Actif</div>
        <div style="color: var(--cerfaos-text-muted); font-size: 0.9rem;">Statut de la section</div>
      </div>
    </div>

  </div>

  <!-- Aperçu en temps réel -->
  <div class="card cerfaos-enhanced" style="margin-bottom: var(--cerfaos-space-6);">
    <div class="card__header">
      <h3 class="card__title u-flex u-items-center u-gap-3">
        <span style="font-size: 1.5rem;">👁️</span>
        Aperçu en temps réel
      </h3>
    </div>
    <div class="card__content">
      <div class="preview-container" style="background: #1a202c; padding: var(--cerfaos-space-6); border-radius: var(--cerfaos-border-radius); border: 2px dashed #4a5568;">
        
        <!-- Titre -->
        <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: var(--cerfaos-space-4); color: #ffffff;">
          {!! \App\Models\HomeContent::getValue('about_title', 'content', 'Titre par défaut') !!}
        </h2>
        
        <!-- Description -->
        <p style="font-size: 1.1rem; color: #e2e8f0; margin-bottom: var(--cerfaos-space-6); line-height: 1.6;">
          {{ \App\Models\HomeContent::getValue('about_subtitle', 'content', 'Description par défaut') }}
        </p>

        <!-- Features -->
        <div class="features-preview" style="display: grid; gap: var(--cerfaos-space-4);">
          @for($i = 1; $i <= 3; $i++)
            <div style="display: flex; align-items: flex-start; gap: var(--cerfaos-space-4); padding: var(--cerfaos-space-4); background: #2d3748; border-radius: var(--cerfaos-border-radius); box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
              <div style="width: 40px; height: 40px; background: #4a5568; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                {{ \App\Models\HomeContent::getValue("about_feature_{$i}_icon", 'content', '⭐') }}
              </div>
              <div>
                <h4 style="font-weight: 600; margin-bottom: 8px; color: #ffffff;">
                  {{ \App\Models\HomeContent::getValue("about_feature_{$i}_title", 'content', "Titre feature {$i}") }}
                </h4>
                <p style="color: #e2e8f0; font-size: 0.9rem; line-height: 1.5;">
                  {{ Str::limit(\App\Models\HomeContent::getValue("about_feature_{$i}_description", 'content', "Description feature {$i}"), 100) }}
                </p>
              </div>
            </div>
          @endfor
        </div>
      </div>
    </div>
  </div>

  <!-- Sections de gestion -->
  @foreach($aboutContents as $sectionName => $contents)
    <div class="card cerfaos-enhanced" style="margin-bottom: var(--cerfaos-space-6);">
      <div class="card__header">
        <h3 class="card__title u-flex u-items-center u-gap-3">
          <span style="font-size: 1.5rem;">
            @if($sectionName === 'Général')
              📝
            @else
              ⭐
            @endif
          </span>
          {{ $sectionName }}
        </h3>
      </div>
      <div class="card__content">
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: var(--cerfaos-space-4);">
          @foreach($contents as $content)
            <div class="content-item card" style="padding: var(--cerfaos-space-4); background: var(--cerfaos-bg-secondary); border-radius: var(--cerfaos-border-radius);">
              <div class="u-flex u-justify-between u-items-start u-mb-3">
                <div>
                  <h4 class="u-text-lg u-font-semibold">{{ $content->title }}</h4>
                  <p class="u-text-sm u-text-muted">{{ $content->description }}</p>
                </div>
                <a href="{{ route('about.content.edit', $content->key) }}" class="btn btn-sm btn-primary">
                  <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                </a>
              </div>
              
              <div class="content-preview">
                @if($content->key === 'about_image')
                  <img src="{{ str_contains($content->content, 'frontend/') ? asset($content->content) : asset('storage/' . $content->content) }}" alt="Image" style="max-width: 100px; max-height: 60px; object-fit: cover; border-radius: 4px;">
                @elseif(str_contains($content->key, 'icon'))
                  <span style="font-size: 2rem;">{{ $content->content }}</span>
                @else
                  <div class="u-text-sm" style="background: #2d3748; color: #e2e8f0; padding: var(--cerfaos-space-3); border-radius: 4px; border-left: 3px solid var(--cerfaos-accent);">
                    {{ Str::limit($content->content, 100) }}
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endforeach

</div>

@endsection