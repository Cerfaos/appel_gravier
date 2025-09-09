@extends('home.body.home_master')

@section('home')
<div class="bg-outdoor-cream-50 min-h-screen">

    <!-- Hero Section Calendrier Vélo -->
    <section class="relative bg-gradient-to-r from-outdoor-ochre-500 to-outdoor-ochre-600 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    
                    <!-- Content Side -->
                    <div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                            <span class="text-outdoor-cream-50">Calendrier</span><br>
                            <span class="text-outdoor-ochre-200">Préparation Vélo</span>
                        </h1>
                        
                        <p class="text-xl md:text-2xl mb-8 text-outdoor-cream-50/90 leading-relaxed">
                            Planifiez votre entraînement cycliste avec séances détaillées selon les saisons
                        </p>
                        
                        <div class="bg-outdoor-cream-50/20 backdrop-blur-sm rounded-xl p-6 mb-8">
                            <p class="text-lg font-medium">
                                Vélo • PPG • Renforcement • Récupération - Tout programmé intelligemment
                            </p>
                        </div>

                        <!-- Stats or Features -->
                        <div class="flex flex-wrap gap-6 text-outdoor-cream-50/90">
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-outdoor-ochre-300 rounded-full mr-3"></span>
                                <span>Séances détaillées</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-outdoor-ochre-300 rounded-full mr-3"></span>
                                <span>Planification automatique</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-outdoor-ochre-300 rounded-full mr-3"></span>
                                <span>Récupération intégrée</span>
                            </div>
                        </div>
                    </div>

                    <!-- Image Side -->
                    <div class="relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                        
                        <!-- Background Gradient Cards -->
                        <div class="absolute inset-0 bg-outdoor-ochre-300 rounded-2xl transform rotate-3 shadow-2xl"></div>
                        <div class="absolute inset-0 bg-outdoor-earth-300 rounded-2xl transform -rotate-1 shadow-xl opacity-70"></div>
                        
                        <!-- Main Image Container -->
                        <div class="relative bg-white rounded-2xl p-6 shadow-2xl">
                            <img 
                                src="{{ asset('frontend/assets/images/img_cerfaos/bandeau_ppg03.png') }}" 
                                alt="Préparation Physique Générale - Entraînement Outdoor" 
                                class="w-full h-80 object-cover rounded-xl"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                            />

                            <!-- Floating Achievement Cards -->
                            <div class="absolute -top-4 -right-4 bg-white rounded-2xl p-3 shadow-xl border border-outdoor-ochre-100 transform rotate-6 hover:rotate-3 transition-transform duration-300">
                                <div class="flex items-center space-x-2">
                                    <span class="text-2xl">🚴</span>
                                    <div>
                                        <div class="text-sm font-bold text-outdoor-forest-600">Vélo</div>
                                        <div class="text-xs text-outdoor-forest-400">Programmé</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl p-3 shadow-xl border border-outdoor-earth-100 transform -rotate-6 hover:-rotate-3 transition-transform duration-300">
                                <div class="flex items-center space-x-2">
                                    <span class="text-2xl">💪</span>
                                    <div>
                                        <div class="text-sm font-bold text-outdoor-forest-600">PPG</div>
                                        <div class="text-xs text-outdoor-forest-400">Intégré</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -z-10 top-1/4 -right-8 w-32 h-32 bg-outdoor-ochre-200 rounded-full opacity-20 blur-2xl"></div>
                        <div class="absolute -z-10 bottom-1/4 -left-8 w-40 h-40 bg-outdoor-earth-200 rounded-full opacity-20 blur-2xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Contenu -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                
                <!-- Introduction -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-outdoor-forest-500 mb-6">Périodisation Intelligente</h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="card-outdoor">
                            <div class="w-16 h-16 bg-outdoor-ochre-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <div class="text-2xl">❄️</div>
                            </div>
                            <h3 class="font-bold text-outdoor-forest-500 mb-3">Automne/Hiver (Oct → Fév)</h3>
                            <div class="text-sm text-gray-600 space-y-2">
                                <div class="flex justify-between"><span>Vélo</span><span class="font-semibold">2x/semaine</span></div>
                                <div class="flex justify-between"><span>Renforcement</span><span class="font-semibold">2-3x/semaine</span></div>
                                <div class="flex justify-between"><span>PPG</span><span class="font-semibold">1-2x/semaine</span></div>
                                <div class="text-xs text-outdoor-forest-400 mt-3">Focus : Construction de la force de base</div>
                            </div>
                        </div>

                        <div class="card-outdoor">
                            <div class="w-16 h-16 bg-outdoor-ochre-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <div class="text-2xl">☀️</div>
                            </div>
                            <h3 class="font-bold text-outdoor-forest-500 mb-3">Printemps/Été (Mar → Sep)</h3>
                            <div class="text-sm text-gray-600 space-y-2">
                                <div class="flex justify-between"><span>Vélo</span><span class="font-semibold">3-4x/semaine</span></div>
                                <div class="flex justify-between"><span>Renforcement</span><span class="font-semibold">1x/semaine</span></div>
                                <div class="flex justify-between"><span>PPG</span><span class="font-semibold">1x/semaine</span></div>
                                <div class="text-xs text-outdoor-forest-400 mt-3">Focus : Volume et spécificité vélo</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Types de séances -->
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-outdoor-forest-500 mb-8 text-center">Types de Séances</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="card-outdoor text-center">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg mx-auto mb-3 flex items-center justify-center">
                                <div class="w-4 h-4 bg-yellow-400 rounded"></div>
                            </div>
                            <h4 class="font-bold text-outdoor-forest-500 mb-2">Vélo Endurance</h4>
                            <p class="text-xs text-gray-600">Z2 • 60-180min</p>
                        </div>

                        <div class="card-outdoor text-center">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg mx-auto mb-3 flex items-center justify-center">
                                <div class="w-4 h-4 bg-orange-400 rounded"></div>
                            </div>
                            <h4 class="font-bold text-outdoor-forest-500 mb-2">Vélo Intensité</h4>
                            <p class="text-xs text-gray-600">SST/Seuil/VO₂ • 45-90min</p>
                        </div>

                        <div class="card-outdoor text-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg mx-auto mb-3 flex items-center justify-center">
                                <div class="w-4 h-4 bg-gray-600 rounded"></div>
                            </div>
                            <h4 class="font-bold text-outdoor-forest-500 mb-2">Renforcement</h4>
                            <p class="text-xs text-gray-600">Force • 25-45min</p>
                        </div>

                        <div class="card-outdoor text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-3 flex items-center justify-center">
                                <div class="w-4 h-4 bg-blue-400 rounded"></div>
                            </div>
                            <h4 class="font-bold text-outdoor-forest-500 mb-2">PPG</h4>
                            <p class="text-xs text-gray-600">Cardio/Core • 30-60min</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Section Calendrier -->
    <section class="py-20 bg-outdoor-earth-100/30">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-outdoor-forest-500 mb-6">Calendrier Détaillé</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Chaque jour affiche la séance recommandée selon la périodisation. 
                        Repos programmés et semaines allégées intégrées.
                    </p>
                </div>

                <!-- Calendrier Container -->
                <div class="card-outdoor p-0 overflow-hidden" style="box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Calendrier Header -->
                    <div class="bg-gradient-to-r from-outdoor-ochre-500 to-outdoor-ochre-600 text-white p-6">
                        <h3 class="text-2xl font-bold mb-4 text-outdoor-cream-50">Planning Complet</h3>
                        <p class="text-sm mb-6 text-outdoor-cream-50/80">
                            Séances automatiques • Récupération intégrée • Adaptation saisonnière
                        </p>
                        
                        <!-- Contrôles -->
                        <div class="flex flex-wrap gap-4 items-center text-sm mb-4 text-outdoor-cream-50/90">
                            <div class="flex items-center gap-2">
                                <label class="font-semibold">Année de départ :</label>
                                <input type="number" id="start-year" min="2020" max="2040" value="2025" 
                                       class="text-outdoor-forest-500 px-3 py-1 rounded-lg border-0 text-sm" 
                                       onchange="updateCalendar()">
                            </div>
                            <span class="text-outdoor-cream-50/60">|</span>
                            <div class="flex items-center gap-2">
                                <label class="font-semibold">Mois :</label>
                                <select id="month-select" class="text-outdoor-forest-500 px-3 py-1 rounded-lg border-0 text-sm" onchange="updateCalendar()">
                                    <option value="0">Janvier</option>
                                    <option value="1">Février</option>
                                    <option value="2">Mars</option>
                                    <option value="3">Avril</option>
                                    <option value="4">Mai</option>
                                    <option value="5">Juin</option>
                                    <option value="6">Juillet</option>
                                    <option value="7">Août</option>
                                    <option value="8" selected>Septembre</option>
                                    <option value="9">Octobre</option>
                                    <option value="10">Novembre</option>
                                    <option value="11">Décembre</option>
                                </select>
                                <span id="current-year-display" class="font-semibold">2025</span>
                            </div>
                        </div>
                        
                        <!-- Navigation -->
                        <div class="flex justify-center gap-3">
                            <button onclick="navigateMonth(-1)" 
                                    class="bg-outdoor-cream-50/20 hover:bg-outdoor-cream-50/30 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                ← Mois précédent
                            </button>
                            <button onclick="navigateMonth(1)" 
                                    class="bg-outdoor-cream-50/20 hover:bg-outdoor-cream-50/30 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                Mois suivant →
                            </button>
                        </div>
                    </div>

                    <!-- Calendrier Content -->
                    <div class="p-6">
                        <!-- Titre du mois -->
                        <div class="mb-6">
                            <h4 class="text-2xl font-bold text-outdoor-forest-500" id="month-title">Septembre 2025</h4>
                            <p class="text-outdoor-forest-400" id="season-badge">Printemps/Été — Focus vélo</p>
                        </div>

                        <!-- Grille du calendrier -->
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm">
                                <thead>
                                    <tr class="bg-outdoor-forest-500 text-outdoor-cream-50">
                                        <th class="p-3 text-sm font-bold">Lun</th>
                                        <th class="p-3 text-sm font-bold">Mar</th>
                                        <th class="p-3 text-sm font-bold">Mer</th>
                                        <th class="p-3 text-sm font-bold">Jeu</th>
                                        <th class="p-3 text-sm font-bold">Ven</th>
                                        <th class="p-3 text-sm font-bold">Sam</th>
                                        <th class="p-3 text-sm font-bold">Dim</th>
                                    </tr>
                                </thead>
                                <tbody id="calendar-body" class="text-sm">
                                    <!-- Généré par JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Légende -->
                        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="flex items-center text-sm">
                                <div class="w-4 h-4 bg-yellow-400 rounded mr-2"></div>
                                <span>Vélo Endurance</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <div class="w-4 h-4 bg-orange-400 rounded mr-2"></div>
                                <span>Vélo Intensité</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <div class="w-4 h-4 bg-gray-600 rounded mr-2"></div>
                                <span>Renforcement</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <div class="w-4 h-4 bg-blue-400 rounded mr-2"></div>
                                <span>PPG</span>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="mt-6 p-4 bg-outdoor-earth-100/50 rounded-lg border-l-4 border-outdoor-ochre-400" id="calendar-footer">
                            <p class="text-sm text-outdoor-forest-500">
                                <strong>💡 Conseils :</strong> Les séances s'adaptent automatiquement à la saison. 
                                Repos le dimanche et semaines allégées programmées tous les 4 cycles.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Section Conseils -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-outdoor-forest-500 mb-6">Optimisation de l'Entraînement</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="card-outdoor hover:shadow-xl transition-shadow text-center">
                            <div class="w-16 h-16 bg-outdoor-ochre-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-outdoor-forest-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-outdoor-forest-500 mb-2">Timing Optimal</h3>
                            <p class="text-sm text-gray-600">Les séances sont programmées pour maximiser les adaptations et la récupération</p>
                        </div>

                        <div class="card-outdoor hover:shadow-xl transition-shadow text-center">
                            <div class="w-16 h-16 bg-outdoor-ochre-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-outdoor-forest-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-outdoor-forest-500 mb-2">Progression Logique</h3>
                            <p class="text-sm text-gray-600">Volume et intensité évoluent selon les principes scientifiques d'entraînement</p>
                        </div>

                        <div class="card-outdoor hover:shadow-xl transition-shadow text-center">
                            <div class="w-16 h-16 bg-outdoor-ochre-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-outdoor-forest-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-outdoor-forest-500 mb-2">Récupération Intégrée</h3>
                            <p class="text-sm text-gray-600">Repos programmés et semaines allégées pour éviter le surentraînement</p>
                        </div>
                    </div>
                </div>

                <!-- Exemple de semaine type -->
                <div class="card-outdoor">
                    <h3 class="text-xl font-bold text-outdoor-forest-500 mb-4">Exemple : Semaine Type Printemps</h3>
                    <div class="grid grid-cols-7 gap-2 text-center text-sm">
                        <div class="p-3 bg-gray-100 rounded"><div class="font-semibold">Lun</div><div class="mt-1 text-xs text-gray-600">Repos</div></div>
                        <div class="p-3 bg-orange-100 rounded"><div class="font-semibold">Mar</div><div class="mt-1 text-xs text-orange-600">Vélo SST</div></div>
                        <div class="p-3 bg-blue-100 rounded"><div class="font-semibold">Mer</div><div class="mt-1 text-xs text-blue-600">PPG Core</div></div>
                        <div class="p-3 bg-yellow-100 rounded"><div class="font-semibold">Jeu</div><div class="mt-1 text-xs text-yellow-600">Vélo Z2</div></div>
                        <div class="p-3 bg-gray-200 rounded"><div class="font-semibold">Ven</div><div class="mt-1 text-xs text-gray-600">Renfo</div></div>
                        <div class="p-3 bg-yellow-100 rounded"><div class="font-semibold">Sam</div><div class="mt-1 text-xs text-yellow-600">Longue Z2</div></div>
                        <div class="p-3 bg-gray-100 rounded"><div class="font-semibold">Dim</div><div class="mt-1 text-xs text-gray-600">Repos</div></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<style>
/* Styles spécifiques au calendrier */
#calendar-body td {
    height: 110px;
    vertical-align: top;
    border: 1px solid #e2e8f0;
    padding: 6px;
    background: white;
    position: relative;
}

#calendar-body td:hover {
    background: #f8fafc;
}

#calendar-body td.other-month {
    background: #f8f9fa;
    color: #94a3b8;
}

#calendar-body td.weekend {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
}

#calendar-body td.other-month.weekend {
    background: #f3f4f6;
}

.date-number {
    font-size: 14px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 4px;
}

#calendar-body td.other-month .date-number {
    color: #94a3b8;
}

.session {
    font-size: 10px;
    line-height: 1.2;
    margin-bottom: 2px;
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    font-weight: 500;
    text-align: center;
}

.session.bike-endurance {
    background: #f59e0b;
    border: 1px solid #d97706;
}

.session.bike-intensity {
    background: #ea580c;
    border: 1px solid #c2410c;
}

.session.bike-tempo {
    background: #0ea5e9;
    border: 1px solid #0284c7;
}

.session.strength {
    background: #374151;
    border: 1px solid #1f2937;
}

.session.ppg {
    background: #3b82f6;
    border: 1px solid #2563eb;
}

.session.rest {
    background: #9ca3af;
    border: 1px solid #6b7280;
    color: #374151;
}

.session.recovery {
    background: #10b981;
    border: 1px solid #059669;
}

.week-marker {
    font-size: 9px;
    font-weight: 600;
    color: #d97706;
    margin-bottom: 3px;
    text-align: center;
    background: rgba(251, 146, 60, 0.1);
    padding: 1px 4px;
    border-radius: 6px;
}

.deload-week {
    background: rgba(251, 146, 60, 0.15) !important;
}

.deload-week .date-number {
    color: #d97706;
}

select option {
    background: white;
    color: #374151;
}
</style>

<script>
let currentMonth = 8; // Septembre (0-based)
let currentYear = 2025;

const monthNames = [
    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
];

// Programme détaillé par saison
const trainingProgram = {
    // Automne/Hiver : Focus renforcement + maintien vélo
    aw: {
        pattern: [
            // Semaine 1
            ['rest', 'strength', 'bike-intensity', 'ppg', 'strength', 'bike-endurance', 'rest'],
            // Semaine 2  
            ['rest', 'strength', 'bike-intensity', 'recovery', 'strength', 'bike-endurance', 'rest'],
            // Semaine 3
            ['rest', 'strength', 'bike-intensity', 'ppg', 'strength', 'bike-endurance', 'rest'],
            // Semaine 4 (allégée)
            ['rest', 'strength', 'bike-endurance', 'recovery', 'rest', 'bike-endurance', 'rest']
        ],
        sessions: {
            'bike-endurance': ['Vélo Z2 (60min)', 'Vélo Z2 (75min)', 'Vélo Z2 (90min)', 'Vélo Z2 (60min)'],
            'bike-intensity': ['Vélo SST (45min)', 'Vélo Seuil (50min)', 'Vélo VO₂ (45min)', 'Vélo Tempo (40min)'],
            'strength': ['Renfo Force (35min)', 'Renfo Puissance (30min)', 'Renfo Endurance (40min)', 'Renfo Léger (25min)'],
            'ppg': ['PPG Core (30min)', 'PPG Cardio (40min)', 'PPG Full Body (35min)', 'PPG Souplesse (25min)'],
            'recovery': ['Mobilité (20min)', 'Vélo Z1 (30min)', 'Marche active (45min)', 'Étirements (15min)'],
            'rest': ['Repos complet', 'Repos complet', 'Repos complet', 'Repos complet']
        }
    },
    
    // Printemps/Été : Focus volume vélo + maintien force
    ps: {
        pattern: [
            // Semaine 1
            ['rest', 'bike-intensity', 'ppg', 'bike-tempo', 'strength', 'bike-endurance', 'rest'],
            // Semaine 2
            ['rest', 'bike-intensity', 'recovery', 'bike-tempo', 'strength', 'bike-endurance', 'rest'],
            // Semaine 3
            ['rest', 'bike-intensity', 'ppg', 'bike-tempo', 'strength', 'bike-endurance', 'rest'],
            // Semaine 4 (allégée)
            ['rest', 'bike-endurance', 'recovery', 'bike-endurance', 'rest', 'bike-endurance', 'rest']
        ],
        sessions: {
            'bike-endurance': ['Vélo Z2 (90min)', 'Vélo Z2 (120min)', 'Longue Z2 (150min)', 'Vélo Z2 (75min)'],
            'bike-intensity': ['Vélo SST (60min)', 'Vélo Seuil (55min)', 'Vélo VO₂ (50min)', 'Vélo Tempo (45min)'],
            'bike-tempo': ['Vélo Tempo+Skills (70min)', 'Vélo Tempo (75min)', 'Vélo Technique (60min)', 'Vélo Souplesse (50min)'],
            'strength': ['Renfo Entretien (25min)', 'Renfo Force (30min)', 'Renfo Prévention (20min)', 'Renfo Léger (20min)'],
            'ppg': ['PPG Cardio (35min)', 'PPG Fonctionnel (40min)', 'PPG Agilité (30min)', 'PPG Souplesse (25min)'],
            'recovery': ['Vélo Z1 (45min)', 'Mobilité (25min)', 'Natation (30min)', 'Marche (30min)'],
            'rest': ['Repos complet', 'Repos complet', 'Repos complet', 'Repos complet']
        }
    }
};

function getSeason(month) {
    // Mars (2) à Septembre (8) = Printemps/Été
    // Octobre (9) à Février (1) = Automne/Hiver
    return (month >= 2 && month <= 8) ? 'ps' : 'aw';
}

function getWeekOfMonth(date) {
    const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    const dayOfMonth = date.getDate();
    let startDayOfWeek = firstDay.getDay();
    startDayOfWeek = startDayOfWeek === 0 ? 6 : startDayOfWeek - 1; // Lundi = 0
    
    return Math.floor((dayOfMonth - 1 + startDayOfWeek) / 7);
}

function isDeloadWeek(weekNumber) {
    // Chaque 4ème semaine est allégée
    return weekNumber % 4 === 3; // Semaine 4, 8, 12, etc.
}

function generateCalendar(year, month) {
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();
    
    // Ajuster pour commencer le lundi
    let startDayOfWeek = firstDay.getDay();
    startDayOfWeek = startDayOfWeek === 0 ? 6 : startDayOfWeek - 1;
    
    const season = getSeason(month);
    const program = trainingProgram[season];
    
    let html = '';
    
    // Générer 6 semaines maximum
    for (let week = 0; week < 6; week++) {
        if ((week * 7 - startDayOfWeek + 1) > daysInMonth && week > 0) break;
        
        html += '<tr>';
        
        for (let day = 0; day < 7; day++) {
            let cellDate = week * 7 + day - startDayOfWeek + 1;
            let isCurrentMonth = cellDate >= 1 && cellDate <= daysInMonth;
            let displayDate = cellDate;
            let isOtherMonth = false;
            
            if (cellDate < 1) {
                // Jours du mois précédent
                const prevMonth = month === 0 ? 11 : month - 1;
                const prevYear = month === 0 ? year - 1 : year;
                const prevLastDay = new Date(prevYear, prevMonth + 1, 0).getDate();
                displayDate = prevLastDay + cellDate;
                isOtherMonth = true;
            } else if (cellDate > daysInMonth) {
                // Jours du mois suivant
                displayDate = cellDate - daysInMonth;
                isOtherMonth = true;
            }
            
            const isWeekend = day >= 5;
            let cssClasses = '';
            if (isOtherMonth) cssClasses += 'other-month ';
            if (isWeekend) cssClasses += 'weekend ';
            
            // Calculer semaine pour déload
            let weekOfYear = Math.floor((new Date(year, month, cellDate).getTime() - new Date(year, 0, 1).getTime()) / (7 * 24 * 60 * 60 * 1000));
            const isDeload = isDeloadWeek(weekOfYear) && isCurrentMonth;
            if (isDeload) cssClasses += 'deload-week ';
            
            html += `<td class="${cssClasses}">`;
            html += `<div class="date-number">${displayDate}</div>`;
            
            // Marqueur semaine allégée
            if (isDeload && day === 0) {
                html += `<div class="week-marker">Semaine allégée (-30%)</div>`;
            }
            
            // Ajouter la séance si c'est le mois courant
            if (isCurrentMonth && !isOtherMonth) {
                const weekInPattern = weekOfYear % 4;
                const sessionType = program.pattern[weekInPattern][day];
                const sessionDetail = program.sessions[sessionType][weekInPattern];
                
                if (sessionType && sessionDetail) {
                    html += `<div class="session ${sessionType}">${sessionDetail}</div>`;
                }
            }
            
            html += '</td>';
        }
        
        html += '</tr>';
    }
    
    return html;
}

function updateCalendar() {
    const yearInput = document.getElementById('start-year');
    const monthSelect = document.getElementById('month-select');
    
    currentYear = parseInt(yearInput.value);
    currentMonth = parseInt(monthSelect.value);
    
    // Calculer l'année réelle
    let displayYear = currentYear;
    if (currentMonth < 8) {
        displayYear = currentYear + 1;
    }
    
    const season = getSeason(currentMonth);
    const monthName = monthNames[currentMonth];
    
    // Mettre à jour l'affichage
    document.getElementById('month-title').textContent = `${monthName} ${displayYear}`;
    document.getElementById('current-year-display').textContent = displayYear;
    
    // Mettre à jour le badge de saison
    const badge = document.getElementById('season-badge');
    
    if (season === 'aw') {
        badge.textContent = 'Automne/Hiver — Focus renforcement';
    } else {
        badge.textContent = 'Printemps/Été — Focus vélo';
    }
    
    // Générer le calendrier
    const calendarBody = document.getElementById('calendar-body');
    calendarBody.innerHTML = generateCalendar(displayYear, currentMonth);
}

function navigateMonth(direction) {
    currentMonth += direction;
    
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear += 1;
    } else if (currentMonth < 0) {
        currentMonth = 11;
        currentYear -= 1;
    }
    
    // Limiter à 10 ans
    const startYear = parseInt(document.getElementById('start-year').value);
    if (currentYear > startYear + 9) {
        currentYear = startYear + 9;
        currentMonth = 11;
    } else if (currentYear < startYear) {
        currentYear = startYear;
        currentMonth = 8;
    }
    
    document.getElementById('month-select').value = currentMonth;
    document.getElementById('start-year').value = currentYear;
    updateCalendar();
}

// Initialiser au chargement
document.addEventListener('DOMContentLoaded', function() {
    updateCalendar();
});
</script>

@endsection