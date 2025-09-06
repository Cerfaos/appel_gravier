@extends('home.body.home_master')
@section('home')

<!-- Hero Section - Style Post Detail -->
<div class="article-hero">
  <div class="article-hero-content">
    
    <!-- Breadcrumb -->
    
    
    <!-- Titre -->
    <h1 class="article-hero-title">
      Chroniques d’un mollet timide
    </h1>
    
    <!-- Description -->
    <div class="article-hero-meta">
      <span>guide non-officiel du gravel sans watt mais avec répartie. <br>
        Chemins blancs, souffle court, ego en PLS, GPS qui me juge comme un coroner<br>
         (“heure du décès : début de la côte”).<br>
        Mes cuisses ont déposé un préavis de grève, pourtant on avance… à la vitesse d’un économiseur d’écran. <br>
        Pressions approximatives, braquets doudou, café obligatoire. <br>
        Je collectionne les petites victoires, les grandes excuses et quelques funérailles de KOM. <br>
        Pro tip : une sieste bat un cadre aéro neuf, neuf fois sur dix — surtout avec des chaussettes propres. Vos astuces ? Balancez.<br>
      </span>
    </div>
    
  </div>
</div>

<!-- Contenu Principal -->
<div class="article-main">
  <div class="article-container">
    
    <!-- Layout avec Grid -->
    <div class="article-grid">
      
      
      <!-- Articles Grid (Col principale) -->
      <div class="fp-blog-articles">
        @if($posts && $posts->count() > 0)
          <div class="fp-blog-grid">
            @foreach($posts as $post)
              <article class="fp-blog-card">
                
                <!-- Image -->
                <div class="fp-blog-card-image-container">
                  @if($post->image)
                    <img src="{{ asset($post->image) }}" alt="{{ $post->post_title }}" class="fp-blog-card-image">
                  @else
                    <div class="fp-blog-card-image fp-blog-card-no-image">
                      <span>📝</span>
                    </div>
                  @endif
                </div>

                <!-- Content -->
                <div class="fp-blog-card-content">
                  
                  <!-- Category -->
                  @if($post->blogCategory)
                    <div class="fp-blog-card-category">
                      {{ $post->blogCategory->category_name }}
                    </div>
                  @endif

                  <!-- Title -->
                  <h2 class="fp-blog-card-title">
                    {{ $post->post_title }}
                  </h2>

                  <!-- Excerpt -->
                  <div class="fp-blog-card-excerpt">
                    @if($post->short_description)
                      {{ $post->short_description }}
                    @else
                      {{ Str::limit(strip_tags($post->long_descp), 150) }}
                    @endif
                  </div>

                  <!-- Meta -->
                  <div class="fp-blog-card-meta">
                    <div class="fp-blog-card-date">
                      <span>📅</span>
                      <span>{{ $post->created_at->format('d/m/Y') }}</span>
                    </div>
                    
                    @php
                      $linkParam = !empty($post->post_slug) ? $post->post_slug : $post->id;
                    @endphp
                    <a href="{{ route('blog.details', $linkParam) }}" class="fp-blog-card-link">
                      <span>Lire l'article</span>
                      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                      </svg>
                    </a>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        @else
          <!-- Empty State -->
          <div class="fp-empty-state">
            <div class="fp-empty-state-icon">📝</div>
            <h3>Aucun article disponible</h3>
            <p>Les premiers récits d'aventures seront bientôt publiés !</p>
          </div>
        @endif
      </div>

      <!-- Sidebar -->
      <aside class="article-sidebar">
        <div class="sidebar-widget">
          <h3 class="sidebar-widget-title">
            🏷️ Catégories
          </h3>
        
          @if($categories && $categories->count() > 0)
            @foreach($categories as $category)
              <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid rgba(96, 108, 56, 0.1);">
                <a href="#" style="color: var(--nature-stone); text-decoration: none; font-weight: 500; transition: color 0.3s ease;" onmouseover="this.style.color='var(--olive-primary)'" onmouseout="this.style.color='var(--nature-stone)'">
                  {{ $category->category_name }}
                </a>
                <span style="background: var(--olive-primary); color: white; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">
                  {{ \App\Models\BlogPost::where('blog_category_id', $category->id)->count() }}
                </span>
              </div>
            @endforeach
            <p style="color: var(--nature-stone); font-style: italic; margin-top: 1rem; font-size: 0.85rem; opacity: 0.7;">
              💡 Filtrage par catégorie bientôt disponible
            </p>
          @else
            <p style="color: var(--nature-stone); font-style: italic;">Aucune catégorie disponible</p>
          @endif
        </div>

        <!-- Search Section -->
        <div class="sidebar-widget">
          <h3 class="sidebar-widget-title">🔍 Rechercher</h3>
          <div style="margin-bottom: 1rem;">
            <input type="text" style="width: 100%; padding: 0.75rem; border: 1px solid rgba(96, 108, 56, 0.3); border-radius: 0.5rem; font-size: 0.95rem;" placeholder="Rechercher un article...">
          </div>
          <button style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, var(--olive-primary), var(--forest-primary)); color: white; padding: 0.75rem 1.5rem; border-radius: 50px; text-decoration: none; font-weight: 600; border: none; cursor: pointer; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <span>🔍</span>
            <span>Rechercher</span>
          </button>
        </div>

      </aside>
    </div>
  </div>
</div>

<style>
/* Variables CSS - Forest Premium Theme (Authentique Cerfaos) */
:root {
  /* Palette Forest Premium Official */
  --olive-primary: #606c38;
  --olive-light: #a8b884;
  --olive-lightest: #f7f8f3;
  --forest-primary: #283618;
  --forest-light: #93a080;
  --forest-lightest: #f4f5f2;
  --cream-primary: #fefae0;
  --cream-secondary: #fdf6c8;
  --cream-accent: #f8e271;
  --ochre-primary: #dda15e;
  --ochre-light: #ecc29e;
  --ochre-lightest: #fdf8f3;
  --earth-primary: #bc6c25;
  --earth-light: #ecb894;
  --earth-lightest: #fdf6f0;
  --nature-stone: #8d8680;
  --nature-mist: #e8edf2;
}

/* Hero Section - Forest Premium Theme */
.article-hero {
  background: linear-gradient(135deg, var(--forest-primary) 0%, var(--olive-primary) 100%);
  min-height: 40vh;
  display: flex;
  align-items: center;
  position: relative;
  overflow: hidden;
}

.article-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('{{ asset('frontend/assets/images/img_cerfaos/bandeau_blog.png') }}');
  background-size: cover;
  background-position: center;
  opacity: 0.15;
  z-index: 1;
}

.article-hero-content {
  position: relative;
  z-index: 2;
  text-align: center;
  color: white;
  max-width: 900px;
  margin: 0 auto;
  padding: 3rem 2rem;
}

.article-breadcrumb {
  margin-bottom: 2rem;
  font-size: 0.95rem;
  opacity: 0.9;
}

.article-breadcrumb a {
  color: white;
  text-decoration: none;
  transition: opacity 0.3s ease;
}

.article-breadcrumb a:hover {
  opacity: 1;
}

.article-hero-title {
  font-size: clamp(2rem, 6vw, 3.5rem);
  font-weight: 700;
  line-height: 1.2;
  margin-bottom: 1.5rem;
  background: linear-gradient(135deg, #ffffff 0%, var(--cream-accent) 100%);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.article-hero-meta {
  display: flex;
  justify-content: center;
  gap: 2rem;
  flex-wrap: wrap;
  margin-bottom: 1rem;
  font-size: 0.95rem;
  opacity: 0.9;
}

.article-hero-meta span {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Main Content - Forest Premium */
.article-main {
  background: linear-gradient(to bottom, var(--cream-primary) 0%, #ffffff 50%, var(--cream-secondary) 100%);
  padding: 4rem 0;
}

.article-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
}

.article-grid {
  display: grid;
  grid-template-columns: 1fr 350px;
  gap: 4rem;
  align-items: start;
}

/* Sidebar - Forest Premium */
.article-sidebar {
  position: sticky;
  top: 2rem;
}

.sidebar-widget {
  background: white;
  border-radius: 1rem;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 4px 15px rgba(40, 54, 24, 0.08);
  border: 1px solid rgba(96, 108, 56, 0.1);
  transition: all 0.3s ease;
}

.sidebar-widget:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(40, 54, 24, 0.12);
}

.sidebar-widget-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--forest-primary);
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Responsive */
@media (max-width: 1024px) {
  .article-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  .article-sidebar {
    position: static;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
  }
}

/* Articles Section */
.fp-blog-articles {
  background: white;
  border-radius: 1.5rem;
  padding: 3rem;
  box-shadow: 0 8px 25px rgba(40, 54, 24, 0.08);
  border: 1px solid rgba(96, 108, 56, 0.1);
}

/* Grille d'Articles */
.fp-blog-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 2rem;
  margin-bottom: 2rem;
}

/* Cartes d'Articles - Style Post Detail */
.fp-blog-card {
  background: var(--forest-lightest);
  border-radius: 1rem;
  padding: 1.5rem;
  text-decoration: none;
  color: inherit;
  transition: all 0.3s ease;
  border: 1px solid rgba(96, 108, 56, 0.1);
  position: relative;
}

.fp-blog-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--olive-primary), var(--ochre-primary));
  opacity: 0;
  transition: opacity 0.3s ease;
  border-radius: 1rem 1rem 0 0;
}

.fp-blog-card:hover::before {
  opacity: 1;
}

.fp-blog-card:hover {
  background: var(--olive-lightest);
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(40, 54, 24, 0.1);
}

.fp-blog-card-image-container {
  position: relative;
  overflow: hidden;
  border-radius: 0.5rem;
  margin-bottom: 1rem;
}

.fp-blog-card-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.fp-blog-card-no-image {
  background: linear-gradient(135deg, var(--ochre-lightest) 0%, var(--ochre-light) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  opacity: 0.6;
  height: 200px;
}

.fp-blog-card:hover .fp-blog-card-image {
  transform: scale(1.05);
}

.fp-blog-card-content {
  /* No specific padding needed as parent has it */
}

.fp-blog-card-category {
  display: inline-block;
  background: var(--olive-primary);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 1rem;
  transition: all 0.3s ease;
}

.fp-blog-card-category:hover {
  background: var(--forest-primary);
  transform: translateY(-2px);
}

.fp-blog-card-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--forest-primary);
  margin-bottom: 0.75rem;
  line-height: 1.3;
  transition: color 0.3s ease;
}

.fp-blog-card:hover .fp-blog-card-title {
  color: var(--olive-primary);
}

.fp-blog-card-excerpt {
  color: var(--nature-stone);
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
}

.fp-blog-card-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 1rem;
  border-top: 1px solid rgba(96, 108, 56, 0.1);
  font-size: 0.9rem;
  color: var(--nature-stone);
}

.fp-blog-card-date {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.fp-blog-card-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--ochre-primary);
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  font-size: 0.9rem;
}

.fp-blog-card-link:hover {
  color: var(--olive-primary);
  transform: translateX(3px);
}

.fp-blog-card-link svg {
  transition: transform 0.3s ease;
}

.fp-blog-card-link:hover svg {
  transform: translateX(3px);
}

/* Empty State - Style Post Detail */
.fp-empty-state {
  text-align: center;
  padding: 4rem 2rem;
  color: var(--nature-stone);
}

.fp-empty-state-icon {
  font-size: 4rem;
  margin-bottom: 2rem;
  opacity: 0.3;
}

.fp-empty-state h3 {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
  color: var(--forest-primary);
}

.fp-empty-state p {
  font-size: 1.1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .article-hero-content {
    padding: 2rem 1rem;
  }
  
  .article-container {
    padding: 0 1rem;
  }
  
  .article-hero-meta {
    flex-direction: column;
    gap: 1rem;
  }
  
  .fp-blog-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  
  .fp-blog-articles {
    padding: 2rem 1.5rem;
  }
}

@media (max-width: 576px) {
  .article-hero-content {
    padding: 1.5rem 1rem;
  }
  
  .fp-blog-articles {
    padding: 1.5rem 1rem;
  }
}
</style>

@endsection