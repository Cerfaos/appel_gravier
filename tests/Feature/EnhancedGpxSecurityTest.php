<?php

use App\Models\User;
use App\Models\Itinerary;
use App\Services\EnhancedGpxParserService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

describe('Enhanced GPX Processing Tests', function () {
    
    beforeEach(function () {
        Storage::fake('public');
        Cache::flush();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->gpxService = new EnhancedGpxParserService();
    });

    it('prevents XXE attacks in GPX files', function () {
        $maliciousGpx = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE gpx [
    <!ENTITY xxe SYSTEM "file:///etc/passwd">
]>
<gpx version="1.1">
    <trk>
        <name>&xxe;</name>
        <trkseg>
            <trkpt lat="44.123456" lon="6.123456">
                <ele>1200.0</ele>
            </trkpt>
        </trkseg>
    </trk>
</gpx>';

        expect(function () use ($maliciousGpx) {
            $this->gpxService->parse($maliciousGpx);
        })->toThrow(Exception::class);
    });

    it('handles oversized GPX files gracefully', function () {
        $largeContent = str_repeat('a', 6 * 1024 * 1024); // 6MB
        
        expect(function () use ($largeContent) {
            $this->gpxService->parse($largeContent);
        })->toThrow(Exception::class, 'Fichier GPX trop volumineux');
    });

    it('limits the number of GPS points to prevent memory exhaustion', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1">
    <trk>
        <name>Large Track</name>
        <trkseg>';
        
        // Generate more than 50000 points
        for ($i = 0; $i < 51000; $i++) {
            $lat = 44.0 + ($i * 0.0001);
            $lon = 6.0 + ($i * 0.0001);
            $gpxContent .= "<trkpt lat=\"{$lat}\" lon=\"{$lon}\"><ele>1000</ele></trkpt>";
        }
        
        $gpxContent .= '</trkseg></trk></gpx>';

        $result = $this->gpxService->parse($gpxContent);
        
        // Should be limited to 50000 points
        expect($result['points'])->toHaveCount(50000);
    });

    it('validates coordinate ranges properly', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1">
    <trk>
        <trkseg>
            <trkpt lat="200.0" lon="6.123456"><ele>1200.0</ele></trkpt>
            <trkpt lat="44.123456" lon="200.0"><ele>1200.0</ele></trkpt>
            <trkpt lat="44.123456" lon="6.123456"><ele>1200.0</ele></trkpt>
        </trkseg>
    </trk>
</gpx>';

        $result = $this->gpxService->parse($gpxContent);
        
        // Only valid coordinate should remain
        expect($result['points'])->toHaveCount(1);
        expect($result['points'][0]['latitude'])->toBe(44.123456);
        expect($result['points'][0]['longitude'])->toBe(6.123456);
    });

    it('validates elevation ranges', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1">
    <trk>
        <trkseg>
            <trkpt lat="44.123456" lon="6.123456"><ele>-1000.0</ele></trkpt>
            <trkpt lat="44.123556" lon="6.123556"><ele>10000.0</ele></trkpt>
            <trkpt lat="44.123656" lon="6.123656"><ele>1200.0</ele></trkpt>
        </trkseg>
    </trk>
</gpx>';

        $result = $this->gpxService->parse($gpxContent);
        
        // Only valid elevations should be kept (not null)
        $validElevations = array_filter(array_column($result['points'], 'elevation'), function($ele) {
            return $ele !== null;
        });
        
        expect($validElevations)->toHaveCount(1);
        expect($validElevations[2])->toBe(1200.0);
    });

    it('caches GPX parsing results for better performance', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1">
    <trk>
        <trkseg>
            <trkpt lat="44.123456" lon="6.123456"><ele>1200.0</ele></trkpt>
            <trkpt lat="44.123556" lon="6.123556"><ele>1250.0</ele></trkpt>
        </trkseg>
    </trk>
</gpx>';

        // First parse
        $result1 = $this->gpxService->parse($gpxContent);
        
        // Second parse should use cache
        $result2 = $this->gpxService->parse($gpxContent);
        
        expect($result1)->toEqual($result2);
        
        // Verify cache is being used
        $contentHash = hash('sha256', $gpxContent);
        $cacheKey = "gpx_parsed_{$contentHash}";
        expect(Cache::has($cacheKey))->toBeTrue();
    });

    it('provides enhanced statistics including elevation extremes', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1">
    <trk>
        <trkseg>
            <trkpt lat="44.000000" lon="6.000000"><ele>1000.0</ele></trkpt>
            <trkpt lat="44.001000" lon="6.001000"><ele>1500.0</ele></trkpt>
            <trkpt lat="44.002000" lon="6.002000"><ele>1200.0</ele></trkpt>
            <trkpt lat="44.003000" lon="6.003000"><ele>1800.0</ele></trkpt>
        </trkseg>
    </trk>
</gpx>';

        $result = $this->gpxService->parse($gpxContent);
        
        expect($result['statistics'])->toHaveKey('max_elevation_m');
        expect($result['statistics'])->toHaveKey('min_elevation_m');
        expect($result['statistics']['max_elevation_m'])->toBe(1800.0);
        expect($result['statistics']['min_elevation_m'])->toBe(1000.0);
    });

    it('handles GPX files without elevation data gracefully', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1">
    <trk>
        <trkseg>
            <trkpt lat="44.123456" lon="6.123456"></trkpt>
            <trkpt lat="44.123556" lon="6.123556"></trkpt>
        </trkseg>
    </trk>
</gpx>';

        $result = $this->gpxService->parse($gpxContent);
        
        expect($result['statistics']['elevation_gain_m'])->toBe(0);
        expect($result['statistics']['elevation_loss_m'])->toBe(0);
        expect($result['statistics']['max_elevation_m'])->toBeNull();
        expect($result['statistics']['min_elevation_m'])->toBeNull();
    });

    it('sanitizes potentially dangerous GPX content', function () {
        $dangerousGpx = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE gpx SYSTEM "http://evil.com/evil.dtd">
<gpx version="1.1">
    <trk>
        <trkseg>
            <trkpt lat="44.123456" lon="6.123456"><ele>1200.0</ele></trkpt>
        </trkseg>
    </trk>
</gpx>';

        // Should not throw exception and should parse successfully
        $result = $this->gpxService->parse($dangerousGpx);
        
        expect($result['points'])->toHaveCount(1);
        expect($result['points'][0]['latitude'])->toBe(44.123456);
    });
});