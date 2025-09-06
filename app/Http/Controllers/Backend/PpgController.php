<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PpgCategory;
use App\Models\PpgExercise;
use App\Models\PpgProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PpgController extends Controller
{
    // ========== CATEGORIES ==========
    
    public function categories()
    {
        $categories = PpgCategory::withCount(['exercises', 'programs'])->orderBy('order_position')->get();
        return view('admin.ppg.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.ppg.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ppg_categories',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'required|string|max:7',
            'order_position' => 'required|integer|min:0',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        PpgCategory::create($data);

        return redirect()->route('admin.ppg.categories')->with('success', 'Catégorie PPG créée avec succès');
    }

    public function editCategory(PpgCategory $category)
    {
        return view('admin.ppg.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, PpgCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ppg_categories,name,' . $category->id,
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'required|string|max:7',
            'order_position' => 'required|integer|min:0',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $category->update($data);

        return redirect()->route('admin.ppg.categories')->with('success', 'Catégorie PPG mise à jour avec succès');
    }

    public function deleteCategory(PpgCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.ppg.categories')->with('success', 'Catégorie PPG supprimée avec succès');
    }

    // ========== EXERCISES ==========
    
    public function exercises()
    {
        $exercises = PpgExercise::with('category')->latest()->get();
        return view('admin.ppg.exercises.index', compact('exercises'));
    }

    public function createExercise()
    {
        $categories = PpgCategory::orderBy('order_position')->get();
        return view('admin.ppg.exercises.create', compact('categories'));
    }

    public function storeExercise(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:ppg_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'nullable|string',
            'difficulty_level' => 'required|in:debutant,intermediaire,avance',
            'duration_minutes' => 'nullable|integer|min:1',
            'sets' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
            'rest_time' => 'nullable|string|max:255',
            'equipment' => 'nullable|string|max:255',
            'target_muscles' => 'nullable|string|max:255',
            'video_url' => 'nullable|url',
            'tips' => 'nullable|string',
            'precautions' => 'nullable|string',
            'order_position' => 'required|integer|min:0',
            'status' => 'required|in:draft,published',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Handle images
        if ($request->hasFile('images')) {
            $images = [];
            $manager = new ImageManager(new Driver());
            
            foreach ($request->file('images') as $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'upload/ppg/exercises/' . $filename;
                
                // Create and save resized image
                $img = $manager->read($image);
                $img->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                Storage::disk('public')->put($path, $img->encode());
                $images[] = $path;
            }
            
            $data['images'] = $images;
        }

        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        PpgExercise::create($data);

        return redirect()->route('admin.ppg.exercises')->with('success', 'Exercice PPG créé avec succès');
    }

    public function showExercise(PpgExercise $exercise)
    {
        $exercise->load('category');
        return view('admin.ppg.exercises.show', compact('exercise'));
    }

    public function editExercise(PpgExercise $exercise)
    {
        $categories = PpgCategory::orderBy('order_position')->get();
        return view('admin.ppg.exercises.edit', compact('exercise', 'categories'));
    }

    public function updateExercise(Request $request, PpgExercise $exercise)
    {
        $request->validate([
            'category_id' => 'required|exists:ppg_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'nullable|string',
            'difficulty_level' => 'required|in:debutant,intermediaire,avance',
            'duration_minutes' => 'nullable|integer|min:1',
            'sets' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
            'rest_time' => 'nullable|string|max:255',
            'equipment' => 'nullable|string|max:255',
            'target_muscles' => 'nullable|string|max:255',
            'video_url' => 'nullable|url',
            'tips' => 'nullable|string',
            'precautions' => 'nullable|string',
            'order_position' => 'required|integer|min:0',
            'status' => 'required|in:draft,published',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Handle images
        if ($request->hasFile('images')) {
            // Delete old images
            if ($exercise->images) {
                foreach ($exercise->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            
            $images = [];
            $manager = new ImageManager(new Driver());
            
            foreach ($request->file('images') as $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'upload/ppg/exercises/' . $filename;
                
                $img = $manager->read($image);
                $img->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                Storage::disk('public')->put($path, $img->encode());
                $images[] = $path;
            }
            
            $data['images'] = $images;
        }

        if ($request->status === 'published' && !$exercise->published_at) {
            $data['published_at'] = now();
        }

        $exercise->update($data);

        return redirect()->route('admin.ppg.exercises')->with('success', 'Exercice PPG mis à jour avec succès');
    }

    public function deleteExercise(PpgExercise $exercise)
    {
        // Delete images
        if ($exercise->images) {
            foreach ($exercise->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $exercise->delete();
        return redirect()->route('admin.ppg.exercises')->with('success', 'Exercice PPG supprimé avec succès');
    }

    // ========== PROGRAMS ==========
    
    public function programs()
    {
        $programs = PpgProgram::with('category')->latest()->get();
        return view('admin.ppg.programs.index', compact('programs'));
    }

    public function createProgram()
    {
        $categories = PpgCategory::orderBy('order_position')->get();
        $exercises = PpgExercise::where('status', 'published')->orderBy('title')->get();
        return view('admin.ppg.programs.create', compact('categories', 'exercises'));
    }

    public function storeProgram(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:ppg_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'difficulty_level' => 'required|in:debutant,intermediaire,avance',
            'duration_weeks' => 'required|integer|min:1',
            'sessions_per_week' => 'required|integer|min:1',
            'session_duration_minutes' => 'required|integer|min:1',
            'exercises' => 'required|array',
            'progression_notes' => 'nullable|string',
            'target_audience' => 'nullable|string|max:255',
            'order_position' => 'required|integer|min:0',
            'status' => 'required|in:draft,published',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Handle images
        if ($request->hasFile('images')) {
            $images = [];
            $manager = new ImageManager(new Driver());
            
            foreach ($request->file('images') as $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'upload/ppg/programs/' . $filename;
                
                $img = $manager->read($image);
                $img->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                Storage::disk('public')->put($path, $img->encode());
                $images[] = $path;
            }
            
            $data['images'] = $images;
        }

        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        PpgProgram::create($data);

        return redirect()->route('admin.ppg.programs')->with('success', 'Programme PPG créé avec succès');
    }

    public function showProgram(PpgProgram $program)
    {
        $program->load('category');
        return view('admin.ppg.programs.show', compact('program'));
    }

    public function editProgram(PpgProgram $program)
    {
        $categories = PpgCategory::orderBy('order_position')->get();
        $exercises = PpgExercise::where('status', 'published')->orderBy('title')->get();
        return view('admin.ppg.programs.edit', compact('program', 'categories', 'exercises'));
    }

    public function updateProgram(Request $request, PpgProgram $program)
    {
        $request->validate([
            'category_id' => 'required|exists:ppg_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'difficulty_level' => 'required|in:debutant,intermediaire,avance',
            'duration_weeks' => 'required|integer|min:1',
            'sessions_per_week' => 'required|integer|min:1',
            'session_duration_minutes' => 'required|integer|min:1',
            'exercises' => 'required|array',
            'progression_notes' => 'nullable|string',
            'target_audience' => 'nullable|string|max:255',
            'order_position' => 'required|integer|min:0',
            'status' => 'required|in:draft,published',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Handle images
        if ($request->hasFile('images')) {
            // Delete old images
            if ($program->images) {
                foreach ($program->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            
            $images = [];
            $manager = new ImageManager(new Driver());
            
            foreach ($request->file('images') as $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'upload/ppg/programs/' . $filename;
                
                $img = $manager->read($image);
                $img->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                Storage::disk('public')->put($path, $img->encode());
                $images[] = $path;
            }
            
            $data['images'] = $images;
        }

        if ($request->status === 'published' && !$program->published_at) {
            $data['published_at'] = now();
        }

        $program->update($data);

        return redirect()->route('admin.ppg.programs')->with('success', 'Programme PPG mis à jour avec succès');
    }

    public function deleteProgram(PpgProgram $program)
    {
        // Delete images
        if ($program->images) {
            foreach ($program->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $program->delete();
        return redirect()->route('admin.ppg.programs')->with('success', 'Programme PPG supprimé avec succès');
    }
}