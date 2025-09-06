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
        Schema::create('ppg_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('ppg_categories')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->text('instructions')->nullable();
            $table->string('difficulty_level')->default('debutant'); // debutant, intermediaire, avance
            $table->integer('duration_minutes')->nullable();
            $table->integer('sets')->nullable();
            $table->integer('reps')->nullable();
            $table->string('rest_time')->nullable();
            $table->string('equipment')->nullable();
            $table->string('target_muscles')->nullable();
            $table->json('images')->nullable();
            $table->string('video_url')->nullable();
            $table->text('tips')->nullable();
            $table->text('precautions')->nullable();
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
        Schema::dropIfExists('ppg_exercises');
    }
};
