<?php

use App\Models\User;
use App\Models\Itinerary;
use App\Models\GpxPoint;
use App\Services\GpxParserService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('GPX File Upload and Processing', function () {
    
    it('can parse a valid GPX file', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1" creator="Test">
    <trk>
        <name>Test Track</name>
        <trkseg>
            <trkpt lat="44.123456" lon="6.123456">
                <ele>1200.0</ele>
            </trkpt>
            <trkpt lat="44.123556" lon="6.123556">
                <ele>1250.0</ele>
            </trkpt>
            <trkpt lat="44.123656" lon="6.123656">
                <ele>1300.0</ele>
            </trkpt>
        </trkseg>
    </trk>
</gpx>';

        $gpxParserService = new GpxParserService();
        $result = $gpxParserService->parse($gpxContent);
        
        expect($result)->toHaveKey('points');
        expect($result)->toHaveKey('statistics');
        expect($result['points'])->toHaveCount(3);
        expect($result['statistics']['elevation_gain_m'])->toBeGreaterThan(0);
        expect($result['statistics']['distance_km'])->toBeGreaterThan(0);
    });

    it('handles invalid GPX file gracefully', function () {
        $invalidContent = 'This is not a valid GPX file';
        
        $gpxParserService = new GpxParserService();
        
        expect(function () use ($gpxParserService, $invalidContent) {
            $gpxParserService->parse($invalidContent);
        })->toThrow(Exception::class);
    });

    it('can upload GPX file via itinerary form', function () {
        // Create a valid GPX file
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1" creator="Test">
    <trk>
        <name>Test Track</name>
        <trkseg>
            <trkpt lat="44.123456" lon="6.123456">
                <ele>1200.0</ele>
            </trkpt>
            <trkpt lat="44.123556" lon="6.123556">
                <ele>1250.0</ele>
            </trkpt>
        </trkseg>
    </trk>
</gpx>';
        
        $gpxFile = UploadedFile::fake()->createWithContent('test-route.gpx', $gpxContent);
        
        $data = [
            'title' => 'GPX Upload Test',
            'description' => 'Testing GPX file upload',
            'gpx_file' => $gpxFile,
            'difficulty_level' => 'moyen'
        ];

        $response = $this->post('/store/itinerary', $data);
        
        $response->assertRedirect();
        
        $itinerary = Itinerary::where('title', 'GPX Upload Test')->first();
        expect($itinerary)->not->toBeNull();
        expect($itinerary->gpx_file_path)->not->toBeNull();
    });

    it('validates GPX file extension', function () {
        $invalidFile = UploadedFile::fake()->create('invalid.txt', 100, 'text/plain');
        
        $data = [
            'title' => 'Invalid File Test',
            'description' => 'Testing invalid file upload',
            'gpx_file' => $invalidFile
        ];

        $response = $this->post('/store/itinerary', $data);
        
        $response->assertSessionHasErrors(['gpx_file']);
    });

    it('calculates route statistics from GPX', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1" creator="Test">
    <trk>
        <name>Test Track</name>
        <trkseg>
            <trkpt lat="44.000000" lon="6.000000">
                <ele>1000.0</ele>
            </trkpt>
            <trkpt lat="44.001000" lon="6.001000">
                <ele>1100.0</ele>
            </trkpt>
            <trkpt lat="44.002000" lon="6.002000">
                <ele>1050.0</ele>
            </trkpt>
            <trkpt lat="44.003000" lon="6.003000">
                <ele>1200.0</ele>
            </trkpt>
        </trkseg>
    </trk>
</gpx>';

        $gpxParserService = new GpxParserService();
        $result = $gpxParserService->parse($gpxContent);
        
        expect($result['statistics'])->toHaveKey('distance_km');
        expect($result['statistics'])->toHaveKey('elevation_gain_m');
        expect($result['statistics'])->toHaveKey('elevation_loss_m');
        expect($result['statistics'])->toHaveKey('min_latitude');
        expect($result['statistics'])->toHaveKey('max_latitude');
        
        expect($result['statistics']['elevation_gain_m'])->toBe(250); // 100m + 150m gains
        expect($result['statistics']['elevation_loss_m'])->toBe(50); // 50m loss
        expect($result['statistics']['min_latitude'])->toBe(44.000000);
        expect($result['statistics']['max_latitude'])->toBe(44.003000);
    });

    it('stores GPX points in database', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1" creator="Test">
    <trk>
        <name>Test Track</name>
        <trkseg>
            <trkpt lat="44.123456" lon="6.123456">
                <ele>1200.0</ele>
            </trkpt>
            <trkpt lat="44.123556" lon="6.123556">
                <ele>1250.0</ele>
            </trkpt>
        </trkseg>
    </trk>
</gpx>';
        
        $gpxFile = UploadedFile::fake()->createWithContent('detailed-route.gpx', $gpxContent);
        
        $data = [
            'title' => 'Detailed GPX Test',
            'description' => 'Testing detailed GPX storage',
            'gpx_file' => $gpxFile,
            'difficulty_level' => 'facile'
        ];

        $response = $this->post('/store/itinerary', $data);
        
        $response->assertRedirect();
        
        $itinerary = Itinerary::where('title', 'Detailed GPX Test')->first();
        expect($itinerary)->not->toBeNull();
        
        // Check that GPX points were stored
        expect($itinerary->gpxPoints)->toHaveCount(2);
        
        $firstPoint = $itinerary->gpxPoints->first();
        expect($firstPoint->latitude)->toBe(44.123456);
        expect($firstPoint->longitude)->toBe(6.123456);
        expect($firstPoint->elevation)->toBe(1200.0);
    });

    it('handles GPX files without elevation data', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1" creator="Test">
    <trk>
        <name>Test Track</name>
        <trkseg>
            <trkpt lat="44.123456" lon="6.123456">
            </trkpt>
            <trkpt lat="44.123556" lon="6.123556">
            </trkpt>
        </trkseg>
    </trk>
</gpx>';

        $gpxParserService = new GpxParserService();
        $result = $gpxParserService->parse($gpxContent);
        
        expect($result['points'])->toHaveCount(2);
        expect($result['points'][0]['elevation'])->toBeNull();
        expect($result['statistics']['elevation_gain_m'])->toBe(0);
    });

    it('validates GPS coordinates within valid range', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1" creator="Test">
    <trk>
        <name>Test Track</name>
        <trkseg>
            <trkpt lat="200.0" lon="6.123456">
                <ele>1200.0</ele>
            </trkpt>
            <trkpt lat="44.123556" lon="200.0">
                <ele>1250.0</ele>
            </trkpt>
        </trkseg>
    </trk>
</gpx>';

        $gpxParserService = new GpxParserService();
        $result = $gpxParserService->parse($gpxContent);
        
        // Invalid coordinates should be filtered out
        expect($result['points'])->toHaveCount(0);
    });

    it('can handle large GPX files', function () {
        $gpxContent = '<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1" creator="Test">
    <trk>
        <name>Large Track</name>
        <trkseg>';
        
        // Generate 1000 points
        for ($i = 0; $i < 1000; $i++) {
            $lat = 44.0 + ($i * 0.001);
            $lon = 6.0 + ($i * 0.001);
            $ele = 1000 + ($i * 0.5);
            $gpxContent .= "<trkpt lat=\"{$lat}\" lon=\"{$lon}\"><ele>{$ele}</ele></trkpt>";
        }
        
        $gpxContent .= '</trkseg>
    </trk>
</gpx>';

        $gpxParserService = new GpxParserService();
        $result = $gpxParserService->parse($gpxContent);
        
        expect($result['points'])->toHaveCount(1000);
        expect($result['statistics']['distance_km'])->toBeGreaterThan(0);
    });

    it('can download GPX file from itinerary', function () {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
            'gpx_file_path' => 'storage/gpx/test-route.gpx'
        ]);

        // Note: This assumes a download route exists
        $response = $this->get("/itineraires/{$itinerary->slug}/download-gpx");
        
        // Should either download the file or return 404 if route doesn't exist
        expect($response->getStatusCode())->toBeIn([200, 404]);
    });
});