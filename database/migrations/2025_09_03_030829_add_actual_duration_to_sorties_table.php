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
        Schema::table('sorties', function (Blueprint $table) {
            $table->integer('actual_duration_minutes')->nullable()->after('estimated_duration_minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sorties', function (Blueprint $table) {
            $table->dropColumn('actual_duration_minutes');
        });
    }
};