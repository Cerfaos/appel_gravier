<div class="layout__sidebar" id="elegant-sidebar">
    <div class="sidebar__container">

        <!-- Logo Section -->
        <a href="{{ route('dashboard') }}" class="sidebar__brand">
            <div class="sidebar__brand-icon">🏔️</div>
            <div class="sidebar__brand-text">CERFAOS</div>
        </a>

        <!-- Navigation -->
        <nav class="sidebar__nav">
            
            <!-- Main Navigation -->
            <div class="sidebar__section">
                <div class="sidebar__section-title">Administration</div>
                <div class="sidebar__menu">
                     
                    <a href="{{ route('dashboard') }}" class="sidebar__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
                        <i data-feather="home" class="sidebar__link-icon"></i>
                        <span class="sidebar__link-text">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.profile') }}" class="sidebar__link {{ request()->routeIs('admin.profile') ? 'is-active' : '' }}">
                        <i data-feather="user" class="sidebar__link-icon"></i>
                        <span class="sidebar__link-text">Mon Profil</span>
                    </a>

                  

                    <a href="{{ route('get.slider') }}" class="sidebar__link {{ request()->routeIs('get.slider', 'all.slider') ? 'is-active' : '' }}">
                        <i data-feather="image" class="sidebar__link-icon"></i>
                        <span class="sidebar__link-text">Message Accueil</span>
                    </a>

                    <!-- Section À Propos -->
                    <a href="{{ route('about.content.index') }}" class="sidebar__link {{ request()->routeIs('about.content.*') ? 'is-active' : '' }}">
                        <i data-feather="user" class="sidebar__link-icon"></i>
                        <span class="sidebar__link-text">Section à Propos</span>                       
                    </a>

                    <a href="/" target="_blank" class="sidebar__link">
                        <i data-feather="external-link" class="sidebar__link-icon"></i>
                        <span class="sidebar__link-text">Site Public</span>
                    </a>




                </div>
            </div>

            <!-- Content Management -->
            <div class="sidebar__section">
                <div class="sidebar__section-title">Gestion Contenu</div>
                <div class="sidebar__menu">
                    <!-- Itinéraires avec submenu -->
                    <div>
                        <a href="#" class="sidebar__link {{ request()->routeIs('admin.all.itinerary', 'admin.add.itinerary') ? 'is-expanded' : '' }}" 
                           onclick="toggleSubmenu(event, 'sidebarItineraries')">
                            <i data-feather="map" class="sidebar__link-icon"></i>
                            <span class="sidebar__link-text">Itinéraires</span>
                            @php
                                $itineraryCount = App\Models\Itinerary::count();
                            @endphp
                            @if($itineraryCount > 0)
                                <span class="sidebar__link-badge">{{ $itineraryCount }}</span>
                            @endif
                            <i data-feather="chevron-down" class="sidebar__link-arrow"></i>
                        </a>
                        <div class="sidebar__submenu {{ request()->routeIs('admin.all.itinerary', 'admin.add.itinerary') ? 'is-expanded' : '' }}" id="sidebarItineraries">
                            <a href="{{ route('admin.all.itinerary') }}" class="sidebar__submenu-link {{ request()->routeIs('admin.all.itinerary') ? 'is-active' : '' }}">
                                <i data-feather="list"></i>
                                <span>Tous les itinéraires</span>
                            </a>
                            <a href="{{ route('admin.add.itinerary') }}" class="sidebar__submenu-link {{ request()->routeIs('admin.add.itinerary') ? 'is-active' : '' }}">
                                <i data-feather="plus"></i>
                                <span>Nouveau</span>
                            </a>
                        </div>
                    </div>

                    <!-- Sorties -->
                    <div>
                        <a href="#" class="sidebar__link {{ request()->routeIs('admin.all.sortie', 'admin.add.sortie', 'admin.edit.sortie', 'admin.show.sortie') ? 'is-expanded' : '' }}" 
                           onclick="toggleSubmenu(event, 'sidebarSorties')">
                            <i data-feather="compass" class="sidebar__link-icon"></i>
                            <span class="sidebar__link-text">Sorties</span>
                            @php
                                $sortieCount = App\Models\Sortie::count();
                            @endphp
                            @if($sortieCount > 0)
                                <span class="sidebar__link-badge">{{ $sortieCount }}</span>
                            @endif
                            <i data-feather="chevron-down" class="sidebar__link-arrow"></i>
                        </a>
                        <div class="sidebar__submenu {{ request()->routeIs('admin.all.sortie', 'admin.add.sortie', 'admin.edit.sortie', 'admin.show.sortie') ? 'is-expanded' : '' }}" id="sidebarSorties">
                            <a href="{{ route('admin.all.sortie') }}" class="sidebar__submenu-link {{ request()->routeIs('admin.all.sortie') ? 'is-active' : '' }}">
                                <i data-feather="list"></i>
                                <span>Toutes les sorties</span>
                            </a>
                            <a href="{{ route('admin.add.sortie') }}" class="sidebar__submenu-link {{ request()->routeIs('admin.add.sortie') ? 'is-active' : '' }}">
                                <i data-feather="plus"></i>
                                <span>Nouvelle sortie</span>
                            </a>
                        </div>
                    </div>


                    <!-- Activités -->
                    <div>
                        <a href="#" class="sidebar__link {{ request()->routeIs('all.feature', 'add.feature') ? 'is-expanded' : '' }}" 
                           onclick="toggleSubmenu(event, 'sidebarActivities')">
                            <i data-feather="activity" class="sidebar__link-icon"></i>
                            <span class="sidebar__link-text">Activités</span>
                            @php
                                $featureCount = App\Models\Feature::count();
                            @endphp
                            @if($featureCount > 0)
                                <span class="sidebar__link-badge">{{ $featureCount }}</span>
                            @endif
                            <i data-feather="chevron-down" class="sidebar__link-arrow"></i>
                        </a>
                        <div class="sidebar__submenu {{ request()->routeIs('all.feature', 'add.feature') ? 'is-expanded' : '' }}" id="sidebarActivities">
                            <a href="{{ route('all.feature') }}" class="sidebar__submenu-link {{ request()->routeIs('all.feature') ? 'is-active' : '' }}">
                                <i data-feather="list"></i>
                                <span>Toutes les activités</span>
                            </a>
                            <a href="{{ route('add.feature') }}" class="sidebar__submenu-link {{ request()->routeIs('add.feature') ? 'is-active' : '' }}">
                                <i data-feather="plus"></i>
                                <span>Nouvelle activité</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blog Management -->
            <div class="sidebar__section">
                <div class="sidebar__section-title">Blog & Contenu</div>
                <div class="sidebar__menu">
                    
                    

                    <!-- Articles Blog -->
                    <div>
                        <a href="#" class="sidebar__link {{ request()->routeIs('all.blog.post', 'add.blog.post', 'edit.blog.post', 'show.blog.post') ? 'is-expanded' : '' }}" 
                           onclick="toggleSubmenu(event, 'sidebarBlogPost')">
                            <i data-feather="edit" class="sidebar__link-icon"></i>
                            <span class="sidebar__link-text">Articles</span>
                            @php
                                $blogPostCount = App\Models\BlogPost::count();
                            @endphp
                            @if($blogPostCount > 0)
                                <span class="sidebar__link-badge">{{ $blogPostCount }}</span>
                            @endif
                            <i data-feather="chevron-down" class="sidebar__link-arrow"></i>
                        </a>
                        <div class="sidebar__submenu {{ request()->routeIs('all.blog.post', 'add.blog.post', 'edit.blog.post', 'show.blog.post') ? 'is-expanded' : '' }}" id="sidebarBlogPost">
                            <a href="{{ route('all.blog.post') }}" class="sidebar__submenu-link {{ request()->routeIs('all.blog.post', 'show.blog.post') ? 'is-active' : '' }}">
                                <i data-feather="file-text"></i>
                                <span>Tous les articles</span>
                            </a>
                            <a href="{{ route('add.blog.post') }}" class="sidebar__submenu-link {{ request()->routeIs('add.blog.post') ? 'is-active' : '' }}">
                                <i data-feather="plus"></i>
                                <span>Nouvel article</span>
                            </a>
                        </div>
                    </div>

                    <!-- Catégories Blog -->
                    <div>
                        <a href="#" class="sidebar__link {{ request()->routeIs('all.blog.category', 'add.blog.category') ? 'is-expanded' : '' }}" 
                           onclick="toggleSubmenu(event, 'sidebarBlogCategory')">
                            <i data-feather="folder" class="sidebar__link-icon"></i>
                            <span class="sidebar__link-text">Catégories</span>
                            @php
                                $categoryCount = App\Models\BlogCategory::count();
                            @endphp
                            @if($categoryCount > 0)
                                <span class="sidebar__link-badge">{{ $categoryCount }}</span>
                            @endif
                            <i data-feather="chevron-down" class="sidebar__link-arrow"></i>
                        </a>
                        <div class="sidebar__submenu {{ request()->routeIs('all.blog.category', 'add.blog.category') ? 'is-expanded' : '' }}" id="sidebarBlogCategory">
                            <a href="{{ route('all.blog.category') }}" class="sidebar__submenu-link {{ request()->routeIs('all.blog.category') ? 'is-active' : '' }}">
                                <i data-feather="list"></i>
                                <span>Toutes catégories</span>
                            </a>
                            <a href="{{ route('add.blog.category') }}" class="sidebar__submenu-link {{ request()->routeIs('add.blog.category') ? 'is-active' : '' }}">
                                <i data-feather="plus"></i>
                                <span>Nouvelle catégorie</span>
                            </a>
                        </div>
                    </div>


                    <!-- Messages de Contact -->
                    <a href="{{ route('admin.contacts.index') }}" class="sidebar__link {{ request()->routeIs('admin.contacts.*') ? 'is-active' : '' }}">
                        <i data-feather="mail" class="sidebar__link-icon"></i>
                        <span class="sidebar__link-text">Messages Contact</span>
                        @php
                            $contactCount = App\Models\Contact::where('status', 'nouveau')->count();
                        @endphp
                        @if($contactCount > 0)
                            <span class="sidebar__link-badge sidebar__link-badge--urgent">{{ $contactCount }}</span>
                        @endif
                    </a>

                </div>
            </div>

            <!-- System Section -->
            <div class="sidebar__section">
               
                <div class="sidebar__menu">
                   
                    
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="sidebar__link sidebar__link--logout">
                            <i data-feather="log-out" class="sidebar__link-icon"></i>
                            <span class="sidebar__link-text">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>

        </nav>

        <!-- Weather Widget -->
        <div class="sidebar__widget">
            <div class="sidebar__widget-content">
                <div class="sidebar__widget-icon">🌤️</div>
                <div class="sidebar__widget-info">
                    <div class="sidebar__widget-temp">La météo</div>
                    <div class="sidebar__widget-desc">Sera toujours parfaite pour sortir</div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- CSS intégré dans le fichier principal ultra-modern-admin.css -->