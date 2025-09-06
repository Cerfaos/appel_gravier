@extends('admin.admin_master_ultra')

@section('admin')
<div class="page-content">
    <div class="container">

        <!-- start page title -->
        <div class="page-header">
            <div>
                <h4>Messages de Contact</h4>
            </div>
            <div>
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li>Contacts</li>
                </ol>
            </div>
        </div>
        <!-- end page title -->

        <div class="content">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card__header">
                        <div class="u-flex u-gap-4">
                            <h5>Liste des Messages de Contact</h5>
                            <div class="u-flex u-gap-2">
                                <button type="button" class="btn btn-primary" onclick="markAllAsRead()" title="Marquer tous comme lus">
                                    <i data-feather="eye" style="width: 16px; height: 16px;"></i> Actions rapides
                                </button>
                            </div>
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
                                        <i data-feather="inbox" style="width: 14px; height: 14px;"></i>
                                        Total: {{ $stats['total'] }}
                                    </div>
                                    <div class="badge badge--warning">
                                        <i data-feather="bell" style="width: 14px; height: 14px;"></i>
                                        Nouveaux: {{ $stats['new'] }}
                                    </div>
                                    <div class="badge badge--info">
                                        <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                        Lus: {{ $stats['read'] }}
                                    </div>
                                    <div class="badge badge--success">
                                        <i data-feather="check-circle" style="width: 14px; height: 14px;"></i>
                                        Traités: {{ $stats['processed'] }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div>
                                <!-- Filtres -->
                                <form method="GET" class="u-flex u-gap-2">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="">Tous les statuts</option>
                                        <option value="nouveau" {{ request('status') === 'nouveau' ? 'selected' : '' }}>
                                            🟡 Nouveaux uniquement
                                        </option>
                                        <option value="lu" {{ request('status') === 'lu' ? 'selected' : '' }}>
                                            🔵 Lus uniquement
                                        </option>
                                        <option value="traite" {{ request('status') === 'traite' ? 'selected' : '' }}>
                                            🟢 Traités uniquement
                                        </option>
                                        <option value="archive" {{ request('status') === 'archive' ? 'selected' : '' }}>
                                            ⚫ Archivés uniquement
                                        </option>
                                    </select>
                                    
                                    @if(request('status'))
                                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-secondary">
                                            <i data-feather="x" style="width: 14px; height: 14px;"></i>
                                        </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <div>

                        @if($contacts->count() > 0)
                        <div class="u-mt-4">
                            <table class="table table--zebra">
                                <thead>
                                    <tr>
                                        <th>Contact</th>
                                        <th>Sujet</th>
                                        <th>Message</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $contact)
                                    <tr>
                                        <td>
                                            <div class="u-flex u-items-center u-gap-3">
                                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--cerfaos-accent), var(--cerfaos-accent-hover)); border-radius: var(--cerfaos-radius-md); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                                    📧
                                                </div>
                                                <div>
                                                    <h6>{{ $contact->name }}</h6>
                                                    <div class="u-flex u-items-center u-gap-2">
                                                        <small class="u-text-muted">#{{ $contact->id }}</small>
                                                        <small class="u-text-muted">{{ $contact->email }}</small>
                                                        @if($contact->phone)
                                                            <small class="u-text-muted">{{ $contact->phone }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge--secondary">
                                                {{ Str::limit($contact->subject, 30) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="u-text-muted">{{ Str::limit($contact->message, 60) }}</small>
                                        </td>
                                        <td>
                                            @if($contact->status === 'nouveau')
                                                <span class="badge badge--warning">
                                                    <i data-feather="bell" style="width: 12px; height: 12px;"></i> Nouveau
                                                </span>
                                            @elseif($contact->status === 'lu')
                                                <span class="badge badge--info">
                                                    <i data-feather="eye" style="width: 12px; height: 12px;"></i> Lu
                                                </span>
                                            @elseif($contact->status === 'traite')
                                                <span class="badge badge--success">
                                                    <i data-feather="check-circle" style="width: 12px; height: 12px;"></i> Traité
                                                </span>
                                            @else
                                                <span class="badge badge--secondary">
                                                    <i data-feather="archive" style="width: 12px; height: 12px;"></i> Archivé
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                {{ $contact->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="u-flex u-gap-2">
                                                <a href="{{ route('admin.contacts.show', $contact->id) }}" 
                                                   class="btn btn-sm btn-secondary"
                                                   title="Voir détails">
                                                    <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                                </a>
                                                
                                                @if($contact->status === 'nouveau')
                                                    <form action="{{ route('admin.contacts.update-status', $contact->id) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="status" value="lu">
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-info"
                                                                title="Marquer comme lu"
                                                                onclick="return confirm('Marquer ce message comme lu ?')">
                                                            <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                                        </button>
                                                    </form>
                                                @elseif($contact->status === 'lu')
                                                    <form action="{{ route('admin.contacts.update-status', $contact->id) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="status" value="traite">
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-success"
                                                                title="Marquer comme traité"
                                                                onclick="return confirm('Marquer ce message comme traité ?')">
                                                            <i data-feather="check-circle" style="width: 14px; height: 14px;"></i>
                                                        </button>
                                                    </form>
                                                @elseif($contact->status === 'traite')
                                                    <form action="{{ route('admin.contacts.update-status', $contact->id) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="status" value="archive">
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-warning"
                                                                title="Archiver"
                                                                onclick="return confirm('Archiver ce message ?')">
                                                            <i data-feather="archive" style="width: 14px; height: 14px;"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.contacts.update-status', $contact->id) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="status" value="nouveau">
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-secondary"
                                                                title="Remettre en traitement"
                                                                onclick="return confirm('Remettre ce message en traitement ?')">
                                                            <i data-feather="rotate-ccw" style="width: 14px; height: 14px;"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" 
                                                      method="POST" 
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger"
                                                            title="Supprimer"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.')">
                                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                    </button>
                                                </form>
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
                                {{ $contacts->appends(request()->query())->links() }}
                            </div>
                        </div>

                        @else
                        <div class="u-center u-mt-4" style="text-align: center; padding: var(--sp-8);">
                            <div style="font-size: 4rem; color: var(--c-text-mut); margin-bottom: var(--sp-4);">📧</div>
                            <h5>Aucun message trouvé</h5>
                            <p class="u-text-muted">
                                @if(request()->hasAny(['status', 'search']))
                                    Aucun message ne correspond à vos critères de recherche.
                                @else
                                    Aucun message de contact n'a encore été reçu.
                                @endif
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection