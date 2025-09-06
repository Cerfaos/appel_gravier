{{--
  Modern Button Component
  
  Usage:
  <x-ui.button variant="primary" size="lg" :loading="$loading">
    Save Changes
  </x-ui.button>
--}}

@props([
    'variant' => 'primary', // primary, secondary, outline, ghost, danger
    'size' => 'md', // sm, md, lg, xl
    'type' => 'button',
    'href' => null,
    'loading' => false,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'left', // left, right
    'block' => false,
    'external' => false
])

@php
$tag = $href ? 'a' : 'button';

$classes = [
    'btn',
    'btn--' . $variant,
    'btn--' . $size,
    $block ? 'btn--block' : '',
    $loading || $disabled ? 'opacity-50 cursor-not-allowed' : ''
];

$attributes = $attributes->merge(['class' => implode(' ', array_filter($classes))]);

if ($href) {
    $attributes = $attributes->merge(['href' => $href]);
    if ($external) {
        $attributes = $attributes->merge(['target' => '_blank', 'rel' => 'noopener noreferrer']);
    }
} else {
    $attributes = $attributes->merge(['type' => $type]);
    if ($disabled || $loading) {
        $attributes = $attributes->merge(['disabled' => true]);
    }
}
@endphp

<{{ $tag }} {{ $attributes }}>
    @if($loading)
        {{-- Loading Spinner --}}
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Loading...
    @else
        {{-- Icon Left --}}
        @if($icon && $iconPosition === 'left')
            @if(is_string($icon) && strlen($icon) === 1)
                <span class="mr-2">{{ $icon }}</span>
            @else
                <i data-feather="{{ $icon }}" class="w-4 h-4 mr-2"></i>
            @endif
        @endif

        {{-- Button Content --}}
        {{ $slot }}

        {{-- Icon Right --}}
        @if($icon && $iconPosition === 'right')
            @if(is_string($icon) && strlen($icon) === 1)
                <span class="ml-2">{{ $icon }}</span>
            @else
                <i data-feather="{{ $icon }}" class="w-4 h-4 ml-2"></i>
            @endif
        @endif
    @endif
</{{ $tag }}>