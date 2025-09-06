@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">➕</span>
      <div>
        <h1>Nouveau Clarify</h1>
        <p>Créer un nouveau contenu pour la section "À propos"</p>
      </div>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('all.clarify') }}" class="breadcrumb__link">Section À Propos</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Nouveau</span>
  </div>

  <!-- Main Content -->
  <div class="card cerfaos-enhanced">
    <div class="card__content">
      
      <form action="{{ route('store.clarify') }}" method="POST" enctype="multipart/form-data" class="cerfaos-form">
        @csrf
        
        <div class="form-grid" style="gap: var(--cerfaos-space-6);">
          
          <!-- Section Informations générales -->
          <div class="form-section">
            <h3 class="form-section__title">
              <i data-feather="info" style="width: 20px; height: 20px;"></i>
              Informations générales
            </h3>
            
            <div class="form-row">
              <div class="form-group">
                <label class="form-label required" for="title">Titre principal</label>
                <input type="text" 
                       class="form-input @error('title') form-input--error @enderror" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       placeholder="Ex: Votre guide pour des aventures gravel exceptionnelles">
                @error('title')
                  <div class="form-error">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="subtitle">Sous-titre / Description</label>
                <textarea class="form-textarea @error('subtitle') form-input--error @enderror" 
                          id="subtitle" 
                          name="subtitle" 
                          rows="3"
                          placeholder="Description détaillée de votre approche...">{{ old('subtitle') }}</textarea>
                @error('subtitle')
                  <div class="form-error">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="image">Image principale</label>
                <input type="file" 
                       class="form-input @error('image') form-input--error @enderror" 
                       id="image" 
                       name="image" 
                       accept="image/*">
                <div class="form-help">Formats acceptés: JPG, PNG, GIF (max 2MB)</div>
                @error('image')
                  <div class="form-error">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Section Features -->
          <div class="form-section">
            <h3 class="form-section__title">
              <i data-feather="star" style="width: 20px; height: 20px;"></i>
              Fonctionnalités (3 maximum)
            </h3>
            
            <!-- Feature 1 -->
            <div class="feature-group">
              <h4 class="feature-title">Feature 1</h4>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="feature_1_icon">Icône (emoji)</label>
                  <input type="text" 
                         class="form-input" 
                         id="feature_1_icon" 
                         name="feature_1_icon" 
                         value="{{ old('feature_1_icon') }}" 
                         placeholder="🚴‍♂️">
                </div>
                <div class="form-group">
                  <label class="form-label" for="feature_1_title">Titre</label>
                  <input type="text" 
                         class="form-input" 
                         id="feature_1_title" 
                         name="feature_1_title" 
                         value="{{ old('feature_1_title') }}" 
                         placeholder="Une balade sans chrono">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="feature_1_description">Description</label>
                  <textarea class="form-textarea" 
                            id="feature_1_description" 
                            name="feature_1_description" 
                            rows="2"
                            placeholder="Description de cette fonctionnalité...">{{ old('feature_1_description') }}</textarea>
                </div>
              </div>
            </div>

            <!-- Feature 2 -->
            <div class="feature-group">
              <h4 class="feature-title">Feature 2</h4>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="feature_2_icon">Icône (emoji)</label>
                  <input type="text" 
                         class="form-input" 
                         id="feature_2_icon" 
                         name="feature_2_icon" 
                         value="{{ old('feature_2_icon') }}" 
                         placeholder="🌿">
                </div>
                <div class="form-group">
                  <label class="form-label" for="feature_2_title">Titre</label>
                  <input type="text" 
                         class="form-input" 
                         id="feature_2_title" 
                         name="feature_2_title" 
                         value="{{ old('feature_2_title') }}" 
                         placeholder="Des chemins à découvrir">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="feature_2_description">Description</label>
                  <textarea class="form-textarea" 
                            id="feature_2_description" 
                            name="feature_2_description" 
                            rows="2"
                            placeholder="Description de cette fonctionnalité...">{{ old('feature_2_description') }}</textarea>
                </div>
              </div>
            </div>

            <!-- Feature 3 -->
            <div class="feature-group">
              <h4 class="feature-title">Feature 3</h4>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="feature_3_icon">Icône (emoji)</label>
                  <input type="text" 
                         class="form-input" 
                         id="feature_3_icon" 
                         name="feature_3_icon" 
                         value="{{ old('feature_3_icon') }}" 
                         placeholder="🤝">
                </div>
                <div class="form-group">
                  <label class="form-label" for="feature_3_title">Titre</label>
                  <input type="text" 
                         class="form-input" 
                         id="feature_3_title" 
                         name="feature_3_title" 
                         value="{{ old('feature_3_title') }}" 
                         placeholder="Un moment à partager">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="feature_3_description">Description</label>
                  <textarea class="form-textarea" 
                            id="feature_3_description" 
                            name="feature_3_description" 
                            rows="2"
                            placeholder="Description de cette fonctionnalité...">{{ old('feature_3_description') }}</textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- Section Options -->
          <div class="form-section">
            <h3 class="form-section__title">
              <i data-feather="settings" style="width: 20px; height: 20px;"></i>
              Options
            </h3>
            
            <div class="form-row">
              <div class="form-group">
                <label class="form-checkbox">
                  <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                  <span class="form-checkbox__indicator"></span>
                  <span class="form-checkbox__label">Activé (visible sur le site)</span>
                </label>
              </div>
            </div>
          </div>

        </div>

        <!-- Actions -->
        <div class="form-actions">
          <a href="{{ route('all.clarify') }}" class="btn btn-secondary">
            <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
            Annuler
          </a>
          <button type="submit" class="btn btn-primary">
            <i data-feather="save" style="width: 16px; height: 16px;"></i>
            Enregistrer
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<style>
.feature-group {
  background: var(--cerfaos-bg-secondary);
  padding: var(--cerfaos-space-4);
  border-radius: var(--cerfaos-border-radius);
  margin-bottom: var(--cerfaos-space-4);
}

.feature-title {
  font-size: var(--cerfaos-font-size-lg);
  font-weight: 600;
  color: var(--cerfaos-text-primary);
  margin-bottom: var(--cerfaos-space-3);
  display: flex;
  align-items: center;
  gap: var(--cerfaos-space-2);
}

.feature-title::before {
  content: "⭐";
  font-size: var(--cerfaos-font-size-sm);
}
</style>

@endsection