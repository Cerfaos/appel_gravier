<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSortieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:sorties,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'departement' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'personal_comment' => 'nullable|string',
            'difficulty_level' => 'required|in:facile,moyen,difficile',
            'status' => 'nullable|in:draft,published',
            'gpx_file' => 'nullable|file|mimes:gpx,xml|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360', // 15MB max
            'new_image_captions.*' => 'nullable|string|max:255',
            'new_featured_image_index' => 'nullable|integer|min:0',
            'existing_images.*.caption' => 'nullable|string|max:255',
            'existing_images.*.is_featured' => 'nullable|in:0,1',
            'existing_images.*.order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'actual_duration_minutes' => 'nullable|integer|min:0|max:1440',
            'weather_conditions' => 'nullable|array',
            'weather_conditions.*' => 'required|string|in:ensoleille,nuageux,pluie,vent,brouillard,neige,orage,chaud,froid',
            'sortie_date' => 'nullable|date',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'id.required' => 'L\'identifiant de la sortie est obligatoire.',
            'id.exists' => 'La sortie spécifiée n\'existe pas.',
            'title.required' => 'Le titre est obligatoire.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'difficulty_level.required' => 'Le niveau de difficulté est obligatoire.',
            'difficulty_level.in' => 'Le niveau de difficulté doit être facile, moyen ou difficile.',
            'gpx_file.mimes' => 'Le fichier doit être au format GPX.',
            'gpx_file.max' => 'Le fichier GPX ne peut pas dépasser 2MB.',
            'images.*.image' => 'Les fichiers doivent être des images.',
            'images.*.mimes' => 'Les images doivent être au format JPEG, PNG, JPG, GIF ou WebP.',
            'images.*.max' => 'Chaque image ne peut pas dépasser 15MB.',
            'meta_title.max' => 'Le titre SEO ne peut pas dépasser 255 caractères.',
            'meta_description.max' => 'La description SEO ne peut pas dépasser 500 caractères.',
            'actual_duration_minutes.integer' => 'La durée réelle doit être un nombre entier.',
            'actual_duration_minutes.min' => 'La durée réelle ne peut pas être négative.',
            'actual_duration_minutes.max' => 'La durée réelle ne peut pas dépasser 24 heures (1440 minutes).',
            'weather_conditions.array' => 'Les conditions météo doivent être un tableau.',
            'weather_conditions.*.required' => 'Chaque condition météo est obligatoire.',
            'weather_conditions.*.in' => 'Condition météo non valide.',
            'sortie_date.date' => 'La date de sortie doit être une date valide.',
        ];
    }
}