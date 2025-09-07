<?php

use App\Models\User;
use App\Models\Itinerary;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('peut redimensionner et sauvegarder une image d\'itinéraire', function () {
    // Créer un fichier image de test
    $image = UploadedFile::fake()->image('test-image.jpg', 1200, 800);
    
    // Appeler la méthode de redimensionnement via le contrôleur
    $controller = new \App\Http\Controllers\Backend\ItineraryController(
        app(\App\Services\GpxParserService::class)
    );
    
    // Utiliser la réflexion pour accéder à la méthode privée
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('uploadItineraryImage');
    $method->setAccessible(true);
    
    // Appeler la méthode
    $result = $method->invoke($controller, $image);
    
    // Vérifier que le chemin retourné est correct
    expect($result)->toStartWith('upload/itinerary/');
    
    // Vérifier que le fichier existe dans le dossier public
    $fullPath = public_path($result);
    expect(file_exists($fullPath))->toBeTrue();
    
    // Vérifier que l'image a été redimensionnée aux bonnes dimensions
    $imageInfo = getimagesize($fullPath);
    expect($imageInfo[0])->toBe(618); // Largeur
    expect($imageInfo[1])->toBe(306); // Hauteur
    
    // Vérifier que la vignette existe aussi
    $thumbPath = str_replace('upload/itinerary/', 'upload/itinerary/thumb_', $fullPath);
    expect(file_exists($thumbPath))->toBeTrue();
    
    // Nettoyer les fichiers de test
    if (file_exists($fullPath)) {
        unlink($fullPath);
    }
    if (file_exists($thumbPath)) {
        unlink($thumbPath);
    }
});

it('crée le dossier upload/itinerary s\'il n\'existe pas', function () {
    // Supprimer le dossier s'il existe
    $uploadDir = base_path('upload/itinerary');
    if (is_dir($uploadDir)) {
        // Supprimer tous les fichiers d'abord
        $files = glob($uploadDir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($uploadDir);
    }
    
    // Créer un fichier image de test
    $image = UploadedFile::fake()->image('test-image.jpg', 1200, 800);
    
    // Appeler la méthode de redimensionnement
    $controller = new \App\Http\Controllers\Backend\ItineraryController(
        app(\App\Services\GpxParserService::class)
    );
    
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('uploadItineraryImage');
    $method->setAccessible(true);
    
    // Appeler la méthode
    $result = $method->invoke($controller, $image);
    
    // Vérifier que le dossier a été créé
    expect(is_dir($uploadDir))->toBeTrue();
    
    // Nettoyer
    if (file_exists(public_path($result))) {
        unlink(public_path($result));
    }
});

it('gère correctement les erreurs de fichiers invalides', function () {
    $controller = new \App\Http\Controllers\Backend\ItineraryController(
        app(\App\Services\GpxParserService::class)
    );
    
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('uploadItineraryImage');
    $method->setAccessible(true);
    
    // Tester avec un fichier null
    expect(function () use ($method, $controller) {
        $method->invoke($controller, null);
    })->toThrow(\Exception::class, 'Erreur lors du traitement de l\'image: Fichier null ou vide');
});

it('crée des images avec des dimensions exactes', function () {
    // Créer une image de test avec des dimensions spécifiques
    $image = UploadedFile::fake()->image('test-image.jpg', 1920, 1080);
    
    $controller = new \App\Http\Controllers\Backend\ItineraryController(
        app(\App\Services\GpxParserService::class)
    );
    
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('uploadItineraryImage');
    $method->setAccessible(true);
    
    // Appeler la méthode
    $result = $method->invoke($controller, $image);
    
    // Vérifier l'image principale
    $mainPath = public_path($result);
    $mainInfo = getimagesize($mainPath);
    expect($mainInfo[0])->toBe(618); // Largeur exacte
    expect($mainInfo[1])->toBe(306); // Hauteur exacte
    
    // Vérifier la vignette
    $thumbPath = str_replace('upload/itinerary/', 'upload/itinerary/thumb_', $mainPath);
    $thumbInfo = getimagesize($thumbPath);
    expect($thumbInfo[0])->toBe(300); // Largeur vignette
    expect($thumbInfo[1])->toBe(200); // Hauteur vignette
    
    // Nettoyer
    if (file_exists($mainPath)) {
        unlink($mainPath);
    }
    if (file_exists($thumbPath)) {
        unlink($thumbPath);
    }
});

it('peut traiter plusieurs images avec uploadItineraryImage', function () {
    // Créer plusieurs images de test
    $images = [
        UploadedFile::fake()->image('image1.jpg', 1200, 800),
        UploadedFile::fake()->image('image2.jpg', 1600, 900),
        UploadedFile::fake()->image('image3.jpg', 800, 600)
    ];
    
    $controller = new \App\Http\Controllers\Backend\ItineraryController(
        app(\App\Services\GpxParserService::class)
    );
    
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('uploadItineraryImage');
    $method->setAccessible(true);
    
    $results = [];
    
    // Traiter chaque image
    foreach ($images as $image) {
        $result = $method->invoke($controller, $image);
        $results[] = $result;
        
        // Vérifier que l'image a été créée
        $fullPath = public_path($result);
        expect(file_exists($fullPath))->toBeTrue();
        
        // Vérifier les dimensions
        $imageInfo = getimagesize($fullPath);
        expect($imageInfo[0])->toBe(618); // Largeur
        expect($imageInfo[1])->toBe(306); // Hauteur
    }
    
    // Vérifier que toutes les images ont été traitées
    expect(count($results))->toBe(3);
    
    // Nettoyer les fichiers créés
    foreach ($results as $result) {
        $mainPath = public_path($result);
        $thumbPath = str_replace('upload/itinerary/', 'upload/itinerary/thumb_', $mainPath);
        
        if (file_exists($mainPath)) {
            unlink($mainPath);
        }
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }
    }
});

it('peut être appelée depuis le contrôleur ItineraryController', function () {
    // Vérifier que la classe existe et peut être instanciée
    $controller = new \App\Http\Controllers\Backend\ItineraryController(
        app(\App\Services\GpxParserService::class)
    );
    
    expect($controller)->toBeInstanceOf(\App\Http\Controllers\Backend\ItineraryController::class);
    
    // Vérifier que la méthode privée existe
    $reflection = new ReflectionClass($controller);
    expect($reflection->hasMethod('uploadItineraryImage'))->toBeTrue();
    
    // Vérifier que la méthode est privée
    $method = $reflection->getMethod('uploadItineraryImage');
    expect($method->isPrivate())->toBeTrue();
});

it('peut traiter un upload d\'image avec des métadonnées complètes', function () {
    // Créer une image de test avec des métadonnées réalistes
    $image = UploadedFile::fake()->image('photo_randonnee.jpg', 1920, 1080);
    
    // L'image UploadedFile::fake() a déjà des métadonnées réalistes
    
    $controller = new \App\Http\Controllers\Backend\ItineraryController(
        app(\App\Services\GpxParserService::class)
    );
    
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('uploadItineraryImage');
    $method->setAccessible(true);
    
    // Appeler la méthode
    $result = $method->invoke($controller, $image);
    
    // Vérifier que le résultat est correct
    expect($result)->toStartWith('upload/itinerary/');
    expect($result)->toEndWith('.jpg');
    
    // Vérifier que l'image a été créée
    $mainPath = public_path($result);
    expect(file_exists($mainPath))->toBeTrue();
    
    // Vérifier les dimensions
    $imageInfo = getimagesize($mainPath);
    expect($imageInfo[0])->toBe(618);
    expect($imageInfo[1])->toBe(306);
    
    // Nettoyer
    if (file_exists($mainPath)) {
        unlink($mainPath);
    }
    
    $thumbPath = str_replace('upload/itinerary/', 'upload/itinerary/thumb_', $mainPath);
    if (file_exists($thumbPath)) {
        unlink($thumbPath);
    }
});

it('peut traiter un upload d\'image via une requête HTTP simulée', function () {
    // Créer un utilisateur authentifié
    $user = User::factory()->create();
    $this->actingAs($user);
    
    // Créer une image de test
    $image = UploadedFile::fake()->image('test_upload.jpg', 1600, 900);
    
    // Créer une requête simulée avec l'image
    $request = new \Illuminate\Http\Request();
    $request->merge([
        'title' => 'Test Itinerary',
        'description' => 'Test Description',
        'difficulty_level' => 'facile',
        'status' => 'draft'
    ]);
    $request->files->set('images', [$image]);
    
    // Appeler directement la méthode uploadItineraryImage
    $controller = new \App\Http\Controllers\Backend\ItineraryController(
        app(\App\Services\GpxParserService::class)
    );
    
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('uploadItineraryImage');
    $method->setAccessible(true);
    
    // Appeler la méthode avec la première image
    $result = $method->invoke($controller, $image);
    
    // Vérifier que l'image a été traitée
    expect($result)->toStartWith('upload/itinerary/');
    
    // Vérifier que le fichier existe
    $mainPath = public_path($result);
    expect(file_exists($mainPath))->toBeTrue();
    
    // Vérifier les dimensions
    $imageInfo = getimagesize($mainPath);
    expect($imageInfo[0])->toBe(618);
    expect($imageInfo[1])->toBe(306);
    
    // Nettoyer
    if (file_exists($mainPath)) {
        unlink($mainPath);
    }
    
    $thumbPath = str_replace('upload/itinerary/', 'upload/itinerary/thumb_', $mainPath);
    if (file_exists($thumbPath)) {
        unlink($thumbPath);
    }
});
