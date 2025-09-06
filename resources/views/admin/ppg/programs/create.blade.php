@extends('admin.admin_master')

@section('admin')
<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Ajouter un Programme PPG</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.ppg.programs') }}">Programmes PPG</a></li>
                            <li class="breadcrumb-item active">Ajouter</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <form action="{{ route('admin.ppg.programs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Informations du programme</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Titre *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug *</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                               id="slug" name="slug" value="{{ old('slug') }}" required>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="overview" class="form-label">Vue d'ensemble</label>
                                <textarea class="form-control @error('overview') is-invalid @enderror" 
                                          id="overview" name="overview" rows="6">{{ old('overview') }}</textarea>
                                @error('overview')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Description détaillée du programme et de ses objectifs</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="duration_weeks" class="form-label">Durée (semaines) *</label>
                                        <input type="number" class="form-control @error('duration_weeks') is-invalid @enderror" 
                                               id="duration_weeks" name="duration_weeks" value="{{ old('duration_weeks') }}" 
                                               min="1" max="52" required>
                                        @error('duration_weeks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="sessions_per_week" class="form-label">Sessions/semaine *</label>
                                        <input type="number" class="form-control @error('sessions_per_week') is-invalid @enderror" 
                                               id="sessions_per_week" name="sessions_per_week" value="{{ old('sessions_per_week') }}" 
                                               min="1" max="14" required>
                                        @error('sessions_per_week')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="session_duration_minutes" class="form-label">Durée session (min)</label>
                                        <input type="number" class="form-control @error('session_duration_minutes') is-invalid @enderror" 
                                               id="session_duration_minutes" name="session_duration_minutes" value="{{ old('session_duration_minutes') }}" 
                                               min="10" max="180">
                                        @error('session_duration_minutes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="estimated_calories" class="form-label">Calories/session</label>
                                        <input type="number" class="form-control @error('estimated_calories') is-invalid @enderror" 
                                               id="estimated_calories" name="estimated_calories" value="{{ old('estimated_calories') }}" 
                                               min="50">
                                        @error('estimated_calories')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="equipment_needed" class="form-label">Matériel nécessaire</label>
                                <textarea class="form-control @error('equipment_needed') is-invalid @enderror" 
                                          id="equipment_needed" name="equipment_needed" rows="2">{{ old('equipment_needed') }}</textarea>
                                @error('equipment_needed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Liste du matériel requis pour suivre le programme</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Exercices du programme -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Exercices du programme</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="exercises" class="form-label">Sélectionner les exercices</label>
                                <select class="form-select @error('exercises') is-invalid @enderror" 
                                        id="exercises" name="exercises[]" multiple size="8">
                                    @foreach($exercises as $exercise)
                                        <option value="{{ $exercise->id }}" 
                                                {{ in_array($exercise->id, old('exercises', [])) ? 'selected' : '' }}>
                                            [{{ $exercise->category->name }}] {{ $exercise->title }}
                                            @if($exercise->difficulty_level) - {{ ucfirst($exercise->difficulty_level) }} @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('exercises')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Maintenez Ctrl/Cmd pour sélectionner plusieurs exercices</small>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Astuce:</strong> Les exercices sont organisés par catégorie. 
                                Sélectionnez ceux qui correspondent aux objectifs du programme.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Images -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Images du programme</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="images" class="form-label">Sélectionner des images</label>
                                <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                       id="images" name="images[]" multiple accept="image/*">
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Vous pouvez sélectionner plusieurs images. La première sera l'image principale.</small>
                            </div>
                            
                            <div id="image-preview" class="row mt-3"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Paramètres -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Paramètres</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="ppg_category_id" class="form-label">Catégorie *</label>
                                <select class="form-select @error('ppg_category_id') is-invalid @enderror" 
                                        id="ppg_category_id" name="ppg_category_id" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('ppg_category_id', request('category')) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ppg_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="difficulty_level" class="form-label">Niveau de difficulté *</label>
                                <select class="form-select @error('difficulty_level') is-invalid @enderror" 
                                        id="difficulty_level" name="difficulty_level" required>
                                    <option value="">Sélectionner un niveau</option>
                                    <option value="beginner" {{ old('difficulty_level') == 'beginner' ? 'selected' : '' }}>Débutant</option>
                                    <option value="intermediate" {{ old('difficulty_level') == 'intermediate' ? 'selected' : '' }}>Intermédiaire</option>
                                    <option value="advanced" {{ old('difficulty_level') == 'advanced' ? 'selected' : '' }}>Avancé</option>
                                </select>
                                @error('difficulty_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publié</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Créer le programme
                                </button>
                                <a href="{{ route('admin.ppg.programs') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Aide -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Aide</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-lightbulb me-2"></i>Conseils</h6>
                                <ul class="mb-0 small">
                                    <li><strong>Durée:</strong> Entre 4-12 semaines pour un programme efficace</li>
                                    <li><strong>Sessions:</strong> 3-5 sessions par semaine pour un bon équilibre</li>
                                    <li><strong>Progression:</strong> Organisez les exercices du plus simple au plus complexe</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title
    const titleField = document.getElementById('title');
    const slugField = document.getElementById('slug');
    
    titleField.addEventListener('input', function() {
        const slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugField.value = slug;
    });
    
    // Image preview
    const imageInput = document.getElementById('images');
    const imagePreview = document.getElementById('image-preview');
    
    imageInput.addEventListener('change', function() {
        imagePreview.innerHTML = '';
        
        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-md-6 mb-3';
                div.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-fluid rounded" alt="Preview">
                        ${i === 0 ? '<span class="position-absolute top-0 start-0 badge bg-primary m-2">Principal</span>' : ''}
                    </div>
                `;
                imagePreview.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        }
    });
    
    // Filter exercises by category
    const categorySelect = document.getElementById('ppg_category_id');
    const exercisesSelect = document.getElementById('exercises');
    const allOptions = Array.from(exercisesSelect.options);
    
    categorySelect.addEventListener('change', function() {
        const categoryId = this.value;
        exercisesSelect.innerHTML = '';
        
        if (!categoryId) {
            // Show all exercises
            allOptions.forEach(option => exercisesSelect.appendChild(option.cloneNode(true)));
        } else {
            // Filter exercises by category (this would need server-side data or AJAX)
            // For now, show all exercises
            allOptions.forEach(option => exercisesSelect.appendChild(option.cloneNode(true)));
        }
    });
});
</script>
@endsection