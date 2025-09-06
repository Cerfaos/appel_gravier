@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-3 rounded-xl text-start text-base font-medium text-outdoor-olive-700 bg-outdoor-olive-100 focus:outline-none focus:text-outdoor-olive-800 focus:bg-outdoor-olive-200 transition-all duration-300'
            : 'block w-full px-4 py-3 rounded-xl text-start text-base font-medium text-outdoor-forest-600 hover:text-outdoor-olive-600 hover:bg-outdoor-cream-100 focus:outline-none focus:text-outdoor-olive-600 focus:bg-outdoor-cream-100 transition-all duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
