<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white border border-outdoor-cream-300 rounded-xl font-semibold text-sm text-outdoor-forest-600 tracking-wide shadow-outdoor-sm hover:bg-outdoor-cream-50 hover:border-outdoor-olive-300 focus:outline-none focus:ring-2 focus:ring-outdoor-olive-400 focus:ring-offset-2 disabled:opacity-25 transition-all duration-300']) }}>
    {{ $slot }}
</button>
