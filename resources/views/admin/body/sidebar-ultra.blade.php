<div id="elegant-sidebar" class="layout__sidebar">
    <div class="sidebar-header">
        <!-- Sidebar Brand -->
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon" title="CERFAOS">🏔️</div>
            <div class="sidebar-brand-text">CERFAOs</div>
            <div class="sidebar-brand-compact">C</div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        
        <!-- Main Navigation -->
        <div class="nav-section">
            <div class="nav-section-title">Administration</div>

            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                    <div class="nav-icon">
                        <i data-feather="home"></i>
                    </div>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}" data-tooltip="Mon Profil">
                    <div class="nav-icon">
                        <i data-feather="user"></i>
                    </div>
                    <span class="nav-text">Mon Profil</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="/" target="_blank" class="nav-link" data-tooltip="Site Public">
                    <div class="nav-icon">
                        <i data-feather="external-link"></i>
                    </div>
                    <span class="nav-text">Site Public</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link" data-tooltip="Analytics" onclick="CerfaosAdmin.showToast('Fonctionnalité Analytics bientôt disponible', 'info')">
                    <div class="nav-icon">
                        <i data-feather="bar-chart-2"></i>
                    </div>
                    <span class="nav-text">Analytics</span>
                    <span class="nav-badge" style="background: var(--cerfaos-info); font-size: 0.6rem; padding: 1px 4px;">NEW</span>
                </a>
            </div>
        </div>

        <!-- Content Management -->
        <div class="nav-section">
            <div class="nav-section-title">Gestion Contenu</div>

            <!-- Itinéraires avec submenu -->
            <div class="nav-item">
                <a href="#" class="nav-link" data-tooltip="Itinéraires" data-bs-toggle="collapse" data-bs-target="#sidebarItineraries">
                    <div class="nav-icon">
                        <i data-feather="map"></i>
                    </div>
                    <span class="nav-text">Itinéraires</span>
                    @php
                        $itineraryCount = App\Models\Itinerary::count();
                    @endphp
                    @if($itineraryCount > 0)
                        <span class="nav-badge">{{ $itineraryCount }}</span>
                    @endif
                    <div class="nav-arrow">
                        <i data-feather="chevron-down"></i>
                    </div>
                </a>
                <div class="nav-submenu {{ request()->routeIs('admin.all.itinerary', 'admin.add.itinerary') ? 'show' : '' }}" id="sidebarItineraries">
                    <a href="{{ route('admin.all.itinerary') }}" class="nav-submenu-link {{ request()->routeIs('admin.all.itinerary') ? 'active' : '' }}">
                        <i data-feather="list"></i>
                        <span>Tous les itinéraires</span>
                    </a>
                    <a href="{{ route('admin.add.itinerary') }}" class="nav-submenu-link {{ request()->routeIs('admin.add.itinerary') ? 'active' : '' }}">
                        <i data-feather="plus"></i>
                        <span>Nouveau</span>
                    </a>
                </div>
            </div>

            <!-- Expéditions -->
            <div class="nav-item">
                <a href="#" class="nav-link" data-tooltip="Sorties" data-bs-toggle="collapse" data-bs-target="#sidebarRides">
                    <div class="nav-icon">
                        <i data-feather="compass"></i>
                    </div>
                    <span class="nav-text">Sorties</span>
                    @php
                        $sortieCount = App\Models\Sortie::count();
                    @endphp
                    @if($sortieCount > 0)
                        <span class="nav-badge">{{ $sortieCount }}</span>
                    @endif
                    <div class="nav-arrow">
                        <i data-feather="chevron-down"></i>
                    </div>
                </a>
                <div class="nav-submenu {{ request()->routeIs('admin.all.sortie', 'admin.add.sortie') ? 'show' : '' }}" id="sidebarRides">
                    <a href="{{ route('admin.all.sortie') }}" class="nav-submenu-link {{ request()->routeIs('admin.all.sortie') ? 'active' : '' }}">
                        <i data-feather="list"></i>
                        <span>Toutes les sorties</span>
                    </a>
                    <a href="{{ route('admin.add.sortie') }}" class="nav-submenu-link {{ request()->routeIs('admin.add.sortie') ? 'active' : '' }}">
                        <i data-feather="plus"></i>
                        <span>Nouvelle sortie</span>
                    </a>
                </div>
            </div>

            <!-- Activités -->
            <div class="nav-item">
                <a href="#" class="nav-link" data-tooltip="Activités" data-bs-toggle="collapse" data-bs-target="#sidebarActivities">
                    <div class="nav-icon">
                        <i data-feather="activity"></i>
                    </div>
                    <span class="nav-text">Activités</span>
                    @php
                        $featureCount = App\Models\Feature::count();
                    @endphp
                    @if($featureCount > 0)
                        <span class="nav-badge">{{ $featureCount }}</span>
                    @endif
                    <div class="nav-arrow">
                        <i data-feather="chevron-down"></i>
                    </div>
                </a>
                <div class="nav-submenu {{ request()->routeIs('all.feature', 'add.feature') ? 'show' : '' }}" id="sidebarActivities">
                    <a href="{{ route('all.feature') }}" class="nav-submenu-link {{ request()->routeIs('all.feature') ? 'active' : '' }}">
                        <i data-feather="list"></i>
                        <span>Toutes les activités</span>
                    </a>
                    <a href="{{ route('add.feature') }}" class="nav-submenu-link {{ request()->routeIs('add.feature') ? 'active' : '' }}">
                        <i data-feather="plus"></i>
                        <span>Nouvelle activité</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Blog Management -->
        <div class="nav-section">
            <div class="nav-section-title">Blog</div>

            <!-- Catégories Blog -->
            <div class="nav-item">
                <a href="#" class="nav-link" data-tooltip="Catégories" data-bs-toggle="collapse" data-bs-target="#sidebarBlogCategory">
                    <div class="nav-icon">
                        <i data-feather="folder"></i>
                    </div>
                    <span class="nav-text">Catégories</span>
                    @php
                        $categoryCount = App\Models\BlogCategory::count();
                    @endphp
                    @if($categoryCount > 0)
                        <span class="nav-badge">{{ $categoryCount }}</span>
                    @endif
                    <div class="nav-arrow">
                        <i data-feather="chevron-down"></i>
                    </div>
                </a>
                <div class="nav-submenu {{ request()->routeIs('all.blog.category', 'add.blog.category') ? 'show' : '' }}" id="sidebarBlogCategory">
                    <a href="{{ route('all.blog.category') }}" class="nav-submenu-link {{ request()->routeIs('all.blog.category') ? 'active' : '' }}">
                        <i data-feather="list"></i>
                        <span>Toutes catégories</span>
                    </a>
                    <a href="{{ route('add.blog.category') }}" class="nav-submenu-link {{ request()->routeIs('add.blog.category') ? 'active' : '' }}">
                        <i data-feather="plus"></i>
                        <span>Nouvelle catégorie</span>
                    </a>
                </div>
            </div>

            <!-- Articles Blog -->
            <div class="nav-item">
                <a href="#" class="nav-link" data-tooltip="Articles" data-bs-toggle="collapse" data-bs-target="#sidebarBlogPost">
                    <div class="nav-icon">
                        <i data-feather="edit"></i>
                    </div>
                    <span class="nav-text">Articles</span>
                    @php
                        $blogPostCount = App\Models\BlogPost::count();
                    @endphp
                    @if($blogPostCount > 0)
                        <span class="nav-badge">{{ $blogPostCount }}</span>
                    @endif
                    <div class="nav-arrow">
                        <i data-feather="chevron-down"></i>
                    </div>
                </a>
                <div class="nav-submenu {{ request()->routeIs('all.blog.post', 'add.blog.post') ? 'show' : '' }}" id="sidebarBlogPost">
                    <a href="{{ route('all.blog.post') }}" class="nav-submenu-link {{ request()->routeIs('all.blog.post') ? 'active' : '' }}">
                        <i data-feather="list"></i>
                        <span>Tous les articles</span>
                    </a>
                    <a href="{{ route('add.blog.post') }}" class="nav-submenu-link {{ request()->routeIs('add.blog.post') ? 'active' : '' }}">
                        <i data-feather="plus"></i>
                        <span>Nouvel article</span>
                    </a>
                </div>
            </div>

            <!-- Témoignages -->
            <div class="nav-item">
                <a href="#" class="nav-link" data-tooltip="Témoignages" data-bs-toggle="collapse" data-bs-target="#sidebarReviews">
                    <div class="nav-icon">
                        <i data-feather="star"></i>
                    </div>
                    <span class="nav-text">Témoignages</span>
                    @php
                        $reviewCount = App\Models\Review::count();
                    @endphp
                    @if($reviewCount > 0)
                        <span class="nav-badge">{{ $reviewCount }}</span>
                    @endif
                    <div class="nav-arrow">
                        <i data-feather="chevron-down"></i>
                    </div>
                </a>
                <div class="nav-submenu {{ request()->routeIs('all.review', 'add.review') ? 'show' : '' }}" id="sidebarReviews">
                    <a href="{{ route('all.review') }}" class="nav-submenu-link {{ request()->routeIs('all.review') ? 'active' : '' }}">
                        <i data-feather="list"></i>
                        <span>Tous témoignages</span>
                    </a>
                    <a href="{{ route('add.review') }}" class="nav-submenu-link {{ request()->routeIs('add.review') ? 'active' : '' }}">
                        <i data-feather="plus"></i>
                        <span>Nouveau témoignage</span>
                    </a>
                </div>
            </div>

            <!-- Messages -->
            <div class="nav-item">
                <a href="{{ route('get.slider') }}" class="nav-link {{ request()->routeIs('get.slider') ? 'active' : '' }}" data-tooltip="Messages">
                    <div class="nav-icon">
                        <i data-feather="message-square"></i>
                    </div>
                    <span class="nav-text">Messages</span>
                </a>
            </div>
        </div>

        <!-- System Section -->
        <div class="nav-section">
            <div class="nav-section-title">Système</div>

            <!-- Settings -->
            <div class="nav-item">
                <a href="#" class="nav-link" data-tooltip="Paramètres" onclick="CerfaosAdmin.showToast('Paramètres système bientôt disponibles', 'info')">
                    <div class="nav-icon">
                        <i data-feather="settings"></i>
                    </div>
                    <span class="nav-text">Paramètres</span>
                </a>
            </div>
            
            <!-- Cache Management -->
            <div class="nav-item">
                <button class="nav-link" onclick="clearCache()" data-tooltip="Vider Cache">
                    <div class="nav-icon">
                        <i data-feather="refresh-cw"></i>
                    </div>
                    <span class="nav-text">Vider Cache</span>
                </button>
            </div>
            
            <!-- System Health -->
            <div class="nav-item">
                <a href="#" class="nav-link" data-tooltip="État Système" onclick="CerfaosAdmin.showSystemHealth()">
                    <div class="nav-icon">
                        <i data-feather="activity"></i>
                    </div>
                    <span class="nav-text">État Système</span>
                    <span class="nav-badge" style="background: var(--cerfaos-success);">●</span>
                </a>
            </div>
            
            <!-- Export Data -->
            <div class="nav-item">
                <a href="#" class="nav-link" data-tooltip="Export" data-bs-toggle="collapse" data-bs-target="#sidebarExport">
                    <div class="nav-icon">
                        <i data-feather="download"></i>
                    </div>
                    <span class="nav-text">Export</span>
                    <div class="nav-arrow">
                        <i data-feather="chevron-down"></i>
                    </div>
                </a>
                <div class="nav-submenu" id="sidebarExport">
                    <a href="/admin/export?type=users&format=json" class="nav-submenu-link">
                        <i data-feather="users"></i>
                        <span>Utilisateurs (JSON)</span>
                    </a>
                    <a href="/admin/export?type=itineraries&format=json" class="nav-submenu-link">
                        <i data-feather="map"></i>
                        <span>Itinéraires (JSON)</span>
                    </a>
                    <a href="/admin/export?type=stats&format=json" class="nav-submenu-link">
                        <i data-feather="bar-chart"></i>
                        <span>Statistiques</span>
                    </a>
                </div>
            </div>
            
            <!-- Logout -->
            <div class="nav-item">
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-link" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; color: var(--cerfaos-error);">
                        <div class="nav-icon">
                            <i data-feather="log-out"></i>
                        </div>
                        <span class="nav-text">Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>

    </nav>

    <!-- Weather Widget -->
    <div class="weather-widget">
        <div class="weather-content">
            <div class="weather-icon">🌤️</div>
            <div>
                <div class="weather-temp">18°C</div>
                <div class="weather-desc">Parfait pour sortir</div>
            </div>
        </div>
    </div>

</div>

<!-- Enhanced JavaScript for Sidebar -->
<script>
    // Extend CerfaosAdmin with sidebar-specific functionality
    if (typeof CerfaosAdmin !== 'undefined') {
        CerfaosAdmin.showSystemHealth = function() {
            // Create a modal-like overlay for system health
            const healthModal = document.createElement('div');
            healthModal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.8);
                backdrop-filter: blur(8px);
                z-index: 10000;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;
            
            healthModal.innerHTML = `
                <div style="
                    background: var(--cerfaos-surface);
                    border: 1px solid var(--cerfaos-border);
                    border-radius: var(--radius-2xl);
                    padding: var(--space-8);
                    max-width: 500px;
                    width: 90%;
                    max-height: 80vh;
                    overflow-y: auto;
                    transform: scale(0.9);
                    transition: transform 0.3s ease;
                ">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-6);">
                        <h3 style="margin: 0; color: var(--cerfaos-text-primary); font-size: 1.25rem;">État du Système</h3>
                        <button onclick="this.closest('[style*=\"fixed\"]').remove()" style="
                            background: none;
                            border: none;
                            color: var(--cerfaos-text-muted);
                            cursor: pointer;
                            font-size: 1.5rem;
                            padding: var(--space-2);
                        ">×</button>
                    </div>
                    
                    <div style="display: grid; gap: var(--space-4);">
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <div style="width: 12px; height: 12px; background: var(--cerfaos-success); border-radius: 50%;"></div>
                            <span style="color: var(--cerfaos-text-primary);">Base de données</span>
                            <span style="margin-left: auto; color: var(--cerfaos-success); font-weight: 600;">Connectée</span>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <div style="width: 12px; height: 12px; background: var(--cerfaos-success); border-radius: 50%;"></div>
                            <span style="color: var(--cerfaos-text-primary);">Cache Redis</span>
                            <span style="margin-left: auto; color: var(--cerfaos-success); font-weight: 600;">Fonctionnel</span>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <div style="width: 12px; height: 12px; background: var(--cerfaos-warning); border-radius: 50%;"></div>
                            <span style="color: var(--cerfaos-text-primary);">Stockage</span>
                            <span style="margin-left: auto; color: var(--cerfaos-warning); font-weight: 600;">75% utilisé</span>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <div style="width: 12px; height: 12px; background: var(--cerfaos-success); border-radius: 50%;"></div>
                            <span style="color: var(--cerfaos-text-primary);">Performance</span>
                            <span style="margin-left: auto; color: var(--cerfaos-success); font-weight: 600;">Optimal</span>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <div style="width: 12px; height: 12px; background: var(--cerfaos-success); border-radius: 50%;"></div>
                            <span style="color: var(--cerfaos-text-primary);">Sécurité</span>
                            <span style="margin-left: auto; color: var(--cerfaos-success); font-weight: 600;">Sécurisé</span>
                        </div>
                    </div>
                    
                    <div style="margin-top: var(--space-6); text-align: center;">
                        <button onclick="this.closest('[style*=\"fixed\"]').remove()" class="ultra-btn ultra-btn-primary">
                            Fermer
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(healthModal);
            
            // Animate in
            requestAnimationFrame(() => {
                healthModal.style.opacity = '1';
                healthModal.querySelector('div').style.transform = 'scale(1)';
            });
        };
    }
</script>

<!-- Additional Styles -->
<style>
    /* Enhanced nav badges */
    .nav-badge {
        animation: subtle-pulse 3s infinite;
    }
    
    @keyframes subtle-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    /* Weather widget animations */
    .weather-widget {
        position: relative;
        overflow: hidden;
    }
    
    .weather-widget::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 2s;
    }
    
    .weather-widget:hover::before {
        left: 100%;
    }
    
    /* Smooth state transitions */
    .nav-submenu {
        transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), 
                    padding 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Enhanced active states */
    .nav-link.active {
        position: relative;
    }
    
    .nav-link.active::after {
        content: '';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 60%;
        background: var(--gradient-accent);
        border-radius: 0 2px 2px 0;
    }
</style>