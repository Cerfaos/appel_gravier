@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">📝</span>
      <div>
        <h1>Modifier l'Article</h1>
        <p>Mettre à jour "{{ $post->post_title }}"</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('all.blog.post') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour aux articles
      </a>
    </div>
  </div>

  <!-- Form Card -->
  <div class="card" style="margin-bottom: var(--cerfaos-space-8);">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="edit-3"></i>
        Modifier l'Article
      </h2>
    </div>
    <div class="card__content">

      <form method="POST" action="{{ route('update.blog.post') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $post->id }}">

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
                  value="{{ old('post_title', $post->post_title) }}"
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
                  required>{{ old('short_description', $post->short_description) }}</textarea>
                @error('short_description')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  <span id="word-count-edit">0</span>/50 mots • 
                  <span id="char-count-edit">0</span>/350 caractères
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
                  <option value="{{ $cat->id }}" {{ (old('blog_category_id', $post->blog_category_id) == $cat->id) ? 'selected' : '' }}>
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

            <!-- Image actuelle -->
            <div class="form-field">
              <label class="form-field__label">
                <span>🖼️</span>
                Image actuelle
              </label>
              <div class="form-field__input">
                <div style="padding: var(--cerfaos-space-4); background: var(--cerfaos-bg-subtle); border-radius: var(--cerfaos-radius-md); border: 1px solid var(--cerfaos-border);">
                  @if($post->image)
                  <img src="{{ asset($post->image) }}" 
                    alt="Image actuelle" 
                    style="max-width: 200px; border-radius: var(--cerfaos-radius-sm);">
                  @else
                  <div class="u-text-muted u-text-sm">
                    <i data-feather="image" style="width: 16px; height: 16px;"></i>
                    Aucune image
                  </div>
                  @endif
                </div>
              </div>
            </div>

            <!-- Nouvelle image -->
            <div class="form-field">
              <label for="image" class="form-field__label">
                <span>📸</span>
                Changer l'image (optionnel)
              </label>
              <div class="form-field__input">
                <input 
                  type="file" 
                  id="image" 
                  name="image" 
                  accept="image/*"
                  onchange="previewImage(event)"
                >
                @error('image')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Formats acceptés: JPG, PNG, WEBP (Max: 2MB) - Laissez vide pour conserver l'image actuelle
                </div>
                
                <!-- Prévisualisation de la nouvelle image -->
                <div class="image-preview" style="margin-top: var(--cerfaos-space-4);">
                  <img id="imagePreview" 
                    src="" 
                    alt="Aperçu nouvelle image" 
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
                  value="{{ old('long_descp', $post->long_descp) }}"
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
                  <span>📊</span>
                  Informations Article
                </h3>
              </div>
              <div class="card__content u-space-y-3">
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">📅 Créé le:</span>
                  <span class="badge badge--secondary">{{ $post->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">🔄 Modifié le:</span>
                  <span class="badge badge--info">{{ $post->updated_at->format('d/m/Y') }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">🏷️ Catégorie:</span>
                  <span class="badge badge--primary">{{ $post->blogCategory->category_name ?? 'Aucune' }}</span>
                </div>
                <div>
                  <span class="u-text-sm u-text-muted">🔗 Slug:</span>
                  <div class="u-text-xs u-text-muted u-mt-1" style="word-break: break-all;">{{ $post->post_slug }}</div>
                </div>
              </div>
            </div>
            
            <div class="card">
              <div class="card__header">
                <h3 class="card__title u-flex u-items-center u-gap-2">
                  <span>💡</span>
                  Conseils de Modification
                </h3>
              </div>
              <div class="card__content">
                <ul class="u-list-none u-space-y-2">
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>✅</span> Vérifiez l'orthographe
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>📸</span> Changez l'image si nécessaire
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🏷️</span> Ajustez la catégorie
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>✨</span> Enrichissez le contenu
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🔍</span> Optimisez pour le SEO
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="form-actions u-flex u-gap-4">
          <button type="submit" class="btn btn-primary u-flex u-items-center u-gap-2">
            <i data-feather="save" style="width: 16px; height: 16px;"></i>
            Mettre à Jour l'Article
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

// Comptage des mots pour la description courte (page d'édition)
function updateWordCountEdit() {
  const shortDesc = document.getElementById('short_description');
  if (shortDesc) {
    const text = shortDesc.value.trim();
    const words = text ? text.split(/\s+/).length : 0;
    const chars = text.length;
    
    const wordCountSpan = document.getElementById('word-count-edit');
    const charCountSpan = document.getElementById('char-count-edit');
    
    if (wordCountSpan) wordCountSpan.textContent = words;
    if (charCountSpan) charCountSpan.textContent = chars;
    
    // Changer les couleurs selon les limites
    if (wordCountSpan) {
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
    }
    
    if (charCountSpan) {
      if (chars > 350) {
        charCountSpan.style.color = 'var(--cerfaos-danger)';
      } else if (chars > 300) {
        charCountSpan.style.color = 'var(--cerfaos-warning)';
      } else {
        charCountSpan.style.color = 'var(--cerfaos-success)';
      }
    }
  }
}

// Écouter les changements dans la description (page d'édition)
document.addEventListener('DOMContentLoaded', function() {
  const shortDescEdit = document.getElementById('short_description');
  if (shortDescEdit) {
    shortDescEdit.addEventListener('input', updateWordCountEdit);
    shortDescEdit.addEventListener('paste', function() {
      setTimeout(updateWordCountEdit, 10);
    });
    // Initialiser le comptage
    updateWordCountEdit();
  }
});
</script>

@endsection