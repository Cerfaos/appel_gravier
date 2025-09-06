{{--
 Ultra Stat Card Component
 Usage: @include('admin.components.ultra-stat-card', [
   'icon' => '🏔️',
   'value' => '1,234',
   'label' => 'Visiteurs',
   'trend' => ['direction' => 'up', 'value' => '+15%'],
   'color' => 'success', // success, warning, error, info
   'gradient' => 'nature' // nature, accent, sunset
 ])
--}}

@php
  $icon = $icon ?? '📊';
  $value = $value ?? '0';
  $label = $label ?? 'Statistique';
  $trend = $trend ?? null;
  $color = $color ?? 'primary';
  $gradient = $gradient ?? 'nature';
  $loading = $loading ?? false;
@endphp

<div class="stat-card {{ $loading ? 'shimmer' : '' }}" 
     data-aos="fade-up" 
     data-aos-duration="600">
  
  <!-- Top bar with gradient -->
  <div class="stat-card-top-bar" style="background: var(--gradient-{{ $gradient }});"></div>
  
  <div class="stat-card-header">
    <div class="stat-icon" style="background: var(--gradient-{{ $gradient }});">
      <span role="img" aria-label="{{ $label }} icon">{{ $icon }}</span>
    </div>
    
    @if($trend)
    <div class="stat-trend {{ $trend['direction'] ?? 'neutral' }}">
      @if(($trend['direction'] ?? '') === 'up')
        <i data-feather="trending-up" aria-hidden="true"></i>
      @elseif(($trend['direction'] ?? '') === 'down')
        <i data-feather="trending-down" aria-hidden="true"></i>
      @else
        <i data-feather="minus" aria-hidden="true"></i>
      @endif
      <span>{{ $trend['value'] ?? '' }}</span>
    </div>
    @endif
  </div>
  
  <div class="stat-content">
    <div class="stat-value">{{ $value }}</div>
    <div class="stat-label">{{ $label }}</div>
    
    @if(isset($description))
    <div class="stat-description">{{ $description }}</div>
    @endif
    
    @if(isset($progress))
    <div class="stat-progress">
      <div class="stat-progress-bar">
        <div class="stat-progress-fill" 
             style="width: {{ $progress }}%; background: var(--gradient-{{ $gradient }});"
             data-progress="{{ $progress }}">
        </div>
      </div>
      <div class="stat-progress-text">{{ $progress }}%</div>
    </div>
    @endif
  </div>
  
  @if(isset($actions))
  <div class="stat-actions">
    @foreach($actions as $action)
    <a href="{{ $action['url'] ?? '#' }}" 
       class="stat-action {{ $action['class'] ?? 'ultra-btn-ghost' }}"
       @if(isset($action['target'])) target="{{ $action['target'] }}" @endif>
      @if(isset($action['icon']))
      <i data-feather="{{ $action['icon'] }}" aria-hidden="true"></i>
      @endif
      {{ $action['label'] ?? 'Action' }}
    </a>
    @endforeach
  </div>
  @endif
  
</div>

<!-- Enhanced styles for ultra stat card -->
<style>
  .stat-card {
    position: relative;
    overflow: visible;
    transition: var(--transition-slow);
  }
  
  .stat-card-top-bar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: var(--radius-2xl) var(--radius-2xl) 0 0;
  }
  
  .stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--cerfaos-shadow-xl);
  }
  
  .stat-card:hover .stat-icon {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
  }
  
  .stat-value {
    position: relative;
    overflow: hidden;
  }
  
  .stat-value::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.8s ease;
  }
  
  .stat-card:hover .stat-value::after {
    left: 100%;
  }
  
  .stat-progress {
    margin-top: var(--space-4);
  }
  
  .stat-progress-bar {
    width: 100%;
    height: 8px;
    background: var(--cerfaos-dark-secondary);
    border-radius: var(--radius-full);
    overflow: hidden;
    position: relative;
  }
  
  .stat-progress-fill {
    height: 100%;
    border-radius: var(--radius-full);
    transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
  }
  
  .stat-progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: progress-shine 2s infinite;
  }
  
  @keyframes progress-shine {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
  }
  
  .stat-progress-text {
    font-size: 0.75rem;
    color: var(--cerfaos-text-muted);
    text-align: right;
    margin-top: var(--space-1);
    font-family: var(--font-mono);
  }
  
  .stat-description {
    font-size: 0.8125rem;
    color: var(--cerfaos-text-muted);
    margin-top: var(--space-2);
    line-height: 1.4;
  }
  
  .stat-actions {
    margin-top: var(--space-4);
    display: flex;
    gap: var(--space-2);
    flex-wrap: wrap;
  }
  
  .stat-action {
    font-size: 0.75rem;
    padding: var(--space-2) var(--space-3);
    text-decoration: none;
    border-radius: var(--radius);
    display: inline-flex;
    align-items: center;
    gap: var(--space-1);
    transition: var(--transition);
    background: var(--glass-bg);
    color: var(--cerfaos-text-secondary);
    border: 1px solid var(--cerfaos-border);
  }
  
  .stat-action:hover {
    background: var(--cerfaos-sage);
    color: white;
    transform: translateY(-1px);
    border-color: var(--cerfaos-sage);
  }
  
  .stat-trend.positive {
    animation: trend-positive 2s ease-in-out infinite;
  }
  
  .stat-trend.negative {
    animation: trend-negative 2s ease-in-out infinite;
  }
  
  @keyframes trend-positive {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
  }
  
  @keyframes trend-negative {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(0.95); }
  }
  
  /* Loading state */
  .stat-card.shimmer {
    pointer-events: none;
  }
  
  .stat-card.shimmer .stat-value,
  .stat-card.shimmer .stat-label {
    background: var(--cerfaos-surface-hover);
    color: transparent;
    border-radius: var(--radius);
  }
  
  /* Dark mode optimizations */
  @media (prefers-color-scheme: dark) {
    .stat-card {
      border-color: rgba(255, 255, 255, 0.05);
    }
    
    .stat-progress-bar {
      background: rgba(255, 255, 255, 0.03);
    }
  }
  
  /* Reduced motion support */
  @media (prefers-reduced-motion: reduce) {
    .stat-card,
    .stat-icon,
    .stat-progress-fill {
      transition: none !important;
    }
    
    .stat-progress-fill::after,
    .stat-value::after {
      animation: none !important;
    }
  }
</style>