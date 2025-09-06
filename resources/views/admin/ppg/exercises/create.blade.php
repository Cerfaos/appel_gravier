@extends('admin.admin_master')

@section('admin')
<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Ajouter un Exercice PPG</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.ppg.exercises') }}">Exercices PPG</a></li>
                            <li class="breadcrumb-item active">Ajouter</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <form action="{{ route('admin.ppg.exercises.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Informations de l'exercice</h4>
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
                                <label for="instructions" class="form-label">Instructions détaillées</label>
                                <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                          id="instructions" name="instructions" rows="6">{{ old('instructions') }}</textarea>
                                @error('instructions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Instructions étape par étape pour l'exercice</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="target_muscles" class="form-label">Muscles ciblés</label>
                                        <input type="text" class="form-control @error('target_muscles') is-invalid @enderror" 
                                               id="target_muscles" name="target_muscles" value="{{ old('target_muscles') }}" 
                                               placeholder="Ex: Quadriceps, Fessiers">
                                        @error('target_muscles')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="equipment" class="form-label">Matériel</label>
                                        <input type="text" class="form-control @error('equipment') is-invalid @enderror" 
                                               id="equipment" name="equipment" value="{{ old('equipment') }}" 
                                               placeholder="Ex: Haltères, Tapis">
                                        @error('equipment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="duration_minutes" class="form-label">Durée (minutes)</label>
                                        <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                                               id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" 
                                               min="1" max="180">
                                        @error('duration_minutes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="sets" class="form-label">Séries</label>
                                        <input type="number" class="form-control @error('sets') is-invalid @enderror" 
                                               id="sets" name="sets" value="{{ old('sets') }}" min="1" max="20">
                                        @error('sets')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="reps" class="form-label">Répétitions</label>
                                        <input type="text" class="form-control @error('reps') is-invalid @enderror" 
                                               id="reps" name="reps" value="{{ old('reps') }}" 
                                               placeholder="Ex: 12 ou 10-15">
                                        @error('reps')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="rest_time" class="form-label">Temps de repos (sec)</label>
                                        <input type="number" class="form-control @error('rest_time') is-invalid @enderror" 
                                               id="rest_time" name="rest_time" value="{{ old('rest_time') }}" 
                                               min="10" max="300">
                                        @error('rest_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="calories_burned" class="form-label">Calories brûlées</label>
                                        <input type="number" class="form-control @error('calories_burned') is-invalid @enderror" 
                                               id="calories_burned" name="calories_burned" value="{{ old('calories_burned') }}" 
                                               min="1">
                                        @error('calories_burned')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tips" class="form-label">Conseils & Astuces</label>
                                <textarea class="form-control @error('tips') is-invalid @enderror" 
                                          id="tips" name="tips" rows="3">{{ old('tips') }}</textarea>
                                @error('tips')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Images -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Images de l'exercice</h4>
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
                                    <i class="fas fa-save me-2"></i>Créer l'exercice
                                </button>
                                <a href="{{ route('admin.ppg.exercises') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
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
});
</script>
@endsection