@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">🏠</span>
      <div>
        <h1>Gestion du Contenu</h1>
        <p>Modifiez les textes et images des différentes sections de votre page d'accueil</p>
      </div>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Contenu Page d'Accueil</span>
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

      <!-- Section Slider -->
      <div class="content-section" style="margin-bottom: var(--cerfaos-space-8);">
        <h2 class="section-title u-flex u-items-center u-gap-3">
          <span style="font-size: 1.5rem;">🎯</span>
          Section Hero / Slider
        </h2>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: var(--cerfaos-space-6); margin-top: var(--cerfaos-space-4);">
          @if($sliders && $sliders->count() > 0)
            @foreach($sliders as $slider)
              <div class="card cerfaos-enhanced cerfaos-hover-lift">
                <div class="card__header u-flex u-justify-between u-items-center">
                  <div class="u-flex u-items-center u-gap-3">
                    <span style="font-size: 1.2rem;">🖼️</span>
                    <strong>Slider #{{ $slider->id }}</strong>
                  </div>
                  <a href="{{ route('home-content.edit-slider', $slider->id) }}" class="btn btn-primary btn-sm u-flex u-items-center u-gap-2">
                    <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                    Modifier
                  </a>
                </div>
                <div class="card__content">
                  <div class="content-grid" style="gap: var(--cerfaos-space-4);">
                    <div>
                      <p class="content-item"><strong>Titre:</strong> {{ Str::limit($slider->title, 50) }}</p>
                      <p class="content-item"><strong>Description:</strong> {{ Str::limit($slider->description, 80) }}</p>
                    </div>
                    <div class="image-preview">
                      @if($slider->image && $slider->image !== 'upload/no_image.jpg')
                        <img src="{{ asset('storage/' . $slider->image) }}" alt="Image" class="preview-image" style="width: 100px; height: 60px; object-fit: cover; border-radius: var(--cerfaos-border-radius);">
                      @else
                        <div class="badge badge--secondary">Aucune image</div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="notification notification--warning">
              <div class="notification__content">
                <i data-feather="alert-triangle" class="notification__icon"></i>
                <span>Aucun slider trouvé. Un slider par défaut sera créé automatiquement.</span>
              </div>
            </div>
          @endif
        </div>
      </div>

      <!-- Sections de contenu -->
      @foreach($contents as $sectionName => $sectionContents)
        <div class="content-section" style="margin-bottom: var(--cerfaos-space-8);">
          <h2 class="section-title u-flex u-items-center u-gap-3">
            <span style="font-size: 1.5rem;">
              @switch($sectionName)
                @case('about')
                  👤
                  @break
                @case('itineraries')
                  🗺️
                  @break
                @case('sorties')
                  🏕️
                  @break
                @default
                  📄
              @endswitch
            </span>
            Section 
            @switch($sectionName)
              @case('about')
                À Propos
                @break
              @case('itineraries')
                Itinéraires
                @break
              @case('sorties')
                Sorties
                @break
              @default
                {{ ucfirst($sectionName) }}
            @endswitch
          </h2>
          
          <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: var(--cerfaos-space-6); margin-top: var(--cerfaos-space-4);">
            @foreach($sectionContents as $content)
              <div class="card cerfaos-enhanced cerfaos-hover-lift">
                <div class="card__header u-flex u-justify-between u-items-center">
                  <div class="u-flex u-items-center u-gap-3">
                    <span style="font-size: 1.2rem;">📝</span>
                    <strong>{{ $content->title }}</strong>
                  </div>
                  <a href="{{ route('home-content.edit', $content->id) }}" class="btn btn-primary btn-sm u-flex u-items-center u-gap-2">
                    <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                    Modifier
                  </a>
                </div>
                <div class="card__content">
                  <p class="u-text-muted u-text-sm" style="margin-bottom: var(--cerfaos-space-3);">{{ $content->description }}</p>
                  
                  @if(str_contains($content->key, 'image') && $content->content)
                    <div class="image-section" style="margin-bottom: var(--cerfaos-space-3);">
                      <img src="{{ asset($content->content) }}" alt="Image" class="preview-image" style="width: 100px; height: 100px; object-fit: cover; border-radius: var(--cerfaos-border-radius);">
                    </div>
                    <p class="u-text-xs u-text-muted">📁 {{ $content->content }}</p>
                  @else
                    <div class="content-preview">
                      <strong>Contenu:</strong>
                      <p class="u-text-sm" style="margin-top: var(--cerfaos-space-2);">{{ Str::limit($content->content, 100) }}</p>
                    </div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach

      @if($contents->isEmpty())
        <div class="notification notification--info">
          <div class="notification__content">
            <i data-feather="info" class="notification__icon"></i>
            <div>
              <h6 style="margin-bottom: var(--cerfaos-space-2);">Aucun contenu trouvé</h6>
              <p style="margin-bottom: var(--cerfaos-space-2);">Exécutez les migrations et seeders pour initialiser les contenus par défaut :</p>
              <code class="code-block">php artisan migrate && php artisan db:seed --class=HomeContentSeeder</code>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>

@endsection