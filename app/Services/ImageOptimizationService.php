<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Exception;

class ImageOptimizationService
{
    private const MAX_WIDTH = 1920;
    private const MAX_HEIGHT = 1080;
    private const THUMBNAIL_WIDTH = 400;
    private const THUMBNAIL_HEIGHT = 300;
    private const QUALITY = 85;
    
    private ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Process and optimize uploaded images
     */
    public function processImages(array $uploadedFiles, string $directory = 'images'): array
    {
        $processedImages = [];
        
        foreach ($uploadedFiles as $index => $file) {
            if (!$file instanceof UploadedFile || !$file->isValid()) {
                Log::warning('Invalid uploaded file at index ' . $index);
                continue;
            }

            try {
                $result = $this->processImage($file, $directory, $index);
                if ($result) {
                    $processedImages[] = $result;
                }
            } catch (Exception $e) {
                Log::error('Image processing failed', [
                    'index' => $index,
                    'error' => $e->getMessage(),
                    'file' => $file->getClientOriginalName()
                ]);
            }
        }

        return $processedImages;
    }

    /**
     * Process a single image file
     */
    public function processImage(UploadedFile $file, string $directory = 'images', ?int $index = null): ?array
    {
        try {
            // Security: Validate image
            if (!$this->isValidImage($file)) {
                throw new Exception('Invalid image file');
            }

            // Generate unique filename
            $filename = $this->generateUniqueFilename($file);
            $thumbnailFilename = 'thumb_' . $filename;
            
            // Load and optimize image
            $image = $this->imageManager->read($file->getRealPath());
            
            // Get original dimensions
            $originalWidth = $image->width();
            $originalHeight = $image->height();
            
            // Resize if too large
            if ($originalWidth > self::MAX_WIDTH || $originalHeight > self::MAX_HEIGHT) {
                $image->scale(width: self::MAX_WIDTH, height: self::MAX_HEIGHT);
            }
            
            // Save optimized image
            $optimizedPath = $directory . '/' . $filename;
            $image->toJpeg(self::QUALITY);
            Storage::disk('public')->put($optimizedPath, (string) $image->encode());
            
            // Create thumbnail
            $thumbnail = $this->imageManager->read($file->getRealPath());
            $thumbnail->cover(self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT);
            $thumbnailPath = $directory . '/thumbnails/' . $thumbnailFilename;
            $thumbnail->toJpeg(self::QUALITY);
            Storage::disk('public')->put($thumbnailPath, (string) $thumbnail->encode());
            
            Log::info('Image processed successfully', [
                'original_size' => $file->getSize(),
                'original_dimensions' => "{$originalWidth}x{$originalHeight}",
                'final_dimensions' => "{$image->width()}x{$image->height()}",
                'path' => $optimizedPath
            ]);
            
            return [
                'index' => $index,
                'original_name' => $file->getClientOriginalName(),
                'filename' => $filename,
                'path' => $optimizedPath,
                'thumbnail_path' => $thumbnailPath,
                'size' => Storage::disk('public')->size($optimizedPath),
                'width' => $image->width(),
                'height' => $image->height(),
                'mime_type' => 'image/jpeg'
            ];
            
        } catch (Exception $e) {
            Log::error('Image processing error', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Validate uploaded image file
     */
    private function isValidImage(UploadedFile $file): bool
    {
        // Check file size (max 10MB)
        if ($file->getSize() > 10 * 1024 * 1024) {
            return false;
        }
        
        // Check MIME type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return false;
        }
        
        // Check if it's actually an image
        $imageInfo = @getimagesize($file->getRealPath());
        if (!$imageInfo) {
            return false;
        }
        
        // Check dimensions (minimum 100x100, maximum 8000x8000)
        [$width, $height] = $imageInfo;
        if ($width < 100 || $height < 100 || $width > 8000 || $height > 8000) {
            return false;
        }
        
        return true;
    }

    /**
     * Generate unique filename
     */
    private function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = 'jpg'; // Always save as JPEG for consistency
        $hash = hash('sha256', $file->getClientOriginalName() . time() . uniqid());
        return substr($hash, 0, 32) . '.' . $extension;
    }

    /**
     * Delete image and its thumbnail
     */
    public function deleteImage(string $imagePath): bool
    {
        try {
            $deleted = true;
            
            // Delete main image
            if (Storage::disk('public')->exists($imagePath)) {
                $deleted = Storage::disk('public')->delete($imagePath) && $deleted;
            }
            
            // Delete thumbnail
            $thumbnailPath = $this->getThumbnailPath($imagePath);
            if (Storage::disk('public')->exists($thumbnailPath)) {
                $deleted = Storage::disk('public')->delete($thumbnailPath) && $deleted;
            }
            
            return $deleted;
        } catch (Exception $e) {
            Log::error('Image deletion failed', [
                'path' => $imagePath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get thumbnail path from main image path
     */
    public function getThumbnailPath(string $imagePath): string
    {
        $pathInfo = pathinfo($imagePath);
        return $pathInfo['dirname'] . '/thumbnails/thumb_' . $pathInfo['basename'];
    }

    /**
     * Batch delete images
     */
    public function deleteImages(array $imagePaths): array
    {
        $results = [];
        
        foreach ($imagePaths as $path) {
            $results[$path] = $this->deleteImage($path);
        }
        
        return $results;
    }

    /**
     * Get image info from storage
     */
    public function getImageInfo(string $imagePath): ?array
    {
        try {
            if (!Storage::disk('public')->exists($imagePath)) {
                return null;
            }
            
            $fullPath = Storage::disk('public')->path($imagePath);
            $imageInfo = getimagesize($fullPath);
            
            if (!$imageInfo) {
                return null;
            }
            
            return [
                'path' => $imagePath,
                'size' => Storage::disk('public')->size($imagePath),
                'width' => $imageInfo[0],
                'height' => $imageInfo[1],
                'mime_type' => $imageInfo['mime'],
                'thumbnail_path' => $this->getThumbnailPath($imagePath)
            ];
            
        } catch (Exception $e) {
            Log::error('Failed to get image info', [
                'path' => $imagePath,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}