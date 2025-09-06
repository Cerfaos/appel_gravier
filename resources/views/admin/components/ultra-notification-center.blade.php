{{--
 Ultra Notification Center Component
 Advanced real-time notification system for CERFAOS admin
 
 Usage: @include('admin.components.ultra-notification-center')
--}}

@php
    $notifications = $notifications ?? [];
    $unreadCount = collect($notifications)->where('read', false)->count();
@endphp

<!-- Notification Center -->
<div class="ultra-notification-center" data-component="notification-center">
    <!-- Notification Trigger -->
    <button class="notification-trigger" 
            data-trigger="notifications"
            aria-label="Notifications ({{ $unreadCount }} non lues)"
            title="Notifications">
        <i data-feather="bell"></i>
        @if($unreadCount > 0)
        <span class="notification-badge" data-count="{{ $unreadCount }}">
            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
        </span>
        @endif
    </button>

    <!-- Notification Dropdown -->
    <div class="notification-dropdown" data-dropdown="notifications" hidden>
        <!-- Header -->
        <div class="notification-header">
            <div class="notification-title">
                <h3>Notifications</h3>
                @if($unreadCount > 0)
                <span class="unread-indicator">{{ $unreadCount }} nouvelles</span>
                @endif
            </div>
            
            <div class="notification-controls">
                @if($unreadCount > 0)
                <button class="control-btn mark-all-read" 
                        data-action="mark-all-read"
                        title="Tout marquer comme lu">
                    <i data-feather="check-circle"></i>
                </button>
                @endif
                
                <button class="control-btn refresh-notifications" 
                        data-action="refresh"
                        title="Actualiser">
                    <i data-feather="refresh-cw"></i>
                </button>
                
                <button class="control-btn settings" 
                        data-action="settings"
                        title="Paramètres">
                    <i data-feather="settings"></i>
                </button>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="notification-filters">
            <button class="filter-tab active" data-filter="all">
                Toutes
                <span class="tab-count">{{ count($notifications) }}</span>
            </button>
            <button class="filter-tab" data-filter="unread">
                Non lues
                <span class="tab-count">{{ $unreadCount }}</span>
            </button>
            <button class="filter-tab" data-filter="system">
                Système
                <span class="tab-count">{{ collect($notifications)->where('type', 'system')->count() }}</span>
            </button>
            <button class="filter-tab" data-filter="user">
                Utilisateurs
                <span class="tab-count">{{ collect($notifications)->where('type', 'user')->count() }}</span>
            </button>
        </div>

        <!-- Notifications List -->
        <div class="notifications-list" id="notificationsList">
            @if(empty($notifications))
            <!-- Empty State -->
            <div class="empty-notifications">
                <div class="empty-icon">
                    <i data-feather="bell-off"></i>
                </div>
                <h4>Aucune notification</h4>
                <p>Vous êtes à jour ! Toutes les notifications apparaîtront ici.</p>
            </div>
            @else
                @foreach($notifications as $notification)
                <div class="notification-item {{ $notification['read'] ? 'read' : 'unread' }}" 
                     data-id="{{ $notification['id'] }}"
                     data-type="{{ $notification['type'] }}"
                     data-priority="{{ $notification['priority'] ?? 'normal' }}">
                     
                    <!-- Notification Avatar/Icon -->
                    <div class="notification-avatar {{ $notification['type'] }}">
                        @if(isset($notification['avatar']) && $notification['avatar'])
                        <img src="{{ $notification['avatar'] }}" alt="Avatar" loading="lazy">
                        @else
                        <i data-feather="{{ $notification['icon'] ?? 'info' }}"></i>
                        @endif
                    </div>
                    
                    <!-- Notification Content -->
                    <div class="notification-content">
                        <div class="notification-header-item">
                            <div class="notification-title-item">{{ $notification['title'] }}</div>
                            <div class="notification-time">{{ $notification['time'] }}</div>
                        </div>
                        
                        <div class="notification-message">{{ $notification['message'] }}</div>
                        
                        @if(isset($notification['metadata']))
                        <div class="notification-metadata">
                            @foreach($notification['metadata'] as $key => $value)
                            <span class="metadata-item">
                                <strong>{{ ucfirst($key) }}:</strong> {{ $value }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                        
                        @if(isset($notification['actions']))
                        <div class="notification-actions">
                            @foreach($notification['actions'] as $action)
                            <button class="action-btn {{ $action['class'] ?? 'primary' }}"
                                    data-action="{{ $action['action'] }}"
                                    data-id="{{ $notification['id'] }}">
                                @if(isset($action['icon']))
                                <i data-feather="{{ $action['icon'] }}"></i>
                                @endif
                                {{ $action['label'] }}
                            </button>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    
                    <!-- Notification Controls -->
                    <div class="notification-controls-item">
                        @if(!$notification['read'])
                        <button class="control-item-btn mark-read" 
                                data-action="mark-read" 
                                data-id="{{ $notification['id'] }}"
                                title="Marquer comme lu">
                            <i data-feather="check"></i>
                        </button>
                        @endif
                        
                        <button class="control-item-btn delete" 
                                data-action="delete" 
                                data-id="{{ $notification['id'] }}"
                                title="Supprimer">
                            <i data-feather="trash-2"></i>
                        </button>
                        
                        <button class="control-item-btn options" 
                                data-action="options" 
                                data-id="{{ $notification['id'] }}"
                                title="Plus d'options">
                            <i data-feather="more-horizontal"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        
        <!-- Load More -->
        @if(count($notifications) >= 10)
        <div class="load-more-section">
            <button class="load-more-btn" data-action="load-more">
                <i data-feather="chevron-down"></i>
                Charger plus de notifications
            </button>
        </div>
        @endif
        
        <!-- Footer -->
        <div class="notification-footer">
            <a href="#" class="view-all-link">
                Voir toutes les notifications
                <i data-feather="arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Real-time notification toast -->
<div class="notification-toast-container" id="notificationToasts"></div>

<!-- Notification Center Styles -->
<style>
    .ultra-notification-center {
        position: relative;
    }
    
    /* Trigger Button */
    .notification-trigger {
        position: relative;
        width: 44px;
        height: 44px;
        border: none;
        background: transparent;
        color: var(--cerfaos-text-secondary);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .notification-trigger:hover {
        background: var(--cerfaos-surface-hover);
        color: var(--cerfaos-text-primary);
        transform: scale(1.05);
    }
    
    .notification-trigger:active {
        transform: scale(0.95);
    }
    
    /* Notification Badge */
    .notification-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        min-width: 18px;
        height: 18px;
        background: var(--cerfaos-error);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        animation: pulse-notification 2s infinite;
        box-shadow: 0 0 0 3px var(--cerfaos-surface);
    }
    
    /* Dropdown */
    .notification-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        width: 400px;
        max-height: 80vh;
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--cerfaos-border);
        border-radius: var(--radius-xl);
        box-shadow: var(--cerfaos-shadow-xl);
        z-index: 1000;
        overflow: hidden;
        transform: translateY(10px);
        opacity: 0;
        transition: var(--transition-slow);
    }
    
    .notification-dropdown:not([hidden]) {
        transform: translateY(0);
        opacity: 1;
    }
    
    /* Header */
    .notification-header {
        padding: var(--space-4) var(--space-5);
        border-bottom: 1px solid var(--cerfaos-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--cerfaos-surface);
    }
    
    .notification-title h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--cerfaos-text-primary);
        margin: 0;
    }
    
    .unread-indicator {
        font-size: 0.75rem;
        color: var(--cerfaos-text-muted);
        background: var(--cerfaos-warning-bg);
        padding: 2px 8px;
        border-radius: var(--radius-full);
        margin-top: 2px;
    }
    
    .notification-controls {
        display: flex;
        gap: var(--space-2);
    }
    
    .control-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        color: var(--cerfaos-text-muted);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .control-btn:hover {
        background: var(--cerfaos-surface-hover);
        color: var(--cerfaos-text-primary);
    }
    
    /* Filters */
    .notification-filters {
        display: flex;
        padding: 0 var(--space-5);
        border-bottom: 1px solid var(--cerfaos-border);
        background: var(--cerfaos-surface);
    }
    
    .filter-tab {
        padding: var(--space-3) var(--space-4);
        border: none;
        background: transparent;
        color: var(--cerfaos-text-muted);
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }
    
    .filter-tab.active {
        color: var(--cerfaos-primary);
    }
    
    .filter-tab.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--cerfaos-primary);
    }
    
    .tab-count {
        font-size: 0.75rem;
        background: var(--cerfaos-surface-hover);
        padding: 2px 6px;
        border-radius: var(--radius-full);
        min-width: 18px;
        text-align: center;
    }
    
    .filter-tab.active .tab-count {
        background: var(--cerfaos-primary-bg);
        color: var(--cerfaos-primary);
    }
    
    /* Notifications List */
    .notifications-list {
        max-height: 60vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--cerfaos-border) transparent;
    }
    
    .notifications-list::-webkit-scrollbar {
        width: 6px;
    }
    
    .notifications-list::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .notifications-list::-webkit-scrollbar-thumb {
        background: var(--cerfaos-border);
        border-radius: var(--radius-full);
    }
    
    /* Empty State */
    .empty-notifications {
        padding: var(--space-12);
        text-align: center;
        color: var(--cerfaos-text-muted);
    }
    
    .empty-icon {
        font-size: 3rem;
        margin-bottom: var(--space-4);
        opacity: 0.5;
    }
    
    .empty-notifications h4 {
        font-size: 1.125rem;
        margin: 0 0 var(--space-2) 0;
        color: var(--cerfaos-text-secondary);
    }
    
    .empty-notifications p {
        margin: 0;
        font-size: 0.875rem;
    }
    
    /* Notification Item */
    .notification-item {
        display: flex;
        gap: var(--space-3);
        padding: var(--space-4);
        border-bottom: 1px solid var(--cerfaos-border-light);
        transition: var(--transition);
        position: relative;
    }
    
    .notification-item:last-child {
        border-bottom: none;
    }
    
    .notification-item:hover {
        background: var(--cerfaos-surface-hover);
    }
    
    .notification-item.unread {
        background: var(--cerfaos-primary-bg);
        border-left: 3px solid var(--cerfaos-primary);
    }
    
    .notification-item.unread::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 8px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--cerfaos-primary);
        transform: translateY(-50%);
    }
    
    /* Notification Avatar */
    .notification-avatar {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-lg);
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .notification-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .notification-avatar.system {
        background: var(--gradient-accent);
        color: white;
    }
    
    .notification-avatar.user {
        background: var(--gradient-nature);
        color: white;
    }
    
    .notification-avatar.warning {
        background: var(--cerfaos-warning);
        color: white;
    }
    
    .notification-avatar.error {
        background: var(--cerfaos-error);
        color: white;
    }
    
    /* Notification Content */
    .notification-content {
        flex: 1;
        min-width: 0;
    }
    
    .notification-header-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-1);
    }
    
    .notification-title-item {
        font-weight: 600;
        color: var(--cerfaos-text-primary);
        font-size: 0.875rem;
    }
    
    .notification-time {
        font-size: 0.75rem;
        color: var(--cerfaos-text-muted);
        flex-shrink: 0;
    }
    
    .notification-message {
        color: var(--cerfaos-text-secondary);
        font-size: 0.875rem;
        line-height: 1.4;
        margin-bottom: var(--space-2);
    }
    
    .notification-metadata {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-2);
        margin-bottom: var(--space-2);
    }
    
    .metadata-item {
        font-size: 0.75rem;
        color: var(--cerfaos-text-muted);
        background: var(--cerfaos-surface);
        padding: 2px 6px;
        border-radius: var(--radius);
    }
    
    .notification-actions {
        display: flex;
        gap: var(--space-2);
        margin-top: var(--space-2);
    }
    
    .action-btn {
        font-size: 0.75rem;
        padding: var(--space-1) var(--space-2);
        border: 1px solid var(--cerfaos-border);
        background: transparent;
        color: var(--cerfaos-text-secondary);
        border-radius: var(--radius);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: var(--space-1);
    }
    
    .action-btn:hover {
        background: var(--cerfaos-surface);
        border-color: var(--cerfaos-primary);
        color: var(--cerfaos-primary);
    }
    
    .action-btn.primary {
        background: var(--cerfaos-primary);
        color: white;
        border-color: var(--cerfaos-primary);
    }
    
    .action-btn.primary:hover {
        background: var(--cerfaos-primary-hover);
    }
    
    /* Notification Controls */
    .notification-controls-item {
        display: flex;
        flex-direction: column;
        gap: var(--space-1);
        flex-shrink: 0;
    }
    
    .control-item-btn {
        width: 28px;
        height: 28px;
        border: none;
        background: transparent;
        color: var(--cerfaos-text-muted);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        opacity: 0;
    }
    
    .notification-item:hover .control-item-btn {
        opacity: 1;
    }
    
    .control-item-btn:hover {
        background: var(--cerfaos-surface-hover);
        color: var(--cerfaos-text-primary);
    }
    
    .control-item-btn.delete:hover {
        background: var(--cerfaos-error-bg);
        color: var(--cerfaos-error);
    }
    
    /* Load More */
    .load-more-section {
        padding: var(--space-4);
        border-top: 1px solid var(--cerfaos-border);
        text-align: center;
    }
    
    .load-more-btn {
        width: 100%;
        padding: var(--space-3);
        border: 1px solid var(--cerfaos-border);
        background: transparent;
        color: var(--cerfaos-text-secondary);
        border-radius: var(--radius-lg);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-2);
        font-size: 0.875rem;
    }
    
    .load-more-btn:hover {
        background: var(--cerfaos-surface-hover);
        border-color: var(--cerfaos-primary);
        color: var(--cerfaos-primary);
    }
    
    /* Footer */
    .notification-footer {
        padding: var(--space-4);
        border-top: 1px solid var(--cerfaos-border);
        text-align: center;
        background: var(--cerfaos-surface);
    }
    
    .view-all-link {
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        color: var(--cerfaos-primary);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: var(--transition);
    }
    
    .view-all-link:hover {
        color: var(--cerfaos-primary-hover);
        gap: var(--space-3);
    }
    
    /* Toast Notifications */
    .notification-toast-container {
        position: fixed;
        top: var(--space-6);
        right: var(--space-6);
        z-index: 10000;
        display: flex;
        flex-direction: column;
        gap: var(--space-3);
    }
    
    .notification-toast {
        min-width: 320px;
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--cerfaos-border);
        border-radius: var(--radius-xl);
        padding: var(--space-4);
        box-shadow: var(--cerfaos-shadow-xl);
        transform: translateX(100%);
        opacity: 0;
        animation: slideInToast 0.3s ease-out forwards;
    }
    
    .notification-toast.success {
        border-left: 4px solid var(--cerfaos-success);
    }
    
    .notification-toast.warning {
        border-left: 4px solid var(--cerfaos-warning);
    }
    
    .notification-toast.error {
        border-left: 4px solid var(--cerfaos-error);
    }
    
    .notification-toast.info {
        border-left: 4px solid var(--cerfaos-info);
    }
    
    .toast-content {
        display: flex;
        gap: var(--space-3);
    }
    
    .toast-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }
    
    .toast-text {
        flex: 1;
    }
    
    .toast-title {
        font-weight: 600;
        color: var(--cerfaos-text-primary);
        margin-bottom: var(--space-1);
        font-size: 0.875rem;
    }
    
    .toast-message {
        color: var(--cerfaos-text-secondary);
        font-size: 0.8125rem;
        line-height: 1.4;
    }
    
    .toast-close {
        width: 24px;
        height: 24px;
        border: none;
        background: transparent;
        color: var(--cerfaos-text-muted);
        cursor: pointer;
        border-radius: var(--radius);
        transition: var(--transition);
        flex-shrink: 0;
    }
    
    .toast-close:hover {
        background: var(--cerfaos-surface-hover);
        color: var(--cerfaos-text-primary);
    }
    
    /* Animations */
    @keyframes pulse-notification {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
    
    @keyframes slideInToast {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    /* Priority Indicators */
    .notification-item[data-priority="high"] {
        border-left-color: var(--cerfaos-error);
    }
    
    .notification-item[data-priority="high"] .notification-title-item {
        color: var(--cerfaos-error);
    }
    
    .notification-item[data-priority="urgent"] {
        background: var(--cerfaos-error-bg);
        border-left-color: var(--cerfaos-error);
        animation: pulse-urgent 2s infinite;
    }
    
    @keyframes pulse-urgent {
        0%, 100% {
            background: var(--cerfaos-error-bg);
        }
        50% {
            background: rgba(239, 68, 68, 0.15);
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .notification-dropdown {
            width: 100vw;
            max-width: 400px;
            right: -20px;
        }
        
        .notification-toast-container {
            top: var(--space-4);
            right: var(--space-4);
            left: var(--space-4);
        }
        
        .notification-toast {
            min-width: auto;
        }
    }
    
    @media (max-width: 480px) {
        .notification-dropdown {
            right: -40px;
        }
        
        .notification-header {
            padding: var(--space-3) var(--space-4);
        }
        
        .notification-filters {
            padding: 0 var(--space-4);
        }
        
        .filter-tab {
            padding: var(--space-2) var(--space-3);
            font-size: 0.8125rem;
        }
        
        .notification-item {
            padding: var(--space-3);
        }
        
        .notification-avatar {
            width: 36px;
            height: 36px;
        }
    }
    
    /* Dark mode enhancements */
    @media (prefers-color-scheme: dark) {
        .notification-dropdown {
            box-shadow: var(--cerfaos-shadow-xl), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }
        
        .notification-toast {
            box-shadow: var(--cerfaos-shadow-xl), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }
    }
</style>

<script>
class UltraNotificationCenter {
    constructor() {
        this.container = document.querySelector('[data-component="notification-center"]');
        this.trigger = document.querySelector('[data-trigger="notifications"]');
        this.dropdown = document.querySelector('[data-dropdown="notifications"]');
        this.notificationsList = document.getElementById('notificationsList');
        this.toastContainer = document.getElementById('notificationToasts');
        this.filters = document.querySelectorAll('.filter-tab');
        this.notifications = [];
        this.currentFilter = 'all';
        this.isOpen = false;
        
        this.init();
    }
    
    init() {
        this.attachEventListeners();
        this.startRealTimeUpdates();
        this.loadNotifications();
    }
    
    attachEventListeners() {
        // Toggle dropdown
        this.trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleDropdown();
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target)) {
                this.closeDropdown();
            }
        });
        
        // Filter tabs
        this.filters.forEach(tab => {
            tab.addEventListener('click', () => {
                this.setFilter(tab.dataset.filter);
            });
        });
        
        // Control buttons
        document.addEventListener('click', (e) => {
            const action = e.target.closest('[data-action]')?.dataset.action;
            const id = e.target.closest('[data-id]')?.dataset.id;
            
            switch(action) {
                case 'mark-all-read':
                    this.markAllAsRead();
                    break;
                case 'refresh':
                    this.refreshNotifications();
                    break;
                case 'mark-read':
                    this.markAsRead(id);
                    break;
                case 'delete':
                    this.deleteNotification(id);
                    break;
                case 'load-more':
                    this.loadMoreNotifications();
                    break;
            }
        });
    }
    
    toggleDropdown() {
        if (this.isOpen) {
            this.closeDropdown();
        } else {
            this.openDropdown();
        }
    }
    
    openDropdown() {
        this.dropdown.hidden = false;
        this.isOpen = true;
        document.body.style.overflow = 'hidden'; // Prevent background scroll on mobile
        
        // Mark notifications as seen
        this.markNotificationsAsSeen();
    }
    
    closeDropdown() {
        this.dropdown.hidden = true;
        this.isOpen = false;
        document.body.style.overflow = '';
    }
    
    setFilter(filter) {
        this.currentFilter = filter;
        
        // Update active tab
        this.filters.forEach(tab => {
            tab.classList.toggle('active', tab.dataset.filter === filter);
        });
        
        this.renderNotifications();
    }
    
    async loadNotifications() {
        try {
            // In a real application, this would fetch from your API
            const response = await fetch('/api/admin/notifications');
            const data = await response.json();
            this.notifications = data.notifications || [];
            this.renderNotifications();
            this.updateBadge();
        } catch (error) {
            console.error('Failed to load notifications:', error);
            // Fallback to sample data for demo
            this.loadSampleNotifications();
        }
    }
    
    loadSampleNotifications() {
        this.notifications = [
            {
                id: 1,
                type: 'user',
                priority: 'normal',
                icon: 'mountain',
                title: 'Nouvelle randonnée',
                message: 'Marie Dubois a terminé le Mont-Blanc Express',
                time: 'Il y a 2 minutes',
                read: false,
                avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=60&h=60&fit=crop&crop=face'
            },
            {
                id: 2,
                type: 'system',
                priority: 'high',
                icon: 'alert-triangle',
                title: 'Mise à jour système',
                message: 'Version 2.4.1 disponible avec correctifs de sécurité',
                time: 'Il y a 1 heure',
                read: false,
                actions: [
                    { label: 'Installer', action: 'install-update', class: 'primary', icon: 'download' },
                    { label: 'Plus tard', action: 'defer-update', class: 'secondary' }
                ]
            },
            {
                id: 3,
                type: 'user',
                priority: 'normal',
                icon: 'upload',
                title: 'Upload terminé',
                message: 'Paul Martin a uploadé 25 nouvelles photos',
                time: 'Il y a 5 minutes',
                read: true,
                avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face'
            }
        ];
        
        this.renderNotifications();
        this.updateBadge();
    }
    
    renderNotifications() {
        let filteredNotifications = this.notifications;
        
        if (this.currentFilter !== 'all') {
            if (this.currentFilter === 'unread') {
                filteredNotifications = this.notifications.filter(n => !n.read);
            } else {
                filteredNotifications = this.notifications.filter(n => n.type === this.currentFilter);
            }
        }
        
        if (filteredNotifications.length === 0) {
            this.renderEmptyState();
            return;
        }
        
        const html = filteredNotifications.map(notification => this.renderNotificationItem(notification)).join('');
        this.notificationsList.innerHTML = html;
        
        // Re-initialize feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }
    
    renderNotificationItem(notification) {
        const avatar = notification.avatar 
            ? `<img src="${notification.avatar}" alt="Avatar" loading="lazy">`
            : `<i data-feather="${notification.icon || 'info'}"></i>`;
            
        const actions = notification.actions 
            ? `<div class="notification-actions">
                ${notification.actions.map(action => 
                    `<button class="action-btn ${action.class || 'primary'}" 
                             data-action="${action.action}" 
                             data-id="${notification.id}">
                        ${action.icon ? `<i data-feather="${action.icon}"></i>` : ''}
                        ${action.label}
                     </button>`
                ).join('')}
               </div>`
            : '';
            
        const metadata = notification.metadata 
            ? `<div class="notification-metadata">
                ${Object.entries(notification.metadata).map(([key, value]) => 
                    `<span class="metadata-item">
                        <strong>${key.charAt(0).toUpperCase() + key.slice(1)}:</strong> ${value}
                     </span>`
                ).join('')}
               </div>`
            : '';
        
        return `
            <div class="notification-item ${notification.read ? 'read' : 'unread'}" 
                 data-id="${notification.id}"
                 data-type="${notification.type}"
                 data-priority="${notification.priority || 'normal'}">
                 
                <div class="notification-avatar ${notification.type}">
                    ${avatar}
                </div>
                
                <div class="notification-content">
                    <div class="notification-header-item">
                        <div class="notification-title-item">${notification.title}</div>
                        <div class="notification-time">${notification.time}</div>
                    </div>
                    
                    <div class="notification-message">${notification.message}</div>
                    ${metadata}
                    ${actions}
                </div>
                
                <div class="notification-controls-item">
                    ${!notification.read ? `
                    <button class="control-item-btn mark-read" 
                            data-action="mark-read" 
                            data-id="${notification.id}"
                            title="Marquer comme lu">
                        <i data-feather="check"></i>
                    </button>
                    ` : ''}
                    
                    <button class="control-item-btn delete" 
                            data-action="delete" 
                            data-id="${notification.id}"
                            title="Supprimer">
                        <i data-feather="trash-2"></i>
                    </button>
                    
                    <button class="control-item-btn options" 
                            data-action="options" 
                            data-id="${notification.id}"
                            title="Plus d'options">
                        <i data-feather="more-horizontal"></i>
                    </button>
                </div>
            </div>
        `;
    }
    
    renderEmptyState() {
        this.notificationsList.innerHTML = `
            <div class="empty-notifications">
                <div class="empty-icon">
                    <i data-feather="bell-off"></i>
                </div>
                <h4>Aucune notification</h4>
                <p>Vous êtes à jour ! Toutes les notifications apparaîtront ici.</p>
            </div>
        `;
        
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }
    
    updateBadge() {
        const unreadCount = this.notifications.filter(n => !n.read).length;
        const badge = this.trigger.querySelector('.notification-badge');
        
        if (unreadCount > 0) {
            if (!badge) {
                const newBadge = document.createElement('span');
                newBadge.className = 'notification-badge';
                newBadge.setAttribute('data-count', unreadCount);
                newBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                this.trigger.appendChild(newBadge);
            } else {
                badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                badge.setAttribute('data-count', unreadCount);
            }
        } else if (badge) {
            badge.remove();
        }
        
        // Update filter counts
        this.updateFilterCounts();
    }
    
    updateFilterCounts() {
        const allCount = this.notifications.length;
        const unreadCount = this.notifications.filter(n => !n.read).length;
        const systemCount = this.notifications.filter(n => n.type === 'system').length;
        const userCount = this.notifications.filter(n => n.type === 'user').length;
        
        this.filters.forEach(tab => {
            const countElement = tab.querySelector('.tab-count');
            if (countElement) {
                switch(tab.dataset.filter) {
                    case 'all':
                        countElement.textContent = allCount;
                        break;
                    case 'unread':
                        countElement.textContent = unreadCount;
                        break;
                    case 'system':
                        countElement.textContent = systemCount;
                        break;
                    case 'user':
                        countElement.textContent = userCount;
                        break;
                }
            }
        });
    }
    
    markAsRead(id) {
        const notification = this.notifications.find(n => n.id == id);
        if (notification) {
            notification.read = true;
            this.renderNotifications();
            this.updateBadge();
            
            // Send to server
            this.updateNotificationOnServer(id, { read: true });
        }
    }
    
    markAllAsRead() {
        this.notifications.forEach(n => n.read = true);
        this.renderNotifications();
        this.updateBadge();
        
        // Send to server
        this.updateAllNotificationsOnServer({ read: true });
        
        this.showToast('success', 'Succès', 'Toutes les notifications ont été marquées comme lues');
    }
    
    deleteNotification(id) {
        this.notifications = this.notifications.filter(n => n.id != id);
        this.renderNotifications();
        this.updateBadge();
        
        // Send to server
        this.deleteNotificationOnServer(id);
        
        this.showToast('info', 'Supprimé', 'Notification supprimée');
    }
    
    async refreshNotifications() {
        const refreshBtn = document.querySelector('[data-action="refresh"]');
        const icon = refreshBtn.querySelector('i');
        
        icon.style.animation = 'spin 1s linear infinite';
        
        await this.loadNotifications();
        
        setTimeout(() => {
            icon.style.animation = '';
        }, 1000);
        
        this.showToast('success', 'Actualisé', 'Notifications mises à jour');
    }
    
    showToast(type, title, message) {
        const toast = document.createElement('div');
        toast.className = `notification-toast ${type}`;
        
        const icons = {
            success: 'check-circle',
            error: 'x-circle',
            warning: 'alert-triangle',
            info: 'info'
        };
        
        toast.innerHTML = `
            <div class="toast-content">
                <i data-feather="${icons[type] || 'info'}" class="toast-icon"></i>
                <div class="toast-text">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="this.parentElement.parentElement.remove()">
                    <i data-feather="x"></i>
                </button>
            </div>
        `;
        
        this.toastContainer.appendChild(toast);
        
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    }
    
    async updateNotificationOnServer(id, data) {
        try {
            await fetch(`/api/admin/notifications/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify(data)
            });
        } catch (error) {
            console.error('Failed to update notification:', error);
        }
    }
    
    async updateAllNotificationsOnServer(data) {
        try {
            await fetch('/api/admin/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify(data)
            });
        } catch (error) {
            console.error('Failed to update all notifications:', error);
        }
    }
    
    async deleteNotificationOnServer(id) {
        try {
            await fetch(`/api/admin/notifications/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            });
        } catch (error) {
            console.error('Failed to delete notification:', error);
        }
    }
    
    startRealTimeUpdates() {
        // In a real application, you would use WebSockets or Server-Sent Events
        // For demo purposes, we'll simulate with polling
        setInterval(() => {
            this.loadNotifications();
        }, 30000); // Check every 30 seconds
    }
    
    markNotificationsAsSeen() {
        // Mark notifications as seen (but not read) when dropdown is opened
        const unseenNotifications = this.notifications.filter(n => !n.seen);
        unseenNotifications.forEach(n => n.seen = true);
        
        if (unseenNotifications.length > 0) {
            this.updateNotificationOnServer('mark-seen', { 
                ids: unseenNotifications.map(n => n.id) 
            });
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.notificationCenter = new UltraNotificationCenter();
});

// CSS keyframes for spin animation
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>