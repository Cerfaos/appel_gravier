{{--
  Modern Card Component
  
  Usage:
  <x-ui.card variant="elevated" :interactive="true">
    <x-slot:header>
      <h3>Card Title</h3>
    </x-slot:header>
    
    <p>Card content goes here...</p>
    
    <x-slot:footer>
      <x-ui.button>Action</x-ui.button>
    </x-slot:footer>
  </x-ui.card>
--}}

@props([
    'variant' => 'default', // default, elevated, interactive
    'padding' => true,
    'interactive' => false,
    'href' => null
])

@php
$tag = $href ? 'a' : 'div';

$classes = [
    'card',
    $variant !== 'default' ? 'card--' . $variant : '',
    $interactive ? 'card--interactive' : ''
];

$attributes = $attributes->merge(['class' => implode(' ', array_filter($classes))]);

if ($href) {
    $attributes = $attributes->merge(['href' => $href]);
}
@endphp

<{{ $tag }} {{ $attributes }}>
    @isset($header)
    <div class="card__header">
        {{ $header }}
    </div>
    @endisset

    <div class="card__content">
        {{ $slot }}
    </div>

    @isset($footer)
    <div class="card__footer">
        {{ $footer }}
    </div>
    @endisset
</{{ $tag }}>