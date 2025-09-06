@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">📝</span>
      <div>
        <h1>Nouvel Article</h1>
        <p>Créer et publier un article d'aventure</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('all.blog.post') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour aux articles
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('all.blog.post') }}" class="breadcrumb__link">Articles</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Nouveau</span>
  </div>

  <!-- Form Card -->
  <div class="card" style="margin-bottom: var(--cerfaos-space-8);">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="edit"></i>
        Détails de l'Article
      </h2>
    </div>
    <div class="card__content">

      <form method="POST" action="{{ route('store.blog.post') }}" enctype="multipart/form-data">
        @csrf

        <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--cerfaos-space-8);">
          <div>
            
            <!-- Titre de l'article -->
            <div class="form-field">
              <label for="post_title" class="form-field__label">
                <span>🎯</span>
                Titre de l'article *
              </label>
              <div class="form-field__input">
                <input 
                  type="text" 
                  id="post_title" 
                  name="post_title" 
                  value="{{ old('post_title') }}"
                  placeholder="Ex: Mon incroyable randonnée dans les Alpes..."
                  required
                >
                @error('post_title')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Le titre doit être accrocheur et décrire le contenu de l'article
                </div>
              </div>
            </div>

            <!-- Description courte (50 mots) -->
            <div class="form-field">
              <label for="short_description" class="form-field__label">
                <span>📝</span>
                Description courte (50 mots) *
              </label>
              <div class="form-field__input">
                <textarea 
                  id="short_description" 
                  name="short_description" 
                  rows="3"
                  maxlength="350"
                  placeholder="Résumé captivant de votre article en maximum 50 mots..."
                  required>{{ old('short_description') }}</textarea>
                @error('short_description')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  <span id="word-count">0</span>/50 mots • 
                  <span id="char-count">0</span>/350 caractères
                </div>
              </div>
            </div>

            <!-- Catégorie -->
            <div class="form-field">
              <label for="blog_category_id" class="form-field__label">
                <span>🏷️</span>
                Catégorie *
              </label>
              <div class="form-field__input">
                <select 
                  id="blog_category_id" 
                  name="blog_category_id" 
                  required>
                  <option value="">🎪 Choisir une catégorie...</option>
                  @foreach ($category as $cat)
                  <option value="{{ $cat->id }}" {{ old('blog_category_id') == $cat->id ? 'selected' : '' }}>
                    🏔️ {{ $cat->category_name }}
                  </option>
                  @endforeach
                </select>
                @error('blog_category_id')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>

            <!-- Image principale -->
            <div class="form-field">
              <label for="image" class="form-field__label">
                <span>📸</span>
                Image principale *
              </label>
              <div class="form-field__input">
                <input 
                  type="file" 
                  id="image" 
                  name="image" 
                  accept="image/*"
                  onchange="previewImage(event)"
                  required
                >
                @error('image')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Formats acceptés: JPG, PNG, WEBP (Max: 2MB)
                </div>
                
                <!-- Prévisualisation de l'image -->
                <div class="image-preview" style="margin-top: var(--cerfaos-space-4);">
                  <img id="imagePreview" 
                    src="" 
                    alt="Aperçu" 
                    style="display: none; max-width: 200px; border-radius: var(--cerfaos-radius-md); border: 2px solid var(--cerfaos-border);">
                </div>
              </div>
            </div>

            <!-- Contenu de l'article avec éditeur TinyMCE -->
            <div class="form-field">
              <label for="long_descp" class="form-field__label">
                <span>✏️</span>
                Corps de l'article (Éditeur) *
              </label>
              <div class="form-field__input">
                <x-tinymce-editor 
                  id="long_descp"
                  name="long_descp"
                  value="{{ old('long_descp') }}"
                  required
                  :config="[
                    'placeholder' => 'Racontez votre aventure, partagez vos conseils, décrivez vos émotions...',
                    'height' => 500
                  ]"
                />
                
                @error('long_descp')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  ✨ Utilisez l'éditeur avancé : formatage, images, couleurs, émojis, etc.
                </div>
              </div>
            </div>

          </div>
          
          <!-- Sidebar avec informations complémentaires -->
          <div>
            <div class="card" style="margin-bottom: var(--cerfaos-space-6);">
              <div class="card__header">
                <h3 class="card__title u-flex u-items-center u-gap-2">
                  <span>💡</span>
                  Conseils de Rédaction
                </h3>
              </div>
              <div class="card__content">
                <ul class="u-list-none u-space-y-2">
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🎯</span> Utilisez un titre accrocheur
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>📝</span> Rédigez une description de max 50 mots
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🏷️</span> Choisissez la bonne catégorie
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>📸</span> Ajoutez une image de qualité
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>✏️</span> Utilisez l'éditeur pour formater le contenu
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🌟</span> Partagez vos émotions et conseils
                  </li>
                </ul>
              </div>
            </div>
            
            <div class="card">
              <div class="card__header">
                <h3 class="card__title u-flex u-items-center u-gap-2">
                  <span>📊</span>
                  Statistiques
                </h3>
              </div>
              <div class="card__content u-space-y-3">
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">📝 Articles total:</span>
                  <span class="badge badge--primary">{{ App\Models\BlogPost::count() }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">🏷️ Catégories:</span>
                  <span class="badge badge--secondary">{{ App\Models\BlogCategory::count() }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="form-actions u-flex u-gap-4">
          <button type="submit" class="btn btn-primary u-flex u-items-center u-gap-2">
            <i data-feather="save" style="width: 16px; height: 16px;"></i>
            Publier l'Article
          </button>
          <a href="{{ route('all.blog.post') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
            <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
            Annuler
          </a>
        </div>

      </form>
    </div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Comptage des mots pour la description courte
  function updateWordCount() {
    const shortDesc = document.getElementById('short_description');
    const text = shortDesc.value.trim();
    const words = text ? text.split(/\s+/).length : 0;
    const chars = text.length;
    
    document.getElementById('word-count').textContent = words;
    document.getElementById('char-count').textContent = chars;
    
    // Changer les couleurs selon les limites
    const wordCountSpan = document.getElementById('word-count');
    const charCountSpan = document.getElementById('char-count');
    
    if (words > 50) {
      wordCountSpan.style.color = 'var(--cerfaos-danger)';
      wordCountSpan.style.fontWeight = 'bold';
    } else if (words > 40) {
      wordCountSpan.style.color = 'var(--cerfaos-warning)';
      wordCountSpan.style.fontWeight = 'bold';
    } else {
      wordCountSpan.style.color = 'var(--cerfaos-success)';
      wordCountSpan.style.fontWeight = 'bold';
    }
    
    if (chars > 350) {
      charCountSpan.style.color = 'var(--cerfaos-danger)';
    } else if (chars > 300) {
      charCountSpan.style.color = 'var(--cerfaos-warning)';
    } else {
      charCountSpan.style.color = 'var(--cerfaos-success)';
    }
  }

  // Écouter les changements dans la description
  document.getElementById('short_description').addEventListener('input', updateWordCount);
  document.getElementById('short_description').addEventListener('paste', function() {
    setTimeout(updateWordCount, 10);
  });

  // Initialiser le comptage
  updateWordCount();
});

// Prévisualisation de l'image
function previewImage(event) {
  const file = event.target.files[0];
  const preview = document.getElementById('imagePreview');
  
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    }
    reader.readAsDataURL(file);
  } else {
    preview.style.display = 'none';
  }
}
</script>

@endsection