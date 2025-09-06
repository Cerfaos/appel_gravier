<?php

namespace App\Services;

use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class ItineraryService
{
    private GpxParserService $gpxParser;
    private ImageOptimizationService $imageOptimizer;

    public function __construct(
        GpxParserService $gpxParser,
        ImageOptimizationService $imageOptimizer
    ) {
        $this->gpxParser = $gpxParser;
        $this->imageOptimizer = $imageOptimizer;
    }

    /**
     * Create a new itinerary with all associated data
     */
    public function create(array $data, User $user): Itinerary
    {
        return DB::transaction(function () use ($data, $user) {
            try {
                // Create base itinerary
                $itinerary = $this->createBaseItinerary($data, $user);
                
                // Process GPX file if uploaded
                if (isset($data['gpx_file']) && $data['gpx_file'] instanceof UploadedFile) {
                    $this->processGpxFile($itinerary, $data['gpx_file']);
                }
                
                // Process images if uploaded
                if (isset($data['images']) && is_array($data['images'])) {
                    $this->processImages($itinerary, $data['images'], $data['image_captions'] ?? []);
                }
                
                // Set featured image if specified
                if (isset($data['featured_image_index'])) {
                    $this->setFeaturedImage($itinerary, (int) $data['featured_image_index']);
                }
                
                Log::info('Itinerary created successfully', [
                    'itinerary_id' => $itinerary->id,
                    'user_id' => $user->id,
                    'title' => $itinerary->title
                ]);
                
                return $itinerary->fresh(['images', 'user']);
                
            } catch (Exception $e) {
                Log::error('Itinerary creation failed', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'data' => array_except($data, ['gpx_file', 'images'])
                ]);
                throw $e;
            }
        });
    }

    /**
     * Update an existing itinerary
     */
    public function update(Itinerary $itinerary, array $data): Itinerary
    {
        return DB::transaction(function () use ($itinerary, $data) {
            try {
                // Update base data
                $this->updateBaseItinerary($itinerary, $data);
                
                // Process new GPX file if uploaded
                if (isset($data['gpx_file']) && $data['gpx_file'] instanceof UploadedFile) {
                    $this->processGpxFile($itinerary, $data['gpx_file'], true);
                }
                
                // Process new images if uploaded
                if (isset($data['images']) && is_array($data['images'])) {
                    $this->processImages($itinerary, $data['images'], $data['image_captions'] ?? []);
                }
                
                // Update featured image if specified
                if (isset($data['featured_image_index'])) {
                    $this->setFeaturedImage($itinerary, (int) $data['featured_image_index']);
                }
                
                Log::info('Itinerary updated successfully', [
                    'itinerary_id' => $itinerary->id,
                    'title' => $itinerary->title
                ]);
                
                return $itinerary->fresh(['images', 'user']);
                
            } catch (Exception $e) {
                Log::error('Itinerary update failed', [
                    'itinerary_id' => $itinerary->id,
                    'error' => $e->getMessage()
                ]);
                throw $e;
            }
        });
    }

    /**
     * Delete an itinerary and clean up associated files
     */
    public function delete(Itinerary $itinerary): bool
    {
        return DB::transaction(function () use ($itinerary) {
            try {
                // Delete GPX file
                if ($itinerary->gpx_file_path && Storage::disk('public')->exists($itinerary->gpx_file_path)) {
                    Storage::disk('public')->delete($itinerary->gpx_file_path);
                }
                
                // Delete images
                if ($itinerary->images) {
                    foreach ($itinerary->images as $image) {
                        $this->imageOptimizer->deleteImage($image->image_path);
                    }
                }
                
                // Delete the itinerary (this will cascade delete images via database constraints)
                $deleted = $itinerary->delete();
                
                Log::info('Itinerary deleted successfully', [
                    'itinerary_id' => $itinerary->id,
                    'title' => $itinerary->title
                ]);
                
                return $deleted;
                
            } catch (Exception $e) {
                Log::error('Itinerary deletion failed', [
                    'itinerary_id' => $itinerary->id,
                    'error' => $e->getMessage()
                ]);
                throw $e;
            }
        });
    }

    /**
     * Create base itinerary record
     */
    private function createBaseItinerary(array $data, User $user): Itinerary
    {
        return Itinerary::create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'slug' => $this->generateUniqueSlug($data['title']),
            'description' => $data['description'],
            'personal_comment' => $data['personal_comment'] ?? null,
            'difficulty_level' => $data['difficulty_level'],
            'departement' => $data['departement'] ?? null,
            'pays' => $data['pays'] ?? null,
            'status' => $data['status'] ?? 'draft',
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
        ]);
    }

    /**
     * Update base itinerary data
     */
    private function updateBaseItinerary(Itinerary $itinerary, array $data): void
    {
        $updateData = [];
        
        $fillableFields = [
            'title', 'description', 'personal_comment', 'difficulty_level',
            'departement', 'pays', 'status', 'meta_title', 'meta_description'
        ];
        
        foreach ($fillableFields as $field) {
            if (isset($data[$field])) {
                $updateData[$field] = $data[$field];
            }
        }
        
        // Update slug if title changed
        if (isset($data['title']) && $data['title'] !== $itinerary->title) {
            $updateData['slug'] = $this->generateUniqueSlug($data['title'], $itinerary->id);
        }
        
        $itinerary->update($updateData);
    }

    /**
     * Process GPX file upload
     */
    private function processGpxFile(Itinerary $itinerary, UploadedFile $gpxFile, bool $isUpdate = false): void
    {
        // Delete old GPX file if updating
        if ($isUpdate && $itinerary->gpx_file_path && Storage::disk('public')->exists($itinerary->gpx_file_path)) {
            Storage::disk('public')->delete($itinerary->gpx_file_path);
        }
        
        // Parse GPX content
        $gpxContent = file_get_contents($gpxFile->getRealPath());
        $gpxData = $this->gpxParser->parse($gpxContent);
        
        // Store GPX file
        $filename = 'gpx/' . Str::uuid() . '.gpx';
        Storage::disk('public')->put($filename, $gpxContent);
        
        // Update itinerary with GPX data
        $itinerary->update([
            'gpx_file_path' => $filename,
            'distance_km' => $gpxData['statistics']['distance_km'],
            'elevation_gain_m' => $gpxData['statistics']['elevation_gain_m'],
            'elevation_loss_m' => $gpxData['statistics']['elevation_loss_m'],
            'min_latitude' => $gpxData['statistics']['min_latitude'],
            'max_latitude' => $gpxData['statistics']['max_latitude'],
            'min_longitude' => $gpxData['statistics']['min_longitude'],
            'max_longitude' => $gpxData['statistics']['max_longitude'],
        ]);
    }

    /**
     * Process uploaded images
     */
    private function processImages(Itinerary $itinerary, array $images, array $captions = []): void
    {
        $processedImages = $this->imageOptimizer->processImages($images, 'itineraries');
        
        foreach ($processedImages as $imageData) {
            $caption = $captions[$imageData['index']] ?? null;
            
            $itinerary->images()->create([
                'image_path' => $imageData['path'],
                'caption' => $caption,
                'is_featured' => false,
                'order_position' => $imageData['index']
            ]);
        }
    }

    /**
     * Set featured image for itinerary
     */
    private function setFeaturedImage(Itinerary $itinerary, int $imageIndex): void
    {
        $image = $itinerary->images()->where('order_position', $imageIndex)->first();
        
        if ($image) {
            // Reset all images to not featured
            $itinerary->images()->update(['is_featured' => false]);
            
            // Set the selected image as featured
            $image->update(['is_featured' => true]);
        }
    }

    /**
     * Generate unique slug for itinerary
     */
    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;
        
        while ($this->slugExists($slug, $excludeId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Check if slug exists
     */
    private function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = Itinerary::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Publish an itinerary
     */
    public function publish(Itinerary $itinerary): bool
    {
        // Validate that itinerary has required data for publishing
        if (!$this->canBePublished($itinerary)) {
            throw new Exception('Itinerary cannot be published - missing required data');
        }
        
        return $itinerary->update([
            'status' => 'published',
            'published_at' => now()
        ]);
    }

    /**
     * Check if itinerary can be published
     */
    private function canBePublished(Itinerary $itinerary): bool
    {
        return !empty($itinerary->title) &&
               !empty($itinerary->description) &&
               !empty($itinerary->difficulty_level) &&
               $itinerary->gpx_file_path !== null;
    }
}