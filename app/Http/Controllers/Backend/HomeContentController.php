<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeContent;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class HomeContentController extends Controller
{
    // Afficher la page de gestion des contenus de la page d'accueil
    public function index()
    {
        // Récupérer tous les contenus groupés par section
        $contents = HomeContent::orderBy('section')->orderBy('key')->get()->groupBy('section');
        
        // Récupérer les sliders
        $sliders = Slider::all();
        
        return view('admin.backend.home_content.index', compact('contents', 'sliders'));
    }

    // Afficher le formulaire d'édition d'un contenu spécifique
    public function edit($id)
    {
        $content = HomeContent::findOrFail($id);
        return view('admin.backend.home_content.edit', compact('content'));
    }

    // Mettre à jour un contenu
    public function update(Request $request, $id)
    {
        $content = HomeContent::findOrFail($id);
        
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->only(['title', 'content', 'description']);

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($content->image && Storage::disk('public')->exists($content->image)) {
                Storage::disk('public')->delete($content->image);
            }

            // Upload de la nouvelle image
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'upload/home_content/' . $imageName;

            // Créer le répertoire s'il n'existe pas
            if (!Storage::disk('public')->exists('upload/home_content/')) {
                Storage::disk('public')->makeDirectory('upload/home_content/');
            }

            // Pour l'image about qui doit être en 306x618
            if ($content->key === 'about_image') {
                $img = Image::make($image->getRealPath());
                $img->resize(306, 618, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save(storage_path('app/public/' . $imagePath));
            } else {
                // Pour les autres images, simple upload
                $image->storeAs('upload/home_content', $imageName, 'public');
            }

            $data['image'] = $imagePath;
        }

        $content->update($data);

        return redirect()->route('admin.home-content.index')
                         ->with('success', 'Contenu mis à jour avec succès');
    }

    // Gestion des sliders (existant)
    public function editSlider($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.backend.home_content.edit_slider', compact('slider'));
    }

    public function updateSlider(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->only(['title', 'description', 'link']);

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($slider->image && $slider->image !== 'upload/no_image.jpg' && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            // Upload de la nouvelle image
            $image = $request->file('image');
            $imageName = time() . '_slider_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'upload/slider/' . $imageName;

            // Créer le répertoire s'il n'existe pas
            if (!Storage::disk('public')->exists('upload/slider/')) {
                Storage::disk('public')->makeDirectory('upload/slider/');
            }

            $image->storeAs('upload/slider', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        $slider->update($data);

        return redirect()->route('admin.home-content.index')
                         ->with('success', 'Slider mis à jour avec succès');
    }
}