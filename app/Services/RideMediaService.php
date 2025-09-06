<?php

namespace App\Services;

use App\Models\Ride;
use App\Models\RideMedia;
// use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;

class RideMediaService {
    
    public function storeCoverImage(Ride $ride, UploadedFile $file): string {
        try {
            $config = config('rides') ?: $this->getDefaultConfig();
            $filename = $this->generateFilename($file);
            $path = $config['storage']['rides']['covers'] . '/' . $filename;
            
            $this->ensureDirectoryExists($config['storage']['rides']['covers']);
            
            // Process and save the cover image (simplified without Intervention Image)
            $file->move(public_path(dirname($path)), basename($path));
            
            // Remove old cover image if exists
            if ($ride->cover_image_path && file_exists(public_path($ride->cover_image_path))) {
                unlink(public_path($ride->cover_image_path));
            }
            
            // Update ride with new cover path
            $ride->update(['cover_image_path' => $path]);
            
            return $path;
        } catch (Exception $e) {
            Log::error('Error storing cover image', [
                'ride_id' => $ride->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Erreur lors de l\'upload de l\'image de couverture: ' . $e->getMessage());
        }
    }

    public function storeImage(Ride $ride, UploadedFile $file): RideMedia {
        try {
            $config = config('rides') ?: $this->getDefaultConfig();
            $filename = $this->generateFilename($file);
            $path = $config['storage']['rides']['images'] . '/' . $filename;
            
            $this->ensureDirectoryExists($config['storage']['rides']['images']);
            
            // Process and save the image (simplified without Intervention Image)
            $file->move(public_path(dirname($path)), basename($path));
            
            // Get image dimensions (basic PHP)
            $dimensions = getimagesize(public_path($path));
            $originalWidth = $dimensions[0] ?? 0;
            $originalHeight = $dimensions[1] ?? 0;
            
            // Create media record
            $media = $ride->media()->create([
                'type' => 'image',
                'file_path' => $path,
                'width' => $originalWidth,
                'height' => $originalHeight,
                'order' => $ride->media()->count() + 1,
            ]);
            
            // Update media count
            $ride->increment('media_count');
            
            Log::info('Image stored successfully', [
                'ride_id' => $ride->id,
                'media_id' => $media->id,
                'path' => $path
            ]);
            
            return $media;
            
        } catch (Exception $e) {
            Log::error('Error storing ride image', [
                'ride_id' => $ride->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new Exception('Erreur lors de l\'upload de l\'image: ' . $e->getMessage());
        }
    }

    public function storeGpxFile(Ride $ride, UploadedFile $file): string {
        try {
            $config = config('rides') ?: $this->getDefaultConfig();
            $filename = Str::uuid() . '.gpx';
            $path = $config['storage']['rides']['gpx'] . '/' . $filename;
            
            $this->ensureDirectoryExists($config['storage']['rides']['gpx']);
            
            // Remove old GPX file if exists
            if ($ride->gpx_path && file_exists(public_path($ride->gpx_path))) {
                unlink(public_path($ride->gpx_path));
            }
            
            $file->move(public_path(dirname($path)), $filename);
            
            // Update ride with new GPX path
            $ride->update(['gpx_path' => $path]);
            
            return $path;
            
        } catch (Exception $e) {
            Log::error('Error storing GPX file', [
                'ride_id' => $ride->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Erreur lors de l\'upload du fichier GPX: ' . $e->getMessage());
        }
    }

    public function deleteRideMedia(Ride $ride): void {
        try {
            // Delete all media files
            foreach ($ride->media as $media) {
                if (file_exists(public_path($media->file_path))) {
                    unlink(public_path($media->file_path));
                }
            }
            
            // Delete cover image
            if ($ride->cover_image_path && file_exists(public_path($ride->cover_image_path))) {
                unlink(public_path($ride->cover_image_path));
            }
            
            // Delete GPX file
            if ($ride->gpx_path && file_exists(public_path($ride->gpx_path))) {
                unlink(public_path($ride->gpx_path));
            }
            
            // Delete thumbnails
            $this->deleteThumbnails($ride);
            
        } catch (Exception $e) {
            Log::error('Error deleting ride media', [
                'ride_id' => $ride->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function generateFilename(UploadedFile $file): string {
        return Str::uuid() . '.' . $file->getClientOriginalExtension();
    }

    private function ensureDirectoryExists(string $path): void {
        $fullPath = public_path($path);
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
    }

    private function generateThumbnails($img, string $filename, array $config): void {
        // Thumbnail generation temporarily disabled without Intervention Image
        Log::info('Thumbnail generation skipped - Intervention Image not configured');
    }

    private function deleteThumbnails(Ride $ride): void {
        $config = config('rides') ?: $this->getDefaultConfig();
        
        // Delete media thumbnails
        foreach ($ride->media as $media) {
            $filename = basename($media->file_path);
            foreach ($config['storage']['thumbnails'] as $thumbnailPath) {
                $thumbnailFile = public_path($thumbnailPath . '/' . $filename);
                if (file_exists($thumbnailFile)) {
                    unlink($thumbnailFile);
                }
            }
        }
        
        // Delete cover thumbnails
        if ($ride->cover_image_path) {
            $filename = basename($ride->cover_image_path);
            foreach ($config['storage']['thumbnails'] as $thumbnailPath) {
                $thumbnailFile = public_path($thumbnailPath . '/' . $filename);
                if (file_exists($thumbnailFile)) {
                    unlink($thumbnailFile);
                }
            }
        }
    }

    private function getDefaultConfig(): array {
        return [
            'storage' => [
                'rides' => [
                    'images' => 'storage/rides/images',
                    'covers' => 'storage/rides/covers', 
                    'gpx' => 'storage/rides/gpx',
                ],
                'thumbnails' => [
                    'small' => 'storage/rides/thumbnails/small',
                    'medium' => 'storage/rides/thumbnails/medium',
                    'large' => 'storage/rides/thumbnails/large',
                ],
            ],
            'upload' => [
                'max_images' => 12,
                'max_image_size' => 12288,
                'max_gpx_size' => 10240,
                'allowed_image_types' => ['jpg', 'jpeg', 'png', 'webp'],
                'image_quality' => 85,
                'generate_thumbnails' => true,
            ],
            'image_processing' => [
                'max_width' => 2000,
                'max_height' => 2000,
                'thumbnail_sizes' => [
                    'small' => 150,
                    'medium' => 300,
                    'large' => 600,
                ],
            ],
        ];
    }
}
