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
        // 1. Index composites pour les itinéraires
        Schema::table('itineraries', function (Blueprint $table) {
            // Index pour les requêtes de recherche courantes
            $table->index(['status', 'created_at'], 'idx_itineraries_status_created');
            $table->index(['status', 'difficulty_level'], 'idx_itineraries_status_difficulty');
            $table->index(['status', 'distance_km'], 'idx_itineraries_status_distance');
            $table->index(['user_id', 'status'], 'idx_itineraries_user_status');
            
            // Index géospatial pour la recherche de proximité
            if (DB::getDriverName() === 'mysql') {
                // Index spatial pour les coordonnées GPS
                $table->index(['min_latitude', 'max_latitude'], 'idx_itineraries_lat_range');
                $table->index(['min_longitude', 'max_longitude'], 'idx_itineraries_lng_range');
                
                // Index composite géo + statut
                $table->index(['status', 'min_latitude', 'min_longitude'], 'idx_itineraries_geo_status');
            }
        });

        // 2. Index full-text pour la recherche textuelle
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE itineraries ADD FULLTEXT idx_itineraries_fulltext (title, description, departement, pays)');
        }

        // 3. Index composites pour les sorties
        Schema::table('sorties', function (Blueprint $table) {
            $table->index(['status', 'date_sortie'], 'idx_sorties_status_date');
            $table->index(['status', 'difficulty_level'], 'idx_sorties_status_difficulty');
            $table->index(['user_id', 'status'], 'idx_sorties_user_status');
            $table->index(['date_sortie', 'status'], 'idx_sorties_date_status');
        });

        // Index full-text pour les sorties
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE sorties ADD FULLTEXT idx_sorties_fulltext (title, description, lieu_depart)');
        }

        // 4. Index pour les utilisateurs
        Schema::table('users', function (Blueprint $table) {
            $table->index(['email_verified_at', 'created_at'], 'idx_users_verified_created');
            $table->index(['role', 'created_at'], 'idx_users_role_created');
            $table->index(['google2fa_enabled', 'role'], 'idx_users_2fa_role');
            $table->index(['banned_at', 'email_verified_at'], 'idx_users_banned_verified');
        });

        // Index full-text pour les utilisateurs (nom seulement pour la vie privée)
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE users ADD FULLTEXT idx_users_fulltext (name)');
        }

        // 5. Index pour les images
        Schema::table('images', function (Blueprint $table) {
            $table->index(['imageable_type', 'imageable_id', 'is_featured'], 'idx_images_poly_featured');
            $table->index(['imageable_type', 'imageable_id', 'order_position'], 'idx_images_poly_order');
        });

        // 6. Index pour les sessions et sécurité
        if (Schema::hasTable('sessions')) {
            Schema::table('sessions', function (Blueprint $table) {
                $table->index(['user_id', 'last_activity'], 'idx_sessions_user_activity');
                $table->index(['last_activity', 'ip_address'], 'idx_sessions_activity_ip');
            });
        }

        // 7. Index pour les logs si ils existent
        if (Schema::hasTable('logs')) {
            Schema::table('logs', function (Blueprint $table) {
                $table->index(['level', 'created_at'], 'idx_logs_level_created');
                $table->index(['created_at'], 'idx_logs_created');
            });
        }

        // 8. Index pour les contacts
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->index(['status', 'created_at'], 'idx_contacts_status_created');
                $table->index(['email', 'created_at'], 'idx_contacts_email_created');
            });
        }

        // 9. Index pour les notifications
        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->index(['notifiable_type', 'notifiable_id', 'read_at'], 'idx_notifications_poly_read');
                $table->index(['created_at', 'read_at'], 'idx_notifications_created_read');
            });
        }

        // 10. Index pour les favoris (table pivot)
        if (Schema::hasTable('itinerary_user')) {
            Schema::table('itinerary_user', function (Blueprint $table) {
                $table->index(['user_id', 'created_at'], 'idx_favorites_user_created');
                $table->index(['itinerary_id', 'created_at'], 'idx_favorites_itinerary_created');
            });
        }

        // 11. Index pour les inscriptions sorties (table pivot)
        if (Schema::hasTable('sortie_user')) {
            Schema::table('sortie_user', function (Blueprint $table) {
                $table->index(['user_id', 'created_at'], 'idx_sortie_inscriptions_user_created');
                $table->index(['sortie_id', 'created_at'], 'idx_sortie_inscriptions_sortie_created');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer les index full-text
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE itineraries DROP INDEX idx_itineraries_fulltext');
            DB::statement('ALTER TABLE sorties DROP INDEX idx_sorties_fulltext');
            DB::statement('ALTER TABLE users DROP INDEX idx_users_fulltext');
        }

        // Supprimer les index composites pour les itinéraires
        Schema::table('itineraries', function (Blueprint $table) {
            $table->dropIndex('idx_itineraries_status_created');
            $table->dropIndex('idx_itineraries_status_difficulty');
            $table->dropIndex('idx_itineraries_status_distance');
            $table->dropIndex('idx_itineraries_user_status');
            
            if (DB::getDriverName() === 'mysql') {
                $table->dropIndex('idx_itineraries_lat_range');
                $table->dropIndex('idx_itineraries_lng_range');
                $table->dropIndex('idx_itineraries_geo_status');
            }
        });

        // Supprimer les index pour les sorties
        Schema::table('sorties', function (Blueprint $table) {
            $table->dropIndex('idx_sorties_status_date');
            $table->dropIndex('idx_sorties_status_difficulty');
            $table->dropIndex('idx_sorties_user_status');
            $table->dropIndex('idx_sorties_date_status');
        });

        // Supprimer les index pour les utilisateurs
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_verified_created');
            $table->dropIndex('idx_users_role_created');
            $table->dropIndex('idx_users_2fa_role');
            $table->dropIndex('idx_users_banned_verified');
        });

        // Supprimer les autres index
        Schema::table('images', function (Blueprint $table) {
            $table->dropIndex('idx_images_poly_featured');
            $table->dropIndex('idx_images_poly_order');
        });

        if (Schema::hasTable('sessions')) {
            Schema::table('sessions', function (Blueprint $table) {
                $table->dropIndex('idx_sessions_user_activity');
                $table->dropIndex('idx_sessions_activity_ip');
            });
        }

        if (Schema::hasTable('logs')) {
            Schema::table('logs', function (Blueprint $table) {
                $table->dropIndex('idx_logs_level_created');
                $table->dropIndex('idx_logs_created');
            });
        }

        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropIndex('idx_contacts_status_created');
                $table->dropIndex('idx_contacts_email_created');
            });
        }

        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->dropIndex('idx_notifications_poly_read');
                $table->dropIndex('idx_notifications_created_read');
            });
        }

        if (Schema::hasTable('itinerary_user')) {
            Schema::table('itinerary_user', function (Blueprint $table) {
                $table->dropIndex('idx_favorites_user_created');
                $table->dropIndex('idx_favorites_itinerary_created');
            });
        }

        if (Schema::hasTable('sortie_user')) {
            Schema::table('sortie_user', function (Blueprint $table) {
                $table->dropIndex('idx_sortie_inscriptions_user_created');
                $table->dropIndex('idx_sortie_inscriptions_sortie_created');
            });
        }
    }
};