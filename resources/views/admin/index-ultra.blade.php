@extends('admin.admin_master_ultra')
@section('admin')

<div class="ultra-main-content">
    <!-- Hero Dashboard Header -->
    <div class="dashboard-hero" data-aos="fade-up">
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-icon">🏔️</div>
                <div>
                    <h1 class="hero-title">CERFAOS Command Center</h1>
                    <p class="hero-subtitle">Votre centre de commandement pour l'aventure outdoor moderne</p>
                </div>
            </div>
            <div class="hero-status">
                <div class="status-indicator active">
                    <i data-feather="zap"></i>
                    <span>Expédition Active</span>
                </div>
                <div class="current-time" id="currentTime"></div>
            </div>
        </div>
        
        <!-- Weather Widget Integration -->
        <div class="weather-summary" data-aos="fade-left" data-aos-delay="200">
            <div class="weather-icon">🌤️</div>
            <div class="weather-info">
                <div class="weather-temp">18°C</div>
                <div class="weather-desc">Parfait pour l'aventure</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="quick-actions-grid" data-aos="fade-up" data-aos-delay="100">
        <div class="quick-action-card" data-action="profile">
            <div class="action-icon">🎯</div>
            <div class="action-content">
                <h4>Mon Profil</h4>
                <p>Configuration admin</p>
            </div>
            <i data-feather="arrow-right" class="action-arrow"></i>
        </div>
        
        <div class="quick-action-card" data-action="analytics">
            <div class="action-icon">📊</div>
            <div class="action-content">
                <h4>Analytics</h4>
                <p>Données en temps réel</p>
            </div>
            <i data-feather="arrow-right" class="action-arrow"></i>
        </div>
        
        <div class="quick-action-card" data-action="export">
            <div class="action-icon">📥</div>
            <div class="action-content">
                <h4>Exporter</h4>
                <p>Données système</p>
            </div>
            <i data-feather="arrow-right" class="action-arrow"></i>
        </div>
        
        <div class="quick-action-card" data-action="settings">
            <div class="action-icon">⚙️</div>
            <div class="action-content">
                <h4>Paramètres</h4>
                <p>Configuration système</p>
            </div>
            <i data-feather="arrow-right" class="action-arrow"></i>
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="stats-grid" data-aos="fade-up" data-aos-delay="200">
        @include('admin.components.ultra-stat-card', [
            'icon' => '🌐',
            'value' => '91,673',
            'label' => 'Explorateurs Web',
            'trend' => ['direction' => 'up', 'value' => '+15%'],
            'color' => 'success',
            'gradient' => 'nature',
            'description' => 'Visiteurs uniques ce mois',
            'progress' => 78
        ])
        
        @include('admin.components.ultra-stat-card', [
            'icon' => '🎯',
            'value' => '15.2%',
            'label' => 'Taux d\'Aventure',
            'trend' => ['direction' => 'down', 'value' => '-2.1%'],
            'color' => 'warning',
            'gradient' => 'sunset',
            'description' => 'Taux de conversion mensuel',
            'progress' => 65
        ])
        
        @include('admin.components.ultra-stat-card', [
            'icon' => '⏱️',
            'value' => '90min',
            'label' => 'Temps d\'Exploration',
            'trend' => ['direction' => 'up', 'value' => '+25%'],
            'color' => 'info',
            'gradient' => 'accent',
            'description' => 'Durée moyenne par session',
            'progress' => 82,
            'actions' => [
                ['label' => 'Détails', 'url' => '#', 'icon' => 'eye']
            ]
        ])
        
        @include('admin.components.ultra-stat-card', [
            'icon' => '🥾',
            'value' => '2,986',
            'label' => 'Randonneurs Actifs',
            'trend' => ['direction' => 'up', 'value' => '+4%'],
            'color' => 'success',
            'gradient' => 'nature',
            'description' => 'Utilisateurs actifs aujourd\'hui',
            'progress' => 71,
            'actions' => [
                ['label' => 'Voir tous', 'url' => '#', 'icon' => 'users'],
                ['label' => 'Exporter', 'url' => '#', 'icon' => 'download']
            ]
        ])
    </div>

    <!-- Advanced Analytics Section -->
    <div class="analytics-section" data-aos="fade-up" data-aos-delay="300">
        <div class="section-header">
            <div class="section-title">
                <i data-feather="trending-up" class="section-icon"></i>
                <h2>Analytics Avancées</h2>
            </div>
            <div class="section-controls">
                <button class="ultra-btn ultra-btn-ghost ultra-btn-sm" data-period="24h">24h</button>
                <button class="ultra-btn ultra-btn-ghost ultra-btn-sm active" data-period="7d">7j</button>
                <button class="ultra-btn ultra-btn-ghost ultra-btn-sm" data-period="30d">30j</button>
                <button class="ultra-btn ultra-btn-ghost ultra-btn-sm" data-period="90d">90j</button>
            </div>
        </div>
        
        <!-- Charts Grid -->
        <div class="charts-grid">
            <!-- Main Chart -->
            <div class="chart-card main-chart" data-aos="fade-up" data-aos-delay="100">
                <div class="chart-header">
                    <h3>Progression des Aventures</h3>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-color" style="background: var(--gradient-nature);"></div>
                            <span>Nouveaux explorateurs</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: var(--gradient-accent);"></div>
                            <span>Explorateurs fidèles</span>
                        </div>
                    </div>
                </div>
                <div class="chart-container">
                    <div id="adventureProgressChart" class="apex-chart"></div>
                </div>
            </div>
            
            <!-- Traffic Sources -->
            <div class="chart-card traffic-sources" data-aos="fade-up" data-aos-delay="200">
                <div class="chart-header">
                    <h3>Sources de Trafic</h3>
                    <button class="ultra-btn ultra-btn-ghost ultra-btn-sm">
                        <i data-feather="refresh-cw"></i>
                        Actualiser
                    </button>
                </div>
                
                @include('admin.components.ultra-data-table', [
                    'headers' => [
                        'Plateforme' => 'text',
                        'Visiteurs' => 'number',
                        'Progression' => 'progress',
                        'Tendance' => 'trend'
                    ],
                    'data' => [
                        [
                            'Plateforme' => ['text' => 'Instagram', 'icon' => '🏔️'],
                            'Visiteurs' => 3550,
                            'Progression' => ['value' => 80, 'color' => 'success'],
                            'Tendance' => ['direction' => 'up', 'value' => '12%']
                        ],
                        [
                            'Plateforme' => ['text' => 'Facebook', 'icon' => '🌐'],
                            'Visiteurs' => 1245,
                            'Progression' => ['value' => 56, 'color' => 'warning'],
                            'Tendance' => ['direction' => 'down', 'value' => '3%']
                        ],
                        [
                            'Plateforme' => ['text' => 'Twitter', 'icon' => '🐦'],
                            'Visiteurs' => 1798,
                            'Progression' => ['value' => 67, 'color' => 'info'],
                            'Tendance' => ['direction' => 'up', 'value' => '8%']
                        ],
                        [
                            'Plateforme' => ['text' => 'YouTube', 'icon' => '📺'],
                            'Visiteurs' => 986,
                            'Progression' => ['value' => 39, 'color' => 'error'],
                            'Tendance' => ['direction' => 'down', 'value' => '5%']
                        ]
                    ],
                    'searchable' => true,
                    'sortable' => true,
                    'pagination' => false,
                    'compact' => true
                ])
            </div>
        </div>
    </div>

    <!-- System Health Monitoring -->
    <div class="system-health" data-aos="fade-up" data-aos-delay="400">
        <div class="section-header">
            <div class="section-title">
                <i data-feather="activity" class="section-icon"></i>
                <h2>État du Système</h2>
            </div>
            <div class="health-indicator overall-health healthy">
                <div class="health-pulse"></div>
                <span>Système Opérationnel</span>
            </div>
        </div>
        
        <div class="health-grid">
            <div class="health-card" data-metric="server">
                <div class="health-icon">
                    <i data-feather="server"></i>
                </div>
                <div class="health-info">
                    <div class="health-title">Serveur</div>
                    <div class="health-value">98.5%</div>
                    <div class="health-status healthy">Optimal</div>
                </div>
                <div class="health-chart">
                    <div class="mini-chart" id="serverChart"></div>
                </div>
            </div>
            
            <div class="health-card" data-metric="database">
                <div class="health-icon">
                    <i data-feather="database"></i>
                </div>
                <div class="health-info">
                    <div class="health-title">Base de Données</div>
                    <div class="health-value">45ms</div>
                    <div class="health-status healthy">Excellent</div>
                </div>
                <div class="health-chart">
                    <div class="mini-chart" id="databaseChart"></div>
                </div>
            </div>
            
            <div class="health-card" data-metric="cache">
                <div class="health-icon">
                    <i data-feather="zap"></i>
                </div>
                <div class="health-info">
                    <div class="health-title">Cache</div>
                    <div class="health-value">87%</div>
                    <div class="health-status warning">Optimisable</div>
                </div>
                <div class="health-chart">
                    <div class="mini-chart" id="cacheChart"></div>
                </div>
            </div>
            
            <div class="health-card" data-metric="storage">
                <div class="health-icon">
                    <i data-feather="hard-drive"></i>
                </div>
                <div class="health-info">
                    <div class="health-title">Stockage</div>
                    <div class="health-value">2.4TB</div>
                    <div class="health-status healthy">Disponible</div>
                </div>
                <div class="health-chart">
                    <div class="mini-chart" id="storageChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="recent-activities" data-aos="fade-up" data-aos-delay="500">
        <div class="section-header">
            <div class="section-title">
                <i data-feather="clock" class="section-icon"></i>
                <h2>Activités Récentes</h2>
            </div>
            <button class="ultra-btn ultra-btn-ghost ultra-btn-sm">
                Voir tout
                <i data-feather="arrow-right"></i>
            </button>
        </div>
        
        <div class="activities-list">
            <div class="activity-item" data-aos="fade-up" data-aos-delay="100">
                <div class="activity-avatar">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop&crop=face" alt="User">
                </div>
                <div class="activity-content">
                    <div class="activity-title">Marie Dubois a terminé le Mont-Blanc Express</div>
                    <div class="activity-subtitle">Nouvelle randonnée complétée avec succès</div>
                    <div class="activity-time">Il y a 2 minutes</div>
                </div>
                <div class="activity-action">
                    <i data-feather="mountain" class="activity-icon success"></i>
                </div>
            </div>
            
            <div class="activity-item" data-aos="fade-up" data-aos-delay="200">
                <div class="activity-avatar">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face" alt="User">
                </div>
                <div class="activity-content">
                    <div class="activity-title">Paul Martin a uploadé photos-sommet.zip</div>
                    <div class="activity-subtitle">25 nouvelles photos ajoutées à la galerie</div>
                    <div class="activity-time">Il y a 5 minutes</div>
                </div>
                <div class="activity-action">
                    <i data-feather="upload" class="activity-icon info"></i>
                </div>
            </div>
            
            <div class="activity-item" data-aos="fade-up" data-aos-delay="300">
                <div class="activity-avatar system">
                    <i data-feather="shield-check"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">Sauvegarde automatique complétée</div>
                    <div class="activity-subtitle">Toutes les données ont été sauvegardées avec succès</div>
                    <div class="activity-time">Il y a 15 minutes</div>
                </div>
                <div class="activity-action">
                    <i data-feather="check-circle" class="activity-icon success"></i>
                </div>
            </div>
            
            <div class="activity-item" data-aos="fade-up" data-aos-delay="400">
                <div class="activity-avatar system">
                    <i data-feather="alert-triangle"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">Mise à jour système disponible</div>
                    <div class="activity-subtitle">Version 2.4.1 prête à être installée</div>
                    <div class="activity-time">Il y a 1 heure</div>
                </div>
                <div class="activity-action">
                    <i data-feather="download" class="activity-icon warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Dashboard Styles -->
<style>
    /* Dashboard Hero Section */
    .dashboard-hero {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--cerfaos-border);
        border-radius: var(--radius-2xl);
        padding: var(--space-8);
        margin-bottom: var(--space-8);
        position: relative;
        overflow: hidden;
    }
    
    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: var(--gradient-nature);
        border-radius: 50%;
        transform: translate(50%, -50%);
        opacity: 0.1;
    }
    
    .hero-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-6);
        position: relative;
        z-index: 2;
    }
    
    .hero-text {
        display: flex;
        align-items: center;
        gap: var(--space-6);
    }
    
    .hero-icon {
        font-size: 4rem;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
    }
    
    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: var(--gradient-nature);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        line-height: 1.2;
    }
    
    .hero-subtitle {
        color: var(--cerfaos-text-secondary);
        font-size: 1.125rem;
        margin: var(--space-2) 0 0 0;
    }
    
    .hero-status {
        display: flex;
        align-items: center;
        gap: var(--space-4);
    }
    
    .status-indicator {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-3) var(--space-4);
        background: var(--cerfaos-success-bg);
        color: var(--cerfaos-success);
        border-radius: var(--radius-full);
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    .status-indicator.active {
        animation: pulse-success 2s infinite;
    }
    
    .current-time {
        font-family: var(--font-mono);
        font-size: 1.125rem;
        color: var(--cerfaos-text-muted);
    }
    
    .weather-summary {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        position: absolute;
        top: var(--space-4);
        right: var(--space-4);
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-xl);
        padding: var(--space-3) var(--space-4);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .weather-icon {
        font-size: 1.5rem;
    }
    
    .weather-temp {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--cerfaos-text-primary);
    }
    
    .weather-desc {
        font-size: 0.75rem;
        color: var(--cerfaos-text-muted);
    }
    
    /* Quick Actions Grid */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-4);
        margin-bottom: var(--space-8);
    }
    
    .quick-action-card {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-6);
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--cerfaos-border);
        border-radius: var(--radius-xl);
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    
    .quick-action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.6s ease;
    }
    
    .quick-action-card:hover::before {
        left: 100%;
    }
    
    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--cerfaos-shadow-xl);
        border-color: var(--cerfaos-primary);
    }
    
    .quick-action-card .action-icon {
        font-size: 2rem;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--gradient-nature);
        border-radius: var(--radius-xl);
        box-shadow: var(--cerfaos-shadow-md);
    }
    
    .quick-action-card .action-content {
        flex: 1;
    }
    
    .quick-action-card .action-content h4 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--cerfaos-text-primary);
        margin: 0 0 var(--space-1) 0;
    }
    
    .quick-action-card .action-content p {
        color: var(--cerfaos-text-secondary);
        margin: 0;
        font-size: 0.875rem;
    }
    
    .quick-action-card .action-arrow {
        width: 20px;
        height: 20px;
        color: var(--cerfaos-text-muted);
        transition: var(--transition);
    }
    
    .quick-action-card:hover .action-arrow {
        color: var(--cerfaos-primary);
        transform: translateX(4px);
    }
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-6);
        margin-bottom: var(--space-8);
    }
    
    /* Analytics Section */
    .analytics-section {
        margin-bottom: var(--space-8);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-6);
    }
    
    .section-title {
        display: flex;
        align-items: center;
        gap: var(--space-3);
    }
    
    .section-title h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--cerfaos-text-primary);
        margin: 0;
    }
    
    .section-icon {
        width: 24px;
        height: 24px;
        color: var(--cerfaos-primary);
    }
    
    .section-controls {
        display: flex;
        gap: var(--space-2);
    }
    
    /* Charts Grid */
    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: var(--space-6);
    }
    
    .chart-card {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--cerfaos-border);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-4);
    }
    
    .chart-header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--cerfaos-text-primary);
        margin: 0;
    }
    
    .chart-legend {
        display: flex;
        gap: var(--space-4);
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        font-size: 0.875rem;
        color: var(--cerfaos-text-secondary);
    }
    
    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    
    .chart-container {
        height: 300px;
    }
    
    /* System Health */
    .system-health {
        margin-bottom: var(--space-8);
    }
    
    .overall-health {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-2) var(--space-4);
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .overall-health.healthy {
        background: var(--cerfaos-success-bg);
        color: var(--cerfaos-success);
    }
    
    .health-pulse {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
        animation: pulse 2s infinite;
    }
    
    .health-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--space-4);
    }
    
    .health-card {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--cerfaos-border);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        display: flex;
        align-items: center;
        gap: var(--space-4);
        transition: var(--transition);
    }
    
    .health-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--cerfaos-shadow-lg);
    }
    
    .health-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-lg);
        background: var(--gradient-nature);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .health-info {
        flex: 1;
    }
    
    .health-title {
        font-size: 0.875rem;
        color: var(--cerfaos-text-secondary);
        margin-bottom: var(--space-1);
    }
    
    .health-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--cerfaos-text-primary);
        margin-bottom: var(--space-1);
    }
    
    .health-status {
        font-size: 0.75rem;
        font-weight: 500;
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius);
    }
    
    .health-status.healthy {
        background: var(--cerfaos-success-bg);
        color: var(--cerfaos-success);
    }
    
    .health-status.warning {
        background: var(--cerfaos-warning-bg);
        color: var(--cerfaos-warning);
    }
    
    .health-chart {
        width: 60px;
        height: 40px;
    }
    
    .mini-chart {
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, var(--cerfaos-primary-alpha), var(--cerfaos-accent-alpha));
        border-radius: var(--radius);
    }
    
    /* Recent Activities */
    .activities-list {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--cerfaos-border);
        border-radius: var(--radius-xl);
        overflow: hidden;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-4);
        border-bottom: 1px solid var(--cerfaos-border);
        transition: var(--transition);
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-item:hover {
        background: var(--cerfaos-surface-hover);
    }
    
    .activity-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .activity-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .activity-avatar.system {
        background: var(--gradient-accent);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 500;
        color: var(--cerfaos-text-primary);
        margin-bottom: var(--space-1);
    }
    
    .activity-subtitle {
        font-size: 0.875rem;
        color: var(--cerfaos-text-secondary);
        margin-bottom: var(--space-1);
    }
    
    .activity-time {
        font-size: 0.75rem;
        color: var(--cerfaos-text-muted);
    }
    
    .activity-action {
        flex-shrink: 0;
    }
    
    .activity-icon {
        width: 20px;
        height: 20px;
    }
    
    .activity-icon.success {
        color: var(--cerfaos-success);
    }
    
    .activity-icon.info {
        color: var(--cerfaos-info);
    }
    
    .activity-icon.warning {
        color: var(--cerfaos-warning);
    }
    
    /* Animations */
    @keyframes pulse-success {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
        
        .hero-content {
            flex-direction: column;
            text-align: center;
            gap: var(--space-4);
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .weather-summary {
            position: static;
            margin-top: var(--space-4);
        }
        
        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }
        
        .health-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 480px) {
        .dashboard-hero {
            padding: var(--space-6);
        }
        
        .hero-icon {
            font-size: 3rem;
        }
        
        .hero-title {
            font-size: 1.75rem;
        }
        
        .quick-action-card {
            padding: var(--space-4);
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--space-4);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('fr-FR', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    
    // Update time every second
    updateTime();
    setInterval(updateTime, 1000);
    
    // Quick action handlers
    document.querySelectorAll('.quick-action-card').forEach(card => {
        card.addEventListener('click', function() {
            const action = this.dataset.action;
            
            switch(action) {
                case 'profile':
                    window.location.href = '{{ route("admin.profile") }}';
                    break;
                case 'analytics':
                    // Handle analytics action
                    break;
                case 'export':
                    // Handle export action
                    break;
                case 'settings':
                    // Handle settings action
                    break;
            }
        });
    });
    
    // Period selector for analytics
    document.querySelectorAll('[data-period]').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('[data-period]').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Handle period change
            const period = this.dataset.period;
            console.log('Period changed to:', period);
            // Here you would typically reload charts with new data
        });
    });
});
</script>

@endsection