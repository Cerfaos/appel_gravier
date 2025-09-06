<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

/** @mixin \Intervention\Image\ImageManager */
class ReviewController extends Controller
{
    public function AllReviews()
    {
        $review = Review::latest()->get();
        return view('admin.backend.review.all_review', compact('review'));
    }

    public function AddReview()
    {
        return view('admin.backend.review.add_review');
    }

    public function StoreReview(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $save_url = null;

        // Traitement de l'image si elle existe
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $image = $request->file('image');
                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                
                $image = $manager->read($image);
                $image->resize(60, 60)->save(public_path('upload/review/'.$name_gen));
                $save_url = 'upload/review/'.$name_gen;
            } catch (\Exception $e) {
                $notification = array(
                    'message' => 'Erreur lors du traitement de l\'image: ' . $e->getMessage(),
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification)->withInput();
            }
        }

        try {
            // Création de l'avis
            Review::create([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Avis ajouté avec succès',
                'alert-type' => 'success'
            );
            
            return redirect()->route('all.review')->with($notification);
            
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Erreur lors de l\'enregistrement: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            
            return redirect()->back()->with($notification)->withInput();
        }
    }

    public function EditReview($id)
    {
        $review = Review::findOrFail($id);
        return view('admin.backend.review.edit_review', compact('review'));
    }

    public function UpdateReview(Request $request)
    {
        $review_id = $request->id;
        $review = Review::findOrFail($review_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $save_url = $review->image;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $image = $request->file('image');
                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                
                $image = $manager->read($image);
                $image->resize(60, 60)->save(public_path('upload/review/'.$name_gen));
                $save_url = 'upload/review/'.$name_gen;
            } catch (\Exception $e) {
                $notification = array(
                    'message' => 'Erreur lors du traitement de l\'image: ' . $e->getMessage(),
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification)->withInput();
            }
        }

        try {
            $review->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Avis mis à jour avec succès',
                'alert-type' => 'success'
            );
            
            return redirect()->route('all.review')->with($notification);
            
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            
            return redirect()->back()->with($notification)->withInput();
        }
    }

    public function DeleteReview($id)
    {
        try {
            $review = Review::findOrFail($id);
            $review->delete();

            $notification = array(
                'message' => 'Avis supprimé avec succès',
                'alert-type' => 'success'
            );
            
            return redirect()->route('all.review')->with($notification);
            
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            
            return redirect()->route('all.review')->with($notification);
        }
    }


    }
    