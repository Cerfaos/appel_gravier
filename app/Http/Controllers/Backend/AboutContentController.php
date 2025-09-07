<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeContent;
use Illuminate\Http\Request;

class AboutContentController extends Controller
{
    public function index()
    {
        $aboutContents = HomeContent::where('section', 'about')->orderBy('key')->get()->groupBy(function ($item) {
            if (str_contains($item->key, 'feature_1')) return 'Feature 1';
            if (str_contains($item->key, 'feature_2')) return 'Feature 2';
            if (str_contains($item->key, 'feature_3')) return 'Feature 3';
            return 'Général';
        });

        // Calculs de statistiques pour le dashboard
        $stats = [
            'total_items' => HomeContent::where('section', 'about')->count(),
            'last_updated' => HomeContent::where('section', 'about')->latest('updated_at')->first()?->updated_at,
            'features_count' => HomeContent::where('section', 'about')->where('key', 'like', '%feature_%')->count() / 3, // 3 champs par feature
        ];

        return view('admin.backend.about_content.index', compact('aboutContents', 'stats'));
    }

    public function edit($key)
    {
        $content = HomeContent::where('key', $key)->firstOrFail();
        return view('admin.backend.about_content.edit', compact('content'));
    }

    public function update(Request $request, $key)
    {
        $content = HomeContent::where('key', $key)->firstOrFail();

        // Handle image upload if this is an image field
        if ($key === 'about_image' && $request->hasFile('image_file')) {
            $request->validate([
                'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            // Delete old image if it's not the default one
            if ($content->content && 
                $content->content !== 'frontend/assets/images/img_cerfaos/hero_about.png' && 
                !str_contains($content->content, 'frontend/assets/')) {
                $oldImagePath = base_path($content->content);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Create upload directory if it doesn't exist
            $uploadDir = base_path('upload/about');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Store new image
            $file = $request->file('image_file');
            $imageName = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->move($uploadDir, $imageName);
            $imagePath = 'upload/about/' . $imageName;
            $content->update(['content' => $imagePath]);
            
            session()->flash('success', 'Image mise à jour avec succès !');
        } else {
            // Handle text content
            $request->validate([
                'content' => 'required|string',
            ]);
            
            $content->update(['content' => $request->content]);
            
            session()->flash('success', 'Contenu mis à jour avec succès !');
        }

        return redirect()->route('about.content.index');
    }

    /**
     * Réinitialiser les données à leurs valeurs par défaut
     */
    public function reset()
    {
        try {
            // Supprimer toutes les données about existantes
            HomeContent::where('section', 'about')->delete();

            // Recréer les données par défaut
            $this->createDefaultAboutData();

            session()->flash('success', 'Section "À Propos" réinitialisée avec succès !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la réinitialisation : ' . $e->getMessage());
        }

        return redirect()->route('about.content.index');
    }

    /**
     * Aperçu de la section About (pour voir le rendu final)
     */
    public function preview()
    {
        $aboutData = HomeContent::where('section', 'about')->get()->keyBy('key');
        return view('admin.backend.about_content.preview', compact('aboutData'));
    }

    /**
     * Créer les données par défaut
     */
    private function createDefaultAboutData()
    {
        $defaultData = [
            [
                'section' => 'about',
                'key' => 'about_title',
                'title' => 'Titre principal',
                'description' => 'Le titre principal de la section à propos',
                'content' => 'Découvrez l\'Aventure Outdoor avec Cerfaos'
            ],
            [
                'section' => 'about',
                'key' => 'about_subtitle',
                'title' => 'Sous-titre / Description',
                'description' => 'Description générale de la section à propos',
                'content' => 'Depuis plus de 10 ans, nous vous accompagnons dans vos aventures outdoor. De la randonnée pédestre aux expéditions gravel, découvrez la nature sous toutes ses formes avec nos guides experts.'
            ],
            [
                'section' => 'about',
                'key' => 'about_image',
                'title' => 'Image principale',
                'description' => 'L\'image principale de la section à propos',
                'content' => 'frontend/assets/images/img_cerfaos/hero_about.png'
            ],
            // Feature 1
            [
                'section' => 'about',
                'key' => 'about_feature_1_icon',
                'title' => 'Icône Feature 1',
                'description' => 'Icône de la première fonctionnalité',
                'content' => '🏔️'
            ],
            [
                'section' => 'about',
                'key' => 'about_feature_1_title',
                'title' => 'Titre Feature 1',
                'description' => 'Titre de la première fonctionnalité',
                'content' => 'Guides Experts'
            ],
            [
                'section' => 'about',
                'key' => 'about_feature_1_description',
                'title' => 'Description Feature 1',
                'description' => 'Description de la première fonctionnalité',
                'content' => 'Nos guides certifiés vous accompagnent en toute sécurité sur les plus beaux sentiers de la région.'
            ],
            // Feature 2
            [
                'section' => 'about',
                'key' => 'about_feature_2_icon',
                'title' => 'Icône Feature 2',
                'description' => 'Icône de la deuxième fonctionnalité',
                'content' => '🎒'
            ],
            [
                'section' => 'about',
                'key' => 'about_feature_2_title',
                'title' => 'Titre Feature 2',
                'description' => 'Titre de la deuxième fonctionnalité',
                'content' => 'Équipement Pro'
            ],
            [
                'section' => 'about',
                'key' => 'about_feature_2_description',
                'title' => 'Description Feature 2',
                'description' => 'Description de la deuxième fonctionnalité',
                'content' => 'Matériel de haute qualité fourni pour garantir votre confort et votre sécurité durant l\'aventure.'
            ],
            // Feature 3
            [
                'section' => 'about',
                'key' => 'about_feature_3_icon',
                'title' => 'Icône Feature 3',
                'description' => 'Icône de la troisième fonctionnalité',
                'content' => '🌿'
            ],
            [
                'section' => 'about',
                'key' => 'about_feature_3_title',
                'title' => 'Titre Feature 3',
                'description' => 'Titre de la troisième fonctionnalité',
                'content' => 'Respect Nature'
            ],
            [
                'section' => 'about',
                'key' => 'about_feature_3_description',
                'title' => 'Description Feature 3',
                'description' => 'Description de la troisième fonctionnalité',
                'content' => 'Approche éco-responsable pour préserver les environnements naturels que nous explorons ensemble.'
            ]
        ];

        foreach ($defaultData as $item) {
            HomeContent::create($item);
        }
    }
}