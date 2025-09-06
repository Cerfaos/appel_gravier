@extends('home.body.home_master')

@section('home')
<div class="bg-outdoor-cream-50 min-h-screen">
    <!-- Banner Title Section -->
    

    <!-- Hero Section Préparation -->
    <section class="relative bg-gradient-to-r from-outdoor-ochre-500 to-outdoor-ochre-600 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    
                    <!-- Content Side -->
                    <div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                            <span class="text-outdoor-cream-50">Préparation</span><br>
                            <span class="text-outdoor-ochre-200">PPG - Performance & Puissance</span>
                        </h1>
                        
                        <p class="text-xl md:text-2xl mb-8 text-outdoor-cream-50/90 leading-relaxed">
                            Développez vos capacités physiques pour exceller dans vos activités outdoor
                        </p>
                        
                        <div class="bg-outdoor-cream-50/20 backdrop-blur-sm rounded-xl p-6 mb-8">
                            <p class="text-lg font-medium">
                                {{ $category->description ?? 'Améliorez votre performance avec des entraînements spécifiques adaptés à vos objectifs.' }}
                            </p>
                        </div>

                        <!-- Stats or Features -->
                        <div class="flex flex-wrap gap-6 text-outdoor-cream-50/90">
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-outdoor-ochre-300 rounded-full mr-3"></span>
                                <span>Entraînement ciblé</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-outdoor-ochre-300 rounded-full mr-3"></span>
                                <span>Progression mesurable</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-outdoor-ochre-300 rounded-full mr-3"></span>
                                <span>Résultats durables</span>
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
                            <!-- Fallback content -->
                            <div class="w-full h-80 bg-outdoor-cream-100 rounded-xl flex items-center justify-center" style="display: none;">
                                <div class="text-center">
                                    <i class="fas fa-dumbbell text-6xl text-outdoor-ochre-400 mb-4"></i>
                                    <p class="text-outdoor-forest-500 font-semibold">Préparation Physique</p>
                                </div>
                            </div>

                            <!-- Floating Achievement Cards -->
                            <div class="absolute -top-4 -right-4 bg-white rounded-2xl p-3 shadow-xl border border-outdoor-ochre-100 transform rotate-6 hover:rotate-3 transition-transform duration-300">
                                <div class="flex items-center space-x-2">
                                    <span class="text-2xl">🎯</span>
                                    <div>
                                        <div class="text-sm font-bold text-outdoor-forest-600">Performance</div>
                                        <div class="text-xs text-outdoor-forest-400">Optimisée</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl p-3 shadow-xl border border-outdoor-earth-100 transform -rotate-6 hover:-rotate-3 transition-transform duration-300">
                                <div class="flex items-center space-x-2">
                                    <span class="text-2xl">💪</span>
                                    <div>
                                        <div class="text-sm font-bold text-outdoor-forest-600">Force</div>
                                        <div class="text-xs text-outdoor-forest-400">Développée</div>
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
                    <h2 class="text-3xl font-bold text-outdoor-forest-500-500 mb-6">Objectifs de Préparation</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="card-outdoor">
                            <div class="w-16 h-16 bg-outdoor-ochre-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-outdoor-forest-500-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-outdoor-forest-500-500 mb-2">Force Fonctionnelle</h3>
                            <p class="text-sm text-gray-600">Développez la force utilisable dans vos activités outdoor</p>
                        </div>

                        <div class="card-outdoor">
                            <div class="w-16 h-16 bg-outdoor-ochre-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-outdoor-forest-500-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-outdoor-forest-500-500 mb-2">Endurance Cardio</h3>
                            <p class="text-sm text-gray-600">Améliorez votre capacité cardiovasculaire</p>
                        </div>

                        <div class="card-outdoor">
                            <div class="w-16 h-16 bg-outdoor-ochre-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-outdoor-forest-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-outdoor-forest-500 mb-2">Puissance Explosive</h3>
                            <p class="text-sm text-gray-600">Développez votre explosivité et réactivité</p>
                        </div>
                    </div>
                </div>

                <!-- Types d'entraînement -->
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-outdoor-forest-500 mb-8 text-center">Types d'Entraînement</h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="card-outdoor">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-outdoor-ochre-500/10 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-outdoor-forest-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 1.657-3.657 3.657-3.657a4.5 4.5 0 001.343 8.657z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-outdoor-forest-500">Entraînement Spécifique Vélo</h3>
                            </div>
                            <p class="text-gray-600 mb-4">
                                Travaillez les muscles et mouvements spécifiques au cyclisme : quadriceps, 
                                fessiers, core, et coordination pédalage.
                            </p>
                            <ul class="text-sm text-gray-600 space-y-2">
                                <li>• Squats et variantes</li>
                                <li>• Fentes dynamiques</li>
                                <li>• Travail unipodal</li>
                                <li>• Core rotatif</li>
                            </ul>
                        </div>

                        <div class="card-outdoor">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-outdoor-ochre-500/10 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-outdoor-forest-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-outdoor-forest-500">HIIT & Interval Training</h3>
                            </div>
                            <p class="text-gray-600 mb-4">
                                Améliorez votre capacité anaérobie et votre récupération avec des 
                                entraînements par intervalles haute intensité.
                            </p>
                            <ul class="text-sm text-gray-600 space-y-2">
                                <li>• Burpees et variations</li>
                                <li>• Sprints</li>
                                <li>• Circuits métaboliques</li>
                                <li>• Travail pliométrique</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Exercices -->
                @if(isset($category) && $category->publishedExercises->count() > 0)
                    <div class="mb-16">
                        <h2 class="text-3xl font-bold text-outdoor-forest-500 mb-8 text-center">Exercices de Préparation</h2>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($category->publishedExercises as $exercise)
                                <div class="card-outdoor hover:shadow-xl transition-shadow group">
                                    @if($exercise->featuredImage())
                                        <img src="{{ asset('storage/' . $exercise->featuredImage()) }}" alt="{{ $exercise->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                    @endif
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="bg-outdoor-ochre-500/20 text-outdoor-forest-500 text-xs px-2 py-1 rounded-full">
                                            {{ ucfirst($exercise->difficulty_level) }}
                                        </span>
                                        @if($exercise->duration_minutes)
                                            <span class="text-sm text-gray-500">{{ $exercise->duration_minutes }}min</span>
                                        @endif
                                    </div>
                                    
                                    <h3 class="text-lg font-semibold text-outdoor-forest-500 mb-2">{{ $exercise->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $exercise->description }}</p>
                                    
                                    @if($exercise->target_muscles)
                                        <div class="text-xs text-outdoor-ochre-400 mb-2 font-medium">
                                            🎯 {{ $exercise->target_muscles }}
                                        </div>
                                    @endif
                                    
                                    @if($exercise->sets && $exercise->reps)
                                        <div class="text-sm text-gray-500 mb-4">
                                            {{ $exercise->sets }} séries × {{ $exercise->reps }} reps
                                        </div>
                                    @endif
                                    
                                    <div class="btn-primary w-full text-center opacity-50 cursor-not-allowed">
                                        Détails bientôt disponibles
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Programmes -->
                @if(isset($category) && $category->publishedPrograms->count() > 0)
                    <div>
                        <h2 class="text-3xl font-bold text-outdoor-forest-500 mb-8 text-center">Programmes de Préparation</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            @foreach($category->publishedPrograms as $program)
                                <div class="card-outdoor hover:shadow-xl transition-shadow">
                                    @if($program->featuredImage())
                                        <img src="{{ asset('storage/' . $program->featuredImage()) }}" alt="{{ $program->title }}" class="w-full h-32 object-cover rounded-lg mb-4">
                                    @endif
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="bg-outdoor-ochre-500/20 text-outdoor-forest-500 text-xs px-2 py-1 rounded-full">
                                            {{ ucfirst($program->difficulty_level) }}
                                        </span>
                                        <span class="text-sm text-gray-500">{{ $program->duration_weeks }} semaines</span>
                                    </div>
                                    
                                    <h3 class="text-xl font-semibold text-outdoor-forest-500 mb-2">{{ $program->title }}</h3>
                                    <p class="text-gray-600 mb-4">{{ $program->description }}</p>
                                    
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <span>{{ $program->sessions_per_week }}x/semaine</span>
                                        <span>{{ $program->session_duration_minutes }}min/session</span>
                                    </div>
                                    
                                    <div class="btn-primary w-full text-center opacity-50 cursor-not-allowed">
                                        Détails bientôt disponibles
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-outdoor-ochre-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-outdoor-forest-500/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-outdoor-forest-500 mb-2">Contenu en préparation</h3>
                        <p class="text-gray-600">Les exercices et programmes de préparation seront bientôt disponibles.</p>
                    </div>
                @endif

            </div>
        </div>
    </section>
</div>
@endsection