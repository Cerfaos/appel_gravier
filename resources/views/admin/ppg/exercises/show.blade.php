@extends('admin.admin_master')

@section('admin')
<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ $exercise->title }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.ppg.exercises') }}">Exercices PPG</a></li>
                            <li class="breadcrumb-item active">{{ $exercise->title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Informations principales -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">{{ $exercise->title }}</h4>
                            <div class="d-flex gap-2">
                                @if($exercise->status == 'published')
                                    <span class="badge bg-success">Publié</span>
                                @else
                                    <span class="badge bg-secondary">Brouillon</span>
                                @endif
                                
                                @if($exercise->difficulty_level == 'beginner')
                                    <span class="badge bg-success">Débutant</span>
                                @elseif($exercise->difficulty_level == 'intermediate')
                                    <span class="badge bg-warning">Intermédiaire</span>
                                @else
                                    <span class="badge bg-danger">Avancé</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h6>Description</h6>
                                <p class="mb-4">{{ $exercise->description }}</p>
                                
                                @if($exercise->instructions)
                                <h6>Instructions</h6>
                                <div class="mb-4">
                                    {!! nl2br(e($exercise->instructions)) !!}
                                </div>
                                @endif
                                
                                @if($exercise->tips)
                                <h6>Conseils & Astuces</h6>
                                <div class="mb-4">
                                    {!! nl2br(e($exercise->tips)) !!}
                                </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <h6>Détails</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Catégorie:</strong></td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $exercise->category->color ?? '#6c757d' }}; color: white;">
                                                {{ $exercise->category->name }}
                                            </span>
                                        </td>
                                    </tr>
                                    @if($exercise->target_muscles)
                                    <tr>
                                        <td><strong>Muscles:</strong></td>
                                        <td>{{ $exercise->target_muscles }}</td>
                                    </tr>
                                    @endif
                                    @if($exercise->equipment)
                                    <tr>
                                        <td><strong>Matériel:</strong></td>
                                        <td>{{ $exercise->equipment }}</td>
                                    </tr>
                                    @endif
                                    @if($exercise->duration_minutes)
                                    <tr>
                                        <td><strong>Durée:</strong></td>
                                        <td>{{ $exercise->duration_minutes }} minutes</td>
                                    </tr>
                                    @endif
                                    @if($exercise->sets || $exercise->reps)
                                    <tr>
                                        <td><strong>Séries/Reps:</strong></td>
                                        <td>{{ $exercise->sets }}x{{ $exercise->reps }}</td>
                                    </tr>
                                    @endif
                                    @if($exercise->rest_time)
                                    <tr>
                                        <td><strong>Repos:</strong></td>
                                        <td>{{ $exercise->rest_time }}s</td>
                                    </tr>
                                    @endif
                                    @if($exercise->calories_burned)
                                    <tr>
                                        <td><strong>Calories:</strong></td>
                                        <td>{{ $exercise->calories_burned }} kcal</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Images -->
                @if($exercise->images && count($exercise->images) > 0)
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Images</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($exercise->images as $index => $image)
                            <div class="col-md-4 mb-3">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         class="img-fluid rounded" 
                                         alt="{{ $exercise->title }} - Image {{ $index + 1 }}"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#imageModal{{ $index }}"
                                         style="cursor: pointer;">
                                    @if($index === 0)
                                        <span class="position-absolute top-0 start-0 badge bg-primary m-2">Principal</span>
                                    @endif
                                </div>
                                
                                <!-- Modal pour l'image -->
                                <div class="modal fade" id="imageModal{{ $index }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $exercise->title }} - Image {{ $index + 1 }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $image) }}" class="img-fluid" alt="{{ $exercise->title }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="col-lg-4">
                <!-- Actions -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.ppg.exercises.edit', $exercise) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Modifier
                            </a>
                            
                            @if($exercise->status === 'published')
                                <a href="{{ route('ppg.exercise', $exercise->slug) }}" class="btn btn-outline-success" target="_blank">
                                    <i class="fas fa-eye me-2"></i>Voir sur le site
                                </a>
                            @endif
                            
                            <a href="{{ route('admin.ppg.exercises.delete', $exercise) }}" 
                               class="btn btn-outline-danger"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet exercice ?')">
                                <i class="fas fa-trash me-2"></i>Supprimer
                            </a>
                            
                            <hr>
                            
                            <a href="{{ route('admin.ppg.exercises') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Métadonnées -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Informations</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Slug:</strong></td>
                                <td><code>{{ $exercise->slug }}</code></td>
                            </tr>
                            <tr>
                                <td><strong>Créé:</strong></td>
                                <td>{{ $exercise->created_at->format('d/m/Y à H:i') }}</td>
                            </tr>
                            @if($exercise->updated_at != $exercise->created_at)
                            <tr>
                                <td><strong>Modifié:</strong></td>
                                <td>{{ $exercise->updated_at->format('d/m/Y à H:i') }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Images:</strong></td>
                                <td>{{ $exercise->images ? count($exercise->images) : 0 }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Navigation</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $prevExercise = \App\Models\PpgExercise::where('id', '<', $exercise->id)
                                ->where('ppg_category_id', $exercise->ppg_category_id)
                                ->orderBy('id', 'desc')
                                ->first();
                            $nextExercise = \App\Models\PpgExercise::where('id', '>', $exercise->id)
                                ->where('ppg_category_id', $exercise->ppg_category_id)
                                ->orderBy('id', 'asc')
                                ->first();
                        @endphp
                        
                        @if($prevExercise)
                        <a href="{{ route('admin.ppg.exercises.show', $prevExercise) }}" class="btn btn-outline-secondary btn-sm d-block mb-2">
                            <i class="fas fa-chevron-left me-2"></i>{{ Str::limit($prevExercise->title, 25) }}
                        </a>
                        @endif
                        
                        @if($nextExercise)
                        <a href="{{ route('admin.ppg.exercises.show', $nextExercise) }}" class="btn btn-outline-secondary btn-sm d-block">
                            {{ Str::limit($nextExercise->title, 25) }}<i class="fas fa-chevron-right ms-2"></i>
                        </a>
                        @endif
                        
                        @if(!$prevExercise && !$nextExercise)
                        <small class="text-muted">Seul exercice dans cette catégorie</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection