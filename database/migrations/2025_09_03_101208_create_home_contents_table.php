<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->string('key')->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->json('meta')->nullable(); // For additional data
            $table->timestamps();
            
            $table->index('section');
            $table->index('key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_contents');
    }
};