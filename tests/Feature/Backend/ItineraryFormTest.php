<?php

use App\Models\User;
use App\Models\Itinerary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('Itinerary Backend Forms', function () {
    
    it('can access itinerary creation form', function () {
        $response = $this->get('/add/itinerary');
        
        $response->assertStatus(200);
        $response->assertSee('Ajouter un itinéraire');
        $response->assertSee('form');
        $response->assertSee('title');
        $response->assertSee('description');
        $response->assertSee('gpx_file');
    });

    it('can create an itinerary with valid data', function () {
        $gpxFile = UploadedFile::fake()->create('test-route.gpx', 100, 'application/gpx+xml');
        $image = UploadedFile::fake()->image('cover.jpg', 800, 600);
        
        $data = [
            'title' => 'Test Itinerary Route',
            'description' => 'A beautiful test route through the mountains',
            'departement' => 'Alpes-de-Haute-Provence',
            'pays' => 'France',
            'personal_comment' => 'Great ride with challenging climbs',
            'difficulty_level' => 'moyen',
            'gpx_file' => $gpxFile,
            'images' => [$image],
            'meta_title' => 'Test Route SEO Title',
            'meta_description' => 'SEO description for test route',
            'status' => 'published'
        ];

        $response = $this->post('/store/itinerary', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('itineraries', [
            'title' => 'Test Itinerary Route',
            'description' => 'A beautiful test route through the mountains',
            'departement' => 'Alpes-de-Haute-Provence',
            'status' => 'published'
        ]);
    });

    it('validates required fields for itinerary creation', function () {
        $response = $this->post('/store/itinerary', []);
        
        $response->assertSessionHasErrors(['title', 'description']);
    });

    it('validates title length for itinerary', function () {
        $response = $this->post('/store/itinerary', [
            'title' => str_repeat('a', 300), // Too long
            'description' => 'Valid description'
        ]);
        
        $response->assertSessionHasErrors(['title']);
    });

    it('can edit existing itinerary', function () {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Original Title'
        ]);

        $response = $this->get("/edit/itinerary/{$itinerary->id}");
        
        $response->assertStatus(200);
        $response->assertSee('Original Title');
        $response->assertSee('form');
    });

    it('can update existing itinerary', function () {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Original Title'
        ]);

        $data = [
            'id' => $itinerary->id,
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'difficulty_level' => 'difficile',
            'status' => 'published'
        ];

        $response = $this->post('/update/itinerary', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('itineraries', [
            'id' => $itinerary->id,
            'title' => 'Updated Title',
            'description' => 'Updated description'
        ]);
    });

    it('validates gpx file upload', function () {
        $invalidFile = UploadedFile::fake()->create('invalid.txt', 100, 'text/plain');
        
        $data = [
            'title' => 'Test Route',
            'description' => 'Test description',
            'gpx_file' => $invalidFile
        ];

        $response = $this->post('/store/itinerary', $data);
        
        $response->assertSessionHasErrors(['gpx_file']);
    });

    it('can upload multiple images for itinerary', function () {
        $images = [
            UploadedFile::fake()->image('image1.jpg', 800, 600),
            UploadedFile::fake()->image('image2.jpg', 800, 600),
            UploadedFile::fake()->image('image3.jpg', 800, 600)
        ];
        
        $data = [
            'title' => 'Multi Image Route',
            'description' => 'Route with multiple images',
            'images' => $images
        ];

        $response = $this->post('/store/itinerary', $data);
        
        $response->assertRedirect();
        
        $itinerary = Itinerary::where('title', 'Multi Image Route')->first();
        expect($itinerary)->not->toBeNull();
        expect($itinerary->images)->toHaveCount(3);
    });

    it('can delete itinerary', function () {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->get("/delete/itinerary/{$itinerary->id}");
        
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('itineraries', [
            'id' => $itinerary->id
        ]);
    });

    it('can publish and unpublish itinerary', function () {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'draft'
        ]);

        // Test publish
        $response = $this->post("/publish/itinerary/{$itinerary->id}");
        $response->assertRedirect();
        
        $this->assertDatabaseHas('itineraries', [
            'id' => $itinerary->id,
            'status' => 'published'
        ]);

        // Test unpublish
        $response = $this->post("/unpublish/itinerary/{$itinerary->id}");
        $response->assertRedirect();
        
        $this->assertDatabaseHas('itineraries', [
            'id' => $itinerary->id,
            'status' => 'draft'
        ]);
    });

    it('validates difficulty level options', function () {
        $response = $this->post('/store/itinerary', [
            'title' => 'Test Route',
            'description' => 'Test description',
            'difficulty_level' => 'invalid_level'
        ]);
        
        $response->assertSessionHasErrors(['difficulty_level']);
    });

    it('can access all itineraries list', function () {
        Itinerary::factory()->count(3)->create(['user_id' => $this->user->id]);
        
        $response = $this->get('/all/itinerary');
        
        $response->assertStatus(200);
        $response->assertSee('Liste des itinéraires');
    });
});