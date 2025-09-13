@extends('home.body.home_master')

@section('title', 'Contact - Cerfaos Outdoor Adventures')

@section('meta')
<meta name="description" content="Contactez l'équipe Cerfaos pour organiser vos aventures outdoor, randonnées et expéditions gravel. Nous sommes là pour vous accompagner dans vos projets.">
<meta name="keywords" content="contact cerfaos, aventure outdoor, randonnée, gravel, expédition, nature">
@endsection

@section('content')

<section class="relative bg-gradient-to-r from-outdoor-forest-500 to-outdoor-forest-800 text-white py-20">
  <div class="container mx-auto px-4">
      <div class="max-w-6xl mx-auto">
          <div class="grid md:grid-cols-2 gap-12 items-center">
              
              <!-- Content Side -->
              <div>
                  <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                      <span class="text-outdoor-cream-50">Parlons de votre</span><br>
                      <span class="text-outdoor-ochre-200">prochain projet</span>
                  </h1>
                  
                 
                  
                  <div class="bg-outdoor-cream-50/20 backdrop-blur-sm rounded-xl p-6 mb-8">
                      <p class="text-lg font-medium">
                        Une question sur mes itinéraires ? Envie de partager une sortie ? Besoin de conseils pour votre équipement ?<br>
                        Je suis là pour échanger et vous accompagner dans vos idées.
                      </p>
                  </div>

                  <!-- Stats or Features -->
                  
              </div>

              <!-- Image Side -->
              <div class="relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                  
                  <!-- Background Gradient Cards -->
                  <div class="absolute inset-0 bg-outdoor-ochre-300 rounded-2xl transform rotate-3 shadow-2xl"></div>
                  <div class="absolute inset-0 bg-outdoor-earth-300 rounded-2xl transform -rotate-1 shadow-xl opacity-70"></div>
                  
                  <!-- Main Image Container -->
                  <div class="relative bg-white rounded-2xl p-6 shadow-2xl">
                      <img 
                          src="{{ asset('frontend/assets/images/img_cerfaos/ts-cerfaos.png') }}" 
                          alt="Préparation Physique Générale - Entraînement Outdoor" 
                          class="object-contain rounded-lg w-full mb-4"
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
                     
                      
                  </div>

                  <!-- Decorative Elements -->
                  <div class="absolute -z-10 top-1/4 -right-8 w-32 h-32 bg-outdoor-ochre-200 rounded-full opacity-20 blur-2xl"></div>
                  <div class="absolute -z-10 bottom-1/4 -left-8 w-40 h-40 bg-outdoor-earth-200 rounded-full opacity-20 blur-2xl"></div>
              </div>
          </div>
      </div>
  </div>
</section>

<!-- Hero Section with Outdoor Theme -->


<!-- Contact Form Section -->
<section class="py-20 lg:py-32 bg-white relative">
  
  <!-- Background Decorations -->
  <div class="absolute top-20 right-16 text-6xl opacity-5">🏔️</div>
  <div class="absolute bottom-32 left-16 text-4xl opacity-5">🚴‍♂️</div>

  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-16 items-start">
      
      <!-- Contact Information -->
      <div class="space-y-8" data-aos="fade-right" data-aos-duration="800">
        
        <!-- Section Title -->
        <div class="space-y-4">
          <h2 class="text-3xl md:text-4xl font-display font-bold text-outdoor-forest-600 leading-tight">
            Discutons de vos <span class="text-outdoor-olive-500">projets</span>
          </h2>
          <p class="text-lg text-outdoor-forest-400 leading-relaxed">
            Que vous soyez débutant ou aventurier confirmé, chaque échange me permet de mieux comprendre vos envies.
          </p>
        </div>

        <!-- Contact Cards -->
        <div class="space-y-6">
          
          <!-- Email Card -->
          <div class="group card-outdoor" data-aos="fade-up" data-aos-duration="600">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-12 h-12 bg-outdoor-olive-100 rounded-2xl flex items-center justify-center group-hover:bg-outdoor-olive-200 transition-colors">
                <svg class="w-6 h-6 text-outdoor-olive-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-display font-semibold text-lg text-outdoor-forest-600 mb-2">Par email</h4>
                <p class="text-outdoor-forest-400 mb-2">Pour toute question générale ou demande d'information</p>
                <a href="mailto:contact@cerfaos.com" class="link-outdoor">cerfaos@gmail.com</a>
              </div>
            </div>
          </div>

          <!-- Response Time Card -->
          <div class="group card-outdoor" data-aos="fade-up" data-aos-duration="700">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-12 h-12 bg-outdoor-earth-100 rounded-2xl flex items-center justify-center group-hover:bg-outdoor-earth-200 transition-colors">
                <svg class="w-6 h-6 text-outdoor-earth-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-display font-semibold text-lg text-outdoor-forest-600 mb-2">Temps de réponse</h4>
                <p class="text-outdoor-forest-400">Je réponds généralement sous 24h, parfois plus rapidement si je ne suis pas en vadrouille !</p>
              </div>
            </div>
          </div>

          <!-- Community Card -->
          <div class="group card-outdoor" data-aos="fade-up" data-aos-duration="800">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-12 h-12 bg-outdoor-ochre-100 rounded-2xl flex items-center justify-center group-hover:bg-outdoor-ochre-200 transition-colors">
                <svg class="w-6 h-6 text-outdoor-ochre-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <div>
                <h4 class="font-display font-semibold text-lg text-outdoor-forest-600 mb-2">Pas de communauté</h4>
                <p class="text-outdoor-forest-400">Je ne suis pas sur les réseaux sociaux.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
        
        <!-- Form Background -->
        <div class="card-outdoor p-8">
          
          <!-- Success/Error Messages -->
          @if(session('success'))
            <div class="mb-6 bg-outdoor-olive-50 border-l-4 border-outdoor-olive-400 p-4 rounded-r-xl">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="w-5 h-5 text-outdoor-olive-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-outdoor-olive-700 font-medium">{{ session('success') }}</p>
                </div>
              </div>
            </div>
          @endif

          @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-xl">
              <div class="flex">
                <div class="flex-shrink-0">
                  <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div class="ml-3">
                  <h4 class="text-red-800 font-medium">Quelques corrections à apporter :</h4>
                  <ul class="mt-2 text-red-700 list-disc list-inside">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          @endif

          <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Form Header -->
            <div class="text-center mb-8">
              <h3 class="text-2xl font-display font-bold text-outdoor-forest-600 mb-2">Envoyez-nous un message</h3>
              <p class="text-outdoor-forest-400">Tous les champs marqués d'un * sont obligatoires</p>
            </div>

            <!-- Name and Email Row -->
            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <label for="name" class="block text-sm font-medium text-outdoor-forest-600 mb-2">Nom complet *</label>
                <input 
                  type="text" 
                  id="name" 
                  name="name" 
                  value="{{ old('name') }}"
                  required 
                  class="input-outdoor @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                  placeholder="Votre nom et prénom"
                  autocomplete="name"
                >
              </div>
              
              <div>
                <label for="email" class="block text-sm font-medium text-outdoor-forest-600 mb-2">Adresse email *</label>
                <input 
                  type="email" 
                  id="email" 
                  name="email" 
                  value="{{ old('email') }}"
                  required 
                  class="input-outdoor @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                  placeholder="votre@email.com"
                  autocomplete="email"
                  inputmode="email"
                >
              </div>
            </div>

            <!-- Phone and Subject Row -->
            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <label for="phone" class="block text-sm font-medium text-outdoor-forest-600 mb-2">Téléphone</label>
                <input 
                  type="tel" 
                  id="phone" 
                  name="phone" 
                  value="{{ old('phone') }}"
                  class="input-outdoor @error('phone') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                  placeholder="06 12 34 56 78"
                  autocomplete="tel"
                  inputmode="tel"
                >
              </div>
              
              <div>
                <label for="subject" class="block text-sm font-medium text-outdoor-forest-600 mb-2">Sujet *</label>
                <input 
                  type="text" 
                  id="subject" 
                  name="subject" 
                  value="{{ old('subject') }}"
                  required 
                  class="input-outdoor @error('subject') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                  placeholder="L'objet de votre message"
                >
              </div>
            </div>

            <!-- Message -->
            <div>
              <label for="message" class="block text-sm font-medium text-outdoor-forest-600 mb-2">Message *</label>
              <textarea 
                id="message" 
                name="message" 
                rows="6" 
                required 
                class="input-outdoor @error('message') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                placeholder="Parlez-nous de votre projet, vos questions, vos envies d'aventure... Nous sommes là pour échanger !"
              >{{ old('message') }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-center pt-4">
              <button 
                type="submit" 
                class="btn-primary text-lg px-8 py-4 w-full md:w-auto"
              >
                <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                Envoyer le message
              </button>
            </div>
          </form>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute -z-10 top-1/4 -right-8 w-32 h-32 bg-outdoor-ochre-200 rounded-full opacity-20 blur-2xl"></div>
        <div class="absolute -z-10 bottom-1/4 -left-8 w-40 h-40 bg-outdoor-olive-200 rounded-full opacity-20 blur-2xl"></div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ/Help Section -->
<section class="py-20 bg-outdoor-forest-300">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    
    <div class="inline-flex items-center space-x-2 bg-outdoor--100 text-outdoor-olive-700 px-4 py-2 rounded-full text-sm font-medium mb-6">
      <span class="text-lg">💡</span>
      <span>Questions Fréquentes</span>
    </div>

    <h2 class="text-3xl md:text-4xl font-display font-bold text-outdoor-forest-600 mb-8">
      Tout ce que vous devez savoir avant de <span class="text-outdoor-olive-500">partir à l'aventure</span>
    </h2>

    <div class="grid md:grid-cols-2 gap-6 mt-12">
      
      <div class="card-outdoor text-left">
        <h4 class="font-display font-semibold text-lg text-outdoor-forest-600 mb-3">🚴‍♂️ Quel niveau pour les sorties gravel ?</h4>
        <p class="text-outdoor-forest-400">Mes sorties s'adaptent à tous les niveaux. Précisez votre expérience dans votre message, en 2025, je me considère comme un débutant.</p>
      </div>

      <div class="card-outdoor text-left">
        <h4 class="font-display font-semibold text-lg text-outdoor-forest-600 mb-3">📅 Comment réserver une sortie ?</h4>
        <p class="text-outdoor-forest-400">Contactez-moi avec vos dates préférées et le type de parcours souhaité. J'organiserai mes sorties en fonction des demandes et de la météo.</p>
      </div>

      <div class="card-outdoor text-left">
        <h4 class="font-display font-semibold text-lg text-outdoor-forest-600 mb-3">🎒 Que faut-il apporter ?</h4>
        <p class="text-outdoor-forest-400">En général : vélo, casque, vêtements adaptés, de quoi manger, de quoi boire (on ne sait jamais) et bonne humeur sont les essentiels !</p>
      </div>

      <div class="card-outdoor text-left">
        <h4 class="font-display font-semibold text-lg text-outdoor-forest-600 mb-3">🌦️ Et si la météo ne joue pas le jeu ?</h4>
        <p class="text-outdoor-forest-400">L'aventure continue sous la pluie ! Mais si les conditions sont vraiment difficiles, je reporte pour notre sécurité et notre plaisir.</p>
      </div>
    </div>
  </div>
</section>

@endsection