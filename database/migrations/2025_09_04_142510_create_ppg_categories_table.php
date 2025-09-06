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
        Schema::create('ppg_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // fondation, prepa, recup
            $table->string('slug');
            $table->string('title');
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('color')->default('#606c38');
            $table->integer('order_position')->default(0);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
            
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppg_categories');
    }
};
