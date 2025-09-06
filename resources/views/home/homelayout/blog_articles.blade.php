
<!-- Blog Articles Section -->
<section id="blog-articles" class="py-20 lg:py-32 relative overflow-hidden">
  
  <!-- Multi-layered Background -->
  <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-50/30 via-white to-outdoor-olive-50/40"></div>
  
  <!-- Dynamic background elements -->
  <div class="absolute inset-0">
    <div class="absolute top-10 right-10 w-44 h-44 bg-outdoor-ochre-200/15 rounded-full blur-3xl animate-pulse-slow"></div>
    <div class="absolute bottom-20 left-20 w-36 h-36 bg-outdoor-olive-200/20 rounded-full blur-2xl animate-float-slow"></div>
    <div class="absolute top-1/2 right-1/3 w-28 h-28 bg-outdoor-earth-200/10 rounded-full blur-xl animate-float-delayed"></div>
  </div>
  
  <!-- Content pattern overlay -->
  <div class="absolute inset-0 opacity-5 bg-[url('data:image/svg+xml,%3Csvg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23d2691e" fill-opacity="0.3"%3E%3Cpath d="M25 0L50 25L25 50L0 25z"/%3E%3C/g%3E%3C/svg%3E')]"></div>
  
  <!-- Themed Decorative Elements -->
  <div class="absolute top-10 right-10 text-6xl opacity-10 animate-sway">📝</div>
  <div class="absolute bottom-20 left-20 text-4xl opacity-10 animate-gentle-bounce">📖</div>
  <div class="absolute top-1/3 left-1/6 text-3xl opacity-8 animate-sway" style="animation-delay: 1.5s">✍️</div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Section Header -->
    <div class="text-center mb-16" data-aos="fade-up">
      <div class="inline-flex items-center space-x-2 bg-outdoor-ochre-100 text-outdoor-ochre-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
        <span class="text-lg">📝</span>
        <span>Blog</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-display font-bold text-outdoor-forest-600 mb-6">
        Derniers Articles
      </h2>
      <p class="text-xl text-outdoor-forest-400 max-w-3xl mx-auto">
        Découvrez nos derniers articles, conseils et récits d'aventures pour enrichir votre pratique outdoor
      </p>
    </div>

    <!-- Articles Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      @if(isset($latestBlogPosts) && $latestBlogPosts->count() > 0)
        @foreach($latestBlogPosts as $index => $article)
          <div class="card-outdoor group hover:scale-105 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 relative overflow-hidden" data-aos="fade-up" data-aos-duration="{{ 500 + ($index * 200) }}">
            <!-- Gradient overlay on hover -->
            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-ochre-500/5 to-outdoor-earth-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative">
            
            <!-- Article Image -->
            <div class="relative mb-6 overflow-hidden rounded-xl">
              @if($article->image)
                <img src="{{ asset($article->image) }}" 
                     alt="{{ $article->post_title }}" 
                     class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300"
                     loading="lazy">
              @else
                <div class="w-full h-48 bg-gradient-to-br from-outdoor-ochre-100 to-outdoor-ochre-200 flex items-center justify-center">
                  <span class="text-6xl text-outdoor-ochre-400">📝</span>
                </div>
              @endif
              
              <!-- Category Badge -->
              @if($article->blogCategory)
                <div class="absolute top-4 left-4 bg-outdoor-ochre-500/90 backdrop-blur-sm rounded-lg px-3 py-1 text-sm font-medium text-white">
                  {{ $article->blogCategory->category_name }}
                </div>
              @endif
            </div>

            <!-- Article Content -->
            <div class="space-y-4">
              
              <!-- Title -->
              <h3 class="text-xl font-bold text-outdoor-forest-600 group-hover:text-outdoor-ochre-600 transition-colors line-clamp-2">
                {{ $article->post_title }}
              </h3>
              
              <!-- Short Description -->
              <div class="text-outdoor-forest-400 text-sm line-clamp-3 leading-relaxed">
                @if($article->short_description)
                  {{ $article->short_description }}
                @else
                  {{ Str::limit(strip_tags($article->long_descp), 120) }}
                @endif
              </div>
              
              <!-- Meta Information -->
              <div class="flex items-center justify-between pt-4 border-t border-outdoor-cream-200">
                <div class="flex items-center space-x-2 text-outdoor-forest-400 text-sm">
                  <span>📅</span>
                  <span>{{ $article->created_at->format('d/m/Y') }}</span>
                </div>
                
                <div class="flex items-center space-x-2 text-outdoor-forest-400 text-sm">
                  <span>⏱️</span>
                  <span>{{ $article->created_at->diffForHumans() }}</span>
                </div>
              </div>
              
              <!-- Read More Button -->
              @php
                $linkParam = !empty($article->post_slug) ? $article->post_slug : $article->id;
              @endphp
              <div class="pt-4">
                <a href="{{ route('blog.details', $linkParam) }}" 
                   class="inline-flex items-center space-x-2 text-outdoor-ochre-600 hover:text-outdoor-ochre-700 font-medium text-sm group">
                  <span>Lire l'article</span>
                  <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </a>
              </div>
            </div>
            
            <!-- Action indicator appears on hover -->
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
              <div class="w-8 h-8 bg-outdoor-ochre-500 rounded-full flex items-center justify-center text-white shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </div>
            </div>
            
            </div>
          </div>
        @endforeach
      @else
        <!-- Empty State -->
        <div class="col-span-full text-center py-16">
          <div class="text-8xl text-outdoor-ochre-200 mb-6">📝</div>
          <h3 class="text-2xl font-bold text-outdoor-forest-400 mb-4">Aucun article disponible</h3>
          <p class="text-outdoor-forest-400">Les premiers articles seront bientôt publiés !</p>
        </div>
      @endif
    </div>

    <!-- See More Button -->
    @if(isset($latestBlogPosts) && $latestBlogPosts->count() > 0)
      <div class="text-center mt-12" data-aos="fade-up">
        <a href="{{ route('blog.page') }}" 
           class="inline-flex items-center space-x-2 bg-outdoor-ochre-500 hover:bg-outdoor-ochre-600 text-white px-8 py-4 rounded-full font-medium transition-all duration-300 hover:shadow-xl hover:scale-105">
          <span>Voir tous les articles</span>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
          </svg>
        </a>
      </div>
    @endif
  </div>
</section>