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
        Schema::create('rides', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->date('ride_date');
            $t->decimal('distance_km', 6, 2)->default(0);
            $t->unsignedInteger('moving_time_sec')->default(0);     // temps effectué
            $t->unsignedInteger('elevation_gain_m')->default(0);    // dénivelé +
            $t->string('gpx_path')->nullable();                     // fichier GPX
            $t->json('weather')->nullable();                        // météo (JSON)
            $t->longText('experience')->nullable();                 // REX
            $t->string('cover_image_path')->nullable();             // vignette
            $t->unsignedSmallInteger('media_count')->default(0);
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->timestamps();
            $t->index(['ride_date', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
