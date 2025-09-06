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
        Schema::create('sortie_gpx_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sortie_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('elevation', 8, 2)->nullable();
            $table->integer('point_order');
            $table->dateTime('timestamp')->nullable();
            $table->timestamps();
            
            $table->index(['sortie_id', 'point_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sortie_gpx_points');
    }
};