@extends('admin.admin_master')

@section('admin')
<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Modifier la Catégorie PPG</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.ppg.categories') }}">Catégories PPG</a></li>
                            <li class="breadcrumb-item active">Modifier {{ $category->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Modifier "{{ $category->name }}"</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.ppg.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nom *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug *</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                               id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">URL-friendly version du nom</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre d'affichage *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $category->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="icon" class="form-label">Icône (classe CSS)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                                   id="icon" name="icon" value="{{ old('icon', $category->icon) }}" 
                                                   placeholder="fas fa-dumbbell">
                                            <span class="input-group-text">
                                                @if($category->icon)
                                                    <i class="{{ $category->icon }}"></i>
                                                @else
                                                    <i class="fas fa-question"></i>
                                                @endif
                                            </span>
                                        </div>
                                        @error('icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Ex: fas fa-dumbbell</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="color" class="form-label">Couleur</label>
                                        <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                               id="color" name="color" value="{{ old('color', $category->color ?? '#6c757d') }}">
                                        @error('color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="order_position" class="form-label">Position</label>
                                        <input type="number" class="form-control @error('order_position') is-invalid @enderror" 
                                               id="order_position" name="order_position" value="{{ old('order_position', $category->order_position) }}" 
                                               min="0">
                                        @error('order_position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Sélectionner un status</option>
                                    <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.ppg.categories') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Modifier la catégorie
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Statistiques</h4>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border p-3 rounded">
                                    <h4 class="mb-1 text-primary">{{ $category->exercises->count() }}</h4>
                                    <small class="text-muted">Exercices</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border p-3 rounded">
                                    <h4 class="mb-1 text-success">{{ $category->programs->count() }}</h4>
                                    <small class="text-muted">Programmes</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Créé le {{ $category->created_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                        
                        @if($category->updated_at != $category->created_at)
                        <div class="mt-1">
                            <small class="text-muted">
                                <i class="fas fa-edit me-1"></i>
                                Modifié le {{ $category->updated_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Actions rapides</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.ppg.exercises.create') }}?category={{ $category->id }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus me-2"></i>Ajouter un exercice
                            </a>
                            <a href="{{ route('admin.ppg.programs.create') }}?category={{ $category->id }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-plus me-2"></i>Ajouter un programme
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameField = document.getElementById('name');
    const slugField = document.getElementById('slug');
    
    nameField.addEventListener('input', function() {
        const slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugField.value = slug;
    });
    
    // Update icon preview
    const iconField = document.getElementById('icon');
    const iconPreview = document.querySelector('.input-group-text i');
    
    iconField.addEventListener('input', function() {
        const iconClass = this.value || 'fas fa-question';
        iconPreview.className = iconClass;
    });
});
</script>
@endsection