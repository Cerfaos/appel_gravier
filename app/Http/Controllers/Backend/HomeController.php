<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;

class HomeController extends Controller
{
    public function AllFeature()
    {
        $feature = Feature::latest()->get();
        return view('admin.backend.feature.all_feature', compact('feature'));
    }
    // End Method
    
    public function AddFeature()
    {
        return view('admin.backend.feature.add_feature');
    }
    // End Method
    public function StoreFeature(StoreFeatureRequest $request)
    {
        try {
            Feature::create($request->validated());
            
            $notification = array(
                'message' => 'Activité ajoutée avec succès',
                'alert-type' => 'success'
            );
            return redirect()->route('all.feature')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Erreur lors de l\'ajout de l\'activité: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->withInput()->with($notification);
        }
    }
    public function EditFeature($id)
    {
        $feature = Feature::findOrFail($id);
        return view('admin.backend.feature.edit_feature', compact('feature'));
    }
    // End Method

    public function UpdateFeature(UpdateFeatureRequest $request)
    {
        try {
            $feature = Feature::findOrFail($request->id);
            $feature->update($request->validated());
            
            $notification = array(
                'message' => 'Activité modifiée avec succès',
                'alert-type' => 'success'
            );
            return redirect()->route('all.feature')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Erreur lors de la modification de l\'activité: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->withInput()->with($notification);
        }
    }
    // End Method

    public function DeleteFeature($id)
    {
        Feature::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Activité supprimée avec succès',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
// End Method