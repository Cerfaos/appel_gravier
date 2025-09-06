@extends('admin.admin_master')

@section('admin')
<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Exercices PPG</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Exercices PPG</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">
                                Liste des Exercices
                                <span class="badge bg-primary ms-2">{{ $exercises->count() }}</span>
                            </h4>
                            <div class="d-flex gap-2">
                                <!-- Filtres -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                                        <i class="fas fa-filter me-2"></i>Filtrer
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.ppg.exercises') }}">Tous</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        @foreach($categories as $category)
                                            <li>
                                                <a class="dropdown-item {{ request('category') == $category->id ? 'active' : '' }}" 
                                                   href="{{ route('admin.ppg.exercises') }}?category={{ $category->id }}">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item {{ request('status') == 'published' ? 'active' : '' }}" href="{{ route('admin.ppg.exercises') }}?status=published">Publiés</a></li>
                                        <li><a class="dropdown-item {{ request('status') == 'draft' ? 'active' : '' }}" href="{{ route('admin.ppg.exercises') }}?status=draft">Brouillons</a></li>
                                    </ul>
                                </div>
                                
                                <a href="{{ route('admin.ppg.exercises.create') }}" class="btn btn-primary waves-effect waves-light">
                                    <i class="fas fa-plus me-2"></i>Ajouter un exercice
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th width="60">Image</th>
                                        <th>Titre</th>
                                        <th>Catégorie</th>
                                        <th>Niveau</th>
                                        <th width="15%">Durée</th>
                                        <th width="15%">Status</th>
                                        <th width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($exercises as $exercise)
                                    <tr>
                                        <td>
                                            @if($exercise->featuredImage())
                                                <img src="{{ asset('storage/' . $exercise->featuredImage()) }}" 
                                                     alt="{{ $exercise->title }}" 
                                                     class="rounded" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1">{{ $exercise->title }}</h6>
                                                <small class="text-muted">{{ Str::limit($exercise->description, 50) }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $exercise->category->color ?? '#6c757d' }}; color: white;">
                                                {{ $exercise->category->name }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($exercise->difficulty_level == 'beginner')
                                                <span class="badge bg-success">Débutant</span>
                                            @elseif($exercise->difficulty_level == 'intermediate')
                                                <span class="badge bg-warning">Intermédiaire</span>
                                            @else
                                                <span class="badge bg-danger">Avancé</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $exercise->duration_minutes ? $exercise->duration_minutes . ' min' : '-' }}
                                        </td>
                                        <td>
                                            @if($exercise->status == 'published')
                                                <span class="badge bg-success">Publié</span>
                                            @else
                                                <span class="badge bg-secondary">Brouillon</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.ppg.exercises.show', $exercise) }}" 
                                                   class="btn btn-sm btn-outline-info" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.ppg.exercises.edit', $exercise) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.ppg.exercises.delete', $exercise) }}" 
                                                   class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet exercice ?')"
                                                   data-bs-toggle="tooltip" 
                                                   title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-info-circle me-2"></i>Aucun exercice trouvé
                                            @if(request()->hasAny(['category', 'status']))
                                                <br><small class="text-muted">Essayez de modifier vos filtres</small>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection