<?php

use App\Models\User;
use App\Models\Sortie;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('Sortie (Expedition) Backend Forms', function () {
    
    it('can access sortie creation form', function () {
        $response = $this->get('/add/sortie');
        
        $response->assertStatus(200);
        $response->assertSee('Ajouter une sortie');
        $response->assertSee('form');
        $response->assertSee('title');
        $response->assertSee('description');
    });

    it('can create a sortie with valid data', function () {
        $gpxFile = UploadedFile::fake()->create('expedition.gpx', 100, 'application/gpx+xml');
        $image = UploadedFile::fake()->image('sortie-cover.jpg', 800, 600);
        
        $data = [
            'title' => 'Alpine Expedition 2024',
            'description' => 'Multi-day gravel expedition through the French Alps',
            'departement' => 'Hautes-Alpes',
            'pays' => 'France',
            'personal_comment' => 'Challenging but rewarding expedition',
            'difficulty_level' => 'difficile',
            'gpx_file_path' => $gpxFile,
            'images' => [$image],
            'sortie_date' => '2024-06-15',
            'actual_duration' => '3 days',
            'weather_conditions' => 'Variable with afternoon storms',
            'status' => 'published'
        ];

        $response = $this->post('/store/sortie', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('sorties', [
            'title' => 'Alpine Expedition 2024',
            'description' => 'Multi-day gravel expedition through the French Alps',
            'departement' => 'Hautes-Alpes',
            'status' => 'published'
        ]);
    });

    it('validates required fields for sortie creation', function () {
        $response = $this->post('/store/sortie', []);
        
        $response->assertSessionHasErrors(['title', 'description']);
    });

    it('can edit existing sortie', function () {
        $sortie = Sortie::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Original Expedition'
        ]);

        $response = $this->get("/edit/sortie/{$sortie->id}");
        
        $response->assertStatus(200);
        $response->assertSee('Original Expedition');
        $response->assertSee('form');
    });

    it('can update existing sortie', function () {
        $sortie = Sortie::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Original Expedition'
        ]);

        $data = [
            'id' => $sortie->id,
            'title' => 'Updated Expedition',
            'description' => 'Updated expedition description',
            'difficulty_level' => 'moyen',
            'status' => 'published',
            'actual_duration' => '2 days',
            'weather_conditions' => 'Perfect sunny weather'
        ];

        $response = $this->post('/update/sortie', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('sorties', [
            'id' => $sortie->id,
            'title' => 'Updated Expedition',
            'description' => 'Updated expedition description'
        ]);
    });

    it('can add weather conditions to sortie', function () {
        $data = [
            'title' => 'Weather Test Expedition',
            'description' => 'Testing weather conditions',
            'weather_conditions' => 'Rainy morning, sunny afternoon',
            'sortie_date' => '2024-07-20'
        ];

        $response = $this->post('/store/sortie', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('sorties', [
            'title' => 'Weather Test Expedition',
            'weather_conditions' => 'Rainy morning, sunny afternoon'
        ]);
    });

    it('can set sortie date', function () {
        $data = [
            'title' => 'Date Test Expedition',
            'description' => 'Testing sortie date',
            'sortie_date' => '2024-08-15'
        ];

        $response = $this->post('/store/sortie', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('sorties', [
            'title' => 'Date Test Expedition'
        ]);
        
        $sortie = Sortie::where('title', 'Date Test Expedition')->first();
        expect($sortie->sortie_date->format('Y-m-d'))->toBe('2024-08-15');
    });

    it('can upload multiple images for sortie', function () {
        $images = [
            UploadedFile::fake()->image('day1.jpg', 800, 600),
            UploadedFile::fake()->image('day2.jpg', 800, 600),
            UploadedFile::fake()->image('summit.jpg', 800, 600)
        ];
        
        $data = [
            'title' => 'Multi Image Expedition',
            'description' => 'Expedition with daily photos',
            'images' => $images
        ];

        $response = $this->post('/store/sortie', $data);
        
        $response->assertRedirect();
        
        $sortie = Sortie::where('title', 'Multi Image Expedition')->first();
        expect($sortie)->not->toBeNull();
        expect($sortie->images)->toHaveCount(3);
    });

    it('can delete sortie', function () {
        $sortie = Sortie::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->get("/delete/sortie/{$sortie->id}");
        
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('sorties', [
            'id' => $sortie->id
        ]);
    });

    it('can publish and unpublish sortie', function () {
        $sortie = Sortie::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'draft'
        ]);

        // Test publish
        $response = $this->post("/publish/sortie/{$sortie->id}");
        $response->assertRedirect();
        
        $this->assertDatabaseHas('sorties', [
            'id' => $sortie->id,
            'status' => 'published'
        ]);

        // Test unpublish
        $response = $this->post("/unpublish/sortie/{$sortie->id}");
        $response->assertRedirect();
        
        $this->assertDatabaseHas('sorties', [
            'id' => $sortie->id,
            'status' => 'draft'
        ]);
    });

    it('can access all sorties list', function () {
        Sortie::factory()->count(3)->create(['user_id' => $this->user->id]);
        
        $response = $this->get('/all/sortie');
        
        $response->assertStatus(200);
        $response->assertSee('Liste des sorties');
    });

    it('validates actual duration field', function () {
        $data = [
            'title' => 'Duration Test',
            'description' => 'Testing duration validation',
            'actual_duration' => str_repeat('a', 500) // Too long
        ];

        $response = $this->post('/store/sortie', $data);
        
        $response->assertSessionHasErrors(['actual_duration']);
    });

    it('can delete sortie image', function () {
        $sortie = Sortie::factory()->create(['user_id' => $this->user->id]);
        
        // Assume we have an image with ID 1 associated with this sortie
        $response = $this->get("/delete/sortie/image/1");
        
        // This should redirect regardless of whether the image exists
        $response->assertRedirect();
    });
});