{{--
 Composant Stat Card Forest Premium
 Usage: @include('admin.components.stat-card', [
 'icon' => '📊',
 'value' => '1,234',
 'label' => 'Visiteurs',
 'trend' => ['direction' => 'up', 'value' => '+15%'],
 'period' => 'Ce mois',
 'class' => 'premium' // optionnel
 ])
--}}

@php
 $icon = $icon ?? '📊';
 $value = $value ?? '0';
 $label = $label ?? 'Statistique';
 $trend = $trend ?? null;
 $period = $period ?? '';
 $cardClass = $class ?? '';
@endphp

<div>
 <div>
 <div role="img" aria-label="{{ $label }} icon">
 {{ $icon }}
 </div>
 
 @if($trend)
 <div 
 aria-label="Tendance {{ $trend['direction'] ?? 'neutre' }}: {{ $trend['value'] ?? '' }}">
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
 
 <div>
 <div>{{ $value }}</div>
 <div>{{ $label }}</div>
 @if($period)
 <div>{{ $period }}</div>
 @endif
 </div>
</div>