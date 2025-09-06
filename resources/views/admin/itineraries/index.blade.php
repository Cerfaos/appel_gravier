@extends('admin.admin_master_outdoor')

@section('admin')
<div class="page-content">
    <div class="container">

        <!-- start page title -->
        <div class="page-header">
            <div>
                <h4>Tous les Itinéraires</h4>
            </div>
            <div>
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li>Itinéraires</li>
                </ol>
            </div>
        </div>
        <!-- end page title -->

        <div class="content">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card__header">
                        <div class="u-flex u-gap-4">
                            <h5>Liste des Itinéraires</h5>
                            <a href="{{ route('admin.add.itinerary') }}" class="btn btn-primary">
                                <i data-feather="plus" style="width: 16px; height: 16px;"></i> Ajouter un Itinéraire
                            </a>
                        </div>
                    </div>
                        
                    <div class="card__body">
                        <!-- Statistiques et filtres -->
                        <div class="u-flex u-gap-4">
                            <div>
                                <!-- Statistiques rapides -->
                                @if(isset($stats))
                                <div class="u-flex u-gap-4">
                                    <div class="badge badge--primary">
                                        <i data-feather="list" style="width: 14px; height: 14px;"></i>
                                        Total: {{ $stats['total'] }}
                                    </div>
                                    <div class="badge badge--success">
                                        <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                        Publiés: {{ $stats['published'] }}
                                    </div>
                                    <div class="badge badge--warning">
                                        <i data-feather="eye-off" style="width: 14px; height: 14px;"></i>
                                        Brouillons: {{ $stats['draft'] }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div>
                                <!-- Filtres -->
                                <form method="GET" class="u-flex u-gap-2">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="">Tous les statuts</option>
                                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>
                                            📌 Publiés uniquement
                                        </option>
                                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>
                                            📝 Brouillons uniquement
                                        </option>
                                    </select>
                                    
                                    @if(request('status'))
                                        <a href="{{ route('admin.all.itinerary') }}" class="btn btn-sm btn-secondary">
                                            <i data-feather="x" style="width: 14px; height: 14px;"></i>
                                        </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <div>

                        @if($itineraries->count() > 0)
                        <div class="u-mt-4">
                            <table class="table table--zebra">
                                <thead>
                                    <tr>
                                        <th>Itinéraire</th>
                                        <th>Auteur</th>
                                        <th>Département</th>
                                        <th>Pays</th>
                                        <th>Difficulté</th>
                                        <th>Distance</th>
                                        <th>Dénivelé</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($itineraries as $itinerary)
                                    <tr>
                                        <td>
                                            <div class="u-flex u-items-center u-gap-3">
                                                @if($itinerary->featuredImage)
                                                    <img src="{{ asset($itinerary->featuredImage->image_path) }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: var(--cerfaos-radius-md);"
                                                         alt="Vignette - {{ $itinerary->title }}">
                                                @else
                                                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--cerfaos-accent), var(--cerfaos-accent-hover)); border-radius: var(--cerfaos-radius-md); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                                        🏔️
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6>{{ Str::limit($itinerary->title, 30) }}</h6>
                                                    <div class="u-flex u-items-center u-gap-2">
                                                        <small class="u-text-muted">#{{ $itinerary->id }}</small>
                                                        <small class="u-text-muted">{{ $itinerary->slug }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($itinerary->user)
                                                <span>{{ $itinerary->user->name }}</span>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($itinerary->departement)
                                                <span class="badge badge--info">
                                                    🏛️ {{ $itinerary->departement }}
                                                </span>
                                            @else
                                                <span class="u-text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($itinerary->pays)
                                                <span class="badge badge--secondary">
                                                    @if($itinerary->pays === 'France')🇫🇷
                                                    @elseif($itinerary->pays === 'Allemagne')🇩🇪
                                                    @elseif($itinerary->pays === 'Suisse')🇨🇭
                                                    @elseif($itinerary->pays === 'Italie')🇮🇹
                                                    @elseif($itinerary->pays === 'Espagne')🇪🇸
                                                    @elseif($itinerary->pays === 'Autriche')🇦🇹
                                                    @else🌍
                                                    @endif
                                                    {{ $itinerary->pays }}
                                                </span>
                                            @else
                                                <span class="u-text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($itinerary->difficulty_level === 'facile')
                                                <span>🟢 Facile</span>
                                            @elseif($itinerary->difficulty_level === 'moyen')
                                                <span>🟡 Moyen</span>
                                            @elseif($itinerary->difficulty_level === 'difficile')
                                                <span>🔴 Difficile</span>
                                            @else
                                                <span class="u-text-muted">Non défini</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($itinerary->distance_km)
                                                {{ number_format($itinerary->distance_km, 1) }} km
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($itinerary->elevation_gain_m)
                                                {{ $itinerary->elevation_gain_m }}m
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($itinerary->status === 'published')
                                                <span class="badge badge--success">
                                                    <i data-feather="eye" style="width: 12px; height: 12px;"></i> Publié
                                                </span>
                                            @else
                                                <span class="badge badge--warning">
                                                    <i data-feather="eye-off" style="width: 12px; height: 12px;"></i> Brouillon
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                {{ $itinerary->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="u-flex u-gap-2">
                                                @if($itinerary->status === 'published')
                                                    <a href="{{ route('itineraries.show', $itinerary->slug) }}" 
                                                       target="_blank"
                                                       class="btn btn-sm btn-secondary"
                                                       title="Voir sur le site">
                                                        <i data-feather="external-link" style="width: 14px; height: 14px;"></i>
                                                    </a>
                                                @endif
                                                
                                                <a href="{{ route('admin.show.itinerary', $itinerary->id) }}" 
                                                   class="btn btn-sm btn-secondary"
                                                   title="Voir détails">
                                                    <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                                </a>
                                                
                                                <a href="{{ route('admin.edit.itinerary', $itinerary->id) }}" 
                                                   class="btn btn-sm btn-secondary"
                                                   title="Modifier">
                                                    <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                                </a>

                                                @if($itinerary->status === 'published')
                                                    <form action="{{ route('admin.unpublish.itinerary', $itinerary->id) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-warning"
                                                                title="Dépublier"
                                                                onclick="return confirm('Voulez-vous dépublier cet itinéraire ?')">
                                                            <i data-feather="eye-off" style="width: 14px; height: 14px;"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.publish.itinerary', $itinerary->id) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-success"
                                                                title="Publier"
                                                                onclick="return confirm('Voulez-vous publier cet itinéraire ?')">
                                                            <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('admin.delete.itinerary', $itinerary->id) }}" 
                                                   class="btn btn-sm btn-danger"
                                                   title="Supprimer"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet itinéraire ? Cette action est irréversible.')">
                                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="u-mt-4">
                            <div class="pagination">
                                {{ $itineraries->links() }}
                            </div>
                        </div>

                        @else
                        <div class="u-center u-mt-4" style="text-align: center; padding: var(--sp-8);">
                            <div style="font-size: 4rem; color: var(--c-text-mut); margin-bottom: var(--sp-4);">🏔️</div>
                            <h5>Aucun itinéraire trouvé</h5>
                            <p class="u-text-muted">Commencez par ajouter votre premier itinéraire.</p>
                            <a href="{{ route('admin.add.itinerary') }}" class="btn btn-primary u-mt-4">
                                <i data-feather="plus" style="width: 16px; height: 16px;"></i> Ajouter un Itinéraire
                            </a>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection