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
        Schema::create('sorties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->text('description');
            $table->string('departement')->nullable();
            $table->string('pays')->nullable();
            $table->text('personal_comment')->nullable();
            $table->string('gpx_file_path')->nullable();
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->integer('elevation_gain_m')->nullable();
            $table->integer('elevation_loss_m')->nullable();
            $table->enum('difficulty_level', ['facile', 'moyen', 'difficile']);
            $table->integer('estimated_duration_minutes')->nullable();
            $table->decimal('min_latitude', 10, 8)->nullable();
            $table->decimal('max_latitude', 10, 8)->nullable();
            $table->decimal('min_longitude', 11, 8)->nullable();
            $table->decimal('max_longitude', 11, 8)->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sorties');
    }
};