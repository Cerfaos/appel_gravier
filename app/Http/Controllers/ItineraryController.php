<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    public function index(Request $request)
    {
        $query = Itinerary::where('status', 'published')
            ->with(['featuredImage', 'user']);

        // Filtrage par recherche
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('personal_comment', 'like', "%{$search}%");
            });
        }

        // Filtrage par département
        if ($request->filled('departement')) {
            $query->where('departement', 'like', '%' . $request->get('departement') . '%');
        }

        // Filtrage par pays
        if ($request->filled('pays')) {
            $query->where('pays', 'like', '%' . $request->get('pays') . '%');
        }

        // Filtrage par difficulté
        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->get('difficulty'));
        }

        // Filtrage par distance
        if ($request->filled('distance')) {
            $distance = $request->get('distance');
            switch ($distance) {
                case '0-5':
                    $query->where('distance_km', '<=', 5);
                    break;
                case '5-10':
                    $query->whereBetween('distance_km', [5, 10]);
                    break;
                case '10-20':
                    $query->whereBetween('distance_km', [10, 20]);
                    break;
                case '20-50':
                    $query->whereBetween('distance_km', [20, 50]);
                    break;
                case '50+':
                    $query->where('distance_km', '>', 50);
                    break;
            }
        }

        // Tri
        $sort = $request->get('sort', 'published_at_desc');
        switch ($sort) {
            case 'published_at_asc':
                $query->orderBy('published_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'distance_asc':
                $query->orderBy('distance_km', 'asc');
                break;
            case 'distance_desc':
                $query->orderBy('distance_km', 'desc');
                break;
            default: // published_at_desc
                $query->latest('published_at');
                break;
        }

        $itineraries = $query->paginate(12);

        return view('home.itineraries.index', compact('itineraries'));
    }

    public function show(string $slug)
    {
        $itinerary = Itinerary::where('slug', $slug)
            ->where('status', 'published')
            ->with(['featuredImage', 'images', 'gpxPoints', 'user'])
            ->firstOrFail();

        return view('home.itineraries.show', compact('itinerary'));
    }
}