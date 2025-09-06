<?php

return [
    /*
    |--------------------------------------------------------------------------
    | TinyMCE API Key
    |--------------------------------------------------------------------------
    |
    | Votre clé API TinyMCE depuis tiny.cloud
    | Configurée dans le fichier .env
    |
    */
    'api_key' => env('TINYMCE_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | TinyMCE Configuration par défaut
    |--------------------------------------------------------------------------
    |
    | Configuration par défaut pour TinyMCE adaptée au projet Cerfaos
    |
    */
    'config' => [
        'height' => 450,
        'plugins' => [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons'
        ],
        'toolbar' => 'undo redo | blocks fontfamily fontsize | ' .
                    'bold italic underline strikethrough | forecolor backcolor | ' .
                    'alignleft aligncenter alignright alignjustify | ' .
                    'bullist numlist outdent indent | blockquote | ' .
                    'removeformat | link image media table emoticons | ' .
                    'code preview fullscreen | help',
        'menubar' => 'file edit view insert format tools table help',
        'branding' => false,
        'language' => 'fr_FR',
        
        // Style du contenu avec thème Forest Premium
        'content_style' => 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 16px; line-height: 1.6; color: #2d5016; } h1,h2,h3,h4,h5,h6 { color: #2d5016; font-weight: 600; } blockquote { border-left: 4px solid #606c38; padding-left: 16px; margin-left: 0; font-style: italic; background: #fefae0; padding: 12px 16px; border-radius: 4px; }',
        
        // Couleurs personnalisées Forest Premium
        'color_map' => [
            '#606c38', 'Olive (Primary)',
            '#2d5016', 'Forest (Dark)',
            '#4a5429', 'Sage (Medium)', 
            '#dda15e', 'Ochre (Accent)',
            '#bc6c25', 'Earth (Secondary)',
            '#fefae0', 'Cream (Light)',
            '#f4f3ee', 'Sand (Background)'
        ],
        
        // Configuration des images
        'image_advtab' => true,
        'image_caption' => true,
        'file_picker_types' => 'image',
        'automatic_uploads' => true,
        'paste_data_images' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Domaines autorisés
    |--------------------------------------------------------------------------
    |
    | Liste des domaines autorisés pour cette clé API
    |
    */
    'allowed_domains' => [
        'localhost',
        '127.0.0.1',
        'cerfaos.test',
        env('APP_URL', 'http://localhost'),
    ]
];