<div class="layout__header">
    <!-- Left Section -->
    <div class="header__left">
        <!-- Mobile Menu Toggle -->
        <button class="header__toggle" id="elegant-sidebar-toggle" onclick="toggleMobileSidebar()">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        
        <!-- Brand -->
        <a href="{{ route('dashboard') }}" class="header__brand">
            <div class="header__brand-icon">🏔️</div>
            <div class="header__brand-text">
                <div class="header__brand-title">CERFAOS</div>
                <div class="header__brand-subtitle">Admin Pro</div>
            </div>
        </a>
        
        <!-- Global Search -->
        <div class="header__search">
            <i data-feather="search" class="header__search-icon"></i>
            <input 
                type="text" 
                class="header__search-input"
                placeholder="Rechercher dans CERFAOS..."
                autocomplete="off"
            >
        </div>
    </div>

    <!-- Right Section -->
    <div class="header__right">

        <!-- Quick Actions -->
        <a href="#" class="header__action" title="Plein écran" onclick="toggleFullscreen()">
            <i data-feather="maximize"></i>
        </a>
        
        <!-- Notifications -->
        <div class="header__dropdown" onclick="toggleDropdown(event, this)">
            <a href="#" class="header__action" title="Notifications">
                <i data-feather="bell"></i>
                <span class="header__badge">5</span>
            </a>
            <div class="header__dropdown-content">
                <div class="card__header">
                    <h6 class="card__title">Notifications</h6>
                </div>
                <div class="u-flex u-flex-col u-gap-2" style="padding: var(--cerfaos-space-4);">
                    <a href="#" class="u-flex u-items-center u-gap-3" style="padding: var(--cerfaos-space-2); border-radius: var(--cerfaos-radius-md); text-decoration: none; transition: var(--cerfaos-transition);" onmouseover="this.style.backgroundColor='var(--cerfaos-bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        <div style="width: 32px; height: 32px; border-radius: 50%; overflow: hidden; flex-shrink: 0;">
                            <img src="{{ asset('backend/assets/images/users/user-12.jpg') }}" alt="Marie" style="width: 100%; height: 100%; object-fit: cover;" />
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div class="u-font-semibold" style="font-size: var(--cerfaos-font-size-sm); color: var(--cerfaos-text-primary);">Marie Dubois</div>
                            <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-xs);">A terminé le Mont-Blanc Express</div>
                        </div>
                    </a>
                    
                    <a href="#" class="u-flex u-items-center u-gap-3" style="padding: var(--cerfaos-space-2); border-radius: var(--cerfaos-radius-md); text-decoration: none; transition: var(--cerfaos-transition);" onmouseover="this.style.backgroundColor='var(--cerfaos-bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        <div style="width: 32px; height: 32px; border-radius: 50%; overflow: hidden; flex-shrink: 0;">
                            <img src="{{ asset('backend/assets/images/users/user-2.jpg') }}" alt="Paul" style="width: 100%; height: 100%; object-fit: cover;" />
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div class="u-font-semibold" style="font-size: var(--cerfaos-font-size-sm); color: var(--cerfaos-text-primary);">Paul Martin</div>
                            <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-xs);">A uploadé photos-sommet.zip</div>
                        </div>
                    </a>
                    
                    <a href="#" class="u-flex u-items-center u-gap-3" style="padding: var(--cerfaos-space-2); border-radius: var(--cerfaos-radius-md); text-decoration: none; transition: var(--cerfaos-transition);" onmouseover="this.style.backgroundColor='var(--cerfaos-bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--cerfaos-accent); display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
                            ⚡
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div class="u-font-semibold" style="font-size: var(--cerfaos-font-size-sm); color: var(--cerfaos-text-primary);">Système</div>
                            <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-xs);">Nouvelle mise à jour disponible</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- User Profile -->
        @php
            $id = Auth::user()->id;
            $profileData = App\Models\User::find($id);
        @endphp
        
        <div class="header__dropdown" onclick="toggleDropdown(event, this)">
            <a href="#" class="header__profile">
                <div class="header__profile-avatar">
                    <img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="user-image">
                </div>
                <div class="header__profile-info">
                    <div class="header__profile-name">{{ $profileData->name }}</div>
                    <div class="header__profile-role">Administrateur</div>
                </div>
                <i data-feather="chevron-down" style="width: 16px; height: 16px;"></i>
            </a>
            <div class="header__dropdown-content">
                <div class="card__header">
                    <h6 class="card__title">Mon Compte</h6>
                </div>
                <div class="u-flex u-flex-col" style="padding: var(--cerfaos-space-4);">
                    <a href="{{ route('admin.profile') }}" class="u-flex u-items-center u-gap-3" style="padding: var(--cerfaos-space-3); border-radius: var(--cerfaos-radius-md); text-decoration: none; transition: var(--cerfaos-transition); color: var(--cerfaos-text-primary);" onmouseover="this.style.backgroundColor='var(--cerfaos-bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        <i data-feather="user" style="width: 20px; height: 20px; color: var(--cerfaos-text-muted);"></i>
                        <div>
                            <div class="u-font-semibold" style="font-size: var(--cerfaos-font-size-sm);">Mon Profil</div>
                            <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-xs);">Gérer mes informations</div>
                        </div>
                    </a>
                    
                    <a href="#" class="u-flex u-items-center u-gap-3" style="padding: var(--cerfaos-space-3); border-radius: var(--cerfaos-radius-md); text-decoration: none; transition: var(--cerfaos-transition); color: var(--cerfaos-text-primary);" onmouseover="this.style.backgroundColor='var(--cerfaos-bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                        <i data-feather="settings" style="width: 20px; height: 20px; color: var(--cerfaos-text-muted);"></i>
                        <div>
                            <div class="u-font-semibold" style="font-size: var(--cerfaos-font-size-sm);">Paramètres</div>
                            <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-xs);">Configuration admin</div>
                        </div>
                    </a>
                    
                    <hr style="margin: var(--cerfaos-space-2) 0; border: none; border-top: 1px solid var(--cerfaos-border-light);">
                    
                    <a href="{{ route('admin.logout') }}" class="u-flex u-items-center u-gap-3" style="padding: var(--cerfaos-space-3); border-radius: var(--cerfaos-radius-md); text-decoration: none; transition: var(--cerfaos-transition); color: var(--cerfaos-danger);" onmouseover="this.style.backgroundColor='rgba(245, 101, 101, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                        <i data-feather="log-out" style="width: 20px; height: 20px;"></i>
                        <div>
                            <div class="u-font-semibold" style="font-size: var(--cerfaos-font-size-sm);">Déconnexion</div>
                            <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-xs);">Quitter l'admin</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

