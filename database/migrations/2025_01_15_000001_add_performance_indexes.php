<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Optimisations pour la table des itinéraires
        Schema::table('itineraries', function (Blueprint $table) {
            // Index composite pour les requêtes de listing public
            $table->index(['status', 'published_at'], 'idx_itineraries_public_listing');
            
            // Index composite pour les filtres géographiques
            $table->index(['departement', 'pays', 'status'], 'idx_itineraries_geo_filter');
            
            // Index composite pour les requêtes par difficulté
            $table->index(['difficulty_level', 'status', 'published_at'], 'idx_itineraries_difficulty');
            
            // Index pour les bounding box (recherches géographiques)
            $table->index(['min_latitude', 'max_latitude', 'min_longitude', 'max_longitude'], 'idx_itineraries_bounds');
            
            // Index pour les recherches full-text
            if (DB::connection()->getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE itineraries ADD FULLTEXT idx_itineraries_search (title, description)');
            }
        });

        // Optimisations pour la table des sorties
        Schema::table('sorties', function (Blueprint $table) {
            // Index composite pour les requêtes publiques
            $table->index(['status', 'published_at'], 'idx_sorties_public_listing');
            
            // Index pour les filtres par date
            $table->index(['sortie_date', 'status'], 'idx_sorties_by_date');
            
            // Index composite géographique
            $table->index(['departement', 'pays', 'status'], 'idx_sorties_geo_filter');
            
            // Index pour les recherches full-text
            if (DB::connection()->getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE sorties ADD FULLTEXT idx_sorties_search (title, description)');
            }
        });

        // Optimisations pour les points GPX
        Schema::table('gpx_points', function (Blueprint $table) {
            // Index composite pour optimiser l'affichage des traces
            $table->index(['itinerary_id', 'point_order'], 'idx_gpx_points_trace');
            
            // Index spatial pour les requêtes géographiques
            if (DB::connection()->getDriverName() === 'mysql') {
                // Créer un index spatial sur latitude/longitude
                DB::statement('ALTER TABLE gpx_points ADD SPATIAL INDEX idx_gpx_points_spatial (latitude, longitude)');
            }
        });

        Schema::table('sortie_gpx_points', function (Blueprint $table) {
            // Index composite pour les traces de sorties
            $table->index(['sortie_id', 'point_order'], 'idx_sortie_gpx_points_trace');
            
            // Index spatial pour les requêtes géographiques
            if (DB::connection()->getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE sortie_gpx_points ADD SPATIAL INDEX idx_sortie_gpx_points_spatial (latitude, longitude)');
            }
        });

        // Optimisations pour les images
        Schema::table('itinerary_images', function (Blueprint $table) {
            // Index composite pour récupérer les images en ordre
            $table->index(['itinerary_id', 'order_position'], 'idx_itinerary_images_ordered');
            
            // Index pour les images featured
            $table->index(['itinerary_id', 'is_featured'], 'idx_itinerary_images_featured');
        });

        Schema::table('sortie_images', function (Blueprint $table) {
            // Index composite pour récupérer les images en ordre
            $table->index(['sortie_id', 'order_position'], 'idx_sortie_images_ordered');
            
            // Index pour les images featured
            $table->index(['sortie_id', 'is_featured'], 'idx_sortie_images_featured');
        });

        // Optimisations pour les contacts
        Schema::table('contacts', function (Blueprint $table) {
            // Index composite pour le dashboard admin
            $table->index(['status', 'priority', 'created_at'], 'idx_contacts_admin_dashboard');
            
            // Index pour les recherches par email
            $table->index('email', 'idx_contacts_email');
        });

        // Optimisations pour les utilisateurs
        Schema::table('users', function (Blueprint $table) {
            // Index composite pour les utilisateurs actifs
            $table->index(['status', 'role'], 'idx_users_active');
            
            // Index pour les recherches par téléphone
            $table->index('phone', 'idx_users_phone');
        });

        // Optimisations pour les sessions
        Schema::table('sessions', function (Blueprint $table) {
            // Index composite pour le nettoyage des sessions
            $table->index(['user_id', 'last_activity'], 'idx_sessions_cleanup');
        });

        // Optimisations pour les blogs
        Schema::table('blog_posts', function (Blueprint $table) {
            // Index composite pour les posts publics
            $table->index(['blog_category_id', 'created_at'], 'idx_blog_posts_category');
            
            // Index pour les recherches full-text
            if (DB::connection()->getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE blog_posts ADD FULLTEXT idx_blog_posts_search (post_title, short_description, long_descp)');
            }
        });

        // Optimisations pour les PPG
        Schema::table('ppg_exercises', function (Blueprint $table) {
            // Index composite pour les exercices actifs
            $table->index(['category_id', 'status', 'order_position'], 'idx_ppg_exercises_active');
            
            // Index pour les niveaux de difficulté
            $table->index(['difficulty_level', 'status'], 'idx_ppg_exercises_difficulty');
        });

        Schema::table('ppg_programs', function (Blueprint $table) {
            // Index composite pour les programmes actifs
            $table->index(['category_id', 'status', 'order_position'], 'idx_ppg_programs_active');
            
            // Index pour les niveaux de difficulté
            $table->index(['difficulty_level', 'status'], 'idx_ppg_programs_difficulty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer les index des itinéraires
        Schema::table('itineraries', function (Blueprint $table) {
            $table->dropIndex('idx_itineraries_public_listing');
            $table->dropIndex('idx_itineraries_geo_filter');
            $table->dropIndex('idx_itineraries_difficulty');
            $table->dropIndex('idx_itineraries_bounds');
        });

        // Supprimer les index full-text MySQL
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE itineraries DROP INDEX idx_itineraries_search');
            DB::statement('ALTER TABLE sorties DROP INDEX idx_sorties_search');
            DB::statement('ALTER TABLE blog_posts DROP INDEX idx_blog_posts_search');
            DB::statement('ALTER TABLE gpx_points DROP INDEX idx_gpx_points_spatial');
            DB::statement('ALTER TABLE sortie_gpx_points DROP INDEX idx_sortie_gpx_points_spatial');
        }

        // Supprimer les autres index
        Schema::table('sorties', function (Blueprint $table) {
            $table->dropIndex('idx_sorties_public_listing');
            $table->dropIndex('idx_sorties_by_date');
            $table->dropIndex('idx_sorties_geo_filter');
        });

        Schema::table('gpx_points', function (Blueprint $table) {
            $table->dropIndex('idx_gpx_points_trace');
        });

        Schema::table('sortie_gpx_points', function (Blueprint $table) {
            $table->dropIndex('idx_sortie_gpx_points_trace');
        });

        Schema::table('itinerary_images', function (Blueprint $table) {
            $table->dropIndex('idx_itinerary_images_ordered');
            $table->dropIndex('idx_itinerary_images_featured');
        });

        Schema::table('sortie_images', function (Blueprint $table) {
            $table->dropIndex('idx_sortie_images_ordered');
            $table->dropIndex('idx_sortie_images_featured');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('idx_contacts_admin_dashboard');
            $table->dropIndex('idx_contacts_email');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_active');
            $table->dropIndex('idx_users_phone');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndex('idx_sessions_cleanup');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex('idx_blog_posts_category');
        });

        Schema::table('ppg_exercises', function (Blueprint $table) {
            $table->dropIndex('idx_ppg_exercises_active');
            $table->dropIndex('idx_ppg_exercises_difficulty');
        });

        Schema::table('ppg_programs', function (Blueprint $table) {
            $table->dropIndex('idx_ppg_programs_active');
            $table->dropIndex('idx_ppg_programs_difficulty');
        });
    }
};