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
        Schema::table('ride_media', function (Blueprint $table) {
            $table->unsignedBigInteger('ride_id')->after('id');
            $table->string('type')->default('image')->after('ride_id'); // image, video, etc.
            $table->string('file_path')->after('type'); // chemin du fichier
            $table->unsignedTinyInteger('order')->default(0)->after('file_path'); // ordre d'affichage
            $table->unsignedInteger('width')->nullable()->after('order'); // largeur pour images
            $table->unsignedInteger('height')->nullable()->after('width'); // hauteur pour images
            $table->unsignedInteger('duration_sec')->nullable()->after('height'); // durée pour vidéos
            
            // Index et contraintes
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
            $table->index(['ride_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ride_media', function (Blueprint $table) {
            $table->dropForeign(['ride_id']);
            $table->dropIndex(['ride_id', 'order']);
            $table->dropColumn([
                'ride_id', 'type', 'file_path', 'order', 
                'width', 'height', 'duration_sec'
            ]);
        });
    }
};
