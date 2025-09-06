@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">✏️</span>
      <div>
        <h1>Modifier le contenu</h1>
        <p>{{ $content->title }}</p>
      </div>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('about.content.index') }}" class="breadcrumb__link">Section À Propos</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Modifier</span>
  </div>

  <!-- Main Content -->
  <div class="card cerfaos-enhanced">
    <div class="card__content">
      
      <form action="{{ route('about.content.update', $content->key) }}" method="POST" enctype="multipart/form-data" class="cerfaos-form">
        @csrf
        @method('PUT')
        
        <div class="form-grid" style="gap: var(--cerfaos-space-6);">
          
          <!-- Section informations -->
          <div class="form-section">
            <h3 class="form-section__title">
              <i data-feather="info" style="width: 20px; height: 20px;"></i>
              Informations
            </h3>
            
            <div class="info-card" style="background: var(--cerfaos-bg-secondary); padding: var(--cerfaos-space-4); border-radius: var(--cerfaos-border-radius); margin-bottom: var(--cerfaos-space-4);">
              <p><strong>Titre:</strong> {{ $content->title }}</p>
              <p><strong>Description:</strong> {{ $content->description }}</p>
              <p><strong>Clé:</strong> <code>{{ $content->key }}</code></p>
            </div>
          </div>

          <!-- Section modification -->
          <div class="form-section">
            <h3 class="form-section__title">
              <i data-feather="edit-2" style="width: 20px; height: 20px;"></i>
              Contenu
            </h3>
            
            @if($content->key === 'about_image')
              <!-- Image field -->
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Image actuelle</label>
                  <div style="margin-bottom: var(--cerfaos-space-4);">
                    <img src="{{ asset($content->content) }}" alt="Image actuelle" style="max-width: 200px; max-height: 150px; object-fit: cover; border-radius: var(--cerfaos-border-radius); border: 2px solid var(--cerfaos-border);">
                  </div>
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="image_file">Changer l'image</label>
                  <div class="file-upload-container" style="border: 2px dashed var(--cerfaos-border); border-radius: var(--cerfaos-border-radius); padding: var(--cerfaos-space-6); text-align: center; background: var(--cerfaos-bg-secondary);">
                    <div class="file-upload-icon" style="font-size: 3rem; margin-bottom: var(--cerfaos-space-3);">📷</div>
                    <input type="file" 
                           class="form-input @error('image_file') form-input--error @enderror" 
                           id="image_file" 
                           name="image_file" 
                           accept="image/*"
                           style="margin-bottom: var(--cerfaos-space-3);">
                    <div class="form-help">
                      <strong>Formats acceptés:</strong> JPG, PNG, GIF, WebP (max 2MB)<br>
                      <strong>Dimensions recommandées:</strong> 400x300px minimum
                    </div>
                    @error('image_file')
                      <div class="form-error">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              
            @elseif(str_contains($content->key, 'title') && $content->key === 'about_title')
              <!-- HTML title field -->
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label required" for="content">Contenu HTML</label>
                  <textarea class="form-textarea @error('content') form-input--error @enderror" 
                            id="content" 
                            name="content" 
                            rows="3"
                            style="font-family: 'Courier New', monospace;"
                            placeholder="Vous pouvez utiliser du HTML comme <span class=&quot;text-outdoor-olive-500&quot;>texte coloré</span>">{{ old('content', $content->content) }}</textarea>
                  <div class="form-help">Vous pouvez utiliser du HTML pour la mise en forme. Exemple: &lt;span class="text-outdoor-olive-500"&gt;texte vert&lt;/span&gt;</div>
                  @error('content')
                    <div class="form-error">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
            @elseif(str_contains($content->key, 'icon'))
              <!-- Icon field -->
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label required" for="content">Icône (emoji)</label>
                  <input type="text" 
                         class="form-input @error('content') form-input--error @enderror" 
                         id="content" 
                         name="content" 
                         value="{{ old('content', $content->content) }}" 
                         placeholder="🚴‍♂️"
                         style="font-size: 1.5rem; text-align: center;">
                  <div class="form-help">Utilisez un emoji ou un caractère spécial</div>
                  @error('content')
                    <div class="form-error">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
            @elseif(str_contains($content->key, 'description'))
              <!-- Description field -->
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label required" for="content">Description</label>
                  <textarea class="form-textarea @error('content') form-input--error @enderror" 
                            id="content" 
                            name="content" 
                            rows="4"
                            placeholder="Décrivez cette fonctionnalité...">{{ old('content', $content->content) }}</textarea>
                  @error('content')
                    <div class="form-error">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
            @else
              <!-- Text field -->
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label required" for="content">Contenu</label>
                  <textarea class="form-textarea @error('content') form-input--error @enderror" 
                            id="content" 
                            name="content" 
                            rows="3"
                            placeholder="Votre contenu...">{{ old('content', $content->content) }}</textarea>
                  @error('content')
                    <div class="form-error">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            @endif

          </div>

        </div>

        <!-- Actions -->
        <div class="form-actions">
          <a href="{{ route('about.content.index') }}" class="btn btn-secondary">
            <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
            Retour
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

@endsection

<style>
/* Thème sombre pour les champs de texte */
.form-input,
.form-textarea {
    color: #e2e8f0 !important; /* Texte clair sur fond sombre */
    background-color: #2d3748 !important; /* Fond sombre */
    border: 1px solid #4a5568 !important; /* Bordure grise */
}

.form-input:focus,
.form-textarea:focus {
    color: #ffffff !important; /* Texte blanc en focus */
    background-color: #1a202c !important; /* Fond plus sombre en focus */
    border-color: #606c38 !important; /* Couleur CERFAOS */
    box-shadow: 0 0 0 3px rgba(96, 108, 56, 0.2) !important;
}

.form-input::placeholder,
.form-textarea::placeholder {
    color: #a0aec0 !important; /* Placeholder visible sur fond sombre */
}

/* Labels en thème sombre */
.form-label {
    color: #f7fafc !important; /* Labels blancs */
    font-weight: 600 !important;
}

/* Aide en thème sombre */
.form-help {
    color: #cbd5e0 !important; /* Aide en gris clair */
}

/* Erreurs en thème sombre */
.form-error {
    color: #f87171 !important; /* Rouge plus clair pour fond sombre */
    font-weight: 500 !important;
}

/* Conteneur d'upload en thème sombre */
.file-upload-container {
    color: #e2e8f0 !important; /* Texte clair */
    background-color: #2d3748 !important; /* Fond sombre */
    border-color: #4a5568 !important; /* Bordure sombre */
}

/* Style pour les champs spéciaux */
#content {
    font-size: 16px !important;
    line-height: 1.5 !important;
}

/* Style pour le champ icône en thème sombre */
input[name="content"][style*="font-size: 1.5rem"] {
    color: #e2e8f0 !important; /* Texte clair pour thème sombre */
    font-weight: normal !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image_file');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Trouver l'image actuelle et créer un aperçu
                    const currentImage = document.querySelector('img[alt="Image actuelle"]');
                    if (currentImage) {
                        currentImage.src = e.target.result;
                        currentImage.style.border = '3px solid var(--cerfaos-accent)';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>