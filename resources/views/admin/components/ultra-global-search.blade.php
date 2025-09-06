{{--
 Ultra Global Search Component
 Advanced search functionality for CERFAOS admin
 
 Usage: @include('admin.components.ultra-global-search')
--}}

<!-- Global Search Container -->
<div class="ultra-global-search" data-component="global-search">
    <!-- Search Input -->
    <div class="search-container">
        <div class="search-input-wrapper">
            <i data-feather="search" class="search-icon"></i>
            <input type="text" 
                   class="global-search-input" 
                   placeholder="Rechercher dans CERFAOS..."
                   autocomplete="off"
                   aria-label="Recherche globale"
                   data-search-input>
            <div class="search-shortcuts">
                <kbd>Ctrl</kbd>+<kbd>K</kbd>
            </div>
            <button class="search-clear" data-action="clear" hidden>
                <i data-feather="x"></i>
            </button>
        </div>
    </div>

    <!-- Search Dropdown -->
    <div class="search-dropdown" data-dropdown="search" hidden>
        <!-- Search Filters -->
        <div class="search-filters">
            <button class="filter-btn active" data-filter="all">
                <i data-feather="globe"></i>
                <span>Tout</span>
            </button>
            <button class="filter-btn" data-filter="users">
                <i data-feather="users"></i>
                <span>Utilisateurs</span>
            </button>
            <button class="filter-btn" data-filter="itineraries">
                <i data-feather="map"></i>
                <span>Itinéraires</span>
            </button>
            <button class="filter-btn" data-filter="sorties">
                <i data-feather="mountain"></i>
                <span>Sorties</span>
            </button>
            <button class="filter-btn" data-filter="content">
                <i data-feather="file-text"></i>
                <span>Contenu</span>
            </button>
            <button class="filter-btn" data-filter="settings">
                <i data-feather="settings"></i>
                <span>Paramètres</span>
            </button>
        </div>

        <!-- Search Results Container -->
        <div class="search-results-container">
            <!-- Loading State -->
            <div class="search-loading" data-state="loading" hidden>
                <div class="loading-spinner"></div>
                <p>Recherche en cours...</p>
            </div>

            <!-- Empty State -->
            <div class="search-empty" data-state="empty" hidden>
                <div class="empty-icon">
                    <i data-feather="search"></i>
                </div>
                <h4>Commencez à taper pour rechercher</h4>
                <p>Trouvez rapidement des utilisateurs, itinéraires, sorties et plus encore.</p>
                
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h5>Actions rapides</h5>
                    <div class="quick-action-grid">
                        <a href="{{ route('admin.profile') }}" class="quick-action-item">
                            <i data-feather="user"></i>
                            <span>Mon profil</span>
                        </a>
                        <button class="quick-action-item" data-action="new-user">
                            <i data-feather="user-plus"></i>
                            <span>Nouvel utilisateur</span>
                        </button>
                        <button class="quick-action-item" data-action="system-health">
                            <i data-feather="activity"></i>
                            <span>État système</span>
                        </button>
                        <button class="quick-action-item" data-action="cache-clear">
                            <i data-feather="refresh-cw"></i>
                            <span>Vider le cache</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- No Results State -->
            <div class="search-no-results" data-state="no-results" hidden>
                <div class="no-results-icon">
                    <i data-feather="search-x"></i>
                </div>
                <h4>Aucun résultat trouvé</h4>
                <p>Essayez avec des termes différents ou utilisez les filtres.</p>
                
                <!-- Search Suggestions -->
                <div class="search-suggestions">
                    <h5>Suggestions :</h5>
                    <div class="suggestion-list">
                        <button class="suggestion-item" data-suggestion="utilisateurs actifs">utilisateurs actifs</button>
                        <button class="suggestion-item" data-suggestion="itinéraires populaires">itinéraires populaires</button>
                        <button class="suggestion-item" data-suggestion="sorties récentes">sorties récentes</button>
                        <button class="suggestion-item" data-suggestion="paramètres système">paramètres système</button>
                    </div>
                </div>
            </div>

            <!-- Search Results -->
            <div class="search-results" data-state="results" hidden>
                <div class="results-list" data-results-list></div>
                
                <!-- Load More Results -->
                <div class="load-more-results" hidden>
                    <button class="load-more-btn" data-action="load-more">
                        Voir plus de résultats
                        <i data-feather="chevron-down"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Search Footer -->
        <div class="search-footer">
            <div class="search-stats">
                <span class="search-time" data-search-time hidden></span>
                <span class="search-count" data-search-count hidden></span>
            </div>
            
            <div class="search-shortcuts-help">
                <span class="shortcut-item">
                    <kbd>↑</kbd><kbd>↓</kbd> naviguer
                </span>
                <span class="shortcut-item">
                    <kbd>↵</kbd> sélectionner
                </span>
                <span class="shortcut-item">
                    <kbd>Esc</kbd> fermer
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Search Styles -->
<style>
    .ultra-global-search {
        position: relative;
        width: 100%;
        max-width: 500px;
    }
    
    /* Search Container */
    .search-container {
        position: relative;
        width: 100%;
    }
    
    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--cerfaos-border);
        border-radius: var(--radius-xl);
        transition: var(--transition);
        overflow: hidden;
    }
    
    .search-input-wrapper:focus-within {
        border-color: var(--cerfaos-primary);
        box-shadow: 0 0 0 3px var(--cerfaos-primary-alpha);
    }
    
    .search-icon {
        position: absolute;
        left: var(--space-4);
        width: 20px;
        height: 20px;
        color: var(--cerfaos-text-muted);
        pointer-events: none;
        z-index: 2;
    }
    
    .global-search-input {
        flex: 1;
        width: 100%;
        padding: var(--space-3) var(--space-4);
        padding-left: calc(var(--space-4) + 20px + var(--space-2));
        padding-right: calc(var(--space-4) + 80px);
        border: none;
        background: transparent;
        color: var(--cerfaos-text-primary);
        font-size: 0.9375rem;
        outline: none;
    }
    
    .global-search-input::placeholder {
        color: var(--cerfaos-text-muted);
    }
    
    .search-shortcuts {
        position: absolute;
        right: var(--space-4);
        display: flex;
        align-items: center;
        gap: 2px;
        pointer-events: none;
        z-index: 2;
    }
    
    .search-shortcuts kbd {
        padding: 2px 6px;
        background: var(--cerfaos-surface);
        border: 1px solid var(--cerfaos-border);
        border-radius: var(--radius);
        font-family: var(--font-mono);
        font-size: 0.75rem;
        color: var(--cerfaos-text-muted);
        line-height: 1;
    }
    
    .search-clear {
        position: absolute;
        right: var(--space-4);
        width: 24px;
        height: 24px;
        border: none;
        background: transparent;
        color: var(--cerfaos-text-muted);
        border-radius: var(--radius);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
    }
    
    .search-clear:hover {
        background: var(--cerfaos-surface-hover);
        color: var(--cerfaos-text-primary);
    }
    
    .search-clear:not([hidden]) + .search-shortcuts {
        display: none;
    }
    
    /* Search Dropdown */
    .search-dropdown {
        position: absolute;
        top: calc(100% + var(--space-2));
        left: 0;
        right: 0;
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--cerfaos-border);
        border-radius: var(--radius-xl);
        box-shadow: var(--cerfaos-shadow-xl);
        z-index: 1000;
        max-height: 80vh;
        overflow: hidden;
        transform: translateY(-10px);
        opacity: 0;
        transition: var(--transition-slow);
    }
    
    .search-dropdown:not([hidden]) {
        transform: translateY(0);
        opacity: 1;
    }
    
    /* Search Filters */
    .search-filters {
        display: flex;
        padding: var(--space-3);
        gap: var(--space-1);
        border-bottom: 1px solid var(--cerfaos-border);
        background: var(--cerfaos-surface);
        overflow-x: auto;
        scrollbar-width: none;
    }
    
    .search-filters::-webkit-scrollbar {
        display: none;
    }
    
    .filter-btn {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-2) var(--space-3);
        border: none;
        background: transparent;
        color: var(--cerfaos-text-muted);
        border-radius: var(--radius-lg);
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
        font-size: 0.875rem;
        position: relative;
    }
    
    .filter-btn:hover {
        background: var(--cerfaos-surface-hover);
        color: var(--cerfaos-text-primary);
    }
    
    .filter-btn.active {
        background: var(--cerfaos-primary);
        color: white;
    }
    
    .filter-btn i {
        width: 16px;
        height: 16px;
    }
    
    /* Search Results Container */
    .search-results-container {
        max-height: 60vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--cerfaos-border) transparent;
    }
    
    .search-results-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .search-results-container::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .search-results-container::-webkit-scrollbar-thumb {
        background: var(--cerfaos-border);
        border-radius: var(--radius-full);
    }
    
    /* Loading State */
    .search-loading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: var(--space-12);
        color: var(--cerfaos-text-muted);
    }
    
    .loading-spinner {
        width: 32px;
        height: 32px;
        border: 3px solid var(--cerfaos-border);
        border-top: 3px solid var(--cerfaos-primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: var(--space-4);
    }
    
    /* Empty State */
    .search-empty {
        padding: var(--space-8);
        text-align: center;
        color: var(--cerfaos-text-muted);
    }
    
    .empty-icon {
        font-size: 3rem;
        margin-bottom: var(--space-4);
        opacity: 0.5;
    }
    
    .search-empty h4 {
        font-size: 1.125rem;
        margin: 0 0 var(--space-2) 0;
        color: var(--cerfaos-text-secondary);
    }
    
    .search-empty p {
        margin: 0 0 var(--space-6) 0;
        font-size: 0.875rem;
    }
    
    /* Quick Actions */
    .quick-actions h5 {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--cerfaos-text-primary);
        margin: 0 0 var(--space-3) 0;
        text-align: left;
    }
    
    .quick-action-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-2);
    }
    
    .quick-action-item {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-3);
        border: 1px solid var(--cerfaos-border);
        background: transparent;
        color: var(--cerfaos-text-secondary);
        text-decoration: none;
        border-radius: var(--radius-lg);
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.875rem;
    }
    
    .quick-action-item:hover {
        background: var(--cerfaos-surface-hover);
        border-color: var(--cerfaos-primary);
        color: var(--cerfaos-primary);
    }
    
    .quick-action-item i {
        width: 16px;
        height: 16px;
    }
    
    /* No Results State */
    .search-no-results {
        padding: var(--space-8);
        text-align: center;
        color: var(--cerfaos-text-muted);
    }
    
    .no-results-icon {
        font-size: 3rem;
        margin-bottom: var(--space-4);
        opacity: 0.5;
    }
    
    .search-no-results h4 {
        font-size: 1.125rem;
        margin: 0 0 var(--space-2) 0;
        color: var(--cerfaos-text-secondary);
    }
    
    .search-no-results p {
        margin: 0 0 var(--space-6) 0;
        font-size: 0.875rem;
    }
    
    /* Search Suggestions */
    .search-suggestions h5 {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--cerfaos-text-primary);
        margin: 0 0 var(--space-3) 0;
        text-align: left;
    }
    
    .suggestion-list {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-2);
    }
    
    .suggestion-item {
        padding: var(--space-1) var(--space-3);
        border: 1px solid var(--cerfaos-border);
        background: transparent;
        color: var(--cerfaos-text-secondary);
        border-radius: var(--radius-full);
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.8125rem;
    }
    
    .suggestion-item:hover {
        background: var(--cerfaos-surface-hover);
        border-color: var(--cerfaos-primary);
        color: var(--cerfaos-primary);
    }
    
    /* Search Results */
    .results-list {
        padding: var(--space-2) 0;
    }
    
    .result-item {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        padding: var(--space-3) var(--space-4);
        border-radius: var(--radius-lg);
        margin: 0 var(--space-2);
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }
    
    .result-item:hover,
    .result-item.selected {
        background: var(--cerfaos-surface-hover);
    }
    
    .result-item.selected::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 60%;
        background: var(--cerfaos-primary);
        border-radius: 0 var(--radius) var(--radius) 0;
    }
    
    /* Result Avatar/Icon */
    .result-avatar {
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
    
    .result-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .result-avatar.users {
        background: var(--gradient-nature);
        color: white;
    }
    
    .result-avatar.itineraries {
        background: var(--gradient-accent);
        color: white;
    }
    
    .result-avatar.sorties {
        background: var(--gradient-sunset);
        color: white;
    }
    
    .result-avatar.content {
        background: var(--cerfaos-info);
        color: white;
    }
    
    .result-avatar.settings {
        background: var(--cerfaos-surface);
        color: var(--cerfaos-text-secondary);
        border: 1px solid var(--cerfaos-border);
    }
    
    /* Result Content */
    .result-content {
        flex: 1;
        min-width: 0;
    }
    
    .result-title {
        font-weight: 600;
        color: var(--cerfaos-text-primary);
        font-size: 0.9375rem;
        margin-bottom: var(--space-1);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .result-description {
        color: var(--cerfaos-text-secondary);
        font-size: 0.8125rem;
        line-height: 1.4;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .result-meta {
        display: flex;
        gap: var(--space-2);
        margin-top: var(--space-1);
    }
    
    .meta-item {
        font-size: 0.75rem;
        color: var(--cerfaos-text-muted);
        background: var(--cerfaos-surface);
        padding: 2px 6px;
        border-radius: var(--radius);
    }
    
    /* Result Actions */
    .result-actions {
        display: flex;
        gap: var(--space-1);
        opacity: 0;
        transition: var(--transition);
    }
    
    .result-item:hover .result-actions {
        opacity: 1;
    }
    
    .result-action {
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        color: var(--cerfaos-text-muted);
        border-radius: var(--radius);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .result-action:hover {
        background: var(--cerfaos-surface);
        color: var(--cerfaos-text-primary);
    }
    
    /* Load More */
    .load-more-results {
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
    
    /* Search Footer */
    .search-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-3) var(--space-4);
        border-top: 1px solid var(--cerfaos-border);
        background: var(--cerfaos-surface);
        font-size: 0.75rem;
        color: var(--cerfaos-text-muted);
    }
    
    .search-stats {
        display: flex;
        gap: var(--space-3);
    }
    
    .search-shortcuts-help {
        display: flex;
        gap: var(--space-2);
    }
    
    .shortcut-item {
        display: flex;
        align-items: center;
        gap: 2px;
    }
    
    .shortcut-item kbd {
        padding: 2px 4px;
        background: var(--cerfaos-surface-hover);
        border: 1px solid var(--cerfaos-border);
        border-radius: 2px;
        font-family: var(--font-mono);
        font-size: 0.6875rem;
        line-height: 1;
    }
    
    /* Highlight Search Terms */
    .highlight {
        background: var(--cerfaos-warning-bg);
        color: var(--cerfaos-warning);
        padding: 0 2px;
        border-radius: 2px;
        font-weight: 600;
    }
    
    /* Animations */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Category Dividers */
    .result-category {
        padding: var(--space-3) var(--space-4) var(--space-2);
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--cerfaos-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: var(--cerfaos-surface);
        border-bottom: 1px solid var(--cerfaos-border-light);
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .ultra-global-search {
            max-width: none;
        }
        
        .search-dropdown {
            left: -20px;
            right: -20px;
            max-height: 70vh;
        }
        
        .quick-action-grid {
            grid-template-columns: 1fr;
        }
        
        .search-filters {
            padding: var(--space-2);
            gap: var(--space-1);
        }
        
        .filter-btn {
            padding: var(--space-2);
            font-size: 0.8125rem;
        }
        
        .filter-btn span {
            display: none;
        }
        
        .search-shortcuts-help {
            display: none;
        }
    }
    
    @media (max-width: 480px) {
        .search-dropdown {
            left: -40px;
            right: -40px;
        }
        
        .search-empty,
        .search-no-results {
            padding: var(--space-6);
        }
        
        .empty-icon,
        .no-results-icon {
            font-size: 2rem;
        }
        
        .result-item {
            padding: var(--space-3);
            margin: 0 var(--space-1);
        }
        
        .result-avatar {
            width: 36px;
            height: 36px;
        }
        
        .result-title {
            font-size: 0.875rem;
        }
        
        .result-description {
            font-size: 0.75rem;
        }
    }
    
    /* Dark mode enhancements */
    @media (prefers-color-scheme: dark) {
        .search-dropdown {
            box-shadow: var(--cerfaos-shadow-xl), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }
        
        .search-input-wrapper:focus-within {
            box-shadow: 0 0 0 3px var(--cerfaos-primary-alpha), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }
    }
    
    /* High contrast mode */
    @media (prefers-contrast: high) {
        .search-input-wrapper,
        .search-dropdown,
        .filter-btn,
        .result-item,
        .quick-action-item {
            border-width: 2px;
        }
        
        .result-item.selected {
            border: 2px solid var(--cerfaos-primary);
        }
    }
    
    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        .search-dropdown,
        .result-item,
        .filter-btn,
        .quick-action-item,
        .suggestion-item,
        .load-more-btn {
            transition: none;
        }
        
        .loading-spinner {
            animation: none;
            border: 3px solid var(--cerfaos-primary);
        }
    }
</style>

<script>
class UltraGlobalSearch {
    constructor() {
        this.container = document.querySelector('[data-component="global-search"]');
        this.input = document.querySelector('[data-search-input]');
        this.dropdown = document.querySelector('[data-dropdown="search"]');
        this.clearBtn = document.querySelector('[data-action="clear"]');
        this.filters = document.querySelectorAll('.filter-btn');
        this.resultsList = document.querySelector('[data-results-list]');
        
        this.currentFilter = 'all';
        this.currentQuery = '';
        this.currentResults = [];
        this.selectedIndex = -1;
        this.searchTimeout = null;
        this.isOpen = false;
        
        this.init();
    }
    
    init() {
        this.attachEventListeners();
        this.registerKeyboardShortcuts();
    }
    
    attachEventListeners() {
        // Input events
        this.input.addEventListener('input', (e) => {
            this.handleInput(e.target.value);
        });
        
        this.input.addEventListener('focus', () => {
            this.openDropdown();
        });
        
        this.input.addEventListener('keydown', (e) => {
            this.handleKeydown(e);
        });
        
        // Clear button
        this.clearBtn.addEventListener('click', () => {
            this.clearSearch();
        });
        
        // Filter buttons
        this.filters.forEach(filter => {
            filter.addEventListener('click', () => {
                this.setFilter(filter.dataset.filter);
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target)) {
                this.closeDropdown();
            }
        });
        
        // Suggestion clicks
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('suggestion-item')) {
                this.input.value = e.target.dataset.suggestion;
                this.handleInput(e.target.dataset.suggestion);
            }
        });
        
        // Quick action clicks
        document.addEventListener('click', (e) => {
            const action = e.target.closest('[data-action]')?.dataset.action;
            if (action) {
                this.handleQuickAction(action);
            }
        });
    }
    
    registerKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl+K or Cmd+K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                this.input.focus();
                this.input.select();
            }
            
            // Escape to close
            if (e.key === 'Escape' && this.isOpen) {
                this.closeDropdown();
                this.input.blur();
            }
        });
    }
    
    handleInput(query) {
        this.currentQuery = query.trim();
        
        // Show/hide clear button
        if (this.currentQuery.length > 0) {
            this.clearBtn.hidden = false;
        } else {
            this.clearBtn.hidden = true;
        }
        
        // Clear previous timeout
        if (this.searchTimeout) {
            clearTimeout(this.searchTimeout);
        }
        
        // Debounce search
        this.searchTimeout = setTimeout(() => {
            this.performSearch(this.currentQuery);
        }, 300);
        
        this.openDropdown();
    }
    
    handleKeydown(e) {
        if (!this.isOpen) return;
        
        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                this.moveSelection(1);
                break;
            case 'ArrowUp':
                e.preventDefault();
                this.moveSelection(-1);
                break;
            case 'Enter':
                e.preventDefault();
                this.selectResult();
                break;
            case 'Escape':
                e.preventDefault();
                this.closeDropdown();
                break;
        }
    }
    
    moveSelection(direction) {
        const results = this.dropdown.querySelectorAll('.result-item');
        
        if (results.length === 0) return;
        
        // Remove previous selection
        results.forEach(result => result.classList.remove('selected'));
        
        // Calculate new index
        this.selectedIndex += direction;
        
        if (this.selectedIndex < 0) {
            this.selectedIndex = results.length - 1;
        } else if (this.selectedIndex >= results.length) {
            this.selectedIndex = 0;
        }
        
        // Add new selection
        results[this.selectedIndex].classList.add('selected');
        
        // Scroll into view
        results[this.selectedIndex].scrollIntoView({
            block: 'nearest',
            behavior: 'smooth'
        });
    }
    
    selectResult() {
        const selectedResult = this.dropdown.querySelector('.result-item.selected');
        if (selectedResult) {
            const url = selectedResult.dataset.url;
            const action = selectedResult.dataset.action;
            
            if (url) {
                window.location.href = url;
            } else if (action) {
                this.handleResultAction(action, selectedResult.dataset);
            }
            
            this.closeDropdown();
        }
    }
    
    async performSearch(query) {
        if (query.length === 0) {
            this.showState('empty');
            return;
        }
        
        if (query.length < 2) {
            return; // Don't search for single characters
        }
        
        this.showState('loading');
        
        const startTime = performance.now();
        
        try {
            const response = await fetch('/api/admin/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({
                    query: query,
                    filter: this.currentFilter,
                    limit: 50
                })
            });
            
            const data = await response.json();
            const endTime = performance.now();
            
            this.currentResults = data.results || [];
            
            if (this.currentResults.length === 0) {
                this.showState('no-results');
            } else {
                this.showState('results');
                this.renderResults(this.currentResults, query);
                this.updateSearchStats(this.currentResults.length, endTime - startTime);
            }
            
        } catch (error) {
            console.error('Search failed:', error);
            this.showState('no-results');
            this.showFallbackResults(query);
        }
    }
    
    showFallbackResults(query) {
        // Show some fallback results when API fails
        const fallbackResults = this.generateFallbackResults(query);
        this.currentResults = fallbackResults;
        
        if (fallbackResults.length > 0) {
            this.showState('results');
            this.renderResults(fallbackResults, query);
            this.updateSearchStats(fallbackResults.length, 0);
        }
    }
    
    generateFallbackResults(query) {
        const results = [];
        const lowerQuery = query.toLowerCase();
        
        // Sample fallback data
        const sampleData = [
            {
                type: 'users',
                title: 'Marie Dubois',
                description: 'Administratrice, dernière connexion il y a 2h',
                url: '#',
                avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=60&h=60&fit=crop&crop=face'
            },
            {
                type: 'itineraries',
                title: 'Mont-Blanc Express',
                description: '15km • Difficile • 1,250m de dénivelé',
                url: '#',
                meta: ['15 participants', 'Actif']
            },
            {
                type: 'settings',
                title: 'Paramètres système',
                description: 'Configuration générale de l\'application',
                url: '#',
                icon: 'settings'
            }
        ];
        
        // Filter based on query
        sampleData.forEach(item => {
            if (item.title.toLowerCase().includes(lowerQuery) || 
                item.description.toLowerCase().includes(lowerQuery)) {
                results.push(item);
            }
        });
        
        return results;
    }
    
    renderResults(results, query) {
        // Group results by type
        const groupedResults = this.groupResultsByType(results);
        let html = '';
        
        Object.keys(groupedResults).forEach(type => {
            const typeResults = groupedResults[type];
            if (typeResults.length === 0) return;
            
            // Add category header
            html += `<div class="result-category">${this.getCategoryName(type)}</div>`;
            
            // Add results
            typeResults.forEach((result, index) => {
                html += this.renderResultItem(result, query, index);
            });
        });
        
        this.resultsList.innerHTML = html;
        this.selectedIndex = -1;
        
        // Re-initialize feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        // Add click handlers to results
        this.resultsList.querySelectorAll('.result-item').forEach(item => {
            item.addEventListener('click', () => {
                const url = item.dataset.url;
                const action = item.dataset.action;
                
                if (url) {
                    window.location.href = url;
                } else if (action) {
                    this.handleResultAction(action, item.dataset);
                }
                
                this.closeDropdown();
            });
        });
    }
    
    groupResultsByType(results) {
        const grouped = {
            users: [],
            itineraries: [],
            sorties: [],
            content: [],
            settings: []
        };
        
        results.forEach(result => {
            if (grouped[result.type]) {
                grouped[result.type].push(result);
            }
        });
        
        return grouped;
    }
    
    getCategoryName(type) {
        const names = {
            users: 'Utilisateurs',
            itineraries: 'Itinéraires',
            sorties: 'Sorties',
            content: 'Contenu',
            settings: 'Paramètres'
        };
        
        return names[type] || type;
    }
    
    renderResultItem(result, query, index) {
        const avatar = result.avatar 
            ? `<img src="${result.avatar}" alt="Avatar" loading="lazy">`
            : `<i data-feather="${result.icon || 'file'}"></i>`;
            
        const meta = result.meta 
            ? `<div class="result-meta">
                ${result.meta.map(item => `<span class="meta-item">${item}</span>`).join('')}
               </div>`
            : '';
            
        const highlightedTitle = this.highlightText(result.title, query);
        const highlightedDescription = this.highlightText(result.description, query);
        
        return `
            <div class="result-item" 
                 data-url="${result.url || ''}"
                 data-action="${result.action || ''}"
                 data-type="${result.type}">
                 
                <div class="result-avatar ${result.type}">
                    ${avatar}
                </div>
                
                <div class="result-content">
                    <div class="result-title">${highlightedTitle}</div>
                    <div class="result-description">${highlightedDescription}</div>
                    ${meta}
                </div>
                
                <div class="result-actions">
                    <button class="result-action" data-action="open" title="Ouvrir">
                        <i data-feather="external-link"></i>
                    </button>
                </div>
            </div>
        `;
    }
    
    highlightText(text, query) {
        if (!query || query.length < 2) return text;
        
        const regex = new RegExp(`(${this.escapeRegExp(query)})`, 'gi');
        return text.replace(regex, '<span class="highlight">$1</span>');
    }
    
    escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }
    
    showState(state) {
        // Hide all states
        const states = ['loading', 'empty', 'no-results', 'results'];
        states.forEach(s => {
            const element = document.querySelector(`[data-state="${s}"]`);
            if (element) element.hidden = true;
        });
        
        // Show target state
        const targetElement = document.querySelector(`[data-state="${state}"]`);
        if (targetElement) targetElement.hidden = false;
    }
    
    updateSearchStats(count, time) {
        const countElement = document.querySelector('[data-search-count]');
        const timeElement = document.querySelector('[data-search-time]');
        
        if (countElement) {
            countElement.textContent = `${count} résultats`;
            countElement.hidden = false;
        }
        
        if (timeElement && time > 0) {
            timeElement.textContent = `en ${Math.round(time)}ms`;
            timeElement.hidden = false;
        }
    }
    
    setFilter(filter) {
        this.currentFilter = filter;
        
        // Update active filter
        this.filters.forEach(f => {
            f.classList.toggle('active', f.dataset.filter === filter);
        });
        
        // Re-search with new filter
        if (this.currentQuery.length >= 2) {
            this.performSearch(this.currentQuery);
        }
    }
    
    openDropdown() {
        this.dropdown.hidden = false;
        this.isOpen = true;
        
        // Show appropriate initial state
        if (this.currentQuery.length === 0) {
            this.showState('empty');
        }
    }
    
    closeDropdown() {
        this.dropdown.hidden = true;
        this.isOpen = false;
        this.selectedIndex = -1;
    }
    
    clearSearch() {
        this.input.value = '';
        this.currentQuery = '';
        this.clearBtn.hidden = true;
        this.showState('empty');
        this.input.focus();
    }
    
    handleQuickAction(action) {
        switch (action) {
            case 'new-user':
                // Handle new user action
                console.log('New user action');
                break;
            case 'system-health':
                // Handle system health action  
                console.log('System health action');
                break;
            case 'cache-clear':
                this.clearCache();
                break;
            default:
                console.log('Unknown action:', action);
        }
        
        this.closeDropdown();
    }
    
    handleResultAction(action, data) {
        switch (action) {
            case 'open':
                if (data.url) {
                    window.location.href = data.url;
                }
                break;
            default:
                console.log('Unknown result action:', action, data);
        }
    }
    
    async clearCache() {
        try {
            const response = await fetch('/api/admin/cache/clear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            });
            
            if (response.ok) {
                // Show success notification
                if (window.notificationCenter) {
                    window.notificationCenter.showToast('success', 'Cache vidé', 'Le cache a été vidé avec succès');
                }
            }
        } catch (error) {
            console.error('Failed to clear cache:', error);
            if (window.notificationCenter) {
                window.notificationCenter.showToast('error', 'Erreur', 'Impossible de vider le cache');
            }
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.globalSearch = new UltraGlobalSearch();
});
</script>