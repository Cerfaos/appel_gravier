<?php

namespace Database\Seeders;

use App\Models\HomeContent;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            // Section About
            [
                'section' => 'about',
                'key' => 'about_title',
                'title' => 'Titre About',
                'content' => 'Votre partenaire pour des aventures authentiques',
                'description' => 'Titre principal de la section à propos'
            ],
            [
                'section' => 'about',
                'key' => 'about_subtitle',  
                'title' => 'Sous-titre About',
                'content' => 'J\'organise une balade en vélo gravel et ce serait top que tu m\'accompagnes. Pas besoin d\'être un pro, l\'idée est surtout de profiter, découvrir et partager un bon moment.',
                'description' => 'Description principale de la section à propos'
            ],
            [
                'section' => 'about',
                'key' => 'about_image',
                'title' => 'Image About',
                'content' => 'frontend/assets/images/img_cerfaos/hero_about.png',
                'description' => 'Image principale de la section à propos (306x618)'
            ],
            
            // Section Itinéraires
            [
                'section' => 'itineraries',
                'key' => 'itineraries_title',
                'title' => 'Titre Itinéraires',
                'content' => 'Découvrez nos itinéraires GPX',
                'description' => 'Titre principal de la section itinéraires'
            ],
            [
                'section' => 'itineraries',
                'key' => 'itineraries_subtitle',
                'title' => 'Sous-titre Itinéraires',
                'content' => 'Des parcours soigneusement sélectionnés pour tous les niveaux, avec fichiers GPX téléchargeables et informations détaillées.',
                'description' => 'Description de la section itinéraires'
            ],
            
            // Section Sorties
            [
                'section' => 'sorties',
                'key' => 'sorties_title',
                'title' => 'Titre Sorties',
                'content' => 'Nos sorties & expéditions',
                'description' => 'Titre principal de la section sorties'
            ],
            [
                'section' => 'sorties', 
                'key' => 'sorties_subtitle',
                'title' => 'Sous-titre Sorties',
                'content' => 'Rejoignez nos aventures collectives et découvrez de nouveaux horizons en groupe.',
                'description' => 'Description de la section sorties'
            ]
        ];

        foreach ($contents as $content) {
            HomeContent::updateOrCreate(
                ['key' => $content['key']],
                $content
            );
        }
    }
}