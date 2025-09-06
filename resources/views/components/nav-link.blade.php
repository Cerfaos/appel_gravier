@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl bg-outdoor-olive-100 text-outdoor-olive-700 focus:outline-none focus:ring-2 focus:ring-outdoor-olive-400 transition-all duration-300'
            : 'inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl text-outdoor-forest-600 hover:text-outdoor-olive-600 hover:bg-outdoor-cream-100 focus:outline-none focus:text-outdoor-olive-600 focus:bg-outdoor-cream-100 transition-all duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
