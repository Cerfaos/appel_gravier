<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-outdoor-olive-500 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:bg-outdoor-olive-600 focus:bg-outdoor-olive-600 active:bg-outdoor-olive-700 focus:outline-none focus:ring-2 focus:ring-outdoor-olive-400 focus:ring-offset-2 transition-all duration-300']) }}>
    {{ $slot }}
</button>
