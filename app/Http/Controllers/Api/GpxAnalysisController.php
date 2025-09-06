<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GpxParserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class GpxAnalysisController extends Controller
{
    protected $gpxParser;

    public function __construct(GpxParserService $gpxParser)
    {
        $this->gpxParser = $gpxParser;
    }

    /**
     * Analyser un fichier GPX uploadé via AJAX
     */
    public function analyze(Request $request): JsonResponse
    {
        try {
            // Validation
            $request->validate([
                'gpx_file' => 'required|file|mimes:xml,gpx|max:2048',
            ]);

            $file = $request->file('gpx_file');
            
            // Lire le contenu du fichier
            $gpxContent = file_get_contents($file->getRealPath());
            
            // Parser avec le service
            $result = $this->gpxParser->parse($gpxContent);
            
            // Formater la réponse
            $stats = $result['statistics'];
            
            return response()->json([
                'success' => true,
                'stats' => [
                    'distance' => number_format($stats['distance_km'], 1),
                    'elevation_gain' => $stats['elevation_gain_m'],
                    'elevation_loss' => $stats['elevation_loss_m'],
                    'points' => $stats['point_count'],
                    'duration' => $this->calculateDuration($stats['distance_km']),
                    'bounds' => [
                        'min_latitude' => $stats['min_latitude'],
                        'max_latitude' => $stats['max_latitude'],
                        'min_longitude' => $stats['min_longitude'],
                        'max_longitude' => $stats['max_longitude'],
                    ]
                ],
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Calculer une durée estimée basée sur la distance
     */
    private function calculateDuration(float $distance): string
    {
        // Estimation : 4 km/h en montagne avec pauses
        $hours = $distance / 4;
        $h = floor($hours);
        $m = floor(($hours - $h) * 60);
        
        if ($h == 0) {
            return $m . 'min';
        }
        
        return $h . 'h' . ($m > 0 ? sprintf('%02d', $m) : '');
    }
}