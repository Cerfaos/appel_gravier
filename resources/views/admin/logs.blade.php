@extends('admin.admin_master_outdoor')

@section('admin')
<div class="page-content">
    <div class="container">
        
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h4>📋 Journaux d'Activité</h4>
            </div>
            <div>
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li>Logs</li>
                </ol>
            </div>
        </div>

        <div class="content">
            <div class="content-wrapper">
                
                <!-- Statistiques des logs -->
                <div class="logs-stats">
                    <div class="logs-stat logs-stat--info">
                        <div class="logs-stat__value">1,247</div>
                        <div class="logs-stat__label">Total des entrées</div>
                    </div>
                    <div class="logs-stat logs-stat--success">
                        <div class="logs-stat__value">892</div>
                        <div class="logs-stat__label">Succès</div>
                    </div>
                    <div class="logs-stat logs-stat--warning">
                        <div class="logs-stat__value">234</div>
                        <div class="logs-stat__label">Avertissements</div>
                    </div>
                    <div class="logs-stat logs-stat--error">
                        <div class="logs-stat__value">121</div>
                        <div class="logs-stat__label">Erreurs</div>
                    </div>
                </div>

                <!-- Filtres -->
                <div class="card u-mt-4">
                    <div class="card__header">
                        <div class="u-flex u-gap-4">
                            <div>
                                <i data-feather="filter" style="color: var(--c-gold);"></i>
                            </div>
                            <div>
                                <h5>Filtres</h5>
                                <p class="u-text-muted">Filtrer les journaux par niveau et date</p>
                            </div>
                        </div>
                    </div>
                    <div class="card__body">
                        <div class="logs-filters">
                            <div class="logs-filters__group">
                                <label class="logs-filters__label">Niveau :</label>
                                <select class="input">
                                    <option value="">Tous les niveaux</option>
                                    <option value="info">Info</option>
                                    <option value="warning">Avertissement</option>
                                    <option value="error">Erreur</option>
                                    <option value="success">Succès</option>
                                </select>
                            </div>
                            
                            <div class="logs-filters__group">
                                <label class="logs-filters__label">Date :</label>
                                <select class="input">
                                    <option value="today">Aujourd'hui</option>
                                    <option value="week">Cette semaine</option>
                                    <option value="month">Ce mois</option>
                                    <option value="all">Tout</option>
                                </select>
                            </div>
                            
                            <div class="logs-filters__group">
                                <button class="btn btn--outline">
                                    <i data-feather="refresh-cw"></i>
                                    Actualiser
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Liste des logs -->
                <div class="card u-mt-4">
                    <div class="card__header">
                        <div class="u-flex u-gap-4">
                            <div>
                                <i data-feather="list" style="color: var(--c-gold);"></i>
                            </div>
                            <div>
                                <h5>Journaux Récents</h5>
                                <p class="u-text-muted">Dernières activités du système</p>
                            </div>
                        </div>
                    </div>
                    <div class="card__body">
                        <div class="logs-container">
                            
                            <!-- Log Entry - Success -->
                            <div class="log-entry">
                                <div class="log-entry__header">
                                    <span class="log-entry__level log-entry__level--success">Succès</span>
                                    <span class="log-entry__timestamp">2024-01-15 14:32:15</span>
                                </div>
                                <p class="log-entry__message">
                                    Nouvel itinéraire créé avec succès : "Tour du Mont-Blanc - Étape 1"
                                </p>
                                <div class="log-entry__context">
                                    <pre>User: admin@cerfaos.fr | Action: create_itinerary | ID: 1234</pre>
                                </div>
                            </div>

                            <!-- Log Entry - Info -->
                            <div class="log-entry">
                                <div class="log-entry__header">
                                    <span class="log-entry__level log-entry__level--info">Info</span>
                                    <span class="log-entry__timestamp">2024-01-15 14:28:42</span>
                                </div>
                                <p class="log-entry__message">
                                    Utilisateur connecté : admin@cerfaos.fr
                                </p>
                                <div class="log-entry__context">
                                    <pre>IP: 192.168.1.100 | User Agent: Mozilla/5.0...</pre>
                                </div>
                            </div>

                            <!-- Log Entry - Warning -->
                            <div class="log-entry">
                                <div class="log-entry__header">
                                    <span class="log-entry__level log-entry__level--warning">Avertissement</span>
                                    <span class="log-entry__timestamp">2024-01-15 14:25:18</span>
                                </div>
                                <p class="log-entry__message">
                                    Tentative de connexion échouée pour l'utilisateur : user@example.com
                                </p>
                                <div class="log-entry__context">
                                    <pre>IP: 203.0.113.45 | Reason: Invalid credentials</pre>
                                </div>
                            </div>

                            <!-- Log Entry - Error -->
                            <div class="log-entry">
                                <div class="log-entry__header">
                                    <span class="log-entry__level log-entry__level--error">Erreur</span>
                                    <span class="log-entry__timestamp">2024-01-15 14:20:33</span>
                                </div>
                                <p class="log-entry__message">
                                    Erreur lors du traitement du fichier GPX : "montagne.gpx"
                                </p>
                                <div class="log-entry__context">
                                    <pre>Error: Invalid GPX format | File size: 2.1MB | User: admin@cerfaos.fr</pre>
                                </div>
                            </div>

                            <!-- Log Entry - Success -->
                            <div class="log-entry">
                                <div class="log-entry__header">
                                    <span class="log-entry__level log-entry__level--success">Succès</span>
                                    <span class="log-entry__timestamp">2024-01-15 14:15:07</span>
                                </div>
                                <p class="log-entry__message">
                                    Sauvegarde automatique effectuée avec succès
                                </p>
                                <div class="log-entry__context">
                                    <pre>Backup: database_2024_01_15.sql | Size: 45.2MB | Duration: 2.3s</pre>
                                </div>
                            </div>

                            <!-- Log Entry - Info -->
                            <div class="log-entry">
                                <div class="log-entry__header">
                                    <span class="log-entry__level log-entry__level--info">Info</span>
                                    <span class="log-entry__timestamp">2024-01-15 14:10:22</span>
                                </div>
                                <p class="log-entry__message">
                                    Mise à jour du profil utilisateur : admin@cerfaos.fr
                                </p>
                                <div class="log-entry__context">
                                    <pre>Updated fields: name, phone | User ID: 1</pre>
                                </div>
                            </div>

                        </div>

                        <!-- Pagination -->
                        <div class="logs-pagination">
                            <div class="pagination">
                                <a href="#" class="btn btn--outline btn--sm">Précédent</a>
                                <span class="u-mx-4">Page 1 sur 15</span>
                                <a href="#" class="btn btn--outline btn--sm">Suivant</a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Actions -->
                <div class="card u-mt-4">
                    <div class="card__header">
                        <div class="u-flex u-gap-4">
                            <div>
                                <i data-feather="settings" style="color: var(--c-gold);"></i>
                            </div>
                            <div>
                                <h5>Actions</h5>
                                <p class="u-text-muted">Gérer les journaux d'activité</p>
                            </div>
                        </div>
                    </div>
                    <div class="card__body">
                        <div class="u-flex u-gap-4">
                            <button class="btn btn--outline">
                                <i data-feather="download"></i>
                                Exporter les logs
                            </button>
                            <button class="btn btn--outline">
                                <i data-feather="trash-2"></i>
                                Nettoyer les anciens logs
                            </button>
                            <button class="btn btn--outline">
                                <i data-feather="settings"></i>
                                Configuration
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection









