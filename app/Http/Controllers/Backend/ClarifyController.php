<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Clarify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClarifyController extends Controller
{
    public function index()
    {
        $clarifies = Clarify::latest()->get();
        return view('admin.backend.clarify.all_clarify', compact('clarifies'));
    }

    public function create()
    {
        return view('admin.backend.clarify.add_clarify');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'feature_1_icon' => 'nullable|string',
            'feature_1_title' => 'nullable|string|max:255',
            'feature_1_description' => 'nullable|string',
            'feature_2_icon' => 'nullable|string',
            'feature_2_title' => 'nullable|string|max:255',
            'feature_2_description' => 'nullable|string',
            'feature_3_icon' => 'nullable|string',
            'feature_3_title' => 'nullable|string|max:255',
            'feature_3_description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('clarify', 'public');
        }

        $features = [
            [
                'icon' => $request->feature_1_icon,
                'title' => $request->feature_1_title,
                'description' => $request->feature_1_description,
            ],
            [
                'icon' => $request->feature_2_icon,
                'title' => $request->feature_2_title,
                'description' => $request->feature_2_description,
            ],
            [
                'icon' => $request->feature_3_icon,
                'title' => $request->feature_3_title,
                'description' => $request->feature_3_description,
            ]
        ];

        Clarify::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'features' => $features,
            'is_active' => $request->has('is_active')
        ]);

        session()->flash('success', 'Clarify créé avec succès !');
        return redirect()->route('all.clarify');
    }

    public function show(Clarify $clarify)
    {
        return view('admin.backend.clarify.show_clarify', compact('clarify'));
    }

    public function edit(Clarify $clarify)
    {
        return view('admin.backend.clarify.edit_clarify', compact('clarify'));
    }

    public function update(Request $request, Clarify $clarify)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'feature_1_icon' => 'nullable|string',
            'feature_1_title' => 'nullable|string|max:255',
            'feature_1_description' => 'nullable|string',
            'feature_2_icon' => 'nullable|string',
            'feature_2_title' => 'nullable|string|max:255',
            'feature_2_description' => 'nullable|string',
            'feature_3_icon' => 'nullable|string',
            'feature_3_title' => 'nullable|string|max:255',
            'feature_3_description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $imagePath = $clarify->image;
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('clarify', 'public');
        }

        $features = [
            [
                'icon' => $request->feature_1_icon,
                'title' => $request->feature_1_title,
                'description' => $request->feature_1_description,
            ],
            [
                'icon' => $request->feature_2_icon,
                'title' => $request->feature_2_title,
                'description' => $request->feature_2_description,
            ],
            [
                'icon' => $request->feature_3_icon,
                'title' => $request->feature_3_title,
                'description' => $request->feature_3_description,
            ]
        ];

        $clarify->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'features' => $features,
            'is_active' => $request->has('is_active')
        ]);

        session()->flash('success', 'Clarify mis à jour avec succès !');
        return redirect()->route('all.clarify');
    }

    public function destroy(Clarify $clarify)
    {
        // Supprimer l'image
        if ($clarify->image && Storage::disk('public')->exists($clarify->image)) {
            Storage::disk('public')->delete($clarify->image);
        }

        $clarify->delete();

        session()->flash('success', 'Clarify supprimé avec succès !');
        return redirect()->route('all.clarify');
    }
}