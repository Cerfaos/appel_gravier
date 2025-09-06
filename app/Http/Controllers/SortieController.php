<?php

namespace App\Http\Controllers;

use App\Models\Sortie;
use Illuminate\Http\Request;

class SortieController extends Controller
{
    public function index(Request $request)
    {
        $query = Sortie::where('status', 'published')
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

        // Pagination dynamique
        $perPage = request('per_page', 12);
        $perPage = in_array($perPage, [12, 24, 48, 100]) ? $perPage : 12;
        $sorties = $query->paginate($perPage)->appends(request()->query());

        // Calculer les statistiques cumulées pour toutes les sorties publiées
        $stats = Sortie::where('status', 'published')
            ->selectRaw('
                COUNT(*) as total_sorties,
                SUM(distance_km) as total_distance,
                SUM(COALESCE(actual_duration_minutes, estimated_duration_minutes)) as total_time_minutes,
                SUM(elevation_gain_m) as total_elevation,
                AVG(distance_km) as avg_distance,
                AVG(COALESCE(actual_duration_minutes, estimated_duration_minutes)) as avg_time_minutes
            ')
            ->first();

        // Statistiques par mois (année courante et précédente pour comparaison)
        $currentYear = date('Y');
        $monthlyStats = Sortie::where('status', 'published')
            ->whereYear('sortie_date', '>=', $currentYear - 1)
            ->selectRaw('
                YEAR(sortie_date) as year,
                MONTH(sortie_date) as month,
                COUNT(*) as sorties_count,
                SUM(distance_km) as distance,
                SUM(COALESCE(actual_duration_minutes, estimated_duration_minutes)) as duration_minutes,
                SUM(elevation_gain_m) as elevation
            ')
            ->groupBy(['year', 'month'])
            ->orderBy('year', 'desc')
            ->orderBy('month')
            ->get()
            ->groupBy('year');

        // Statistiques par année (5 dernières années)
        $yearlyStats = Sortie::where('status', 'published')
            ->where('sortie_date', '>=', now()->subYears(5))
            ->selectRaw('
                YEAR(sortie_date) as year,
                COUNT(*) as sorties_count,
                SUM(distance_km) as distance,
                SUM(COALESCE(actual_duration_minutes, estimated_duration_minutes)) as duration_minutes,
                SUM(elevation_gain_m) as elevation
            ')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get()
            ->keyBy('year');

        return view('home.sorties.index', compact('sorties', 'stats', 'monthlyStats', 'yearlyStats'));
    }

    public function show(string $slug)
    {
        $sortie = Sortie::where('slug', $slug)
            ->where('status', 'published')
            ->with(['featuredImage', 'images', 'gpxPoints', 'user'])
            ->firstOrFail();

        return view('home.sorties.show', compact('sortie'));
    }
}