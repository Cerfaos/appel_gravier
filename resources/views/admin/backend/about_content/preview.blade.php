@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">👁️</span>
      <div>
        <h1>Aperçu Section À Propos</h1>
        <p>Prévisualisation du rendu final de votre section "à propos"</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('about.content.index') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour à l'édition
      </a>
      <a href="{{ url('/') }}#about" target="_blank" class="btn btn-primary u-flex u-items-center u-gap-2">
        <i data-feather="external-link" style="width: 16px; height: 16px;"></i>
        Voir sur le site
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('about.content.index') }}" class="breadcrumb__link">Section À Propos</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Aperçu</span>
  </div>

  <!-- Preview Container -->
  <div class="card cerfaos-enhanced">
    <div class="card__content" style="padding: 0;">
      
      <!-- Section About Preview -->
      <div class="about-preview" style="background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%); color: white; padding: 4rem 2rem; border-radius: var(--cerfaos-border-radius);">
        
        <div class="max-width-container" style="max-width: 1200px; margin: 0 auto;">
          
          <!-- Hero Content -->
          <div class="hero-content" style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 3rem; font-weight: bold; margin-bottom: 1.5rem; background: linear-gradient(45deg, #4fd1c7, #81e6d9); background-clip: text; -webkit-background-clip: text; color: transparent;">
              {{ $aboutData['about_title']->content ?? 'Titre par défaut' }}
            </h2>
            <p style="font-size: 1.25rem; color: #e2e8f0; line-height: 1.7; max-width: 800px; margin: 0 auto;">
              {{ $aboutData['about_subtitle']->content ?? 'Description par défaut' }}
            </p>
          </div>

          <!-- Features Grid -->
          <div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
            
            @for($i = 1; $i <= 3; $i++)
              <div class="feature-card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 16px; padding: 2rem; border: 1px solid rgba(255,255,255,0.1); transition: all 0.3s ease;">
                
                <!-- Feature Icon -->
                <div class="feature-icon" style="width: 60px; height: 60px; background: linear-gradient(45deg, #4fd1c7, #81e6d9); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1.5rem;">
                  {{ $aboutData["about_feature_{$i}_icon"]->content ?? '⭐' }}
                </div>

                <!-- Feature Content -->
                <div class="feature-content">
                  <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: white;">
                    {{ $aboutData["about_feature_{$i}_title"]->content ?? "Titre feature {$i}" }}
                  </h3>
                  <p style="color: #cbd5e0; line-height: 1.6; font-size: 1rem;">
                    {{ $aboutData["about_feature_{$i}_description"]->content ?? "Description feature {$i}" }}
                  </p>
                </div>

              </div>
            @endfor

          </div>

          <!-- Image Section (if configured) -->
          @if(isset($aboutData['about_image']) && $aboutData['about_image']->content)
            <div class="image-section" style="margin-top: 4rem; text-align: center;">
              <div style="max-width: 600px; margin: 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.5);">
                <img src="{{ asset($aboutData['about_image']->content) }}" 
                     alt="About Image" 
                     style="width: 100%; height: auto; display: block;">
              </div>
            </div>
          @endif

        </div>

      </div>

    </div>
  </div>

  <!-- Informations techniques -->
  <div class="card cerfaos-enhanced" style="margin-top: var(--cerfaos-space-6);">
    <div class="card__header">
      <h3 class="card__title u-flex u-items-center u-gap-3">
        <span style="font-size: 1.5rem;">ℹ️</span>
        Informations techniques
      </h3>
    </div>
    <div class="card__content">
      <div class="info-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--cerfaos-space-4);">
        
        <div class="info-item">
          <strong>Nombre d'éléments:</strong>
          <span>{{ $aboutData->count() }} éléments configurés</span>
        </div>
        
        <div class="info-item">
          <strong>Dernière modification:</strong>
          <span>{{ $aboutData->sortByDesc('updated_at')->first()->updated_at->format('d/m/Y à H:i') ?? 'Jamais' }}</span>
        </div>
        
        <div class="info-item">
          <strong>Features configurées:</strong>
          <span>{{ $aboutData->filter(function($item) { return str_contains($item->key, 'feature_') && str_contains($item->key, '_title'); })->count() }} features</span>
        </div>
        
        <div class="info-item">
          <strong>Image principale:</strong>
          <span>{{ isset($aboutData['about_image']) ? '✅ Configurée' : '❌ Non définie' }}</span>
        </div>
        
      </div>
    </div>
  </div>

</div>

@endsection