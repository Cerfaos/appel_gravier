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
        Schema::create('ppg_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('ppg_categories')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->text('objectives');
            $table->string('difficulty_level')->default('debutant');
            $table->integer('duration_weeks');
            $table->integer('sessions_per_week');
            $table->integer('session_duration_minutes');
            $table->json('exercises'); // IDs des exercices avec détails
            $table->text('progression_notes')->nullable();
            $table->string('target_audience')->nullable();
            $table->json('images')->nullable();
            $table->integer('order_position')->default(0);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->unique('slug');
            $table->index(['category_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppg_programs');
    }
};
