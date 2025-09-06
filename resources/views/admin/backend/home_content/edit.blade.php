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
                        <li class="breadcrumb-item active" aria-current="page">{{ $content->title }}</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">✏️ Modifier: {{ $content->title }}</h4>
                            <p class="card-description text-muted">{{ $content->description }}</p>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.home-content.update', $content->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Titre (modifiable) -->
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Titre du champ</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="{{ old('title', $content->title) }}">
                                    <small class="form-text text-muted">Nom d'affichage de ce champ dans l'admin</small>
                                </div>

                                <!-- Contenu principal -->
                                @if(str_contains($content->key, 'image'))
                                    <!-- Gestion d'image -->
                                    <div class="form-group mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        
                                        @if($content->content)
                                            <div class="mb-3">
                                                <img src="{{ asset($content->content) }}" alt="Image actuelle" class="img-thumbnail" 
                                                     style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                                <p class="small text-muted mt-1">Image actuelle: {{ $content->content }}</p>
                                            </div>
                                        @endif
                                        
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        
                                        @if($content->key === 'about_image')
                                            <small class="form-text text-info">
                                                📐 Cette image sera automatiquement redimensionnée à 306x618px (format vertical)
                                            </small>
                                        @else
                                            <small class="form-text text-muted">
                                                Formats acceptés: JPEG, PNG, JPG, WEBP. Taille max: 2 Mo
                                            </small>
                                        @endif
                                    </div>

                                    <!-- Chemin de l'image (en readonly pour info) -->
                                    <div class="form-group mb-3">
                                        <label for="content" class="form-label">Chemin de l'image</label>
                                        <input type="text" class="form-control" id="content" name="content" 
                                               value="{{ old('content', $content->content) }}" readonly>
                                        <small class="form-text text-muted">Chemin automatiquement généré lors de l'upload</small>
                                    </div>
                                @else
                                    <!-- Gestion de texte -->
                                    <div class="form-group mb-3">
                                        <label for="content" class="form-label">Contenu</label>
                                        @if(str_contains($content->key, 'subtitle') || str_contains($content->key, 'description'))
                                            <textarea class="form-control" id="content" name="content" rows="4">{{ old('content', $content->content) }}</textarea>
                                        @else
                                            <input type="text" class="form-control" id="content" name="content" 
                                                   value="{{ old('content', $content->content) }}">
                                        @endif
                                        <small class="form-text text-muted">Ce texte sera affiché sur la page d'accueil</small>
                                    </div>
                                @endif

                                <!-- Description -->
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">Description du champ</label>
                                    <textarea class="form-control" id="description" name="description" rows="2">{{ old('description', $content->description) }}</textarea>
                                    <small class="form-text text-muted">Description pour l'administration (non affichée publiquement)</small>
                                </div>

                                <!-- Informations de debug -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <strong>Section:</strong> {{ $content->section }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Clé:</strong> {{ $content->key }}
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