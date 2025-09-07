
<!-- About Cerfaos Outdoor Adventures -->
<section id="about" class="py-20 lg:py-32 relative overflow-hidden">
  
  <!-- Multi-layered Background -->
  <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-50/40 via-white to-outdoor-earth-100/30"></div>
  
  <!-- Animated background shapes -->
  <div class="absolute inset-0">
    <div class="absolute top-20 right-16 w-48 h-48 bg-outdoor-olive-200/20 rounded-full blur-3xl animate-pulse-slow"></div>
    <div class="absolute bottom-32 left-16 w-36 h-36 bg-outdoor-earth-200/15 rounded-full blur-2xl animate-float-slow"></div>
    <div class="absolute top-1/3 left-1/2 w-28 h-28 bg-outdoor-ochre-200/10 rounded-full blur-xl animate-float"></div>
  </div>
  
  <!-- Organic pattern overlay -->
  <div class="absolute inset-0 opacity-5 bg-[url('data:image/svg+xml,%3Csvg width="80" height="80" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23606c38" fill-opacity="0.3"%3E%3Cpath d="M40 0c22.091 0 40 17.909 40 40s-17.909 40-40 40S0 62.091 0 40 17.909 0 40 0zm0 20c11.046 0 20 8.954 20 20s-8.954 20-20 20-20-8.954-20-20 8.954-20 20-20z"/%3E%3C/g%3E%3C/svg%3E')]"></div>
  
  <!-- Refined Decorative Elements -->
  <div class="absolute top-20 right-16 text-4xl opacity-15 animate-sway">🏔️</div>
  <div class="absolute bottom-32 left-16 text-3xl opacity-15 animate-gentle-bounce">🌲</div>
  <div class="absolute top-2/3 right-1/4 text-2xl opacity-10 animate-sway" style="animation-delay: 1s">🍃</div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
      
      <!-- Image Section -->
      <div class="order-2 lg:order-1" data-aos="fade-right" data-aos-duration="800">
        <div class="relative">
          <!-- Decorative Background -->
          <div class="absolute inset-0 bg-outdoor-sunset rounded-4xl transform rotate-3 shadow-outdoor-2xl"></div>
          <div class="absolute inset-0 bg-outdoor-forest rounded-4xl transform -rotate-1 shadow-outdoor-xl opacity-20"></div>
          
          <!-- Main Image Container -->
          <div class="relative bg-white p-6 rounded-4xl shadow-outdoor-xl">
            @php
              $imagePath = \App\Models\HomeContent::getValue('about_image', 'content', 'frontend/assets/images/img_cerfaos/vertical_rouge.png');
            @endphp
            <img 
              src="{{ asset($imagePath) }}" 
              alt="Équipe Cerfaos en montagne"
              class="w-full h-auto rounded-3xl"
            />
            
          
            
            <!-- Floating Certification Badges -->
            <div class="absolute -top-4 -right-4 bg-white rounded-2xl p-3 shadow-xl border border-outdoor-olive-100 transform rotate-6 hover:rotate-3 transition-transform duration-300">
              <div class="text-center">
                <span class="text-2xl">🏔️</span>
                <div class="text-xs font-bold text-outdoor-forest-600 mt-1">15 Ans</div>
                <div class="text-xs text-outdoor-forest-400">Expérience</div>
              </div>
            </div>
            
            <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-3 shadow-xl border border-outdoor-earth-100 transform -rotate-6 hover:-rotate-3 transition-transform duration-300">
              <div class="text-center">
                <span class="text-2xl">🚴‍♂️</span>
                <div class="text-xs font-bold text-outdoor-forest-600 mt-1">Gravel</div>
                <div class="text-xs text-outdoor-forest-400">Spécialiste</div>
              </div>
            </div>
          
          </div>
        </div>
      </div>
      
      <!-- Content Section -->
      <div class="order-1 lg:order-2 space-y-8" data-aos="fade-left" data-aos-duration="800">
        
        <!-- Badge -->
        <div class="inline-flex items-center space-x-2 bg-outdoor-olive-100 text-outdoor-olive-700 px-4 py-2 rounded-full text-sm font-medium">
          <span class="text-lg">🌿</span>
          <span>À propos de Cerfaos</span>
        </div>

        <!-- Title -->
        <h2 class="text-4xl md:text-5xl font-display font-bold text-outdoor-forest-600 leading-tight">
          {!! \App\Models\HomeContent::getValue('about_title', 'content', 'Votre partenaire pour des <span class="text-outdoor-olive-500">aventures authentiques</span>') !!}
        </h2>
        
        <!-- Description -->
        <p class="text-xl text-outdoor-forest-400 leading-relaxed">
          {{ \App\Models\HomeContent::getValue('about_subtitle', 'content', 'J\'organise une balade en vélo gravel et ce serait top que tu m\'accompagnes. Pas besoin d\'être un pro, l\'idée est surtout de profiter, découvrir et partager un bon moment.') }}
        </p>

        <!-- Feature List -->
        <div class="space-y-6 mt-8">
          
          <!-- Experience -->
          <div class="group hover:bg-white/50 rounded-2xl p-4 -m-4 hover:shadow-lg transition-all duration-300" data-aos="fade-up" data-aos-duration="600">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-12 h-12 bg-outdoor-olive-100 rounded-2xl flex items-center justify-center group-hover:bg-outdoor-olive-200 group-hover:scale-110 transition-all duration-300">
                <span class="text-2xl">{{ \App\Models\HomeContent::getValue('about_feature_1_icon', 'content', '🚴‍♂️') }}</span>
              </div>
              <div>
                <h4 class="font-display font-semibold text-lg text-outdoor-forest-600 mb-2">
                  {{ \App\Models\HomeContent::getValue('about_feature_1_title', 'content', 'Une balade sans chrono') }}
                </h4>
                <p class="text-outdoor-forest-400">
                  {{ \App\Models\HomeContent::getValue('about_feature_1_description', 'content', 'Pas de compétition, pas de pression : juste le plaisir de rouler ensemble au rythme qui nous convient. Respirer, pédaler, savourer.') }}
                </p>
              </div>
            </div>
          </div>

          <!-- Personalization -->
          <div class="group hover:bg-white/50 rounded-2xl p-4 -m-4 hover:shadow-lg transition-all duration-300" data-aos="fade-up" data-aos-duration="700">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-12 h-12 bg-outdoor-earth-100 rounded-2xl flex items-center justify-center group-hover:bg-outdoor-earth-200 group-hover:scale-110 transition-all duration-300">
                <span class="text-2xl">{{ \App\Models\HomeContent::getValue('about_feature_2_icon', 'content', '🌿') }}</span>
              </div>
              <div>
                <h4 class="font-display font-semibold text-lg text-outdoor-forest-600 mb-2">
                  {{ \App\Models\HomeContent::getValue('about_feature_2_title', 'content', 'Des chemins à découvrir') }}
                </h4>
                <p class="text-outdoor-forest-400">
                  {{ \App\Models\HomeContent::getValue('about_feature_2_description', 'content', 'Le gravel, c\'est l\'aventure simple et accessible. Entre petites routes, sentiers forestiers et paysages ouverts, chaque sortie est une surprise et une nouvelle trace à écrire.') }}
                </p>
              </div>
            </div>
          </div>

          <!-- Respect for Nature -->
          <div class="group" data-aos="fade-up" data-aos-duration="800">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-12 h-12 bg-outdoor-ochre-100 rounded-2xl flex items-center justify-center group-hover:bg-outdoor-ochre-200 transition-colors">
                <span class="text-2xl">{{ \App\Models\HomeContent::getValue('about_feature_3_icon', 'content', '🤝') }}</span>
              </div>
              <div>
                <h4 class="font-display font-semibold text-lg text-outdoor-forest-600 mb-2">
                  {{ \App\Models\HomeContent::getValue('about_feature_3_title', 'content', 'Un moment à partager') }}
                </h4>
                <p class="text-outdoor-forest-400">
                  {{ \App\Models\HomeContent::getValue('about_feature_3_description', 'content', 'Le vélo, c\'est mieux à plusieurs. Entre discussions, pauses café et éclats de rire, la balade devient une vraie aventure amicale.') }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- CTA -->
        <div class="flex flex-col sm:flex-row gap-4 pt-6" data-aos="fade-up" data-aos-delay="200">
          <a href="{{ route('contact.index') }}" class="btn-primary">
            📞 Contactez-moi
          </a>
         
        </div>
      </div>
    </div>
  </div>
</section>