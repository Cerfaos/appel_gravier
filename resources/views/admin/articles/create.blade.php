@extends('admin.admin_master_outdoor')

@section('admin')
<div class="page-content">
 <div class="container">

 <!-- start page title -->
 <div class="content">
 <div class="content-wrapper">
 <div class="page-header">
 <h4>Nouvel Article</h4>

 <div class="page-actions">
 <ol class="breadcrumb">
 <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
 <li><a href="{{ route('admin.all.articles') }}">Articles</a></li>
 <li>Nouveau</li>
 </ol>
 </div>
 </div>
 </div>
 </div>
 <!-- end page title -->

 <div class="content">
 <div class="content-wrapper">
 <div class="card">
 <div>
 <h5>
 <i data-feather="plus me-2"></i>
 🎯 FORMULAIRE MODIFIÉ - Créer un nouvel article
 </h5>
 <div>
 ✅ Formulaire mis à jour avec les champs demandés
 </div>
 </div>
 <div>

 @if ($errors->any())
 <div>
 <ul>
 @foreach ($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 </div>
 @endif

 <form action="{{ route('admin.store.article') }}" method="POST" enctype="multipart/form-data" id="articleForm">
 @csrf

 <div class="content">
 <!-- Colonne principale -->
 <div>
 
 <!-- Informations de base -->
 <div>
 <div>
 <h6>Contenu Principal</h6>
 </div>
 <div>
 <div>
 <label for="title">Titre de l'article <span>*</span></label>
 <input type="text" 
 
 id="title" 
 name="title" 
 value="{{ old('title') }}" 
 required>
 @error('title')
 <div class="error-message">{{ $message }}</div>
 @enderror
 </div>

 <div>
 <label for="excerpt">Description courte <span>*</span></label>
 <textarea 
 id="excerpt" 
 name="excerpt" 
 rows="3"
 maxlength="350"
 placeholder="Description courte de l'article (maximum 50 mots / 350 caractères)"
 required>{{ old('excerpt') }}</textarea>
 <div>
 <span id="word-count">0</span>/50 mots • 
 <span id="char-count">0</span>/350 caractères
 </div>
 @error('excerpt')
 <div class="error-message">{{ $message }}</div>
 @enderror
 </div>

 <div>
 <label for="content">Contenu de l'article <span>*</span></label>
 <textarea 
 id="content" 
 name="content" 
 rows="15" 
 required>{{ old('content') }}</textarea>
 @error('content')
 <div class="error-message">{{ $message }}</div>
 @enderror
 </div>
 </div>
 </div>

 <!-- SEO & Métadonnées -->
 <div>
 <div>
 <h6>SEO & Métadonnées</h6>
 </div>
 <div>
 <div>
 <label for="meta_title">Titre SEO</label>
 <input type="text" 
 
 id="meta_title" 
 name="meta_title" 
 value="{{ old('meta_title') }}"
 maxlength="255">
 <div>Titre pour les moteurs de recherche (optionnel)</div>
 @error('meta_title')
 <div class="error-message">{{ $message }}</div>
 @enderror
 </div>

 <div>
 <label for="meta_description">Description SEO</label>
 <textarea 
 id="meta_description" 
 name="meta_description" 
 rows="3"
 maxlength="500">{{ old('meta_description') }}</textarea>
 <div>Description pour les moteurs de recherche (optionnel)</div>
 @error('meta_description')
 <div class="error-message">{{ $message }}</div>
 @enderror
 </div>
 </div>
 </div>

 </div>

 <!-- Colonne latérale -->
 <div>
 
 <!-- Actions -->
 <div>
 <div>
 <h6>Publication</h6>
 </div>
 <div>
 <div>
 <label for="status">Statut</label>
 <select 
 id="status" 
 name="status">
 <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
 Brouillon
 </option>
 <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
 Publier immédiatement
 </option>
 </select>
 @error('status')
 <div class="error-message">{{ $message }}</div>
 @enderror
 </div>

 <div>
 <button type="submit">
 <i data-feather="save"></i> Créer l'article
 </button>
 
 <a href="{{ route('admin.all.articles') }}" class="btn btn-secondary">
 <i></i> Annuler
 </a>
 </div>
 </div>
 </div>

 <!-- Organisation -->
 <div>
 <div>
 <h6>Organisation</h6>
 </div>
 <div>
 <div>
 <label for="category">Catégorie <span>*</span></label>
 <select 
 id="category" 
 name="category" 
 required>
 <option value="">Sélectionnez une catégorie</option>
 @if(isset($categories))
 @foreach($categories as $blogCategory)
 <option value="{{ $blogCategory->category_slug }}" {{ old('category') == $blogCategory->category_slug ? 'selected' : '' }}>
 {{ $blogCategory->category_name }}
 </option>
 @endforeach
 @endif
 </select>
 @error('category')
 <div class="error-message">{{ $message }}</div>
 @enderror
 </div>

 <div>
 <label for="tags">Tags</label>
 <input type="text" 
 
 id="tags" 
 name="tags" 
 value="{{ old('tags') }}"
 placeholder="randonnée, vélo, montagne">
 <div>Séparez les tags par des virgules</div>
 @error('tags')
 <div class="error-message">{{ $message }}</div>
 @enderror
 </div>

 <div>
 <label for="itinerary_id">Itinéraire associé</label>
 <select 
 id="itinerary_id" 
 name="itinerary_id">
 <option value="">Aucun itinéraire</option>
 @foreach($itineraries as $itinerary)
 <option value="{{ $itinerary->id }}" 
 {{ old('itinerary_id', $selectedItinerary?->id) == $itinerary->id ? 'selected' : '' }}>
 {{ $itinerary->title }}
 </option>
 @endforeach
 </select>
 <div>Associez cet article à un itinéraire spécifique</div>
 @error('itinerary_id')
 <div class="error-message">{{ $message }}</div>
 @enderror
 </div>
 </div>
 </div>

 <!-- Image principale -->
 <div>
 <div>
 <h6>Image Principale</h6>
 </div>
 <div>
 <div>
 <label for="featured_image">Image de couverture</label>
 <input type="file" 
 
 id="featured_image" 
 name="featured_image" 
 accept="image/*">
 <div>
 Formats acceptés : JPEG, PNG, JPG, GIF (Max : 2MB)
 </div>
 @error('featured_image')
 <div class="error-message">{{ $message }}</div>
 @enderror
 </div>
 
 <div id="image-preview" >
 <img id="preview-img" src="" alt="Aperçu" class="img-thumbnail" >
 </div>
 </div>
 </div>
 
 </div>
 </div>
 </form>
 </div>
 </div>
 </div>
 </div>
 </div>
</div>

<!-- Styles personnalisés -->
<style>
 .form-label {
 font-weight: 600;
 color: #374151;
 }
 
 .card-header {
 background-color: #f8fafc;
 border-bottom: 1px solid #e5e7eb;
 }
 
 .card-header h6 {
 color: #606c38;
 font-weight: 600;
 }
 
 #word-count, #char-count {
 font-weight: 600;
 transition: color 0.3s ease;
 }
 
 .form-control:focus, .form-select:focus {
 border-color: #606c38;
 box-shadow: 0 0 0 0.2rem rgba(96, 108, 56, 0.25);
 }
 
 .btn-success {
 background-color: #606c38;
 border-color: #606c38;
 }
 
 .btn-success:hover {
 background-color: #4a5429;
 border-color: #4a5429;
 }
 
 .image-preview {
 border: 2px dashed #e5e7eb;
 border-radius: 8px;
 padding: 10px;
 text-align: center;
 transition: border-color 0.3s ease;
 }
 
 .image-preview:hover {
 border-color: #606c38;
 }
 
 .text-danger {
 color: #dc2626 !important;
 }
 
 .breadcrumb-item  .breadcrumb-item::before {
 color: #6b7280;
 }
 
 .page-title-box h4 {
 color: #283618;
 font-weight: 700;
 }
</style>

<!-- Inclure TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
 // Initialiser TinyMCE pour l'éditeur de contenu
 tinymce.init({
 selector: '#content',
 height: 500,
 plugins: [
 'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
 'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
 'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount',
 'emoticons', 'codesample'
 ],
 toolbar: 'undo redo | blocks fontfamily fontsize | ' 
 'bold italic underline strikethrough | alignleft aligncenter ' 
 'alignright alignjustify | bullist numlist outdent indent | ' 
 'removeformat | link image media table | code preview fullscreen | ' 
 'emoticons charmap codesample | help',
 menubar: 'file edit view insert format tools table help',
 branding: false,
 content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 16px; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }',
 language: 'fr_FR',
 image_advtab: true,
 image_caption: true,
 image_list: false,
 image_title: true,
 file_picker_types: 'image',
 automatic_uploads: true,
 paste_data_images: true,
 setup: function(editor) {
 editor.on('change keyup', function() {
 editor.save();
 });
 },
 // Configuration pour les images
 images_upload_handler: function (blobInfo, success, failure) {
 // Cette fonction sera appelée quand une image est uploadée
 // Pour l'instant, on accepte les images mais sans upload réel
 success(blobInfo.blob());
 },
 // Style du contenu
 content_css: [
 '//fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'
 ],
 font_formats: 'Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Inter=Inter,sans-serif; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
 fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt',
 // Configuration avancée
 block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre',
 contextmenu: 'link image table',
 skin: 'oxide',
 statusbar: true
 });

 // Comptage des mots et caractères pour la description
 function updateWordCount() {
 const excerpt = document.getElementById('excerpt');
 const text = excerpt.value.trim();
 const words = text ? text.split(/\s+/).length : 0;
 const chars = text.length;
 
 document.getElementById('word-count').textContent = words;
 document.getElementById('char-count').textContent = chars;
 
 // Changer la couleur si on dépasse la limite
 const wordCountSpan = document.getElementById('word-count');
 const charCountSpan = document.getElementById('char-count');
 
 if (words > 50) {
 wordCountSpan.style.color = '#dc3545';
 } else {
 wordCountSpan.style.color = words > 40 ? '#ffc107' : '#28a745';
 }
 
 if (chars > 350) {
 charCountSpan.style.color = '#dc3545';
 } else {
 charCountSpan.style.color = chars > 300 ? '#ffc107' : '#28a745';
 }
 }

 // Écouter les changements dans la description
 document.getElementById('excerpt').addEventListener('input', updateWordCount);
 document.getElementById('excerpt').addEventListener('paste', function() {
 setTimeout(updateWordCount, 10);
 });

 // Initialiser le comptage au chargement
 updateWordCount();

 // Prévisualisation de l'image
 document.getElementById('featured_image').addEventListener('change', function(e) {
 const file = e.target.files[0];
 if (file) {
 const reader = new FileReader();
 reader.onload = function(e) {
 document.getElementById('preview-img').src = e.target.result;
 document.getElementById('image-preview').style.display = 'block';
 }
 reader.readAsDataURL(file);
 } else {
 document.getElementById('image-preview').style.display = 'none';
 }
 });

 // Auto-génération du meta_title depuis le title si vide
 document.getElementById('title').addEventListener('blur', function() {
 const metaTitle = document.getElementById('meta_title');
 if (!metaTitle.value.trim() && this.value.trim()) {
 metaTitle.value = this.value;
 }
 });

 // Auto-génération du meta_description depuis l'excerpt si vide
 document.getElementById('excerpt').addEventListener('blur', function() {
 const metaDescription = document.getElementById('meta_description');
 if (!metaDescription.value.trim() && this.value.trim()) {
 metaDescription.value = this.value.substring(0, 160)  (this.value.length > 160 ? '...' : '');
 }
 });

 // Validation avant soumission
 document.getElementById('articleForm').addEventListener('submit', function(e) {
 // Synchroniser TinyMCE
 tinymce.triggerSave();
 
 // Validation basique côté client
 const title = document.getElementById('title').value.trim();
 const excerpt = document.getElementById('excerpt').value.trim();
 const content = document.getElementById('content').value.trim();
 const category = document.getElementById('category').value;
 
 if (!title) {
 alert('Le titre est obligatoire');
 document.getElementById('title').focus();
 e.preventDefault();
 return;
 }
 
 if (!excerpt) {
 alert('La description courte est obligatoire');
 document.getElementById('excerpt').focus();
 e.preventDefault();
 return;
 }
 
 // Vérifier la limite de mots pour la description
 const wordCount = excerpt.split(/\s+/).length;
 if (wordCount > 50) {
 alert('La description ne peut pas dépasser 50 mots. Vous avez '  wordCount  ' mots.');
 document.getElementById('excerpt').focus();
 e.preventDefault();
 return;
 }
 
 if (!content) {
 alert('Le contenu est obligatoire');
 tinymce.get('content').focus();
 e.preventDefault();
 return;
 }
 
 if (!category) {
 alert('La catégorie est obligatoire');
 document.getElementById('category').focus();
 e.preventDefault();
 return;
 }
 });
});
</script>

@endsection