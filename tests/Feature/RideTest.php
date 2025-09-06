<?php

use App\Models\Ride;
use App\Models\RideMedia;
use App\Models\User;
use App\Services\RideMediaService;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can display rides index page', function () {
    $response = $this->get('/rides');
    
    $response->assertStatus(200);
});

it('can display a single ride', function () {
    // Créer un utilisateur et une sortie de test
    $user = User::factory()->create();
    $ride = Ride::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Ride',
        'slug' => 'test-ride-' . Str::random(6),
        'ride_date' => now(),
        'distance_km' => 25.5,
        'elevation_gain_m' => 300,
        'moving_time_sec' => 3600,
        'cover_image_path' => 'upload/ride/test-image.jpg',
    ]);

    $response = $this->get("/rides/{$ride->slug}");
    
    $response->assertStatus(200);
    $response->assertSee('Test Ride');
});

it('displays GPX map when ride has GPX file', function () {
    // Créer un utilisateur et une sortie de test avec GPX
    $user = User::factory()->create();
    $ride = Ride::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Ride with GPX',
        'slug' => 'test-ride-gpx-' . Str::random(6),
        'ride_date' => now(),
        'distance_km' => 25.5,
        'elevation_gain_m' => 300,
        'moving_time_sec' => 3600,
        'gpx_path' => 'storage/rides/gpx/test-ride.gpx',
        'cover_image_path' => 'upload/ride/test-image.jpg',
    ]);

    $response = $this->get("/rides/{$ride->slug}");
    
    $response->assertStatus(200);
    $response->assertSee('Parcours GPX');
    $response->assertSee('gpx-map-' . $ride->id);
    $response->assertSee('leaflet');
    $response->assertSee('Télécharger GPX');
    $response->assertSee('Centrer la carte');
});

it('displays ride statistics correctly in public view', function () {
    // Créer un utilisateur et une sortie de test
    $user = User::factory()->create();
    $ride = Ride::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Ride Stats',
        'slug' => 'test-ride-stats-' . Str::random(6),
        'ride_date' => now(),
        'distance_km' => 42.0,
        'elevation_gain_m' => 850,
        'moving_time_sec' => 7200, // 2 heures
        'cover_image_path' => 'upload/ride/test-image.jpg',
    ]);

    $response = $this->get("/rides/{$ride->slug}");
    
    $response->assertStatus(200);
    $response->assertSee('42.0 km');
    $response->assertSee('850 m');
    $response->assertSee('02:00:00');
    $response->assertSee('21.0 km/h'); // 42 km / 2h
});

it('ride model has required attributes', function () {
    $ride = new Ride();
    
    expect($ride->getFillable())->toContain('cover_image_path');
    expect($ride->getFillable())->toContain('title');
    expect($ride->getFillable())->toContain('distance_km');
});

it('can create ride with cover image', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $image = UploadedFile::fake()->image('cover.jpg', 800, 600);
    
    $response = $this->post('/admin/rides', [
        'title' => 'Test Ride with Image',
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'elevation_gain_m' => 300,
        'experience' => 'Great ride!',
        'cover_image' => $image,
        'weather' => ['ensoleille'],
    ]);
    
    $response->assertRedirect();
    
    $ride = Ride::where('title', 'Test Ride with Image')->first();
    expect($ride)->not->toBeNull();
    expect($ride->cover_image_path)->toContain('upload/ride/');
});

it('can create ride without cover image (validation test)', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $response = $this->post('/admin/rides', [
        'title' => 'Test Ride No Image',
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'elevation_gain_m' => 300,
        'experience' => 'Great ride!',
        'weather' => ['ensoleille'],
    ]);
    
    // Devrait échouer car cover_image est requis
    $response->assertSessionHasErrors(['cover_image']);
});

it('can create ride with total time', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $image = UploadedFile::fake()->image('cover.jpg', 800, 600);
    
    $response = $this->post('/admin/rides', [
        'title' => 'Test Ride with Total Time',
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'total_time' => '02:00',
        'elevation_gain_m' => 300,
        'experience' => 'Great ride with breaks!',
        'cover_image' => $image,
        'weather' => ['ensoleille', 'nuageux'],
    ]);
    
    $response->assertRedirect();
    
    $ride = Ride::where('title', 'Test Ride with Total Time')->first();
    expect($ride)->not->toBeNull();
    expect($ride->total_time_sec)->toBe(7200); // 2 heures = 7200 secondes
    expect($ride->moving_time_sec)->toBe(5400); // 1h30 = 5400 secondes
});

it('can create ride with weather conditions', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $image = UploadedFile::fake()->image('cover.jpg', 800, 600);
    
    $response = $this->post('/admin/rides', [
        'title' => 'Test Ride with Weather',
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'elevation_gain_m' => 300,
        'experience' => 'Ride in various weather conditions',
        'cover_image' => $image,
        'weather' => ['ensoleille', 'vent', 'pluie'],
    ]);
    
    $response->assertRedirect();
    
    $ride = Ride::where('title', 'Test Ride with Weather')->first();
    expect($ride)->not->toBeNull();
    expect($ride->weather)->toBe(['ensoleille', 'vent', 'pluie']);
});

it('can display add ride form', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $response = $this->get('/admin/rides/create');
    
    $response->assertStatus(200);
    $response->assertSee('Ajouter une Sortie');
    
    // Vérifier que le formulaire contient les éléments essentiels
    $response->assertSee('form');
    $response->assertSee('POST');
});

it('form contains cover_image field', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    $response = $this->get('/admin/rides/create');
    
    $response->assertStatus(200);
    $response->assertSee('cover_image');
});

it('can submit form and create ride via web interface', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    // Créer une image de test
    $image = UploadedFile::fake()->image('cover.jpg', 800, 600);
    
    // Simuler la soumission du formulaire exactement comme dans l'interface
    $response = $this->post('/admin/rides', [
        'title' => 'Test Ride Web Interface ' . time(),
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'elevation_gain_m' => 300,
        'experience' => 'Test de l\'interface web',
        'cover_image' => $image,
        'weather' => ['ensoleille'],
    ]);
    
    // Vérifier la réponse
    if ($response->getStatusCode() !== 302) {
        echo "Status code: " . $response->getStatusCode() . "\n";
        echo "Contenu de la réponse: " . $response->getContent() . "\n";
    }
    
    $response->assertStatus(302); // Redirection après succès
    
    // Vérifier que la ride a été créée
    $ride = Ride::where('title', 'like', 'Test Ride Web Interface%')->first();
    expect($ride)->not->toBeNull();
    expect($ride->user_id)->toBe($user->id);
    expect($ride->cover_image_path)->toContain('upload/ride/');
});

it('debug ride creation process step by step', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    // Étape 1: Vérifier l'authentification
    $this->assertTrue(auth()->check());
    $this->assertEquals($user->id, auth()->id());
    
    // Étape 2: Vérifier l'accès au formulaire
    $createResponse = $this->get('/admin/rides/create');
    $createResponse->assertStatus(200);
    $createResponse->assertSee('Ajouter une Sortie');
    
    // Étape 3: Vérifier que le formulaire contient le token CSRF
    $createResponse->assertSee('_token');
    
    // Étape 4: Créer une image de test
    $image = UploadedFile::fake()->image('debug-cover.jpg', 800, 600);
    
    // Étape 5: Préparer les données de test
    $testData = [
        'title' => 'Debug Ride ' . time(),
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'elevation_gain_m' => 300,
        'experience' => 'Test de débogage étape par étape',
        'cover_image' => $image,
        'weather' => ['ensoleille'],
    ];
    
    // Étape 6: Soumettre le formulaire
    $storeResponse = $this->post('/admin/rides', $testData);
    
    // Étape 7: Analyser la réponse
    echo "Status code: " . $storeResponse->getStatusCode() . "\n";
    echo "Headers: " . json_encode($storeResponse->headers->all()) . "\n";
    
    if ($storeResponse->getStatusCode() !== 302) {
        echo "Contenu de la réponse: " . $storeResponse->getContent() . "\n";
    }
    
    // Étape 8: Vérifier la redirection
    $storeResponse->assertStatus(302);
    
    // Étape 9: Vérifier que la ride a été créée
    $ride = Ride::where('title', 'like', 'Debug Ride%')->first();
    expect($ride)->not->toBeNull();
    expect($ride->user_id)->toBe($user->id);
    expect($ride->title)->toBe($testData['title']);
    expect($ride->cover_image_path)->toContain('upload/ride/');
    
    // Étape 10: Vérifier la redirection vers la page de détail
    $redirectLocation = $storeResponse->headers->get('Location');
    echo "Redirection vers: " . $redirectLocation . "\n";
    
    expect($redirectLocation)->toContain('/admin/rides/');
});

it('verifies session and authentication state', function () {
    $user = User::factory()->create();
    
    // Étape 1: Se connecter et vérifier la session
    $this->actingAs($user);
    
    // Étape 2: Vérifier l'état de l'authentification
    $this->assertTrue(auth()->check());
    $this->assertEquals($user->id, auth()->id());
    
    // Étape 3: Accéder au formulaire et vérifier la session
    $createResponse = $this->get('/admin/rides/create');
    $createResponse->assertStatus(200);
    
    // Étape 4: Vérifier que le formulaire contient le bon utilisateur
    $createResponse->assertSee($user->name);
    
    // Étape 5: Vérifier les cookies de session
    $cookies = $createResponse->headers->getCookies();
    echo "Cookies de session trouvés: " . count($cookies) . "\n";
    
    foreach ($cookies as $cookie) {
        echo "Cookie: " . $cookie->getName() . " = " . $cookie->getValue() . "\n";
    }
    
    // Étape 6: Vérifier que la session contient l'utilisateur
    $session = app('session');
    echo "Session ID: " . $session->getId() . "\n";
    echo "User ID dans la session: " . $session->get('auth.user_id', 'Non défini') . "\n";
    
    // Étape 7: Tester la création de ride avec la même session
    $image = UploadedFile::fake()->image('session-test.jpg', 800, 600);
    
    $storeResponse = $this->post('/admin/rides', [
        'title' => 'Session Test Ride ' . time(),
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'elevation_gain_m' => 300,
        'experience' => 'Test de session',
        'cover_image' => $image,
        'weather' => ['ensoleille'],
    ]);
    
    // Étape 8: Vérifier la réponse
    $storeResponse->assertStatus(302);
    
    // Étape 9: Vérifier que la ride a été créée
    $ride = Ride::where('title', 'like', 'Session Test Ride%')->first();
    expect($ride)->not->toBeNull();
    expect($ride->user_id)->toBe($user->id);
    
    echo "✅ Test de session réussi - Ride créée avec ID: " . $ride->id . "\n";
});

it('diagnoses and fixes session authentication issue', function () {
    $user = User::factory()->create();
    
    // Étape 1: Se connecter normalement
    $this->actingAs($user);
    
    // Étape 2: Vérifier l'état initial
    $this->assertTrue(auth()->check());
    $this->assertEquals($user->id, auth()->id());
    
    // Étape 3: Accéder au formulaire
    $createResponse = $this->get('/admin/rides/create');
    $createResponse->assertStatus(200);
    
    // Étape 4: Diagnostiquer le problème de session
    $session = app('session');
    echo "=== DIAGNOSTIC DE SESSION ===\n";
    echo "Session ID: " . $session->getId() . "\n";
    echo "User ID dans la session: " . $session->get('auth.user_id', 'Non défini') . "\n";
    echo "User ID via auth(): " . auth()->id() . "\n";
    echo "Session data: " . json_encode($session->all()) . "\n";
    
    // Étape 5: Tester la création de ride malgré le problème de session
    $image = UploadedFile::fake()->image('session-fix.jpg', 800, 600);
    
    $storeResponse = $this->post('/admin/rides', [
        'title' => 'Session Fix Test ' . time(),
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'elevation_gain_m' => 300,
        'experience' => 'Test de correction de session',
        'cover_image' => $image,
        'weather' => ['ensoleille'],
    ]);
    
    // Étape 6: Vérifier la réponse
    $storeResponse->assertStatus(302);
    
    // Étape 7: Vérifier que la ride a été créée
    $ride = Ride::where('title', 'like', 'Session Fix Test%')->first();
    expect($ride)->not->toBeNull();
    expect($ride->user_id)->toBe($user->id);
    
    echo "✅ Ride créée avec succès malgré le problème de session\n";
    echo "Ride ID: " . $ride->id . ", User ID: " . $ride->user_id . "\n";
    
    // Étape 8: Analyser pourquoi ça fonctionne quand même
    echo "\n=== ANALYSE ===\n";
    echo "Le problème de session n'empêche PAS la création de ride\n";
    echo "Cela suggère que le problème est ailleurs (interface utilisateur?)\n";
});

it('simulates complete browser workflow', function () {
    $user = User::factory()->create();
    
    // Simuler le workflow complet du navigateur
    
    // Étape 1: Se connecter
    $this->actingAs($user);
    
    // Étape 2: Accéder au dashboard
    $dashboardResponse = $this->get('/dashboard');
    $dashboardResponse->assertStatus(200);
    echo "✅ Dashboard accessible\n";
    
    // Étape 3: Accéder à la liste des rides
    $ridesIndexResponse = $this->get('/admin/rides');
    $ridesIndexResponse->assertStatus(200);
    echo "✅ Liste des rides accessible\n";
    
    // Étape 4: Accéder au formulaire de création
    $createResponse = $this->get('/admin/rides/create');
    $createResponse->assertStatus(200);
    $createResponse->assertSee('Ajouter une Sortie');
    echo "✅ Formulaire de création accessible\n";
    
    // Étape 5: Vérifier que le formulaire contient tous les éléments
    $createResponse->assertSee('title');
    $createResponse->assertSee('ride_date');
    $createResponse->assertSee('distance_km');
    $createResponse->assertSee('moving_time');
    $createResponse->assertSee('cover_image');
    $createResponse->assertSee('_token');
    echo "✅ Tous les champs du formulaire présents\n";
    
    // Étape 6: Soumettre le formulaire
    $image = UploadedFile::fake()->image('browser-test.jpg', 800, 600);
    
    $storeResponse = $this->post('/admin/rides', [
        'title' => 'Browser Workflow Test ' . time(),
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'elevation_gain_m' => 300,
        'experience' => 'Test du workflow navigateur complet',
        'cover_image' => $image,
        'weather' => ['ensoleille'],
    ]);
    
    // Étape 7: Vérifier la réponse
    $storeResponse->assertStatus(302);
    echo "✅ Formulaire soumis avec succès (redirection 302)\n";
    
    // Étape 8: Vérifier la redirection
    $redirectLocation = $storeResponse->headers->get('Location');
    echo "📍 Redirection vers: " . $redirectLocation . "\n";
    
    // Étape 9: Vérifier que la ride a été créée
    $ride = Ride::where('title', 'like', 'Browser Workflow Test%')->first();
    expect($ride)->not->toBeNull();
    expect($ride->user_id)->toBe($user->id);
    echo "✅ Ride créée avec succès - ID: " . $ride->id . "\n";
    
    // Étape 10: Accéder à la page de détail de la ride
    $showResponse = $this->get($redirectLocation);
    $showResponse->assertStatus(200);
    $showResponse->assertSee($ride->title);
    echo "✅ Page de détail de la ride accessible\n";
    
    echo "\n🎉 WORKFLOW COMPLET RÉUSSI !\n";
    echo "Le problème n'est PAS dans le code Laravel\n";
    echo "Vérifiez votre navigateur et votre session\n";
});

// Tests pour les nouvelles fonctionnalités refactorées

it('validates ride creation with improved validation rules', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    
    // Test avec date dans le futur
    $response = $this->post('/admin/rides', [
        'title' => 'Future Ride',
        'ride_date' => now()->addDay()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'cover_image' => UploadedFile::fake()->image('cover.jpg', 800, 600)
    ]);
    
    $response->assertSessionHasErrors(['ride_date']);
});

it('validates ride creation with distance limits', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    
    // Test avec distance trop grande
    $response = $this->post('/admin/rides', [
        'title' => 'Too Far Ride',
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 1500, // Au-dessus de la limite de 1000km
        'moving_time' => '01:30',
        'cover_image' => UploadedFile::fake()->image('cover.jpg', 800, 600)
    ]);
    
    $response->assertSessionHasErrors(['distance_km']);
});

it('validates maximum number of images', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    
    // Créer plus d'images que la limite autorisée
    $images = [];
    for ($i = 0; $i < 15; $i++) { // Au-dessus de la limite de 12
        $images[] = UploadedFile::fake()->image("image{$i}.jpg", 400, 400);
    }
    
    $response = $this->post('/admin/rides', [
        'title' => 'Too Many Images Ride',
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'cover_image' => UploadedFile::fake()->image('cover.jpg', 800, 600),
        'images' => $images
    ]);
    
    $response->assertSessionHasErrors(['images']);
});

it('validates image dimensions', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    
    // Test avec image trop petite
    $response = $this->post('/admin/rides', [
        'title' => 'Small Image Ride',
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'cover_image' => UploadedFile::fake()->image('small.jpg', 100, 100) // Trop petit
    ]);
    
    $response->assertSessionHasErrors(['cover_image']);
});

it('creates ride with multiple images using media service', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    
    $coverImage = UploadedFile::fake()->image('cover.jpg', 800, 600);
    $images = [
        UploadedFile::fake()->image('image1.jpg', 600, 400),
        UploadedFile::fake()->image('image2.png', 800, 600),
        UploadedFile::fake()->image('image3.webp', 400, 300)
    ];
    
    $response = $this->post('/admin/rides', [
        'title' => 'Multi Image Ride Test',
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'elevation_gain_m' => 300,
        'experience' => 'Test avec plusieurs images',
        'cover_image' => $coverImage,
        'images' => $images,
        'weather' => ['ensoleille', 'vent']
    ]);
    
    $response->assertRedirect();
    
    $ride = Ride::where('title', 'Multi Image Ride Test')->first();
    expect($ride)->not->toBeNull();
    expect($ride->media)->toHaveCount(3);
    expect($ride->media_count)->toBe(3);
    
    // Vérifier que les fichiers sont stockés dans le bon répertoire
    expect($ride->cover_image_path)->toContain('storage/rides/covers/');
    
    foreach ($ride->media as $media) {
        expect($media->file_path)->toContain('storage/rides/images/');
        expect($media->width)->toBeGreaterThan(0);
        expect($media->height)->toBeGreaterThan(0);
    }
});

it('updates ride with new images using media service', function () {
    $user = User::factory()->create();
    $ride = Ride::factory()->create(['user_id' => $user->id]);
    
    $this->actingAs($user);
    
    $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    
    $newCoverImage = UploadedFile::fake()->image('new-cover.jpg', 800, 600);
    $newImages = [
        UploadedFile::fake()->image('new1.jpg', 600, 400),
        UploadedFile::fake()->image('new2.png', 800, 600)
    ];
    
    $response = $this->put(route('admin.rides.update', $ride), [
        'title' => 'Updated Ride Title',
        'ride_date' => $ride->ride_date->format('Y-m-d'),
        'distance_km' => $ride->distance_km,
        'moving_time' => '02:00',
        'cover_image' => $newCoverImage,
        'images' => $newImages
    ]);
    
    $response->assertRedirect();
    
    $ride->refresh();
    expect($ride->title)->toBe('Updated Ride Title');
    expect($ride->moving_time_sec)->toBe(7200); // 2 heures
    expect($ride->cover_image_path)->toContain('storage/rides/covers/');
    expect($ride->media)->toHaveCount(2);
});

it('deletes ride with all associated media files', function () {
    $user = User::factory()->create();
    $ride = Ride::factory()->create(['user_id' => $user->id]);
    
    // Créer des médias associés
    $media1 = RideMedia::create([
        'ride_id' => $ride->id,
        'type' => 'image',
        'file_path' => 'storage/rides/images/test1.jpg',
        'order' => 1,
        'width' => 800,
        'height' => 600
    ]);
    
    $media2 = RideMedia::create([
        'ride_id' => $ride->id,
        'type' => 'image',
        'file_path' => 'storage/rides/images/test2.jpg',
        'order' => 2,
        'width' => 600,
        'height' => 400
    ]);
    
    $this->actingAs($user);
    
    $response = $this->delete(route('admin.rides.destroy', $ride));
    
    $response->assertRedirect(route('admin.rides.index'));
    
    // Vérifier que la ride et tous les médias ont été supprimés
    expect(Ride::find($ride->id))->toBeNull();
    expect(RideMedia::where('ride_id', $ride->id)->count())->toBe(0);
});

it('handles gpx file upload correctly', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    
    // Créer un fichier GPX fictif
    $gpxContent = '<?xml version="1.0"?>
    <gpx xmlns="http://www.topografix.com/GPX/1/1" version="1.1">
        <trk>
            <trkseg>
                <trkpt lat="46.5197" lon="6.6323">
                    <ele>372</ele>
                </trkpt>
                <trkpt lat="46.5198" lon="6.6324">
                    <ele>373</ele>
                </trkpt>
            </trkseg>
        </trk>
    </gpx>';
    
    $gpxFile = UploadedFile::fake()->createWithContent('test.gpx', $gpxContent);
    
    $response = $this->post('/admin/rides', [
        'title' => 'GPX Test Ride',
        'ride_date' => now()->format('Y-m-d'),
        'distance_km' => 25.5,
        'moving_time' => '01:30',
        'cover_image' => UploadedFile::fake()->image('cover.jpg', 800, 600),
        'gpx' => $gpxFile
    ]);
    
    $response->assertRedirect();
    
    $ride = Ride::where('title', 'GPX Test Ride')->first();
    expect($ride)->not->toBeNull();
    expect($ride->gpx_path)->toContain('storage/rides/gpx/');
    expect($ride->gpx_path)->toEndWith('.gpx');
});

it('tests ride media service directly', function () {
    $user = User::factory()->create();
    $ride = Ride::factory()->create([
        'user_id' => $user->id,
        'media_count' => 0,
        'cover_image_path' => null
    ]);
    $mediaService = app(RideMediaService::class);
    
    // Test storeCoverImage
    $coverImage = UploadedFile::fake()->image('test-cover.jpg', 800, 600);
    $coverPath = $mediaService->storeCoverImage($ride, $coverImage);
    
    expect($coverPath)->toContain('storage/rides/covers/');
    expect($ride->fresh()->cover_image_path)->toBe($coverPath);
    
    // Test storeImage
    $image = UploadedFile::fake()->image('test-image.jpg', 600, 400);
    $media = $mediaService->storeImage($ride, $image);
    
    expect($media)->toBeInstanceOf(RideMedia::class);
    expect($media->file_path)->toContain('storage/rides/images/');
    expect($media->type)->toBe('image');
    expect($ride->fresh()->media_count)->toBe(1);
    
    // Test storeGpxFile
    $gpxContent = '<?xml version="1.0"?><gpx></gpx>';
    $gpxFile = UploadedFile::fake()->createWithContent('test.gpx', $gpxContent);
    $gpxPath = $mediaService->storeGpxFile($ride, $gpxFile);
    
    expect($gpxPath)->toContain('storage/rides/gpx/');
    expect($ride->fresh()->gpx_path)->toBe($gpxPath);
});

it('tests ajax media upload endpoint', function () {
    $user = User::factory()->create();
    $ride = Ride::factory()->create(['user_id' => $user->id]);
    
    $this->actingAs($user);
    
    $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    
    $image = UploadedFile::fake()->image('ajax-test.jpg', 600, 400);
    
    $response = $this->post(route('admin.rides.media.upload', $ride), [
        'file' => $image
    ]);
    
    $response->assertJson(['success' => true]);
    
    $responseData = $response->json();
    expect($responseData['media']['id'])->toBeInt();
    expect($responseData['media']['path'])->toContain('storage/rides/images/');
    expect($responseData['message'])->toBe('Image uploadée avec succès');
    
    // Vérifier que le média a été créé en base
    expect(RideMedia::find($responseData['media']['id']))->not->toBeNull();
});
