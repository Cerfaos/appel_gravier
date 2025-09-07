<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    public function GetSlider()
    {
        $slider = Slider::first();
        
        // Si aucun slider n'existe, créer un slider par défaut
        if (!$slider) {
            $slider = Slider::create([
                'title' => 'Titre du Slider',
                'description' => 'Description par défaut du slider',
                'image' => 'upload/no_image.jpg',
                'link' => '#'
            ]);
        }
        
        return view('admin.backend.slider.get_slider', compact('slider'));
    }

    public function UpdateSlider(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $slider = Slider::findOrFail($request->id);
        $save_url = $slider->image;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $image = $request->file('image');
                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                
                $image = $manager->read($image);
                $image->resize(306, 618)->save(base_path('upload/slider/'.$name_gen));
                $save_url = 'upload/slider/'.$name_gen;
            } catch (\Exception $e) {
                $notification = array(
                    'message' => 'Erreur lors du traitement de l\'image: ' . $e->getMessage(),
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification)->withInput();
            }
        }

        try {
            $slider->update([
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link,
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Slider mis à jour avec succès',
                'alert-type' => 'success'
            );
            
            return redirect()->route('get.slider')->with($notification);
            
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            
            return redirect()->back()->with($notification)->withInput();
        }
    }

    public function AllSliders()
    {
        $sliders = Slider::latest()->get();
        return view('admin.backend.slider.all_sliders', compact('sliders'));
    }
}
