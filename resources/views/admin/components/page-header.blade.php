{{--
 Composant Page Header Forest Premium
 Usage: @include('admin.components.page-header', [
 'title' => 'Titre de la page',
 'subtitle' => 'Description de la page',
 'icon' => '🏔️',
 'breadcrumb' => [
 ['url' => route('dashboard'), 'label' => 'Dashboard'],
 ['label' => 'Page Actuelle']
 ],
 'actions' => [
 ['url' => '#', 'label' => 'Action', 'class' => 'fp-btn-primary', 'icon' => 'plus']
 ]
 ])
--}}

@php
 $title = $title ?? 'Page';
 $subtitle = $subtitle ?? '';
 $icon = $icon ?? '📄';
 $breadcrumb = $breadcrumb ?? [];
 $actions = $actions ?? [];
@endphp

<!-- Forest Premium Page Header -->
<section>
 <div>
 <div>
 
 <!-- Breadcrumb Navigation -->
 @if(!empty($breadcrumb))
 <nav aria-label="Breadcrumb">
 @foreach($breadcrumb as $index => $item)
 @if($index > 0)
 <span aria-hidden="true">›</span>
 @endif
 
 @if(isset($item['url']) && !$loop->last)
 <a href="{{ $item['url'] }}">
 {{ $item['label'] }}
 </a>
 @else
 <span aria-current="page">
 {{ $item['label'] }}
 </span>
 @endif
 @endforeach
 </nav>
 @endif
 
 <!-- Page Title Section -->
 <div>
 <div>
 <div role="img" aria-label="Page icon">
 {{ $icon }}
 </div>
 <div>
 <h1>{{ $title }}</h1>
 @if($subtitle)
 <p>{{ $subtitle }}</p>
 @endif
 </div>
 </div>
 
 <!-- Page Actions -->
 @if(!empty($actions))
 <div>
 @foreach($actions as $action)
 <a href="{{ $action['url'] ?? '#' }}" 

 @if(isset($action['target'])) target="{{ $action['target'] }}" @endif>
 @if(isset($action['icon']))
 <i data-feather="{{ $action['icon'] }}" aria-hidden="true"></i>
 @endif
 {{ $action['label'] }}
 </a>
 @endforeach
 </div>
 @endif
 </div>
 </div>
 </div>
</section>