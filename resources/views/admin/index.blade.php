@extends('admin.admin_master_ultra')
@section('admin')

<!-- Dashboard -->
<div class="dashboard">
    
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <div>
                <h1>Bienvenue sur CERFAOS</h1>
                <p>Interface d'administration moderne et élégante pour gérer votre plateforme outdoor</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('admin.add.itinerary') }}" class="btn btn-primary">
                    <i data-feather="plus"></i>
                    Nouvel itinéraire
                </a>
                <a href="{{ route('admin.add.sortie') }}" class="btn btn-secondary">
                    <i data-feather="compass"></i>
                    Planifier sortie
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        
        <!-- Itinéraires -->
        <div class="stat-card">
            <div class="stat-header">
                <h3>Itinéraires</h3>
                <div class="stat-icon">
                    <i data-feather="map"></i>
                </div>
            </div>
            @php
                $itineraryCount = App\Models\Itinerary::count();
            @endphp
            <div class="stat-value">{{ $itineraryCount }}</div>
            <div class="stat-change">
                <i data-feather="trending-up"></i>
                <span>+12% ce mois</span>
            </div>
        </div>

        <!-- Expéditions -->
        <div class="stat-card">
            <div class="stat-header">
                <h3>Expéditions</h3>
                <div class="stat-icon">
                    <i data-feather="compass"></i>
                </div>
            </div>
            @php
                $sortieCount = App\Models\Sortie::count();
            @endphp
            <div class="stat-value">{{ $sortieCount }}</div>
            <div class="stat-change">
                <i data-feather="trending-up"></i>
                <span>+8% ce mois</span>
            </div>
        </div>

        <!-- Articles Blog -->
        <div class="stat-card">
            <div class="stat-header">
                <h3>Articles</h3>
                <div class="stat-icon">
                    <i data-feather="edit"></i>
                </div>
            </div>
            @php
                $blogPostCount = App\Models\BlogPost::count();
            @endphp
            <div class="stat-value">{{ $blogPostCount }}</div>
            <div class="stat-change">
                <i data-feather="trending-up"></i>
                <span>+15% ce mois</span>
            </div>
        </div>

        <!-- Témoignages -->
        <div class="stat-card">
            <div class="stat-header">
                <h3>Témoignages</h3>
                <div class="stat-icon">
                    <i data-feather="star"></i>
                </div>
            </div>
            @php
                $reviewCount = App\Models\Review::count();
            @endphp
            <div class="stat-value">{{ $reviewCount }}</div>
            <div class="stat-change">
                <i data-feather="trending-up"></i>
                <span>+5% ce mois</span>
            </div>
        </div>

        <!-- Messages Contact -->
        <div class="stat-card">
            <div class="stat-header">
                <h3>Messages</h3>
                <div class="stat-icon">
                    <i data-feather="mail"></i>
                </div>
            </div>
            @php
                $contactCount = App\Models\Contact::count();
                $newContactCount = App\Models\Contact::where('status', 'nouveau')->count();
            @endphp
            <div class="stat-value">{{ $contactCount }}</div>
            <div class="stat-change">
                @if($newContactCount > 0)
                    <i data-feather="bell"></i>
                    <span style="color: #d4af37;">{{ $newContactCount }} nouveau{{ $newContactCount > 1 ? 'x' : '' }}</span>
                @else
                    <i data-feather="check-circle"></i>
                    <span>Tous traités</span>
                @endif
            </div>
        </div>

    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        
        <!-- Actions rapides -->
        <div class="card">
            <div class="card__header">
                <h3>Actions rapides</h3>
            </div>
            <div class="card__body">
                <div class="quick-actions">
                    
                    <a href="{{ route('admin.add.itinerary') }}" class="quick-action">
                        <div class="quick-action-icon">
                            <i data-feather="map"></i>
                        </div>
                        <div>
                            <div class="quick-action-title">Créer itinéraire</div>
                            <div class="quick-action-desc">Ajouter un nouveau parcours</div>
                        </div>
                        <i data-feather="chevron-right"></i>
                    </a>

                    <a href="{{ route('admin.add.sortie') }}" class="quick-action">
                        <div class="quick-action-icon">
                            <i data-feather="compass"></i>
                        </div>
                        <div>
                            <div class="quick-action-title">Planifier sortie</div>
                            <div class="quick-action-desc">Organiser une expédition</div>
                        </div>
                        <i data-feather="chevron-right"></i>
                    </a>

                    

                    <a href="{{ route('add.review') }}" class="quick-action">
                        <div class="quick-action-icon">
                            <i data-feather="star"></i>
                        </div>
                        <div>
                            <div class="quick-action-title">Ajouter témoignage</div>
                            <div class="quick-action-desc">Partager une expérience</div>
                        </div>
                        <i data-feather="chevron-right"></i>
                    </a>

                    <a href="{{ route('admin.contacts.index') }}" class="quick-action">
                        <div class="quick-action-icon">
                            <i data-feather="mail"></i>
                        </div>
                        <div>
                            <div class="quick-action-title">Messages contact</div>
                            <div class="quick-action-desc">Gérer les demandes reçues</div>
                        </div>
                        <i data-feather="chevron-right"></i>
                    </a>

                </div>
            </div>
        </div>

        <!-- Activité récente -->
        <div class="card">
            <div class="card__header">
                <h3>Activité récente</h3>
            </div>
            <div class="card__body">
                <div class="activity-list">
                    
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i data-feather="map"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Mont-Blanc Express ajouté</div>
                            <div class="activity-desc">Mont-Blanc Express ajouté par Admin</div>
                            <div class="activity-time">Il y a 2 heures</div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon">
                            <i data-feather="compass"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Sortie VTT planifiée</div>
                            <div class="activity-desc">Trail des Alpes programmé</div>
                            <div class="activity-time">Il y a 4 heures</div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon">
                            <i data-feather="edit"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Article publié</div>
                            <div class="activity-desc">Guide des sentiers de montagne</div>
                            <div class="activity-time">Il y a 1 jour</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection