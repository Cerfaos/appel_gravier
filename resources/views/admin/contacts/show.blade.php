@extends('admin.admin_master_ultra')

@section('admin')
<div class="page-content">
    <div class="container">

        <!-- start page title -->
        <div class="page-header">
            <div>
                <h4>Détail du Message</h4>
            </div>
            <div>
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.contacts.index') }}">Contacts</a></li>
                    <li>Détail</li>
                </ol>
            </div>
        </div>
        <!-- end page title -->

        <div class="content">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card__header">
                        <div class="u-flex u-gap-4">
                            <h5>Message de {{ $contact->name }}</h5>
                            <div class="u-flex u-gap-2">
                                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                                    <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i> Retour à la liste
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card__body">
                        
                        <!-- Informations du contact -->
                        <div class="u-flex u-gap-4">
                            <div>
                                <!-- Informations principales -->
                                <div class="u-flex u-gap-4">
                                    <div class="badge badge--primary">
                                        <i data-feather="user" style="width: 14px; height: 14px;"></i>
                                        {{ $contact->name }}
                                    </div>
                                    <div class="badge badge--secondary">
                                        <i data-feather="mail" style="width: 14px; height: 14px;"></i>
                                        {{ $contact->email }}
                                    </div>
                                    @if($contact->phone)
                                        <div class="badge badge--info">
                                            <i data-feather="phone" style="width: 14px; height: 14px;"></i>
                                            {{ $contact->phone }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <!-- Statut -->
                                <div class="u-flex u-gap-2">
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
                                    
                                    <small class="u-text-muted">
                                        Reçu le {{ $contact->created_at->format('d/m/Y à H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>

                        @if($contact)
                        <div class="u-mt-4">
                            
                            <!-- Contenu du message -->
                            <div class="card" style="margin-bottom: var(--sp-6);">
                                <div class="card__header">
                                    <h6>
                                        <i data-feather="message-square" style="width: 16px; height: 16px;"></i>
                                        {{ $contact->subject }}
                                    </h6>
                                </div>
                                <div class="card__body">
                                    <div style="background: var(--cerfaos-surface); padding: var(--sp-4); border-radius: var(--cerfaos-radius-md); border-left: 4px solid var(--cerfaos-accent);">
                                        {!! nl2br(e($contact->message)) !!}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions rapides -->
                            <div class="card">
                                <div class="card__header">
                                    <h6>
                                        <i data-feather="settings" style="width: 16px; height: 16px;"></i>
                                        Actions
                                    </h6>
                                </div>
                                <div class="card__body">
                                    <div class="u-flex u-gap-2">
                                        @if($contact->status === 'nouveau')
                                            <form action="{{ route('admin.contacts.update-status', $contact->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="lu">
                                                <button type="submit" 
                                                        class="btn btn-info"
                                                        onclick="return confirm('Marquer ce message comme lu ?')">
                                                    <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                                    Marquer comme lu
                                                </button>
                                            </form>
                                        @elseif($contact->status === 'lu')
                                            <form action="{{ route('admin.contacts.update-status', $contact->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="traite">
                                                <button type="submit" 
                                                        class="btn btn-success"
                                                        onclick="return confirm('Marquer ce message comme traité ?')">
                                                    <i data-feather="check-circle" style="width: 14px; height: 14px;"></i>
                                                    Marquer comme traité
                                                </button>
                                            </form>
                                        @elseif($contact->status === 'traite')
                                            <form action="{{ route('admin.contacts.update-status', $contact->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="archive">
                                                <button type="submit" 
                                                        class="btn btn-warning"
                                                        onclick="return confirm('Archiver ce message ?')">
                                                    <i data-feather="archive" style="width: 14px; height: 14px;"></i>
                                                    Archiver
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.contacts.update-status', $contact->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="nouveau">
                                                <button type="submit" 
                                                        class="btn btn-secondary"
                                                        onclick="return confirm('Remettre ce message en traitement ?')">
                                                    <i data-feather="rotate-ccw" style="width: 14px; height: 14px;"></i>
                                                    Remettre en traitement
                                                </button>
                                            </form>
                                        @endif

                                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" 
                                           class="btn btn-primary">
                                            <i data-feather="mail" style="width: 14px; height: 14px;"></i>
                                            Répondre par email
                                        </a>

                                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" 
                                              method="POST" 
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.')">
                                                <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection