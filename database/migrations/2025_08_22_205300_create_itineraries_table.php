<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('personal_comment')->nullable();
            $table->string('gpx_file_path');
            $table->decimal('distance_km', 10, 2);
            $table->integer('elevation_gain_m');
            $table->integer('elevation_loss_m');
            $table->enum('difficulty_level', ['facile', 'moyen', 'difficile', 'expert']);
            $table->integer('estimated_duration_minutes');
            $table->decimal('min_latitude', 10, 8);
            $table->decimal('max_latitude', 10, 8);
            $table->decimal('min_longitude', 11, 8);
            $table->decimal('max_longitude', 11, 8);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
            
            // Index pour les performances
            $table->index('status');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itineraries');
    }
};
