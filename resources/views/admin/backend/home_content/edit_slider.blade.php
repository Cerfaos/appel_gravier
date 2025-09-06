@extends('admin.admin_master_outdoor')
@section('admin')

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Header -->
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.home-content.index') }}">Contenu Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Slider #{{ $slider->id }}</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">🎯 Modifier le Slider Hero</h4>
                            <p class="card-description text-muted">Configuration de la section principale (hero) de la page d'accueil</p>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.home-content.update-slider', $slider->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Titre principal -->
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Titre Principal *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="{{ old('title', $slider->title) }}" required>
                                    <small class="form-text text-muted">Titre principal affiché en grand dans la section hero</small>
                                </div>

                                <!-- Description -->
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $slider->description) }}</textarea>
                                    <small class="form-text text-muted">Texte de description sous le titre</small>
                                </div>

                                <!-- Lien du bouton -->
                                <div class="form-group mb-3">
                                    <label for="link" class="form-label">Lien du bouton</label>
                                    <input type="text" class="form-control" id="link" name="link" 
                                           value="{{ old('link', $slider->link) }}" placeholder="#services">
                                    <small class="form-text text-muted">Lien vers lequel redirige le bouton d'action (ex: #services)</small>
                                </div>

                                <!-- Image d'arrière-plan -->
                                <div class="form-group mb-4">
                                    <label for="image" class="form-label">Image d'arrière-plan</label>
                                    
                                    @if($slider->image && $slider->image !== 'upload/no_image.jpg')
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $slider->image) }}" alt="Image actuelle" class="img-thumbnail" 
                                                 style="max-width: 300px; max-height: 200px; object-fit: cover;">
                                            <p class="small text-muted mt-1">Image actuelle: {{ $slider->image }}</p>
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <div class="alert alert-info">Aucune image d'arrière-plan définie</div>
                                        </div>
                                    @endif
                                    
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <small class="form-text text-muted">
                                        Formats acceptés: JPEG, PNG, JPG, WEBP. Taille max: 2 Mo. 
                                        Recommandé: image large (ex: 1920x1080) pour l'arrière-plan
                                    </small>
                                </div>

                                <!-- Informations de debug -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <strong>ID Slider:</strong> {{ $slider->id }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Créé le:</strong> {{ $slider->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>

                                <!-- Boutons -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        💾 Enregistrer les modifications
                                    </button>
                                    <a href="{{ route('admin.home-content.index') }}" class="btn btn-secondary">
                                        ↩️ Retour
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection