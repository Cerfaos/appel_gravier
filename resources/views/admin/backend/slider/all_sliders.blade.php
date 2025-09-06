@extends('admin.admin_master_outdoor')
@section('admin')

<div class="outdoor-page-wrapper">
    <!-- Header Section -->
    <div class="outdoor-page-header">
        <div class="header-content">
            <div class="header-left">
                <div class="page-icon">🎬</div>
                <div class="header-info">
                    <h1 class="page-title">Gestion des Sliders</h1>
                    <p class="page-subtitle">Gérez tous les sliders de votre site web</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('get.slider') }}" class="btn-primary">
                    <i data-feather="edit-3"></i>
                    Modifier le Slider Principal
                </a>
                <a href="{{ route('dashboard') }}" class="btn-secondary">
                    <i data-feather="arrow-left"></i>
                    Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <div class="stat-value">{{ $sliders->count() }}</div>
                <div class="stat-label">Sliders Total</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <div class="stat-value">{{ $sliders->count() }}</div>
                <div class="stat-label">Actifs</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-content">
                <div class="stat-value">{{ $sliders->first()?->updated_at?->format('d/m') ?? '-' }}</div>
                <div class="stat-label">Dernière MAJ</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎯</div>
            <div class="stat-content">
                <div class="stat-value">100%</div>
                <div class="stat-label">Performance</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-card">
        <div class="card-header">
            <div class="card-header-icon">📋</div>
            <div class="card-header-content">
                <h3 class="card-title">Liste des Sliders</h3>
                <p class="card-subtitle">Visualisez et gérez tous vos sliders</p>
            </div>
            <div class="header-actions">
                <button class="btn-icon" onclick="refreshTable()" title="Actualiser">
                    <i data-feather="refresh-cw"></i>
                </button>
            </div>
        </div>

        @if($sliders->isEmpty())
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">🎬</div>
            <h3 class="empty-title">Aucun slider trouvé</h3>
            <p class="empty-description">Commencez par créer votre premier slider pour présenter votre contenu.</p>
            <a href="{{ route('get.slider') }}" class="btn-primary">
                <i data-feather="plus"></i>
                Créer un Slider
            </a>
        </div>
        @else
        <!-- Sliders Grid -->
        <div class="sliders-grid">
            @foreach($sliders as $slider)
            <div class="slider-card" data-slider-id="{{ $slider->id }}">
                <div class="slider-image">
                    <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}" class="slider-thumb">
                    <div class="slider-overlay">
                        <div class="slider-actions">
                            <a href="{{ route('get.slider') }}" class="action-btn edit-btn" title="Modifier">
                                <i data-feather="edit-2"></i>
                            </a>
                            <button class="action-btn preview-btn" onclick="previewSlider({{ $slider->id }})" title="Aperçu">
                                <i data-feather="eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="slider-status">
                        <span class="status-badge active">Actif</span>
                    </div>
                </div>
                
                <div class="slider-content">
                    <h4 class="slider-title">{{ $slider->title }}</h4>
                    <p class="slider-description">{{ Str::limit($slider->description, 100) }}</p>
                    
                    <div class="slider-meta">
                        <div class="meta-item">
                            <i data-feather="calendar"></i>
                            <span>{{ $slider->updated_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i data-feather="link"></i>
                            <span>{{ Str::limit($slider->link, 30) }}</span>
                        </div>
                    </div>
                    
                    <div class="slider-footer">
                        <div class="slider-stats">
                            <span class="stat">ID: {{ $slider->id }}</span>
                        </div>
                        <a href="{{ route('get.slider') }}" class="btn-sm btn-primary">
                            Modifier
                            <i data-feather="arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="modal-overlay" onclick="closeModal()">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 class="modal-title">Aperçu du Slider</h3>
            <button class="modal-close" onclick="closeModal()">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="modal-body">
            <div id="modalPreviewContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
/* Variables CSS */
:root {
    --outdoor-primary: #606c38;
    --outdoor-primary-dark: #495029;
    --outdoor-secondary: #dda15e;
    --outdoor-accent: #bc6c25;
    --outdoor-success: #2d5016;
    --outdoor-light: #fefae0;
    --outdoor-gray: #8b8c89;
    --outdoor-dark: #283618;
    --border-radius: 12px;
    --shadow-soft: 0 4px 20px rgba(0,0,0,0.08);
    --shadow-hover: 0 8px 32px rgba(0,0,0,0.12);
}

/* Page Layout */
.outdoor-page-wrapper {
    padding: 24px;
    max-width: 1400px;
    margin: 0 auto;
}

.outdoor-page-header {
    background: linear-gradient(135deg, var(--outdoor-primary) 0%, var(--outdoor-primary-dark) 100%);
    border-radius: var(--border-radius);
    padding: 32px;
    margin-bottom: 32px;
    color: white;
    box-shadow: var(--shadow-soft);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

.page-icon {
    font-size: 48px;
    background: rgba(255,255,255,0.1);
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--border-radius);
    backdrop-filter: blur(10px);
}

.header-info h1 {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 8px 0;
    letter-spacing: -0.5px;
}

.page-subtitle {
    font-size: 16px;
    opacity: 0.9;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Buttons */
.btn-primary, .btn-secondary, .btn-icon {
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
}

.btn-primary:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-1px);
}

.btn-secondary {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.9);
}

.btn-secondary:hover {
    background: rgba(255,255,255,0.2);
}

.btn-icon {
    width: 44px;
    height: 44px;
    padding: 0;
    justify-content: center;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    color: white;
}

.btn-icon:hover {
    background: rgba(255,255,255,0.2);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: white;
    border-radius: var(--border-radius);
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow-soft);
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    font-size: 32px;
    background: var(--outdoor-light);
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: var(--outdoor-primary);
    line-height: 1;
}

.stat-label {
    font-size: 14px;
    color: var(--outdoor-gray);
    margin-top: 4px;
}

/* Content Card */
.content-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-soft);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 24px 32px;
    display: flex;
    align-items: center;
    gap: 16px;
    border-bottom: 1px solid #dee2e6;
}

.card-header-icon {
    font-size: 24px;
    background: white;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card-header-content {
    flex: 1;
}

.card-title {
    font-size: 20px;
    font-weight: 600;
    margin: 0;
    color: var(--outdoor-dark);
}

.card-subtitle {
    font-size: 14px;
    color: var(--outdoor-gray);
    margin: 4px 0 0 0;
}

/* Empty State */
.empty-state {
    padding: 80px 40px;
    text-align: center;
}

.empty-icon {
    font-size: 80px;
    margin-bottom: 24px;
    opacity: 0.6;
}

.empty-title {
    font-size: 24px;
    font-weight: 600;
    color: var(--outdoor-dark);
    margin: 0 0 12px 0;
}

.empty-description {
    font-size: 16px;
    color: var(--outdoor-gray);
    margin: 0 0 32px 0;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

/* Sliders Grid */
.sliders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 24px;
    padding: 32px;
}

.slider-card {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-soft);
    transition: all 0.3s ease;
    border: 1px solid #f1f3f4;
}

.slider-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-hover);
}

.slider-image {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
}

.slider-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.slider-card:hover .slider-thumb {
    transform: scale(1.05);
}

.slider-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.slider-card:hover .slider-overlay {
    opacity: 1;
}

.slider-actions {
    display: flex;
    gap: 12px;
}

.action-btn {
    width: 44px;
    height: 44px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    cursor: pointer;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
}

.action-btn:hover {
    background: rgba(255,255,255,0.25);
    transform: scale(1.1);
}

.slider-status {
    position: absolute;
    top: 16px;
    right: 16px;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.active {
    background: var(--outdoor-success);
    color: white;
}

.slider-content {
    padding: 24px;
}

.slider-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--outdoor-dark);
    margin: 0 0 8px 0;
    line-height: 1.3;
}

.slider-description {
    font-size: 14px;
    color: var(--outdoor-gray);
    line-height: 1.5;
    margin: 0 0 16px 0;
}

.slider-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 20px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--outdoor-gray);
}

.meta-item svg {
    width: 14px;
    height: 14px;
}

.slider-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 20px;
    border-top: 1px solid #f1f3f4;
}

.slider-stats {
    font-size: 12px;
    color: var(--outdoor-gray);
}

.btn-sm {
    padding: 8px 16px;
    font-size: 13px;
    background: var(--outdoor-primary);
    color: white;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.btn-sm:hover {
    background: var(--outdoor-primary-dark);
    transform: translateY(-1px);
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: white;
    border-radius: var(--border-radius);
    max-width: 90vw;
    max-height: 90vh;
    overflow: hidden;
    transform: scale(0.9);
    transition: transform 0.3s ease;
}

.modal-overlay.active .modal-content {
    transform: scale(1);
}

.modal-header {
    padding: 24px 32px;
    border-bottom: 1px solid #e1e5e9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-title {
    font-size: 20px;
    font-weight: 600;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    padding: 8px;
    border-radius: 4px;
    transition: background 0.2s ease;
}

.modal-close:hover {
    background: #f8f9fa;
}

.modal-body {
    padding: 32px;
    max-height: 70vh;
    overflow-y: auto;
}

/* Responsive */
@media (max-width: 768px) {
    .outdoor-page-wrapper {
        padding: 16px;
    }
    
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    
    .header-actions {
        width: 100%;
        justify-content: flex-start;
    }
    
    .sliders-grid {
        grid-template-columns: 1fr;
        padding: 24px;
    }
}
</style>

<!-- Scripts -->
<script>
function refreshTable() {
    location.reload();
}

function previewSlider(sliderId) {
    // This would typically make an AJAX request to get slider data
    // For now, we'll show a simple preview
    const modal = document.getElementById('previewModal');
    const content = document.getElementById('modalPreviewContent');
    
    // Find the slider card
    const sliderCard = document.querySelector(`[data-slider-id="${sliderId}"]`);
    if (sliderCard) {
        const title = sliderCard.querySelector('.slider-title').textContent;
        const description = sliderCard.querySelector('.slider-description').textContent;
        const image = sliderCard.querySelector('.slider-thumb').src;
        
        content.innerHTML = `
            <div style="max-width: 600px;">
                <div style="aspect-ratio: 16/9; border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                    <img src="${image}" alt="${title}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <h3 style="font-size: 24px; font-weight: 600; margin-bottom: 12px; color: var(--outdoor-dark);">${title}</h3>
                <p style="font-size: 16px; color: var(--outdoor-gray); line-height: 1.6;">${description}</p>
            </div>
        `;
    }
    
    modal.classList.add('active');
}

function closeModal() {
    const modal = document.getElementById('previewModal');
    modal.classList.remove('active');
}

// Initialize Feather icons when page loads
document.addEventListener('DOMContentLoaded', function() {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection