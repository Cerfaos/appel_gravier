{{--
 Composant Action Card Forest Premium
 Usage: @include('admin.components.action-card', [
 'icon' => '🎯',
 'title' => 'Mon Profil',
 'description' => 'Gérer vos informations',
 'url' => route('admin.profile'),
 'class' => 'primary' // optionnel
 ])
--}}

@php
 $icon = $icon ?? '🔧';
 $title = $title ?? 'Action';
 $description = $description ?? '';
 $url = $url ?? '#';
 $cardClass = $class ?? '';
 $target = $target ?? null;
@endphp

<a href="{{ $url }}" 

 @if($target) target="{{ $target }}" @endif
 role="button"
 aria-label="{{ $title }}: {{ $description }}">
 
 <div role="img" aria-hidden="true">
 <span>{{ $icon }}</span>
 </div>
 
 <div>
 <h3>{{ $title }}</h3>
 @if($description)
 <p>{{ $description }}</p>
 @endif
 </div>
 
 <div aria-hidden="true">
 <i data-feather="arrow-right"></i>
 </div>
</a>