<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSortieRequest extends FormRequest
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
            'departement' => 'nullable|string|max:100',
            'pays' => 'nullable|string|max:100|alpha',
            'personal_comment' => 'nullable|string|max:2000',
            'difficulty_level' => 'required|in:facile,moyen,difficile',
            'gpx_file' => 'nullable|file|mimes:xml,gpx|max:5120',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240|dimensions:min_width=300,min_height=300,max_width=4000,max_height=4000',
            'image_captions.*' => 'nullable|string|max:255',
            'featured_image_index' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'actual_duration_minutes' => 'nullable|integer|min:0|max:1440',
            'weather_conditions' => 'nullable|array|max:5',
            'weather_conditions.*' => 'required|string|in:ensoleille,nuageux,pluie,vent,brouillard,neige,orage,chaud,froid',
            'sortie_date' => 'nullable|date|before_or_equal:today',
            'status' => 'nullable|in:draft,published',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'title.min' => 'Le titre doit contenir au moins 3 caractères.',
            'description.required' => 'La description est obligatoire.',
            'description.min' => 'La description doit contenir au moins 10 caractères.',
            'description.max' => 'La description ne peut pas dépasser 5000 caractères.',
            'pays.alpha' => 'Le pays ne peut contenir que des lettres.',
            'difficulty_level.required' => 'Le niveau de difficulté est obligatoire.',
            'difficulty_level.in' => 'Le niveau de difficulté doit être facile, moyen ou difficile.',
            'gpx_file.max' => 'Le fichier GPX ne peut pas dépasser 5MB.',
            'images.*.dimensions' => 'Les images doivent avoir une résolution entre 300x300 et 4000x4000 pixels.',
            'images.*.max' => 'Chaque image ne peut pas dépasser 10MB.',
            'meta_title.max' => 'Le titre SEO ne peut pas dépasser 60 caractères.',
            'meta_description.max' => 'La description SEO ne peut pas dépasser 160 caractères.',
            'actual_duration_minutes.integer' => 'La durée réelle doit être un nombre entier.',
            'actual_duration_minutes.min' => 'La durée réelle ne peut pas être négative.',
            'actual_duration_minutes.max' => 'La durée réelle ne peut pas dépasser 24 heures (1440 minutes).',
            'weather_conditions.array' => 'Les conditions météo doivent être un tableau.',
            'weather_conditions.max' => 'Vous ne pouvez sélectionner que 5 conditions météo maximum.',
            'weather_conditions.*.required' => 'Chaque condition météo est obligatoire.',
            'weather_conditions.*.in' => 'Condition météo non valide.',
            'sortie_date.date' => 'La date de sortie doit être une date valide.',
            'sortie_date.before_or_equal' => 'La date de sortie ne peut pas être dans le futur.',
        ];
    }
}