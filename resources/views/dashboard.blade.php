<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="flex items-center justify-center w-12 h-12 bg-outdoor-olive-500 rounded-2xl text-white">
                <span class="text-2xl">🏔️</span>
            </div>
            <div>
                <h2 class="font-display font-bold text-2xl text-outdoor-forest-600">
                    Dashboard Outdoor
                </h2>
                <p class="text-outdoor-forest-400 mt-1">
                    Bienvenue dans votre espace aventurier, {{ Auth::user()->name }} !
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Card -->
            <div class="bg-outdoor-sunset rounded-3xl p-8 text-white relative overflow-hidden shadow-outdoor-2xl">
                <!-- Background Pattern -->
                <div class="absolute top-6 right-8 text-6xl opacity-20">🌿</div>
                <div class="absolute bottom-6 right-16 text-4xl opacity-20">🏔️</div>
                
                <div class="relative z-10">
                    <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium mb-4">
                        <span class="text-lg">🎉</span>
                        <span>Membre Cerfaos</span>
                    </div>
                    
                    <h3 class="text-3xl font-display font-bold mb-4">
                        Votre aventure commence ici !
                    </h3>
                    <p class="text-white/90 text-lg max-w-2xl">
                        Explorez vos prochaines aventures outdoor, consultez vos réservations et découvrez de nouveaux défis qui vous attendent.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 mt-6">
                        <a href="{{ url('/') }}" class="btn-secondary bg-white text-outdoor-forest-600 hover:bg-outdoor-cream-100">
                            🌍 Explorer les Aventures
                        </a>
                        <a href="#booking" class="bg-outdoor-olive-600 hover:bg-outdoor-olive-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors duration-300">
                            📅 Nouvelle Réservation
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Adventures Count -->
                <div class="bg-white rounded-3xl p-6 shadow-outdoor-lg hover:shadow-outdoor-xl transition-shadow group">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-outdoor-olive-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="text-2xl">🥾</span>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-outdoor-forest-600">12</div>
                            <div class="text-outdoor-forest-400 text-sm">Aventures Complétées</div>
                        </div>
                    </div>
                </div>

                <!-- Next Adventure -->
                <div class="bg-white rounded-3xl p-6 shadow-outdoor-lg hover:shadow-outdoor-xl transition-shadow group">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-outdoor-ochre-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="text-2xl">📅</span>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-outdoor-forest-600">3</div>
                            <div class="text-outdoor-forest-400 text-sm">Prochaines Sorties</div>
                        </div>
                    </div>
                </div>

                <!-- Experience Level -->
                <div class="bg-white rounded-3xl p-6 shadow-outdoor-lg hover:shadow-outdoor-xl transition-shadow group">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-outdoor-earth-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="text-2xl">🏆</span>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-outdoor-forest-600">Expert</div>
                            <div class="text-outdoor-forest-400 text-sm">Niveau Atteint</div>
                        </div>
                    </div>
                </div>

                <!-- Favorite Activity -->
                <div class="bg-white rounded-3xl p-6 shadow-outdoor-lg hover:shadow-outdoor-xl transition-shadow group">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-outdoor-forest-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="text-2xl">🏔️</span>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-outdoor-forest-600">Randonnée</div>
                            <div class="text-outdoor-forest-400 text-sm">Activité Favorite</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content Grid -->
            <div class="grid lg:grid-cols-3 gap-8">
                
                <!-- Recent Activities -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-outdoor-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-outdoor-olive-100 rounded-xl flex items-center justify-center">
                                <span class="text-xl">📈</span>
                            </div>
                            <h3 class="text-xl font-display font-semibold text-outdoor-forest-600">
                                Activités Récentes
                            </h3>
                        </div>
                        <a href="#" class="text-outdoor-olive-600 hover:text-outdoor-olive-700 text-sm font-medium">
                            Voir tout →
                        </a>
                    </div>

                    <div class="space-y-4">
                        <!-- Activity Item -->
                        <div class="flex items-center space-x-4 p-4 bg-outdoor-cream-50 rounded-2xl hover:bg-outdoor-cream-100 transition-colors">
                            <div class="w-12 h-12 bg-outdoor-olive-500 rounded-xl flex items-center justify-center text-white">
                                <span class="text-lg">🏔️</span>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-outdoor-forest-600">Randonnée Mont Blanc</div>
                                <div class="text-sm text-outdoor-forest-400">Complétée le 15 Dec 2024</div>
                            </div>
                            <div class="text-outdoor-olive-600 font-semibold">✓</div>
                        </div>

                        <div class="flex items-center space-x-4 p-4 bg-outdoor-cream-50 rounded-2xl hover:bg-outdoor-cream-100 transition-colors">
                            <div class="w-12 h-12 bg-outdoor-earth-500 rounded-xl flex items-center justify-center text-white">
                                <span class="text-lg">🏕️</span>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-outdoor-forest-600">Camping Sauvage Vercors</div>
                                <div class="text-sm text-outdoor-forest-400">Complétée le 8 Dec 2024</div>
                            </div>
                            <div class="text-outdoor-olive-600 font-semibold">✓</div>
                        </div>

                        <div class="flex items-center space-x-4 p-4 bg-outdoor-cream-50 rounded-2xl hover:bg-outdoor-cream-100 transition-colors">
                            <div class="w-12 h-12 bg-outdoor-ochre-500 rounded-xl flex items-center justify-center text-white">
                                <span class="text-lg">🧗</span>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-outdoor-forest-600">Escalade Débutant</div>
                                <div class="text-sm text-outdoor-forest-400">Complétée le 1 Dec 2024</div>
                            </div>
                            <div class="text-outdoor-olive-600 font-semibold">✓</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="space-y-6">
                    
                    <!-- Upcoming Adventure -->
                    <div class="bg-white rounded-3xl p-6 shadow-outdoor-lg">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-outdoor-ochre-100 rounded-xl flex items-center justify-center">
                                <span class="text-xl">⏰</span>
                            </div>
                            <h3 class="text-lg font-display font-semibold text-outdoor-forest-600">
                                Prochaine Aventure
                            </h3>
                        </div>
                        
                        <div class="bg-outdoor-cream-50 rounded-2xl p-4">
                            <div class="font-semibold text-outdoor-forest-600 mb-2">🌲 Trekking Forestier</div>
                            <div class="text-sm text-outdoor-forest-400 mb-3">22 Décembre 2024 - 09:00</div>
                            <button class="w-full bg-outdoor-olive-500 hover:bg-outdoor-olive-600 text-white px-4 py-2 rounded-xl font-semibold transition-colors">
                                Voir Détails
                            </button>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-3xl p-6 shadow-outdoor-lg">
                        <h3 class="text-lg font-display font-semibold text-outdoor-forest-600 mb-4">
                            Actions Rapides
                        </h3>
                        
                        <div class="space-y-3">
                            <button class="w-full flex items-center space-x-3 p-3 text-left bg-outdoor-cream-50 hover:bg-outdoor-cream-100 rounded-xl transition-colors">
                                <span class="text-xl">📅</span>
                                <span class="font-medium text-outdoor-forest-600">Nouvelle Réservation</span>
                            </button>
                            
                            <button class="w-full flex items-center space-x-3 p-3 text-left bg-outdoor-cream-50 hover:bg-outdoor-cream-100 rounded-xl transition-colors">
                                <span class="text-xl">👤</span>
                                <span class="font-medium text-outdoor-forest-600">Modifier Profil</span>
                            </button>
                            
                            <button class="w-full flex items-center space-x-3 p-3 text-left bg-outdoor-cream-50 hover:bg-outdoor-cream-100 rounded-xl transition-colors">
                                <span class="text-xl">📊</span>
                                <span class="font-medium text-outdoor-forest-600">Mes Statistiques</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
