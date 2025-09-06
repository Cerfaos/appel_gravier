<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ItineraryImage;
use App\Models\SortieImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class VerifyImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:verify {--fix : Automatically fix missing images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify that all image records have corresponding files on disk';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verifying image files...');
        
        $missingItineraryImages = [];
        $missingSortieImages = [];
        
        // Check itinerary images
        $this->info('📷 Checking itinerary images...');
        $itineraryImages = ItineraryImage::all();
        
        foreach ($itineraryImages as $image) {
            $fullPath = public_path($image->image_path);
            if (!File::exists($fullPath)) {
                $missingItineraryImages[] = $image;
                $this->warn("❌ Missing: {$image->image_path} (ID: {$image->id})");
            }
        }
        
        // Check sortie images
        $this->info('🏃 Checking sortie images...');
        $sortieImages = SortieImage::all();
        
        foreach ($sortieImages as $image) {
            $fullPath = public_path($image->image_path);
            if (!File::exists($fullPath)) {
                $missingSortieImages[] = $image;
                $this->warn("❌ Missing: {$image->image_path} (ID: {$image->id})");
            }
        }
        
        // Summary
        $this->info('📊 Summary:');
        $this->line("   Itinerary images: {$itineraryImages->count()} total, " . count($missingItineraryImages) . " missing");
        $this->line("   Sortie images: {$sortieImages->count()} total, " . count($missingSortieImages) . " missing");
        
        if (empty($missingItineraryImages) && empty($missingSortieImages)) {
            $this->info('✅ All images are present on disk!');
            return Command::SUCCESS;
        }
        
        if ($this->option('fix')) {
            $this->info('🔧 Fixing missing images...');
            $this->fixMissingImages($missingItineraryImages, $missingSortieImages);
        } else {
            $this->warn('💡 Run with --fix option to automatically handle missing images.');
        }
        
        return Command::SUCCESS;
    }
    
    private function fixMissingImages(array $missingItineraryImages, array $missingSortieImages)
    {
        $placeholderPath = public_path('upload/no_image.jpg');
        
        if (!File::exists($placeholderPath)) {
            $this->error('❌ Placeholder image not found at: ' . $placeholderPath);
            return;
        }
        
        // Fix itinerary images
        foreach ($missingItineraryImages as $image) {
            $directory = dirname(public_path($image->image_path));
            
            // Create directory if it doesn't exist
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->info("📁 Created directory: {$directory}");
            }
            
            // Copy placeholder image
            if (File::copy($placeholderPath, public_path($image->image_path))) {
                $this->info("✅ Fixed itinerary image: {$image->image_path}");
                
                Log::info('Fixed missing itinerary image', [
                    'image_id' => $image->id,
                    'path' => $image->image_path,
                    'itinerary_id' => $image->itinerary_id
                ]);
            } else {
                $this->error("❌ Failed to fix: {$image->image_path}");
            }
        }
        
        // Fix sortie images
        foreach ($missingSortieImages as $image) {
            $directory = dirname(public_path($image->image_path));
            
            // Create directory if it doesn't exist
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->info("📁 Created directory: {$directory}");
            }
            
            // Copy placeholder image
            if (File::copy($placeholderPath, public_path($image->image_path))) {
                $this->info("✅ Fixed sortie image: {$image->image_path}");
                
                Log::info('Fixed missing sortie image', [
                    'image_id' => $image->id,
                    'path' => $image->image_path,
                    'sortie_id' => $image->sortie_id
                ]);
            } else {
                $this->error("❌ Failed to fix: {$image->image_path}");
            }
        }
        
        $this->info('🎉 Missing image fix completed!');
    }
}