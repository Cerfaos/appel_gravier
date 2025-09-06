<div class="layout__header">
    <!-- Left Section -->
    <div class="header-left">
        <!-- Sidebar Toggle Controls -->
        <div class="sidebar-controls">
            <!-- Mobile Menu Toggle -->
            <button id="elegant-sidebar-toggle" class="mobile-menu-toggle" aria-label="Toggle sidebar">
                <i data-feather="menu"></i>
            </button>
            
            <!-- Desktop Sidebar Collapse -->
            <button id="sidebar-collapse-toggle" class="desktop-sidebar-toggle" aria-label="Réduire/Agrandir sidebar" title="Réduire/Agrandir sidebar">
                <i data-feather="sidebar" class="expand-icon"></i>
                <i data-feather="chevrons-left" class="collapse-icon"></i>
            </button>
        </div>
        
        <!-- Brand -->
        <a href="{{ route('dashboard') }}" class="header-brand">
            <div class="header-brand-icon">🏔️</div>
            <div class="header-brand-text">
                <h2>CERFAOS</h2>
                <small class="header-brand-subtitle">Ultra Admin</small>
            </div>
        </a>
        
        <!-- Global Search -->
        @include('admin.components.ultra-global-search')
    </div>

    <!-- Right Section -->
    <div class="header-right">
        
        <!-- Enhanced Quick Actions -->
        <div class="header-actions-group" data-version="v2.0-ultra-enhanced">
            <!-- Theme Toggle -->
            <button class="header-action" id="theme-toggle" title="Basculer le thème" aria-label="Basculer entre mode clair et sombre">
                <i data-feather="sun" class="theme-light"></i>
                <i data-feather="moon" class="theme-dark"></i>
            </button>
            
            <!-- Performance Monitor -->
            <button class="header-action" id="performance-monitor" title="Performances système" aria-label="Voir les performances">
                <i data-feather="activity"></i>
                <span class="performance-indicator"></span>
            </button>
            
            <!-- Fullscreen Toggle -->
            <button class="header-action" id="fullscreen-toggle" title="Plein écran" data-toggle="fullscreen" aria-label="Activer le plein écran">
                <i data-feather="maximize" class="fullscreen-enter"></i>
                <i data-feather="minimize" class="fullscreen-exit"></i>
            </button>
            
            <!-- Cache Management -->
            <button class="header-action cache-action" onclick="clearCache()" title="Vider le cache" aria-label="Vider le cache">
                <i data-feather="refresh-cw"></i>
                <span class="action-badge" id="cache-status">OK</span>
            </button>
            
            <!-- Quick Search -->
            <button class="header-action" id="quick-search-toggle" title="Recherche rapide" aria-label="Ouvrir la recherche rapide">
                <i data-feather="search"></i>
            </button>
            
            <!-- Voice Commands -->
            <button class="header-action" id="voice-command-toggle" title="Commandes vocales" aria-label="Activer commandes vocales" style="border: 2px solid red;">
                <i data-feather="mic"></i>
                <span class="voice-indicator"></span>
            </button>
            
            <!-- Sync Status -->
            <button class="header-action" id="sync-status" title="Synchronisation" aria-label="État de synchronisation">
                <i data-feather="refresh-ccw"></i>
                <span class="sync-indicator"></span>
            </button>
        </div>
        
        <!-- Notifications -->
        @include('admin.components.ultra-notification-center', [
            'notifications' => [
                [
                    'id' => 1,
                    'type' => 'user',
                    'priority' => 'normal',
                    'icon' => 'mountain',
                    'title' => 'Nouvelle randonnée',
                    'message' => 'Marie Dubois a terminé le Mont-Blanc Express',
                    'time' => 'Il y a 2 minutes',
                    'read' => false,
                    'avatar' => asset('backend/assets/images/users/user-12.jpg')
                ],
                [
                    'id' => 2,
                    'type' => 'user', 
                    'priority' => 'normal',
                    'icon' => 'upload',
                    'title' => 'Upload terminé',
                    'message' => 'Paul Martin a uploadé photos-sommet.zip',
                    'time' => 'Il y a 5 minutes',
                    'read' => false,
                    'avatar' => asset('backend/assets/images/users/user-2.jpg')
                ],
                [
                    'id' => 3,
                    'type' => 'system',
                    'priority' => 'high',
                    'icon' => 'alert-triangle',
                    'title' => 'Mise à jour système',
                    'message' => 'Version 2.4.1 disponible avec correctifs de sécurité',
                    'time' => 'Il y a 1 heure',
                    'read' => false,
                    'actions' => [
                        ['label' => 'Installer', 'action' => 'install-update', 'class' => 'primary', 'icon' => 'download'],
                        ['label' => 'Plus tard', 'action' => 'defer-update', 'class' => 'secondary']
                    ]
                ],
                [
                    'id' => 4,
                    'type' => 'system',
                    'priority' => 'normal', 
                    'icon' => 'shield-check',
                    'title' => 'Sauvegarde complète',
                    'message' => 'Sauvegarde automatique terminée avec succès',
                    'time' => 'Il y a 2 heures',
                    'read' => true
                ],
                [
                    'id' => 5,
                    'type' => 'user',
                    'priority' => 'normal',
                    'icon' => 'star',
                    'title' => 'Nouvel avis',
                    'message' => 'Luc Bernard a laissé un avis 5 étoiles',
                    'time' => 'Il y a 3 heures',
                    'read' => true,
                    'metadata' => ['Itinéraire' => 'GR20 - Étape 3', 'Note' => '5/5']
                ]
            ]
        ])

        <!-- User Profile -->
        @php
            $id = Auth::user()->id;
            $profileData = App\Models\User::find($id);
        @endphp
        
        <div class="user-menu">
            <a href="#" class="user-trigger">
                <div class="user-avatar">
                    <img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" 
                         alt="user-image" 
                         loading="lazy">
                </div>
                <div class="user-info">
                    <div class="user-name">{{ $profileData->name }}</div>
                    <div class="user-role">{{ $profileData->role ?? 'Administrateur' }}</div>
                </div>
                <i data-feather="chevron-down" style="width: 16px; height: 16px; transition: var(--transition);"></i>
            </a>
            
            <div class="dropdown-content">
                <div class="dropdown-header">
                    <h6>Mon Compte</h6>
                </div>
                
                <!-- Profile Link -->
                <a href="{{ route('admin.profile') }}" class="notification-item">
                    <div class="notification-avatar" style="background: var(--gradient-nature); display: flex; align-items: center; justify-content: center;">
                        <i data-feather="user" style="width: 18px; height: 18px; color: white;"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">Mon Profil</div>
                        <div class="notification-subtitle">Gérer mes informations</div>
                    </div>
                    <i data-feather="chevron-right" style="width: 16px; height: 16px; color: var(--cerfaos-text-muted);"></i>
                </a>
                
                <!-- Settings -->
                <a href="#" class="notification-item">
                    <div class="notification-avatar" style="background: var(--gradient-accent); display: flex; align-items: center; justify-content: center;">
                        <i data-feather="settings" style="width: 18px; height: 18px; color: white;"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">Paramètres</div>
                        <div class="notification-subtitle">Configuration admin</div>
                    </div>
                    <i data-feather="chevron-right" style="width: 16px; height: 16px; color: var(--cerfaos-text-muted);"></i>
                </a>
                
                <!-- Analytics -->
                <a href="#" class="notification-item">
                    <div class="notification-avatar" style="background: var(--cerfaos-info); display: flex; align-items: center; justify-content: center;">
                        <i data-feather="bar-chart-2" style="width: 18px; height: 18px; color: white;"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">Analytics</div>
                        <div class="notification-subtitle">Statistiques détaillées</div>
                    </div>
                    <i data-feather="chevron-right" style="width: 16px; height: 16px; color: var(--cerfaos-text-muted);"></i>
                </a>
                
                <!-- Separator -->
                <div style="height: 1px; background: var(--cerfaos-border); margin: var(--space-2) 0;"></div>
                
                <!-- Logout -->
                <a href="{{ route('admin.logout') }}" class="notification-item" style="color: var(--cerfaos-error);">
                    <div class="notification-avatar" style="background: var(--cerfaos-error); display: flex; align-items: center; justify-content: center;">
                        <i data-feather="log-out" style="width: 18px; height: 18px; color: white;"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title" style="color: var(--cerfaos-error);">Déconnexion</div>
                        <div class="notification-subtitle">Quitter l'admin</div>
                    </div>
                    <i data-feather="log-out" style="width: 16px; height: 16px; color: var(--cerfaos-error);"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced CSS for Ultra Modern Header -->
<style>
    /* ==================== HEADER LAYOUT IMPROVEMENTS ==================== */
    .layout__header {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border-bottom: 1px solid var(--cerfaos-border);
        position: sticky;
        top: 0;
        z-index: 100;
        padding: 0 var(--content-padding);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 56px;
        min-height: 56px;
        max-height: 56px;
        display: flex;
        align-items: center;
    }
    
    .layout__header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--cerfaos-gold), transparent);
        opacity: 0.3;
    }
    
    /* Enhanced Sidebar Controls */
    .sidebar-controls {
        display: flex;
        align-items: center;
        gap: var(--space-1);
        margin-right: var(--space-3);
        padding: 4px;
        border-radius: var(--radius-lg);
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid var(--cerfaos-border);
    }
    
    .desktop-sidebar-toggle {
        display: none;
        width: 36px;
        height: 36px;
        border: none;
        background: transparent;
        color: var(--cerfaos-text-secondary);
        border-radius: var(--radius-lg);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .desktop-sidebar-toggle::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: radial-gradient(circle, var(--cerfaos-gold) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .desktop-sidebar-toggle:hover {
        background: var(--cerfaos-surface-hover);
        color: var(--cerfaos-gold);
        transform: scale(1.05) rotate(5deg);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .desktop-sidebar-toggle:hover::before {
        width: 100%;
        height: 100%;
        opacity: 0.1;
    }
    
    .desktop-sidebar-toggle:active {
        transform: scale(0.95);
    }
    
    .desktop-sidebar-toggle .collapse-icon {
        display: none;
    }
    
    .layout.sidebar-collapsed .desktop-sidebar-toggle .expand-icon {
        display: none;
    }
    
    .layout.sidebar-collapsed .desktop-sidebar-toggle .collapse-icon {
        display: block;
        transform: rotate(180deg);
    }
    
    /* Mobile menu toggle improvements */
    .mobile-menu-toggle {
        width: 40px; /* Touch-friendly size */
        height: 40px;
        border: none;
        background: transparent;
        color: var(--cerfaos-text-secondary);
        border-radius: var(--radius-lg);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .mobile-menu-toggle::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: var(--gradient-nature);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: -1;
    }
    
    .mobile-menu-toggle:hover {
        background: var(--cerfaos-surface-hover);
        color: var(--cerfaos-gold);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .mobile-menu-toggle:hover::after {
        width: 200%;
        height: 200%;
        opacity: 0.1;
    }
    
    .mobile-menu-toggle:active {
        transform: scale(0.95);
    }
    
    /* Enhanced Mobile Menu Animation */
    .mobile-menu-toggle i {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .mobile-menu-toggle.active i {
        transform: rotate(90deg);
    }
    
    /* Enhanced Header Brand */
    .header-brand {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-1) var(--space-3);
        border-radius: var(--radius-lg);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        height: 40px;
        position: relative;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid transparent;
    }
    
    .header-brand::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s ease;
    }
    
    .header-brand:hover {
        background: var(--cerfaos-surface-hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border-color: var(--cerfaos-border);
    }
    
    .header-brand:hover::before {
        left: 100%;
    }
    
    .header-brand-icon {
        font-size: 1.8rem;
        filter: drop-shadow(0 2px 8px rgba(0,0,0,0.3));
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    .header-brand-icon::after {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: radial-gradient(circle, var(--cerfaos-gold) 0%, transparent 70%);
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: -1;
    }
    
    .header-brand:hover .header-brand-icon {
        transform: scale(1.15) rotate(8deg);
        filter: drop-shadow(0 4px 12px rgba(0,0,0,0.4));
    }
    
    .header-brand:hover .header-brand-icon::after {
        opacity: 0.2;
    }
    
    .header-brand-text h2 {
        margin: 0;
        font-weight: 800;
        font-size: 1.2rem;
        background: var(--gradient-nature);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        transition: all 0.3s ease;
        line-height: 1.2;
    }
    
    .header-brand:hover .header-brand-text h2 {
        transform: scale(1.05);
        filter: brightness(1.2);
    }
    
    .header-brand-subtitle {
        color: var(--cerfaos-text-muted);
        font-size: 0.65rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.8;
        transition: all 0.3s ease;
        line-height: 1;
    }
    
    .header-brand:hover .header-brand-subtitle {
        color: var(--cerfaos-gold);
        opacity: 1;
    }
    
    /* Header layout improvements */
    .header-left {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        flex: 1;
        min-width: 0;
    }
    
    .header-right {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        flex-shrink: 0;
    }
    
    /* ==================== ENHANCED HEADER ACTIONS ==================== */
    .header-actions-group {
        display: flex;
        align-items: center;
        gap: var(--space-1);
        padding: 4px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: var(--radius-lg);
        border: 1px solid var(--cerfaos-border);
        backdrop-filter: blur(10px);
    }
    
    .header-action {
        position: relative;
        width: 36px;
        height: 36px;
        border: none;
        background: transparent;
        color: var(--cerfaos-text-secondary);
        border-radius: var(--radius-lg);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        overflow: hidden;
    }
    
    .header-action::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: radial-gradient(circle, var(--cerfaos-gold) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 0;
    }
    
    .header-action i {
        position: relative;
        z-index: 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .header-action:hover {
        background: var(--cerfaos-surface-hover);
        color: var(--cerfaos-gold);
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    
    .header-action:hover::before {
        width: 100%;
        height: 100%;
        opacity: 0.1;
    }
    
    .header-action:active {
        transform: scale(0.95);
    }
    
    /* Theme Toggle Specific Styles */
    #theme-toggle .theme-dark {
        display: none;
    }
    
    .dark-mode #theme-toggle .theme-light {
        display: none;
    }
    
    .dark-mode #theme-toggle .theme-dark {
        display: block;
    }
    
    #theme-toggle:hover {
        color: var(--cerfaos-warning);
    }
    
    /* Performance Monitor Styles */
    .performance-indicator {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 8px;
        height: 8px;
        background: var(--cerfaos-success);
        border-radius: 50%;
        animation: pulse-slow 2s infinite;
    }
    
    .performance-indicator.warning {
        background: var(--cerfaos-warning);
        animation: pulse-fast 1s infinite;
    }
    
    .performance-indicator.error {
        background: var(--cerfaos-error);
        animation: pulse-urgent 0.5s infinite;
    }
    
    @keyframes pulse-slow {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.2); }
    }
    
    @keyframes pulse-fast {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.4); }
    }
    
    @keyframes pulse-urgent {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.2; transform: scale(1.6); }
    }
    
    /* Fullscreen Toggle */
    #fullscreen-toggle .fullscreen-exit {
        display: none;
    }
    
    .fullscreen #fullscreen-toggle .fullscreen-enter {
        display: none;
    }
    
    .fullscreen #fullscreen-toggle .fullscreen-exit {
        display: block;
    }
    
    /* Cache Action Badge */
    .action-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background: var(--cerfaos-success);
        color: white;
        font-size: 0.6rem;
        font-weight: 600;
        padding: 2px 4px;
        border-radius: var(--radius-full);
        min-width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        transition: all 0.3s ease;
    }
    
    .action-badge.loading {
        background: var(--cerfaos-warning);
        animation: rotate 1s linear infinite;
    }
    
    .action-badge.error {
        background: var(--cerfaos-error);
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Voice Command Indicator */
    .voice-indicator {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 10px;
        height: 10px;
        background: var(--cerfaos-error);
        border-radius: 50%;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .voice-indicator.listening {
        opacity: 1;
        background: var(--cerfaos-success);
        animation: pulse-voice 1.5s infinite;
    }
    
    .voice-indicator.processing {
        opacity: 1;
        background: var(--cerfaos-warning);
        animation: rotate 1s linear infinite;
    }
    
    @keyframes pulse-voice {
        0%, 100% { 
            opacity: 1; 
            transform: scale(1); 
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        }
        50% { 
            opacity: 0.8; 
            transform: scale(1.3); 
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0);
        }
    }
    
    /* Sync Indicator */
    .sync-indicator {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 8px;
        height: 8px;
        background: var(--cerfaos-success);
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .sync-indicator.syncing {
        background: var(--cerfaos-warning);
        animation: pulse-sync 2s infinite;
    }
    
    .sync-indicator.error {
        background: var(--cerfaos-error);
        animation: shake 0.5s infinite;
    }
    
    @keyframes pulse-sync {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-2px); }
        75% { transform: translateX(2px); }
    }
    
    /* Enhanced Voice Command Styling */
    #voice-command-toggle:hover {
        color: var(--cerfaos-success);
    }
    
    #voice-command-toggle.listening {
        color: var(--cerfaos-success);
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.3);
    }
    
    /* Sync Button Styling */
    #sync-status:hover {
        color: var(--cerfaos-info);
    }
    
    #sync-status.syncing i {
        animation: rotate 1s linear infinite;
    }
    
    /* Show desktop toggle on larger screens */
    @media (min-width: 1024px) {
        .desktop-sidebar-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .mobile-menu-toggle {
            display: none;
        }
    }
    
    /* Enhance user menu dropdown arrow rotation */
    .user-menu:hover .user-trigger i[data-feather="chevron-down"] {
        transform: rotate(180deg);
    }
    
    /* Notification badge pulse animation */
    .notifications-badge {
        animation: pulse 2s infinite;
    }
    
    /* Fullscreen toggle functionality */
    [data-toggle="fullscreen"] {
        cursor: pointer;
    }
    
    /* Enhanced hover states */
    .header-action:hover {
        transform: translateY(-2px) scale(1.05);
    }
    
    /* Search input focus enhancement */
    .global-search-input:focus + .global-search-icon {
        color: var(--cerfaos-gold);
    }
    
    /* Dropdown animation improvements */
    .dropdown-content {
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* ==================== ADVANCED RESPONSIVE DESIGN ==================== */
    
    /* Enhanced Mobile Responsive (max-width: 768px) */
    @media (max-width: 768px) {
        .layout__header {
            padding: 0 var(--space-3);
            height: 52px;
            min-height: 52px;
            max-height: 52px;
        }
        
        .sidebar-controls {
            margin-right: var(--space-2);
            padding: 4px;
        }
        
        .header-brand {
            padding: var(--space-1) var(--space-2);
            height: 36px;
        }
        
        .header-brand-icon {
            font-size: 1.5rem;
        }
        
        .header-brand-text h2 {
            font-size: 1.1rem;
        }
        
        .header-brand-subtitle {
            display: none;
        }
        
        .header-actions-group {
            gap: var(--space-1);
            padding: 4px;
        }
        
        .header-action {
            width: 32px;
            height: 32px;
        }
        
        .action-badge {
            font-size: 0.5rem;
            min-width: 14px;
            height: 14px;
            padding: 1px 3px;
        }
        
        .user-trigger {
            min-width: 100px;
            padding: var(--space-1) var(--space-2);
        }
        
        .user-name,
        .user-role {
            display: none;
        }
        
        .header-right {
            gap: var(--space-2);
        }
        
        /* Hide some actions on mobile */
        #performance-monitor,
        #quick-search-toggle {
            display: none;
        }
    }
    
    /* Ultra Small Mobile (max-width: 480px) */
    @media (max-width: 480px) {
        .layout__header {
            padding: 0 var(--space-2);
            height: 48px;
            min-height: 48px;
            max-height: 48px;
        }
        
        .header-brand-icon {
            font-size: 1.4rem;
        }
        
        .header-brand-text h2 {
            font-size: 1rem;
        }
        
        .header-actions-group {
            gap: 2px;
            padding: 2px;
        }
        
        .header-action {
            width: 30px;
            height: 30px;
        }
        
        .user-trigger {
            padding: var(--space-1);
            min-width: auto;
        }
        
        .user-avatar {
            width: 28px !important;
            height: 28px !important;
        }
        
        /* Further reduce actions on very small screens */
        #theme-toggle {
            display: none;
        }
    }
    
    /* Large Desktop Enhancements (min-width: 1400px) */
    @media (min-width: 1400px) {
        .layout__header {
            padding: 0 var(--space-8);
        }
        
        .sidebar-controls {
            margin-right: var(--space-6);
        }
        
        .header-brand {
            padding: var(--space-3) var(--space-5);
        }
        
        .header-brand-icon {
            font-size: 2.4rem;
        }
        
        .header-actions-group {
            gap: var(--space-3);
            padding: var(--space-2);
        }
        
        .header-action {
            width: 46px;
            height: 46px;
        }
    }
    
    /* High DPI Displays */
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
        .header-brand-icon {
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.5));
        }
        
        .action-badge {
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    }
    
    /* Motion Preferences */
    @media (prefers-reduced-motion: reduce) {
        .header-action,
        .header-brand,
        .sidebar-controls,
        .desktop-sidebar-toggle,
        .mobile-menu-toggle {
            transition: none !important;
            animation: none !important;
        }
        
        .header-action::before,
        .header-brand::before,
        .performance-indicator {
            animation: none !important;
        }
    }
    
    /* Dark Mode Enhancements */
    @media (prefers-color-scheme: dark) {
        .layout__header::before {
            opacity: 0.5;
        }
        
        .sidebar-controls,
        .header-actions-group {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .header-brand {
            background: rgba(255, 255, 255, 0.05);
        }
    }
    
    /* Print Styles */
    @media print {
        .layout__header {
            background: white !important;
            border-bottom: 1px solid #ccc !important;
            box-shadow: none !important;
        }
        
        .sidebar-controls,
        .header-actions-group,
        .user-menu {
            display: none !important;
        }
        
        .header-brand-text h2 {
            color: black !important;
            background: none !important;
            -webkit-text-fill-color: black !important;
        }
    }
</style>

<script>
    // Enhanced Sidebar Collapse Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const layout = document.querySelector('.layout');
        const sidebarCollapseToggle = document.getElementById('sidebar-collapse-toggle');
        const sidebar = document.querySelector('.layout__sidebar');
        
        // Enhanced preferences management
        const sidebarPrefs = {
            collapsed: localStorage.getItem('sidebar-collapsed') === 'true',
            autoCollapse: localStorage.getItem('sidebar-auto-collapse') === 'true',
            lastWidth: localStorage.getItem('sidebar-last-width') || 'normal'
        };
        
        // Intelligent auto-collapse based on screen size
        function checkAutoCollapse() {
            const screenWidth = window.innerWidth;
            
            // Auto-collapse logic for medium screens
            if (screenWidth >= 1024 && screenWidth <= 1200 && sidebarPrefs.autoCollapse) {
                layout.classList.add('auto-collapse');
            } else {
                layout.classList.remove('auto-collapse');
            }
            
            // Apply saved collapsed state on larger screens
            if (screenWidth > 1200) {
                if (sidebarPrefs.collapsed) {
                    layout.classList.add('sidebar-collapsed');
                } else {
                    layout.classList.remove('sidebar-collapsed');
                }
            }
        }
        
        // Initialize sidebar state
        checkAutoCollapse();
        
        // Handle window resize for responsive behavior
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(checkAutoCollapse, 150);
        });
        
        if (sidebarCollapseToggle) {
            sidebarCollapseToggle.addEventListener('click', function() {
                const wasCollapsed = layout.classList.contains('sidebar-collapsed');
                layout.classList.toggle('sidebar-collapsed');
                
                // Save preference
                const collapsed = layout.classList.contains('sidebar-collapsed');
                sidebarPrefs.collapsed = collapsed;
                localStorage.setItem('sidebar-collapsed', collapsed.toString());
                
                // Announce to screen reader with enhanced feedback
                const message = collapsed ? 'Sidebar réduite - Navigation par icônes' : 'Sidebar agrandie - Navigation complète';
                if (window.announceToScreenReader) {
                    window.announceToScreenReader(message);
                } else {
                    // Fallback visual feedback
                    const toast = document.createElement('div');
                    toast.textContent = message;
                    toast.style.cssText = `
                        position: fixed;
                        bottom: 20px;
                        left: 50%;
                        transform: translateX(-50%);
                        background: var(--cerfaos-dark-tertiary);
                        color: var(--cerfaos-text-primary);
                        padding: 8px 16px;
                        border-radius: 20px;
                        font-size: 0.875rem;
                        z-index: 10000;
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    `;
                    document.body.appendChild(toast);
                    requestAnimationFrame(() => toast.style.opacity = '1');
                    setTimeout(() => {
                        toast.style.opacity = '0';
                        setTimeout(() => toast.remove(), 300);
                    }, 2000);
                }
                
                // Update ARIA labels with enhanced descriptions
                const ariaLabel = collapsed ? 'Agrandir sidebar - Afficher navigation complète' : 'Réduire sidebar - Navigation par icônes uniquement';
                this.setAttribute('aria-label', ariaLabel);
                this.setAttribute('title', collapsed ? 'Agrandir sidebar' : 'Réduire sidebar');
                
                // Enhanced animation feedback
                this.style.transform = 'scale(0.9)';
                setTimeout(() => this.style.transform = '', 150);
            });
        }
        
        // Keyboard shortcut: Ctrl+B to toggle sidebar
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                if (sidebarCollapseToggle) {
                    sidebarCollapseToggle.click();
                }
            }
        });
        
        // Enhanced mobile interaction handling
        function setupMobileInteractions() {
            if (window.innerWidth <= 1024) {
                document.addEventListener('click', function(e) {
                    const mobileToggle = document.getElementById('elegant-sidebar-toggle');
                    if (!sidebar.contains(e.target) && 
                        !mobileToggle?.contains(e.target) &&
                        !sidebarCollapseToggle?.contains(e.target)) {
                        if (sidebar.classList.contains('active') || sidebar.classList.contains('open')) {
                            sidebar.classList.remove('active', 'open');
                            document.querySelector('#mobile-overlay')?.classList.remove('active');
                        }
                    }
                });
                
                // Touch gesture support for closing sidebar
                let startX = 0;
                sidebar.addEventListener('touchstart', function(e) {
                    startX = e.touches[0].clientX;
                });
                
                sidebar.addEventListener('touchmove', function(e) {
                    if (e.touches[0].clientX - startX < -100) { // Swipe left to close
                        sidebar.classList.remove('active', 'open');
                        document.querySelector('#mobile-overlay')?.classList.remove('active');
                    }
                });
            }
        }
        
        setupMobileInteractions();
        
        // Ergonomic usage analytics (privacy-friendly, local storage only)
        function trackUsagePatterns() {
            const usage = JSON.parse(localStorage.getItem('sidebar-usage') || '{}');
            const now = new Date();
            const hour = now.getHours();
            const day = now.getDay();
            
            // Track collapse/expand patterns
            if (!usage[day]) usage[day] = {};
            if (!usage[day][hour]) usage[day][hour] = { collapses: 0, expands: 0 };
            
            // Auto-suggest optimal settings
            if (sidebarCollapseToggle) {
                sidebarCollapseToggle.addEventListener('click', function() {
                    const collapsed = layout.classList.contains('sidebar-collapsed');
                    if (collapsed) {
                        usage[day][hour].collapses++;
                    } else {
                        usage[day][hour].expands++;
                    }
                    localStorage.setItem('sidebar-usage', JSON.stringify(usage));
                    
                    // Smart suggestion after patterns emerge
                    setTimeout(() => suggestOptimalSettings(usage), 1000);
                });
            }
        }
        
        function suggestOptimalSettings(usage) {
            const totalInteractions = Object.values(usage).reduce((total, dayData) => {
                return total + Object.values(dayData).reduce((dayTotal, hourData) => {
                    return dayTotal + hourData.collapses + hourData.expands;
                }, 0);
            }, 0);
            
            // Only suggest after sufficient data (20+ interactions)
            if (totalInteractions > 20) {
                const collapseRatio = Object.values(usage).reduce((total, dayData) => {
                    return total + Object.values(dayData).reduce((dayTotal, hourData) => {
                        return dayTotal + hourData.collapses;
                    }, 0);
                }, 0) / totalInteractions;
                
                // Suggest auto-collapse if user collapses frequently (>70%)
                if (collapseRatio > 0.7 && !sidebarPrefs.autoCollapse) {
                    const suggestion = confirm(
                        '💡 CERFAOS a remarqué que vous utilisez souvent le sidebar réduit. ' +
                        'Voulez-vous activer le mode auto-réduction sur les écrans moyens ?'
                    );
                    if (suggestion) {
                        sidebarPrefs.autoCollapse = true;
                        localStorage.setItem('sidebar-auto-collapse', 'true');
                        checkAutoCollapse();
                    }
                }
            }
        }
        
        trackUsagePatterns();
    });
    
    // Enhanced Header Functionality
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 CERFAOS Header Ultra - Initialisation...', new Date());
        // Initialize header enhancements
        initializeHeaderFeatures();
        
        function initializeHeaderFeatures() {
            initThemeToggle();
            initPerformanceMonitor();
            initEnhancedFullscreen();
            initQuickSearch();
            initCacheMonitor();
            initVoiceCommands();
            initRealTimeSync();
            initSmartNotifications();
            initCommandCenter();
            initHeaderAnimations();
            initKeyboardShortcuts();
        }
        
        // Theme Toggle System
        function initThemeToggle() {
            const themeToggle = document.getElementById('theme-toggle');
            const currentTheme = localStorage.getItem('cerfaos-theme') || 'auto';
            
            if (themeToggle) {
                // Apply saved theme
                applyTheme(currentTheme);
                
                themeToggle.addEventListener('click', function() {
                    const html = document.documentElement;
                    const isDark = html.classList.contains('dark-mode');
                    const newTheme = isDark ? 'light' : 'dark';
                    
                    applyTheme(newTheme);
                    localStorage.setItem('cerfaos-theme', newTheme);
                    
                    // Visual feedback
                    this.style.transform = 'rotate(360deg) scale(1.2)';
                    setTimeout(() => this.style.transform = '', 600);
                    
                    // Show toast
                    CerfaosAdmin.showToast(`Mode ${newTheme === 'dark' ? 'sombre' : 'clair'} activé`, 'success');
                });
            }
        }
        
        function applyTheme(theme) {
            const html = document.documentElement;
            html.classList.remove('light-mode', 'dark-mode');
            
            if (theme === 'dark') {
                html.classList.add('dark-mode');
            } else if (theme === 'light') {
                html.classList.add('light-mode');
            } else {
                // Auto mode - detect system preference
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                html.classList.add(prefersDark ? 'dark-mode' : 'light-mode');
            }
        }
        
        // Performance Monitor
        function initPerformanceMonitor() {
            const perfMonitor = document.getElementById('performance-monitor');
            const perfIndicator = document.querySelector('.performance-indicator');
            
            if (perfMonitor && perfIndicator) {
                // Monitor performance metrics
                setInterval(updatePerformanceIndicator, 5000);
                
                perfMonitor.addEventListener('click', function() {
                    showPerformanceModal();
                });
                
                // Initial check
                updatePerformanceIndicator();
            }
        }
        
        function updatePerformanceIndicator() {
            const perfIndicator = document.querySelector('.performance-indicator');
            if (!perfIndicator) return;
            
            // Simulate performance monitoring
            const memoryInfo = performance.memory || {};
            const usedMemory = memoryInfo.usedJSHeapSize || 0;
            const totalMemory = memoryInfo.totalJSHeapSize || 1;
            const memoryUsage = usedMemory / totalMemory;
            
            // Update indicator based on usage
            perfIndicator.className = 'performance-indicator';
            if (memoryUsage > 0.8) {
                perfIndicator.classList.add('error');
            } else if (memoryUsage > 0.6) {
                perfIndicator.classList.add('warning');
            }
        }
        
        function showPerformanceModal() {
            const modal = document.createElement('div');
            modal.className = 'performance-modal-overlay';
            modal.style.cssText = `
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
            
            const memoryInfo = performance.memory || {};
            const timing = performance.timing;
            const loadTime = timing.loadEventEnd - timing.navigationStart;
            
            modal.innerHTML = `
                <div style="
                    background: var(--cerfaos-surface);
                    border: 1px solid var(--cerfaos-border);
                    border-radius: var(--radius-2xl);
                    padding: var(--space-8);
                    max-width: 600px;
                    width: 90%;
                    transform: scale(0.9);
                    transition: transform 0.3s ease;
                ">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-6);">
                        <h3 style="margin: 0; color: var(--cerfaos-text-primary); font-size: 1.5rem;">📊 Performances Système</h3>
                        <button onclick="this.closest('.performance-modal-overlay').remove()" style="
                            background: none;
                            border: none;
                            color: var(--cerfaos-text-muted);
                            cursor: pointer;
                            font-size: 1.5rem;
                            padding: var(--space-2);
                            border-radius: var(--radius-lg);
                            transition: all 0.3s ease;
                        ">×</button>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-4);">
                        <div style="padding: var(--space-4); background: var(--cerfaos-surface-secondary); border-radius: var(--radius-lg);">
                            <div style="color: var(--cerfaos-text-muted); font-size: 0.875rem; margin-bottom: var(--space-2);">Mémoire Utilisée</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: var(--cerfaos-text-primary);">
                                ${formatBytes(memoryInfo.usedJSHeapSize || 0)}
                            </div>
                        </div>
                        
                        <div style="padding: var(--space-4); background: var(--cerfaos-surface-secondary); border-radius: var(--radius-lg);">
                            <div style="color: var(--cerfaos-text-muted); font-size: 0.875rem; margin-bottom: var(--space-2);">Temps de Chargement</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: var(--cerfaos-text-primary);">
                                ${loadTime}ms
                            </div>
                        </div>
                        
                        <div style="padding: var(--space-4); background: var(--cerfaos-surface-secondary); border-radius: var(--radius-lg);">
                            <div style="color: var(--cerfaos-text-muted); font-size: 0.875rem; margin-bottom: var(--space-2);">Connexions</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: var(--cerfaos-success);">
                                ${navigator.onLine ? 'En ligne' : 'Hors ligne'}
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: var(--space-6); text-align: center;">
                        <button onclick="this.closest('.performance-modal-overlay').remove()" class="ultra-btn ultra-btn-primary">
                            Fermer
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            requestAnimationFrame(() => {
                modal.style.opacity = '1';
                modal.querySelector('div').style.transform = 'scale(1)';
            });
        }
        
        function formatBytes(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // Enhanced Fullscreen
        function initEnhancedFullscreen() {
            const fullscreenToggle = document.getElementById('fullscreen-toggle');
            
            if (fullscreenToggle) {
                fullscreenToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen().then(() => {
                            document.body.classList.add('fullscreen');
                            CerfaosAdmin.showToast('Mode plein écran activé', 'success');
                        });
                    } else {
                        document.exitFullscreen().then(() => {
                            document.body.classList.remove('fullscreen');
                            CerfaosAdmin.showToast('Mode fenêtré activé', 'success');
                        });
                    }
                });
                
                // Handle fullscreen change events
                document.addEventListener('fullscreenchange', function() {
                    if (document.fullscreenElement) {
                        document.body.classList.add('fullscreen');
                    } else {
                        document.body.classList.remove('fullscreen');
                    }
                });
            }
        }
        
        // Quick Search Feature
        function initQuickSearch() {
            const quickSearchToggle = document.getElementById('quick-search-toggle');
            
            if (quickSearchToggle) {
                quickSearchToggle.addEventListener('click', function() {
                    showQuickSearchModal();
                });
            }
        }
        
        function showQuickSearchModal() {
            const modal = document.createElement('div');
            modal.className = 'quick-search-modal';
            modal.style.cssText = `
                position: fixed;
                top: 10%;
                left: 50%;
                transform: translateX(-50%);
                width: 90%;
                max-width: 600px;
                background: var(--cerfaos-surface);
                border: 1px solid var(--cerfaos-border);
                border-radius: var(--radius-2xl);
                box-shadow: var(--cerfaos-shadow-xl);
                z-index: 10000;
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            `;
            
            modal.innerHTML = `
                <div style="padding: var(--space-6);">
                    <input type="text" id="quick-search-input" placeholder="🔍 Rechercher dans l'admin..." style="
                        width: 100%;
                        border: none;
                        background: var(--cerfaos-surface-secondary);
                        padding: var(--space-4);
                        border-radius: var(--radius-lg);
                        font-size: 1.1rem;
                        color: var(--cerfaos-text-primary);
                        outline: none;
                        transition: all 0.3s ease;
                    ">
                    <div style="margin-top: var(--space-4); color: var(--cerfaos-text-muted); font-size: 0.875rem; text-align: center;">
                        Utilisez ↑↓ pour naviguer • Entrée pour sélectionner • Échap pour fermer
                    </div>
                </div>
            `;
            
            // Add overlay
            const overlay = document.createElement('div');
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
                z-index: 9999;
            `;
            
            document.body.appendChild(overlay);
            document.body.appendChild(modal);
            
            // Animate in
            requestAnimationFrame(() => {
                modal.style.opacity = '1';
                modal.style.transform = 'translateX(-50%) translateY(0)';
            });
            
            // Focus input
            const input = modal.querySelector('#quick-search-input');
            input.focus();
            
            // Handle close
            const closeModal = () => {
                modal.style.opacity = '0';
                modal.style.transform = 'translateX(-50%) translateY(-20px)';
                setTimeout(() => {
                    overlay.remove();
                    modal.remove();
                }, 300);
            };
            
            overlay.addEventListener('click', closeModal);
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        }
        
        // Cache Monitor
        function initCacheMonitor() {
            const cacheAction = document.querySelector('.cache-action');
            const cacheStatus = document.getElementById('cache-status');
            
            if (cacheAction && cacheStatus) {
                cacheAction.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Visual feedback
                    cacheStatus.textContent = '...';
                    cacheStatus.classList.add('loading');
                    
                    // Simulate cache clear
                    setTimeout(() => {
                        cacheStatus.textContent = 'OK';
                        cacheStatus.classList.remove('loading');
                        CerfaosAdmin.showToast('Cache vidé avec succès', 'success');
                        
                        // Navigate to clear cache route
                        window.location.href = this.href;
                    }, 1000);
                });
            }
        }
        
        // Header Animations
        function initHeaderAnimations() {
            const headerActions = document.querySelectorAll('.header-action');
            
            headerActions.forEach(action => {
                action.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.05)';
                });
                
                action.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                });
            });
        }
        
        // Advanced Keyboard Shortcuts
        function initKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + K for quick search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    showQuickSearchModal();
                }
                
                // Ctrl/Cmd + Shift + F for fullscreen
                if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'F') {
                    e.preventDefault();
                    document.getElementById('fullscreen-toggle')?.click();
                }
                
                // Ctrl/Cmd + Shift + T for theme toggle
                if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'T') {
                    e.preventDefault();
                    document.getElementById('theme-toggle')?.click();
                }
                
                // Ctrl/Cmd + Shift + P for performance monitor
                if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'P') {
                    e.preventDefault();
                    document.getElementById('performance-monitor')?.click();
                }
                
                // Ctrl/Cmd + Shift + B for sidebar toggle
                if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'B') {
                    e.preventDefault();
                    document.getElementById('sidebar-collapse-toggle')?.click();
                }
                
                // Escape to close any open modals
                if (e.key === 'Escape') {
                    const modals = document.querySelectorAll('.performance-modal-overlay, .quick-search-modal');
                    modals.forEach(modal => modal.remove());
                }
            });
            
            // Show keyboard shortcuts help
            const showShortcutsHelp = () => {
                const modal = document.createElement('div');
                modal.className = 'shortcuts-help-modal';
                modal.style.cssText = `
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
                
                modal.innerHTML = `
                    <div style="
                        background: var(--cerfaos-surface);
                        border: 1px solid var(--cerfaos-border);
                        border-radius: var(--radius-2xl);
                        padding: var(--space-8);
                        max-width: 500px;
                        width: 90%;
                        transform: scale(0.9);
                        transition: transform 0.3s ease;
                    ">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-6);">
                            <h3 style="margin: 0; color: var(--cerfaos-text-primary); font-size: 1.5rem;">⌨️ Raccourcis Clavier</h3>
                            <button onclick="this.closest('.shortcuts-help-modal').remove()" style="
                                background: none;
                                border: none;
                                color: var(--cerfaos-text-muted);
                                cursor: pointer;
                                font-size: 1.5rem;
                                padding: var(--space-2);
                                border-radius: var(--radius-lg);
                                transition: all 0.3s ease;
                            ">×</button>
                        </div>
                        
                        <div style="display: grid; gap: var(--space-3);">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-2); background: var(--cerfaos-surface-secondary); border-radius: var(--radius-lg);">
                                <span style="color: var(--cerfaos-text-primary);">Recherche rapide</span>
                                <kbd style="background: var(--cerfaos-dark-tertiary); color: var(--cerfaos-text-primary); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">Ctrl + K</kbd>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-2); background: var(--cerfaos-surface-secondary); border-radius: var(--radius-lg);">
                                <span style="color: var(--cerfaos-text-primary);">Plein écran</span>
                                <kbd style="background: var(--cerfaos-dark-tertiary); color: var(--cerfaos-text-primary); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">Ctrl + Shift + F</kbd>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-2); background: var(--cerfaos-surface-secondary); border-radius: var(--radius-lg);">
                                <span style="color: var(--cerfaos-text-primary);">Basculer thème</span>
                                <kbd style="background: var(--cerfaos-dark-tertiary); color: var(--cerfaos-text-primary); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">Ctrl + Shift + T</kbd>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-2); background: var(--cerfaos-surface-secondary); border-radius: var(--radius-lg);">
                                <span style="color: var(--cerfaos-text-primary);">Performances</span>
                                <kbd style="background: var(--cerfaos-dark-tertiary); color: var(--cerfaos-text-primary); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">Ctrl + Shift + P</kbd>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-2); background: var(--cerfaos-surface-secondary); border-radius: var(--radius-lg);">
                                <span style="color: var(--cerfaos-text-primary);">Toggle Sidebar</span>
                                <kbd style="background: var(--cerfaos-dark-tertiary); color: var(--cerfaos-text-primary); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">Ctrl + Shift + B</kbd>
                            </div>
                        </div>
                        
                        <div style="margin-top: var(--space-6); text-align: center;">
                            <button onclick="this.closest('.shortcuts-help-modal').remove()" class="ultra-btn ultra-btn-primary">
                                Fermer
                            </button>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(modal);
                requestAnimationFrame(() => {
                    modal.style.opacity = '1';
                    modal.querySelector('div').style.transform = 'scale(1)';
                });
            };
            
            // Show shortcuts with Ctrl+/
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                    e.preventDefault();
                    showShortcutsHelp();
                }
            });
        }
        
        // Advanced Header Analytics
        function initHeaderAnalytics() {
            const analytics = {
                actions: {},
                startTime: Date.now(),
                
                track(action, data = {}) {
                    if (!this.actions[action]) {
                        this.actions[action] = [];
                    }
                    this.actions[action].push({
                        timestamp: Date.now(),
                        data
                    });
                    
                    // Store in localStorage for persistence
                    const stored = JSON.parse(localStorage.getItem('cerfaos-header-analytics') || '{}');
                    stored[action] = (stored[action] || 0) + 1;
                    localStorage.setItem('cerfaos-header-analytics', JSON.stringify(stored));
                },
                
                getReport() {
                    const stored = JSON.parse(localStorage.getItem('cerfaos-header-analytics') || '{}');
                    const sessionTime = Date.now() - this.startTime;
                    
                    return {
                        sessionDuration: sessionTime,
                        totalActions: Object.values(stored).reduce((sum, count) => sum + count, 0),
                        mostUsedFeatures: Object.entries(stored)
                            .sort(([,a], [,b]) => b - a)
                            .slice(0, 5),
                        actions: stored
                    };
                }
            };
            
            // Track header action usage
            document.querySelectorAll('.header-action').forEach(action => {
                action.addEventListener('click', function() {
                    analytics.track(`header_action_${this.id || 'unknown'}`);
                });
            });
            
            // Track brand clicks
            document.querySelector('.header-brand')?.addEventListener('click', function() {
                analytics.track('brand_click');
            });
            
            // Track sidebar toggle
            document.querySelector('#sidebar-collapse-toggle')?.addEventListener('click', function() {
                analytics.track('sidebar_toggle');
            });
            
            // Export analytics to global scope for debugging
            window.CerfaosHeaderAnalytics = analytics;
        }
        
        // Voice Commands System
        function initVoiceCommands() {
            const voiceToggle = document.getElementById('voice-command-toggle');
            const voiceIndicator = document.querySelector('.voice-indicator');
            
            if (!voiceToggle || !('webkitSpeechRecognition' in window || 'SpeechRecognition' in window)) {
                if (voiceToggle) voiceToggle.style.display = 'none';
                return;
            }
            
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();
            
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'fr-FR';
            
            let isListening = false;
            
            voiceToggle.addEventListener('click', function() {
                if (isListening) {
                    recognition.stop();
                    return;
                }
                
                recognition.start();
                isListening = true;
                voiceIndicator.classList.add('listening');
                voiceToggle.classList.add('listening');
                CerfaosAdmin.showToast('🎤 Écoute en cours...', 'info');
            });
            
            recognition.onresult = function(event) {
                const command = event.results[0][0].transcript.toLowerCase();
                voiceIndicator.classList.remove('listening');
                voiceIndicator.classList.add('processing');
                
                processVoiceCommand(command);
                
                setTimeout(() => {
                    voiceIndicator.classList.remove('processing');
                }, 2000);
            };
            
            recognition.onend = function() {
                isListening = false;
                voiceIndicator.classList.remove('listening');
                voiceToggle.classList.remove('listening');
            };
            
            recognition.onerror = function(event) {
                isListening = false;
                voiceIndicator.classList.remove('listening');
                voiceToggle.classList.remove('listening');
                CerfaosAdmin.showToast('❌ Erreur de reconnaissance vocale', 'error');
            };
            
            function processVoiceCommand(command) {
                const commands = {
                    'ouvrir le tableau de bord': () => window.location.href = '/dashboard',
                    'dashboard': () => window.location.href = '/dashboard',
                    'plein écran': () => document.getElementById('fullscreen-toggle')?.click(),
                    'mode sombre': () => document.getElementById('theme-toggle')?.click(),
                    'recherche': () => showQuickSearchModal(),
                    'rechercher': () => showQuickSearchModal(),
                    'vider le cache': () => document.querySelector('.cache-action')?.click(),
                    'performance': () => document.getElementById('performance-monitor')?.click(),
                    'performances': () => document.getElementById('performance-monitor')?.click(),
                    'réduire sidebar': () => document.getElementById('sidebar-collapse-toggle')?.click(),
                    'agrandir sidebar': () => document.getElementById('sidebar-collapse-toggle')?.click(),
                    'aide': () => showShortcutsHelp(),
                    'raccourcis': () => showShortcutsHelp()
                };
                
                const foundCommand = Object.keys(commands).find(cmd => command.includes(cmd));
                
                if (foundCommand) {
                    CerfaosAdmin.showToast(`✅ Commande exécutée: ${foundCommand}`, 'success');
                    commands[foundCommand]();
                } else {
                    CerfaosAdmin.showToast(`❓ Commande non reconnue: "${command}"`, 'warning');
                }
            }
        }
        
        // Real-time Data Synchronization
        function initRealTimeSync() {
            const syncButton = document.getElementById('sync-status');
            const syncIndicator = document.querySelector('.sync-indicator');
            
            if (!syncButton) return;
            
            let syncStatus = {
                lastSync: Date.now(),
                isOnline: navigator.onLine,
                pendingChanges: 0
            };
            
            // Auto-sync every 30 seconds
            setInterval(() => {
                if (syncStatus.isOnline && syncStatus.pendingChanges > 0) {
                    performSync();
                }
            }, 30000);
            
            // Manual sync on click
            syncButton.addEventListener('click', () => performSync());
            
            // Monitor online/offline status
            window.addEventListener('online', () => {
                syncStatus.isOnline = true;
                updateSyncIndicator('success');
                CerfaosAdmin.showToast('🌐 Connexion rétablie', 'success');
                if (syncStatus.pendingChanges > 0) {
                    performSync();
                }
            });
            
            window.addEventListener('offline', () => {
                syncStatus.isOnline = false;
                updateSyncIndicator('error');
                CerfaosAdmin.showToast('📡 Mode hors ligne', 'warning');
            });
            
            function performSync() {
                if (!syncStatus.isOnline) {
                    CerfaosAdmin.showToast('📡 Pas de connexion internet', 'error');
                    return;
                }
                
                updateSyncIndicator('syncing');
                syncButton.classList.add('syncing');
                
                // Simulate sync process
                fetch('/admin/sync-data', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        lastSync: syncStatus.lastSync,
                        pendingChanges: syncStatus.pendingChanges
                    })
                })
                .then(response => response.json())
                .then(data => {
                    syncStatus.lastSync = Date.now();
                    syncStatus.pendingChanges = 0;
                    updateSyncIndicator('success');
                    CerfaosAdmin.showToast('✅ Synchronisation réussie', 'success');
                })
                .catch(error => {
                    updateSyncIndicator('error');
                    CerfaosAdmin.showToast('❌ Erreur de synchronisation', 'error');
                })
                .finally(() => {
                    syncButton.classList.remove('syncing');
                });
            }
            
            function updateSyncIndicator(status) {
                syncIndicator.className = 'sync-indicator';
                if (status !== 'success') {
                    syncIndicator.classList.add(status);
                }
            }
            
            // Track data changes
            window.CerfaosSyncManager = {
                addPendingChange() {
                    syncStatus.pendingChanges++;
                    updateSyncIndicator('syncing');
                },
                
                getStatus() {
                    return syncStatus;
                }
            };
        }
        
        // Smart Notifications System
        function initSmartNotifications() {
            const notificationSystem = {
                queue: [],
                isProcessing: false,
                maxVisible: 3,
                
                add(notification) {
                    this.queue.push({
                        id: Date.now(),
                        ...notification,
                        timestamp: new Date()
                    });
                    this.process();
                },
                
                process() {
                    if (this.isProcessing || this.queue.length === 0) return;
                    
                    this.isProcessing = true;
                    const notification = this.queue.shift();
                    this.show(notification);
                },
                
                show(notification) {
                    const container = this.getOrCreateContainer();
                    const element = this.createElement(notification);
                    
                    container.appendChild(element);
                    
                    // Auto-remove after delay
                    setTimeout(() => {
                        element.style.opacity = '0';
                        element.style.transform = 'translateX(100%)';
                        setTimeout(() => {
                            if (element.parentNode) {
                                element.parentNode.removeChild(element);
                            }
                            this.isProcessing = false;
                            this.process();
                        }, 300);
                    }, notification.duration || 5000);
                },
                
                getOrCreateContainer() {
                    let container = document.getElementById('smart-notifications');
                    if (!container) {
                        container = document.createElement('div');
                        container.id = 'smart-notifications';
                        container.style.cssText = `
                            position: fixed;
                            top: 70px;
                            right: 20px;
                            z-index: 10000;
                            display: flex;
                            flex-direction: column;
                            gap: 12px;
                            max-width: 400px;
                        `;
                        document.body.appendChild(container);
                    }
                    return container;
                },
                
                createElement(notification) {
                    const element = document.createElement('div');
                    element.className = `smart-notification ${notification.type || 'info'}`;
                    element.style.cssText = `
                        background: var(--cerfaos-surface);
                        border: 1px solid var(--cerfaos-border);
                        border-radius: var(--radius-lg);
                        padding: 16px;
                        box-shadow: var(--cerfaos-shadow-lg);
                        transform: translateX(100%);
                        opacity: 0;
                        transition: all 0.3s ease;
                        cursor: pointer;
                    `;
                    
                    const typeColors = {
                        success: 'var(--cerfaos-success)',
                        error: 'var(--cerfaos-error)',
                        warning: 'var(--cerfaos-warning)',
                        info: 'var(--cerfaos-info)'
                    };
                    
                    element.innerHTML = `
                        <div style="display: flex; align-items: start; gap: 12px;">
                            <div style="width: 4px; height: 100%; background: ${typeColors[notification.type] || typeColors.info}; border-radius: 2px;"></div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: var(--cerfaos-text-primary); margin-bottom: 4px;">
                                    ${notification.title}
                                </div>
                                <div style="color: var(--cerfaos-text-secondary); font-size: 0.875rem;">
                                    ${notification.message}
                                </div>
                                <div style="color: var(--cerfaos-text-muted); font-size: 0.75rem; margin-top: 8px;">
                                    ${notification.timestamp.toLocaleTimeString()}
                                </div>
                            </div>
                            <button onclick="this.parentNode.parentNode.remove()" style="
                                background: none;
                                border: none;
                                color: var(--cerfaos-text-muted);
                                cursor: pointer;
                                padding: 4px;
                                border-radius: 4px;
                                transition: all 0.2s ease;
                            ">×</button>
                        </div>
                    `;
                    
                    // Animate in
                    requestAnimationFrame(() => {
                        element.style.opacity = '1';
                        element.style.transform = 'translateX(0)';
                    });
                    
                    // Click to dismiss
                    element.addEventListener('click', () => {
                        element.style.opacity = '0';
                        element.style.transform = 'translateX(100%)';
                        setTimeout(() => element.remove(), 300);
                    });
                    
                    return element;
                }
            };
            
            // Expose globally
            window.CerfaosNotifications = notificationSystem;
            
            // Demo notifications
            setTimeout(() => {
                notificationSystem.add({
                    type: 'success',
                    title: '🚀 Système initialisé',
                    message: 'Toutes les fonctionnalités avancées sont maintenant actives',
                    duration: 3000
                });
            }, 2000);
        }
        
        // Command Center
        function initCommandCenter() {
            const commandCenter = {
                commands: new Map(),
                history: [],
                
                register(name, fn, description) {
                    this.commands.set(name, { fn, description });
                },
                
                execute(command, ...args) {
                    const cmd = this.commands.get(command);
                    if (cmd) {
                        this.history.push({ command, args, timestamp: Date.now() });
                        return cmd.fn(...args);
                    }
                    throw new Error(`Command '${command}' not found`);
                },
                
                list() {
                    return Array.from(this.commands.entries()).map(([name, {description}]) => ({
                        name,
                        description
                    }));
                },
                
                getHistory() {
                    return this.history;
                }
            };
            
            // Register built-in commands
            commandCenter.register('theme.toggle', () => {
                document.getElementById('theme-toggle')?.click();
            }, 'Basculer entre thème clair et sombre');
            
            commandCenter.register('sidebar.toggle', () => {
                document.getElementById('sidebar-collapse-toggle')?.click();
            }, 'Agrandir/réduire la barre latérale');
            
            commandCenter.register('search.open', () => {
                showQuickSearchModal();
            }, 'Ouvrir la recherche rapide');
            
            commandCenter.register('performance.show', () => {
                document.getElementById('performance-monitor')?.click();
            }, 'Afficher le moniteur de performances');
            
            commandCenter.register('fullscreen.toggle', () => {
                document.getElementById('fullscreen-toggle')?.click();
            }, 'Basculer le mode plein écran');
            
            commandCenter.register('cache.clear', () => {
                document.querySelector('.cache-action')?.click();
            }, 'Vider le cache application');
            
            commandCenter.register('sync.now', () => {
                document.getElementById('sync-status')?.click();
            }, 'Synchroniser les données maintenant');
            
            commandCenter.register('notifications.clear', () => {
                document.querySelectorAll('.smart-notification').forEach(n => n.remove());
            }, 'Effacer toutes les notifications');
            
            // Expose globally
            window.CerfaosCommandCenter = commandCenter;
            
            // Console integration
            console.log('🎮 CERFAOS Command Center initialisé');
            console.log('Tapez CerfaosCommandCenter.list() pour voir les commandes disponibles');
        }
        
        // Initialize analytics
        initHeaderAnalytics();
        
        // Test immédiat pour vérifier que le JavaScript se charge
        console.log('✅ CERFAOS Header Ultra - Fonctionnalités chargées:', {
            voiceCommands: !!document.getElementById('voice-command-toggle'),
            syncStatus: !!document.getElementById('sync-status'),
            speechAPI: 'webkitSpeechRecognition' in window || 'SpeechRecognition' in window,
            timestamp: new Date().toLocaleTimeString()
        });
        
        // Ajouter notification de test
        setTimeout(() => {
            if (window.CerfaosNotifications) {
                window.CerfaosNotifications.add({
                    type: 'info',
                    title: '🎯 Test des nouvelles fonctionnalités',
                    message: 'Header ultra-moderne chargé avec succès !',
                    duration: 4000
                });
            }
        }, 1000);
    });
</script>

<!-- Version Cache Buster -->
<script>
    console.log('🔄 CERFAOS Cache Buster:', Math.random().toString(36).substring(7));
</script>