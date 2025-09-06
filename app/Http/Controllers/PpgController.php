<?php

namespace App\Http\Controllers;

use App\Models\PpgCategory;

class PpgController extends Controller
{
    public function index()
    {
        $categories = PpgCategory::where('status', 'published')
            ->orderBy('order_position')
            ->with(['publishedExercises', 'publishedPrograms'])
            ->get();
            
        return view('home.ppg.ppg', compact('categories'));
    }

    public function fondation()
    {
        $category = PpgCategory::where('slug', 'fondation')
            ->where('status', 'published')
            ->with(['publishedExercises', 'publishedPrograms'])
            ->first();
            
        // If category doesn't exist, create a default one or redirect
        if (!$category) {
            // Create default category if it doesn't exist
            $category = PpgCategory::create([
                'name' => 'Fondation',
                'slug' => 'fondation',
                'title' => 'PPG Fondation',
                'description' => 'Construisez une base solide avec des exercices de renforcement fondamentaux.',
                'icon' => 'fas fa-cube',
                'color' => '#606c38',
                'order_position' => 1,
                'status' => 'published'
            ]);
        }
            
        return view('home.ppg.fondation.fondation', compact('category'));
    }

    public function prepa()
    {
        $category = PpgCategory::where('slug', 'prepa')
            ->where('status', 'published')
            ->with(['publishedExercises', 'publishedPrograms'])
            ->first();
            
        // If category doesn't exist, create a default one
        if (!$category) {
            $category = PpgCategory::create([
                'name' => 'Préparation',
                'slug' => 'prepa',
                'title' => 'PPG Préparation',
                'description' => 'Optimisez vos performances avec des exercices ciblés de préparation physique.',
                'icon' => 'fas fa-rocket',
                'color' => '#bc6c25',
                'order_position' => 2,
                'status' => 'published'
            ]);
        }
            
        return view('home.ppg.prepa.prepa', compact('category'));
    }

    public function recup()
    {
        $category = PpgCategory::where('slug', 'recup')
            ->where('status', 'published')
            ->with(['publishedExercises', 'publishedPrograms'])
            ->first();
            
        // If category doesn't exist, create a default one
        if (!$category) {
            $category = PpgCategory::create([
                'name' => 'Récupération',
                'slug' => 'recup',
                'title' => 'PPG Récupération',
                'description' => 'Accélérez votre récupération avec des techniques de relâchement et mobilité.',
                'icon' => 'fas fa-leaf',
                'color' => '#dda15e',
                'order_position' => 3,
                'status' => 'published'
            ]);
        }
            
        return view('home.ppg.recup.recup', compact('category'));
    }

}
