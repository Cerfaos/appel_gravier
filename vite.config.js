import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/modules/gpx-uploader.js',
                'resources/js/modules/enhanced-forms.js',
                'resources/js/modules/map-integration.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    // Vendor chunks for better caching
                    'vendor-alpine': ['alpinejs'],
                    'vendor-leaflet': ['leaflet'],
                    
                    // Feature-based chunks
                    'forms': ['./resources/js/modules/enhanced-forms.js'],
                    'gpx': ['./resources/js/modules/gpx-uploader.js'],
                    'maps': ['./resources/js/modules/map-integration.js'],
                    
                    // Admin chunks
                    'admin-components': [
                        './resources/js/modules/admin-dashboard.js',
                        './resources/js/modules/data-tables.js'
                    ]
                },
                // Optimize asset naming
                entryFileNames: 'js/[name]-[hash].js',
                chunkFileNames: 'js/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'css/[name]-[hash].css';
                    }
                    return 'assets/[name]-[hash][extname]';
                }
            }
        },
        // Enable source maps for debugging
        sourcemap: process.env.NODE_ENV === 'development'
    },
    optimizeDeps: {
        include: [
            'alpinejs',
            'leaflet'
        ],
        exclude: [
            // Exclude heavy development dependencies
        ]
    },
    css: {
        devSourcemap: true
    },
    server: {
        hmr: {
            host: 'localhost'
        }
    }
});
    