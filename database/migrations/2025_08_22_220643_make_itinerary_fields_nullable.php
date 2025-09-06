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
        Schema::table('itineraries', function (Blueprint $table) {
            // Rendre les champs GPX et statistiques nullable
            $table->string('gpx_file_path')->nullable()->change();
            $table->decimal('distance_km', 8, 2)->nullable()->change();
            $table->integer('elevation_gain_m')->nullable()->change();
            $table->integer('elevation_loss_m')->nullable()->change();
            $table->integer('estimated_duration_minutes')->nullable()->change();
            $table->decimal('min_latitude', 10, 8)->nullable()->change();
            $table->decimal('max_latitude', 10, 8)->nullable()->change();
            $table->decimal('min_longitude', 11, 8)->nullable()->change();
            $table->decimal('max_longitude', 11, 8)->nullable()->change();
            $table->text('personal_comment')->nullable()->change();
            $table->string('meta_title')->nullable()->change();
            $table->text('meta_description')->nullable()->change();
            $table->string('og_image')->nullable()->change();
            $table->timestamp('published_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itineraries', function (Blueprint $table) {
            // Remettre les champs NOT NULL (attention aux données existantes)
            $table->string('gpx_file_path')->nullable(false)->change();
            $table->decimal('distance_km', 8, 2)->nullable(false)->change();
            $table->integer('elevation_gain_m')->nullable(false)->change();
            $table->integer('elevation_loss_m')->nullable(false)->change();
            $table->integer('estimated_duration_minutes')->nullable(false)->change();
            $table->decimal('min_latitude', 10, 8)->nullable(false)->change();
            $table->decimal('max_latitude', 10, 8)->nullable(false)->change();
            $table->decimal('min_longitude', 11, 8)->nullable(false)->change();
            $table->decimal('max_longitude', 11, 8)->nullable(false)->change();
            $table->text('personal_comment')->nullable(false)->change();
            $table->string('meta_title')->nullable(false)->change();
            $table->text('meta_description')->nullable(false)->change();
            $table->string('og_image')->nullable(false)->change();
            $table->timestamp('published_at')->nullable(false)->change();
        });
    }
};
