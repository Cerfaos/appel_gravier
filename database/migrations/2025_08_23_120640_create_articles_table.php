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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('itinerary_id')->nullable()->constrained()->onDelete('set null');
            
            // Contenu principal
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Extrait/résumé
            $table->longText('content'); // Contenu principal HTML/Markdown
            $table->string('featured_image')->nullable();
            
            // Organisation
            $table->string('category')->default('aventure'); // aventure, technique, récit, guide
            $table->json('tags')->nullable(); // Tags pour classification
            
            // Publication
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();
            
            // Statistiques
            $table->integer('reading_time_minutes')->nullable();
            $table->integer('views_count')->default(0);
            
            $table->timestamps();
            
            // Index pour les performances
            $table->index(['status', 'published_at']);
            $table->index(['category', 'status']);
            $table->index('slug');
            $table->index('itinerary_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};