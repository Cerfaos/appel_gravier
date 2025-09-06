<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnhancedStoreItineraryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:3',
            'description' => 'required|string|min:10|max:5000',
            'personal_comment' => 'nullable|string|max:2000',
            'difficulty_level' => 'required|in:facile,moyen,difficile,expert',
            
            // Enhanced GPX file validation
            'gpx_file' => [
                'nullable',
                'file',
                'mimes:xml,gpx',
                'max:5120', // 5MB in KB
            ],
            
            // Enhanced image validation
            'images' => [
                'nullable',
                'array'
            ],
            'images.*' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:10240', // 10MB in KB
                'dimensions:min_width=300,min_height=300,max_width=4000,max_height=4000',
            ],
            
            'image_captions.*' => 'nullable|string|max:255',
            'featured_image_index' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:60', // SEO optimal length
            'meta_description' => 'nullable|string|max:160', // SEO optimal length
            'departement' => 'nullable|string|max:100',
            'pays' => 'nullable|string|max:100|alpha',
            'status' => 'nullable|in:draft,published',
        ];
    }

    public function messages(): array
    {
        return [
            'title.min' => 'Le titre doit contenir au moins 3 caractères.',
            'description.min' => 'La description doit contenir au moins 10 caractères.',
            'description.max' => 'La description ne peut pas dépasser 5000 caractères.',
            'gpx_file.max' => 'Le fichier GPX ne peut pas dépasser 5MB.',
            'images.*.dimensions' => 'Les images doivent avoir une résolution entre 300x300 et 4000x4000 pixels.',
            'meta_title.max' => 'Le titre SEO ne peut pas dépasser 60 caractères (optimal pour le référencement).',
            'meta_description.max' => 'La description SEO ne peut pas dépasser 160 caractères (optimal pour le référencement).',
            'pays.alpha' => 'Le pays ne peut contenir que des lettres.',
        ];
    }

    /**
     * Additional security validation after basic rules
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check for suspicious file content
            if ($this->hasFile('gpx_file')) {
                $content = file_get_contents($this->file('gpx_file')->getRealPath());
                if ($this->containsSuspiciousContent($content)) {
                    $validator->errors()->add('gpx_file', 'Le fichier GPX contient du contenu suspect.');
                }
            }
        });
    }

    private function containsSuspiciousContent($content): bool
    {
        $suspiciousPatterns = [
            '/<script[^>]*>.*?<\/script>/is',
            '/javascript:/i',
            '/on\w+\s*=/i',
            '/<iframe/i',
            '/<object/i',
            '/<embed/i',
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }
}