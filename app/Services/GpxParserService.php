<?php

namespace App\Services;

use SimpleXMLElement;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GpxParserService
{
    private const MAX_POINTS = 50000; // Prevent memory exhaustion
    private const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    private const CACHE_TTL = 3600; // 1 hour

    public function parse(string $gpxContent): array
    {
        // Security: Check file size
        if (strlen($gpxContent) > self::MAX_FILE_SIZE) {
            throw new Exception('Fichier GPX trop volumineux (maximum 5MB)');
        }

        // Security: Generate cache key based on content hash
        $contentHash = hash('sha256', $gpxContent);
        $cacheKey = "gpx_parsed_{$contentHash}";

        // Check cache first for performance
        if (Cache::has($cacheKey)) {
            Log::info('GPX parsing cache hit', ['hash' => $contentHash]);
            return Cache::get($cacheKey);
        }

        try {
            // Security: Disable external entity loading
            $previousValue = libxml_disable_entity_loader(true);
            libxml_use_internal_errors(true);
            
            // Security: Clean content
            $gpxContent = $this->sanitizeGpxContent($gpxContent);
            
            $xml = simplexml_load_string(
                $gpxContent, 
                'SimpleXMLElement', 
                LIBXML_NOCDATA | LIBXML_NONET | LIBXML_NOENT
            );
            
            // Restore previous setting
            libxml_disable_entity_loader($previousValue);
            
            if ($xml === false) {
                $errors = libxml_get_errors();
                $errorMessage = !empty($errors) ? $errors[0]->message : 'XML parsing failed';
                throw new Exception('Fichier GPX invalide: ' . trim($errorMessage));
            }
            $result = $this->processGpxData($xml);
            
            // Cache the result
            Cache::put($cacheKey, $result, self::CACHE_TTL);
            
            Log::info('GPX parsing completed', [
                'points_count' => count($result['points']),
                'distance_km' => $result['statistics']['distance_km']
            ]);
            
            return $result;
            
        } catch (Exception $e) {
            Log::error('GPX parsing error', [
                'error' => $e->getMessage(),
                'file_size' => strlen($gpxContent)
            ]);
            throw new Exception('Erreur lors du parsing du fichier GPX: ' . $e->getMessage());
        }
    }

    private function sanitizeGpxContent(string $content): string
    {
        // Remove potential security threats
        $content = preg_replace('/<!DOCTYPE[^>]*>/i', '', $content);
        $content = preg_replace('/<!ENTITY[^>]*>/i', '', $content);
        
        // Ensure it's a valid GPX structure
        if (!preg_match('/<gpx[^>]*>/i', $content)) {
            throw new Exception('Le fichier ne semble pas être un fichier GPX valide');
        }
        
        return $content;
    }

    private function processGpxData(SimpleXMLElement $xml): array
    {
        $points = [];
        $elevations = [];
        $pointCount = 0;

        if (!isset($xml->trk)) {
            throw new Exception('Aucune track trouvée dans le fichier GPX');
        }

        foreach ($xml->trk as $track) {
            if (!isset($track->trkseg)) continue;
            
            foreach ($track->trkseg as $segment) {
                if (!isset($segment->trkpt)) continue;
                
                foreach ($segment->trkpt as $point) {
                    // Security: Limit number of points to prevent memory exhaustion
                    if ($pointCount >= self::MAX_POINTS) {
                        Log::warning('GPX file exceeded max points limit', ['limit' => self::MAX_POINTS]);
                        break 3;
                    }

                    $lat = $this->validateCoordinate((float) $point['lat'], -90, 90);
                    $lon = $this->validateCoordinate((float) $point['lon'], -180, 180);
                    $ele = isset($point->ele) ? $this->validateElevation((float) $point->ele) : null;

                    if ($lat === null || $lon === null) {
                        continue; // Skip invalid points
                    }

                    $points[] = [
                        'latitude' => $lat,
                        'longitude' => $lon,
                        'elevation' => $ele,
                    ];

                    if ($ele !== null) {
                        $elevations[] = $ele;
                    }
                    
                    $pointCount++;
                }
            }
        }

        if (empty($points)) {
            throw new Exception('Aucun point GPS valide trouvé dans le fichier GPX');
        }

        return [
            'points' => $points,
            'statistics' => $this->calculateStatistics($points, $elevations)
        ];
    }

    private function validateCoordinate(float $value, float $min, float $max): ?float
    {
        if (!is_finite($value) || $value < $min || $value > $max) {
            return null;
        }
        return $value;
    }

    private function validateElevation(float $elevation): ?float
    {
        // Reasonable elevation limits: Dead Sea to Everest + margin
        if (!is_finite($elevation) || $elevation < -500 || $elevation > 9000) {
            return null;
        }
        return $elevation;
    }
    
    private function calculateStatistics(array $points, array $elevations): array
    {
        // Vérifier qu'il y a des points
        if (empty($points)) {
            return [
                'distance_km' => 0,
                'elevation_gain_m' => 0,
                'elevation_loss_m' => 0,
                'point_count' => 0,
                'min_latitude' => null,
                'max_latitude' => null,
                'min_longitude' => null,
                'max_longitude' => null,
            ];
        }
        
        // Calculs des statistiques
        $distance = $this->calculateTotalDistance($points);
        $elevation = $this->calculateElevation($elevations);
        
        // Extraire les coordonnées pour les calculs min/max
        $latitudes = array_column($points, 'latitude');
        $longitudes = array_column($points, 'longitude');
        
        return [
            'distance_km' => round($distance, 2),
            'elevation_gain_m' => $elevation['gain'],
            'elevation_loss_m' => $elevation['loss'],
            'point_count' => count($points),
            'min_latitude' => !empty($latitudes) ? min($latitudes) : null,
            'max_latitude' => !empty($latitudes) ? max($latitudes) : null,
            'min_longitude' => !empty($longitudes) ? min($longitudes) : null,
            'max_longitude' => !empty($longitudes) ? max($longitudes) : null,
        ];
    }
    
    private function calculateTotalDistance(array $points): float
    {
        $distance = 0;
        for ($i = 1; $i < count($points); $i++) {
            $distance += $this->haversineDistance(
                $points[$i-1]['latitude'],
                $points[$i-1]['longitude'],
                $points[$i]['latitude'],
                $points[$i]['longitude']
            );
        }
        return $distance;
    }
    
    private function haversineDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371; // km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earthRadius * $c;
    }
    
    private function calculateElevation(array $elevations): array
    {
        $gain = 0;
        $loss = 0;
        
        for ($i = 1; $i < count($elevations); $i++) {
            $diff = $elevations[$i] - $elevations[$i-1];
            if ($diff > 0) {
                $gain += $diff;
            } else {
                $loss += abs($diff);
            }
        }
        
        return [
            'gain' => round($gain),
            'loss' => round($loss)
        ];
    }
}