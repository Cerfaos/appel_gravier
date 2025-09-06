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
            $table->string('departement')->nullable()->after('max_longitude');
            $table->string('pays')->nullable()->after('departement');
            $table->index(['departement']);
            $table->index(['pays']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itineraries', function (Blueprint $table) {
            $table->dropIndex(['departement']);
            $table->dropIndex(['pays']);
            $table->dropColumn(['departement', 'pays']);
        });
    }
};
