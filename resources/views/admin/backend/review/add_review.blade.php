@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">💭</span>
      <div>
        <h1>Nouveau Témoignage</h1>
        <p>Ajouter l'expérience d'un aventurier</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('all.review') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour aux témoignages
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('all.review') }}" class="breadcrumb__link">Témoignages</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Nouveau</span>
  </div>

  <!-- Form Card -->
  <div class="card" style="margin-bottom: var(--cerfaos-space-8);">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="message-square"></i>
        Détails du Témoignage
      </h2>
    </div>
    <div class="card__content">

      <form action="{{ route('store.review') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--cerfaos-space-8);">
          <div>
            
            <!-- Nom de l'aventurier -->
            <div class="form-field">
              <label for="name" class="form-field__label">
                <span>🏔️</span>
                Nom de l'aventurier *
              </label>
              <div class="form-field__input">
                <input 
                  type="text" 
                  id="name" 
                  name="name" 
                  value="{{ old('name') }}"
                  placeholder="Ex: Marie Dupont"
                  required
                >
                @error('name')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Le nom complet de la personne qui témoigne
                </div>
              </div>
            </div>

            <!-- Profession/Spécialité -->
            <div class="form-field">
              <label for="position" class="form-field__label">
                <span>🎯</span>
                Profession / Spécialité *
              </label>
              <div class="form-field__input">
                <input 
                  type="text" 
                  id="position" 
                  name="position" 
                  value="{{ old('position') }}"
                  placeholder="Ex: Guide de montagne, Randonneur expert..."
                  required
                >
                @error('position')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Profession ou domaine d'expertise de l'aventurier
                </div>
              </div>
            </div>

            <!-- Photo de profil -->
            <div class="form-field">
              <label for="image" class="form-field__label">
                <span>📸</span>
                Photo de profil *
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
                  <img id="showImage" 
                    src="{{ url('upload/no_image.jpg') }}" 
                    alt="Aperçu photo de profil" 
                    style="max-width: 150px; border-radius: var(--cerfaos-radius-md); border: 2px solid var(--cerfaos-border);">
                </div>
              </div>
            </div>

            <!-- Message/Témoignage -->
            <div class="form-field">
              <label for="message" class="form-field__label">
                <span>💬</span>
                Message du témoignage *
              </label>
              <div class="form-field__input">
                <textarea 
                  id="message" 
                  name="message" 
                  rows="6"
                  placeholder="Partagez votre expérience, vos émotions et vos conseils d'aventure..."
                  required>{{ old('message') }}</textarea>
                @error('message')
                <div class="form-field__error">
                  <i data-feather="alert-circle"></i>
                  {{ $message }}
                </div>
                @enderror
                <div class="form-field__help">
                  Le témoignage authentique de l'aventurier
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
                    <span>🏔️</span> Utilisez le vrai nom de la personne
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>🎯</span> Précisez son domaine d'expertise
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>📸</span> Ajoutez une photo authentique
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>💬</span> Rédigez un témoignage sincère
                  </li>
                  <li class="u-flex u-items-center u-gap-2 u-text-sm">
                    <span>✨</span> Partagez des émotions vraies
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
                  <span class="u-text-sm u-text-muted">💭 Témoignages total:</span>
                  <span class="badge badge--primary">{{ \App\Models\Review::count() }}</span>
                </div>
                <div class="u-flex u-justify-between u-items-center">
                  <span class="u-text-sm u-text-muted">⭐ Note moyenne:</span>
                  <span class="badge badge--success">4.8/5</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="form-actions u-flex u-gap-4">
          <button type="submit" class="btn btn-primary u-flex u-items-center u-gap-2">
            <i data-feather="save" style="width: 16px; height: 16px;"></i>
            Enregistrer le Témoignage
          </button>
          <a href="{{ route('all.review') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
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
  const preview = document.getElementById('showImage');
  
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
}

// Initialisation de la prévisualisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
  const imageInput = document.getElementById('image');
  if (imageInput) {
    imageInput.addEventListener('change', previewImage);
  }
});
</script>

@endsection