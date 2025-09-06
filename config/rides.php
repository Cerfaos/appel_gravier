<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ride Storage Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration centralisée pour les chemins de stockage des sorties
    |
    */

    'storage' => [
        'rides' => [
            'images' => 'storage/rides/images',
            'covers' => 'storage/rides/covers', 
            'gpx' => 'storage/rides/gpx',
        ],
        'thumbnails' => [
            'small' => 'storage/rides/thumbnails/small',   // 150x150
            'medium' => 'storage/rides/thumbnails/medium', // 300x300
            'large' => 'storage/rides/thumbnails/large',   // 600x600
        ],
    ],

    'upload' => [
        'max_images' => 12,
        'max_image_size' => 12288, // 12MB en KB
        'max_gpx_size' => 10240,   // 10MB en KB
        'allowed_image_types' => ['jpg', 'jpeg', 'png', 'webp'],
        'image_quality' => 85,
        'generate_thumbnails' => true,
    ],

    'image_processing' => [
        'max_width' => 2000,
        'max_height' => 2000,
        'thumbnail_sizes' => [
            'small' => 150,
            'medium' => 300,
            'large' => 600,
        ],
    ],
];