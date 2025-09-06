@extends('admin.admin_master_outdoor')
@section('admin')

<div class="outdoor-page-wrapper">
    <!-- Header Section -->
    <div class="outdoor-page-header">
        <div class="header-content">
            <div class="header-left">
                <div class="page-icon">🎬</div>
                <div class="header-info">
                    <h1 class="page-title">Gestion du Slider Principal</h1>
                    <p class="page-subtitle">Configurez l'image et le contenu du slider de la page d'accueil</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn-secondary">
                    <i data-feather="arrow-left"></i>
                    Retour Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('message'))
    <div class="alert alert-success">
        <div class="alert-icon">✅</div>
        <div class="alert-content">
            <strong>Succès!</strong>
            {{ session('message') }}
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <i data-feather="x"></i>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <div class="alert-icon">⚠️</div>
        <div class="alert-content">
            <strong>Erreurs détectées:</strong>
            <ul class="error-list">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <i data-feather="x"></i>
        </button>
    </div>
    @endif

    <!-- Main Content -->
    <div class="outdoor-content-grid">
        
        <!-- Form Section -->
        <div class="content-card main-form-card">
            <div class="card-header">
                <div class="card-header-icon">📝</div>
                <div class="card-header-content">
                    <h3 class="card-title">Configuration du Slider</h3>
                    <p class="card-subtitle">Modifiez le contenu et l'apparence du slider principal</p>
                </div>
            </div>

            <form action="{{ route('update.slider') }}" method="post" enctype="multipart/form-data" class="slider-form">
                @csrf
                <input type="hidden" name="id" value="{{ $slider->id }}">

                <div class="form-grid">
                    <!-- Title Field -->
                    <div class="form-group">
                        <label class="form-label">
                            <i data-feather="type"></i>
                            Titre du Slider
                            <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               value="{{ old('title', $slider->title) }}" 
                               class="form-input" 
                               placeholder="Ex: Découvrez les Alpes..."
                               required>
                        <div class="form-hint">Le titre principal qui apparaîtra sur le slider</div>
                    </div>

                    <!-- Link Field -->
                    <div class="form-group">
                        <label class="form-label">
                            <i data-feather="link"></i>
                            Lien de Destination
                            <span class="required">*</span>
                        </label>
                        <input type="url" 
                               name="link" 
                               value="{{ old('link', $slider->link) }}" 
                               class="form-input" 
                               placeholder="https://exemple.com ou /page-interne"
                               required>
                        <div class="form-hint">URL vers laquelle le slider redirige (interne ou externe)</div>
                    </div>

                    <!-- Description Field -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i data-feather="align-left"></i>
                            Description
                            <span class="required">*</span>
                        </label>
                        <div class="textarea-wrapper">
                            <textarea name="description" 
                                    class="form-textarea" 
                                    rows="4" 
                                    placeholder="Description engageante qui accompagne le slider..."
                                    required>{{ old('description', $slider->description) }}</textarea>
                            <div class="textarea-counter">
                                <span id="char-count">{{ strlen($slider->description) }}</span>/500 caractères
                            </div>
                        </div>
                        <div class="form-hint">Description qui apparaîtra sous le titre du slider</div>
                    </div>

                    <!-- Image Upload Field -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i data-feather="image"></i>
                            Image du Slider
                        </label>
                        <div class="image-upload-zone" id="imageUploadZone">
                            <input type="file" 
                                   name="image" 
                                   id="imageInput" 
                                   accept="image/*"
                                   class="image-input">
                            <div class="upload-content">
                                <div class="upload-icon">📸</div>
                                <div class="upload-text">
                                    <strong>Cliquez pour sélectionner</strong> ou glissez l'image ici
                                </div>
                                <div class="upload-requirements">
                                    JPG, PNG ou GIF • Max 2MB • Recommandé: 1920x1080px
                                </div>
                            </div>
                        </div>
                        <div class="form-hint">Image principale du slider (format paysage recommandé)</div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary btn-lg">
                        <i data-feather="save"></i>
                        Mettre à Jour le Slider
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn-secondary btn-lg">
                        <i data-feather="x"></i>
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <!-- Preview Section -->
        <div class="content-card preview-card">
            <div class="card-header">
                <div class="card-header-icon">👁️</div>
                <div class="card-header-content">
                    <h3 class="card-title">Aperçu du Slider</h3>
                    <p class="card-subtitle">Visualisation en temps réel</p>
                </div>
            </div>

            <div class="slider-preview">
                <div class="preview-container">
                    <div class="preview-image-wrapper">
                        <img id="previewImage" 
                             src="{{ asset($slider->image) }}" 
                             alt="Aperçu du slider"
                             class="preview-image">
                        <div class="preview-overlay">
                            <div class="preview-content">
                                <h4 id="previewTitle" class="preview-title">{{ $slider->title }}</h4>
                                <p id="previewDescription" class="preview-description">{{ $slider->description }}</p>
                                <div class="preview-button">
                                    <span>Découvrir</span>
                                    <i data-feather="arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Info -->
                <div class="preview-info">
                    <div class="info-item">
                        <span class="info-label">Dimensions actuelles:</span>
                        <span id="imageDimensions" class="info-value">Calcul en cours...</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Taille du fichier:</span>
                        <span id="fileSize" class="info-value">Calcul en cours...</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Dernière modification:</span>
                        <span class="info-value">{{ $slider->updated_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Usage Tips -->
            <div class="tips-section">
                <h4 class="tips-title">
                    <i data-feather="lightbulb"></i>
                    Conseils d'Optimisation
                </h4>
                <ul class="tips-list">
                    <li>Utilisez des images haute résolution (1920x1080px minimum)</li>
                    <li>Privilégiez un format paysage pour un meilleur rendu</li>
                    <li>Évitez les textes sur l'image (utilisez les champs titre/description)</li>
                    <li>Compressez vos images pour améliorer les performances</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Styles personnalisés -->
<style>
/* Variables CSS pour cohérence avec le thème outdoor */
:root {
    --outdoor-primary: #606c38;
    --outdoor-primary-dark: #495029;
    --outdoor-secondary: #dda15e;
    --outdoor-accent: #bc6c25;
    --outdoor-success: #2d5016;
    --outdoor-danger: #c5481a;
    --outdoor-light: #fefae0;
    --outdoor-gray: #8b8c89;
    --outdoor-dark: #283618;
    --border-radius: 12px;
    --shadow-soft: 0 4px 20px rgba(0,0,0,0.08);
    --shadow-hover: 0 8px 32px rgba(0,0,0,0.12);
}

/* Page Layout */
.outdoor-page-wrapper {
    padding: 24px;
    max-width: 1400px;
    margin: 0 auto;
}

.outdoor-page-header {
    background: linear-gradient(135deg, var(--outdoor-primary) 0%, var(--outdoor-primary-dark) 100%);
    border-radius: var(--border-radius);
    padding: 32px;
    margin-bottom: 32px;
    color: white;
    box-shadow: var(--shadow-soft);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

.page-icon {
    font-size: 48px;
    background: rgba(255,255,255,0.1);
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--border-radius);
    backdrop-filter: blur(10px);
}

.header-info h1 {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 8px 0;
    letter-spacing: -0.5px;
}

.page-subtitle {
    font-size: 16px;
    opacity: 0.9;
    margin: 0;
}

.header-actions .btn-secondary {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.header-actions .btn-secondary:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-1px);
}

/* Alerts */
.alert {
    padding: 20px;
    border-radius: var(--border-radius);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    border: none;
    position: relative;
}

.alert-success {
    background: linear-gradient(135deg, #d4f4dd 0%, #c8f0d4 100%);
    color: var(--outdoor-success);
}

.alert-danger {
    background: linear-gradient(135deg, #fdeaea 0%, #fbd6d6 100%);
    color: var(--outdoor-danger);
}

.alert-icon {
    font-size: 24px;
    flex-shrink: 0;
}

.alert-content {
    flex: 1;
}

.alert-content strong {
    display: block;
    margin-bottom: 4px;
    font-weight: 600;
}

.error-list {
    margin: 8px 0 0 0;
    padding-left: 20px;
}

.alert-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    border-radius: 4px;
    transition: background 0.2s ease;
}

.alert-close:hover {
    background: rgba(0,0,0,0.1);
}

/* Content Grid */
.outdoor-content-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 32px;
    align-items: start;
}

@media (max-width: 1200px) {
    .outdoor-content-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
}

/* Cards */
.content-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    transition: all 0.3s ease;
}

.content-card:hover {
    box-shadow: var(--shadow-hover);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 24px 32px;
    display: flex;
    align-items: center;
    gap: 16px;
    border-bottom: 1px solid #dee2e6;
}

.card-header-icon {
    font-size: 24px;
    background: white;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card-title {
    font-size: 20px;
    font-weight: 600;
    margin: 0;
    color: var(--outdoor-dark);
}

.card-subtitle {
    font-size: 14px;
    color: var(--outdoor-gray);
    margin: 4px 0 0 0;
}

/* Form Styles */
.slider-form {
    padding: 32px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 32px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: var(--outdoor-dark);
    margin-bottom: 8px;
    font-size: 14px;
}

.required {
    color: var(--outdoor-danger);
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 16px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--outdoor-primary);
    background: white;
    box-shadow: 0 0 0 3px rgba(96, 108, 56, 0.1);
}

.textarea-wrapper {
    position: relative;
}

.textarea-counter {
    position: absolute;
    bottom: 8px;
    right: 12px;
    font-size: 12px;
    color: var(--outdoor-gray);
    background: rgba(255,255,255,0.9);
    padding: 2px 6px;
    border-radius: 4px;
}

.form-hint {
    font-size: 13px;
    color: var(--outdoor-gray);
    margin-top: 4px;
    font-style: italic;
}

/* Image Upload */
.image-upload-zone {
    border: 2px dashed #cbd5e0;
    border-radius: var(--border-radius);
    padding: 40px 20px;
    text-align: center;
    background: #f8fafc;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.image-upload-zone:hover {
    border-color: var(--outdoor-primary);
    background: var(--outdoor-light);
}

.image-upload-zone.dragover {
    border-color: var(--outdoor-primary);
    background: var(--outdoor-light);
    transform: scale(1.02);
}

.image-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.upload-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.upload-text {
    font-size: 16px;
    font-weight: 500;
    color: var(--outdoor-dark);
    margin-bottom: 8px;
}

.upload-requirements {
    font-size: 13px;
    color: var(--outdoor-gray);
}

/* Buttons */
.form-actions {
    display: flex;
    gap: 16px;
    justify-content: flex-end;
    padding-top: 24px;
    border-top: 1px solid #e1e5e9;
}

.btn-primary,
.btn-secondary {
    padding: 16px 32px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, var(--outdoor-primary) 0%, var(--outdoor-primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(96, 108, 56, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(96, 108, 56, 0.4);
}

.btn-secondary {
    background: #f8f9fa;
    color: var(--outdoor-gray);
    border: 1px solid #dee2e6;
}

.btn-secondary:hover {
    background: #e9ecef;
    transform: translateY(-1px);
}

/* Preview Section */
.slider-preview {
    padding: 24px;
}

.preview-container {
    border-radius: var(--border-radius);
    overflow: hidden;
    position: relative;
    margin-bottom: 24px;
    box-shadow: var(--shadow-soft);
}

.preview-image-wrapper {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.preview-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    color: white;
    padding: 32px 24px 24px;
}

.preview-title {
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 8px 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.preview-description {
    font-size: 16px;
    margin: 0 0 16px 0;
    opacity: 0.9;
    text-shadow: 0 1px 2px rgba(0,0,0,0.5);
}

.preview-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: 500;
}

.preview-info {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 24px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 14px;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-label {
    color: var(--outdoor-gray);
}

.info-value {
    font-weight: 500;
    color: var(--outdoor-dark);
}

/* Tips Section */
.tips-section {
    background: linear-gradient(135deg, var(--outdoor-light) 0%, #fdfbf0 100%);
    border-radius: 8px;
    padding: 20px;
    border: 1px solid #e8e5d3;
}

.tips-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    font-weight: 600;
    color: var(--outdoor-accent);
    margin: 0 0 12px 0;
}

.tips-list {
    margin: 0;
    padding-left: 20px;
    color: var(--outdoor-dark);
}

.tips-list li {
    margin-bottom: 6px;
    font-size: 14px;
}

.tips-list li:last-child {
    margin-bottom: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .outdoor-page-wrapper {
        padding: 16px;
    }
    
    .outdoor-page-header {
        padding: 24px;
    }
    
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .form-actions {
        flex-direction: column-reverse;
    }
    
    .btn-primary,
    .btn-secondary {
        justify-content: center;
    }
}
</style>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const titleInput = document.querySelector('input[name="title"]');
    const descriptionTextarea = document.querySelector('textarea[name="description"]');
    const imageInput = document.getElementById('imageInput');
    const uploadZone = document.getElementById('imageUploadZone');
    
    // Preview elements
    const previewTitle = document.getElementById('previewTitle');
    const previewDescription = document.getElementById('previewDescription');
    const previewImage = document.getElementById('previewImage');
    const charCount = document.getElementById('char-count');
    const imageDimensions = document.getElementById('imageDimensions');
    const fileSize = document.getElementById('fileSize');

    // Real-time preview updates
    titleInput?.addEventListener('input', function() {
        previewTitle.textContent = this.value || 'Titre du slider';
    });

    descriptionTextarea?.addEventListener('input', function() {
        previewDescription.textContent = this.value || 'Description du slider';
        if (charCount) {
            charCount.textContent = this.value.length;
            charCount.style.color = this.value.length > 500 ? '#c5481a' : '#8b8c89';
        }
    });

    // Image upload handling
    imageInput?.addEventListener('change', function(e) {
        handleImageUpload(e.target.files[0]);
    });

    // Drag and drop
    uploadZone?.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadZone?.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadZone?.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleImageUpload(files[0]);
        }
    });

    function handleImageUpload(file) {
        if (!file) return;

        // Validation
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format de fichier non supporté. Utilisez JPG, PNG ou GIF.');
            return;
        }

        if (file.size > 2 * 1024 * 1024) { // 2MB
            alert('Fichier trop volumineux. Maximum 2MB.');
            return;
        }

        // Update preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            
            // Get image dimensions
            const img = new Image();
            img.onload = function() {
                if (imageDimensions) {
                    imageDimensions.textContent = `${this.naturalWidth} × ${this.naturalHeight}px`;
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Update file size
        if (fileSize) {
            const size = file.size;
            let sizeText;
            if (size < 1024) {
                sizeText = size + ' B';
            } else if (size < 1024 * 1024) {
                sizeText = Math.round(size / 1024) + ' KB';
            } else {
                sizeText = Math.round(size / (1024 * 1024) * 10) / 10 + ' MB';
            }
            fileSize.textContent = sizeText;
        }
    }

    // Get current image info
    if (previewImage && previewImage.src) {
        const img = new Image();
        img.onload = function() {
            if (imageDimensions) {
                imageDimensions.textContent = `${this.naturalWidth} × ${this.naturalHeight}px`;
            }
        };
        img.src = previewImage.src;
    }

    // Initialize character count
    if (descriptionTextarea && charCount) {
        charCount.textContent = descriptionTextarea.value.length;
    }

    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
</script>

@endsection