@extends('home.body.home_master')
@section('home')

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

.article-content {
  background: white;
  border-radius: 1.5rem;
  padding: 3rem;
  box-shadow: 0 8px 25px rgba(40, 54, 24, 0.08);
  border: 1px solid rgba(96, 108, 56, 0.1);
}

.article-content img {
  max-width: 100%;
  height: auto;
  border-radius: 1rem;
  margin: 2rem 0;
  box-shadow: 0 4px 15px rgba(40, 54, 24, 0.1);
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
  color: var(--forest-primary);
  margin: 2rem 0 1rem 0;
  line-height: 1.3;
}

.article-content h2 {
  font-size: 1.75rem;
  font-weight: 700;
  border-bottom: 2px solid var(--olive-primary);
  padding-bottom: 0.5rem;
}

.article-content h3 {
  font-size: 1.5rem;
  font-weight: 600;
}

.article-content p {
  color: var(--nature-stone);
  line-height: 1.8;
  margin-bottom: 1.5rem;
  font-size: 1.1rem;
}

.article-content ul,
.article-content ol {
  color: var(--nature-stone);
  line-height: 1.7;
  margin-bottom: 1.5rem;
  padding-left: 2rem;
}

.article-content li {
  margin-bottom: 0.5rem;
}

.article-content blockquote {
  background: var(--forest-lightest);
  border-left: 4px solid var(--olive-primary);
  padding: 1.5rem;
  margin: 2rem 0;
  border-radius: 0.5rem;
  font-style: italic;
  color: var(--forest-primary);
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

.category-badge {
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

.category-badge:hover {
  background: var(--forest-primary);
  transform: translateY(-2px);
}

.recent-post-item {
  display: flex;
  gap: 1rem;
  padding: 0.75rem;
  background: var(--forest-lightest);
  border-radius: 0.75rem;
  margin-bottom: 1rem;
  text-decoration: none;
  color: inherit;
  transition: all 0.3s ease;
}

.recent-post-item:hover {
  background: var(--olive-lightest);
  transform: translateX(4px);
}

.recent-post-thumb {
  width: 60px;
  height: 45px;
  border-radius: 0.5rem;
  overflow: hidden;
  background: var(--nature-mist);
  flex-shrink: 0;
}

.recent-post-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.recent-post-content h4 {
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--forest-primary);
  margin: 0 0 0.25rem 0;
  line-height: 1.3;
}

.recent-post-date {
  font-size: 0.75rem;
  color: var(--nature-stone);
}

/* Share Buttons */
.share-buttons {
  display: flex;
  gap: 1rem;
  margin: 2rem 0;
  padding: 1.5rem;
  background: var(--forest-lightest);
  border-radius: 1rem;
  border: 1px solid rgba(96, 108, 56, 0.1);
}

.share-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  text-decoration: none;
  color: white;
  transition: all 0.3s ease;
}

.share-btn:hover {
  transform: translateY(-2px);
}

.share-facebook { background: #1877f2; }
.share-twitter { background: #1da1f2; }
.share-linkedin { background: #0a66c2; }
.share-whatsapp { background: #25d366; }

/* Navigation entre articles */
.article-navigation {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2rem;
  margin-top: 3rem;
  padding-top: 2rem;
  border-top: 1px solid rgba(96, 108, 56, 0.1);
}

.nav-article {
  background: var(--forest-lightest);
  padding: 1.5rem;
  border-radius: 1rem;
  text-decoration: none;
  color: inherit;
  transition: all 0.3s ease;
  border: 1px solid rgba(96, 108, 56, 0.1);
}

.nav-article:hover {
  background: var(--olive-lightest);
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(40, 54, 24, 0.1);
}

.nav-article-label {
  font-size: 0.8rem;
  color: var(--nature-stone);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 0.5rem;
}

.nav-article-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--forest-primary);
  line-height: 1.3;
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

@media (max-width: 768px) {
  .article-content {
    padding: 2rem 1.5rem;
  }
  
  .article-container {
    padding: 0 1rem;
  }
  
  .article-hero-meta {
    flex-direction: column;
    gap: 1rem;
  }
  
  .article-navigation {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
}

@media (max-width: 576px) {
  .article-hero-content {
    padding: 2rem 1rem;
  }
  
  .article-content {
    padding: 1.5rem 1rem;
  }
}
</style>

@if($blog)
<!-- Hero Section -->
<div class="article-hero">
  <div class="article-hero-content">
    
    <!-- Breadcrumb -->
    <nav class="article-breadcrumb">
      <a href="{{ route('home') }}">🌿 Accueil</a>
      <span> / </span>
      <a href="{{ route('blog.page') }}">📝 Blog</a>
      <span> / </span>
      <span>{{ Str::limit($blog->post_title, 30) }}</span>
    </nav>
    
    <!-- Titre -->
    <h1 class="article-hero-title">
      {{ $blog->post_title }}
    </h1>
    
    <!-- Métadonnées -->
    <div class="article-hero-meta">
      @if($blog->blogCategory)
        <span>🏷️ {{ $blog->blogCategory->category_name }}</span>
      @endif
      <span>📅 {{ $blog->created_at->format('d M Y') }}</span>
      <span>⏱️ {{ $blog->created_at->diffForHumans() }}</span>
      <span>👁️ {{ rand(150, 500) }} vues</span>
    </div>
    
  </div>
</div>

<!-- Contenu Principal -->
<div class="article-main">
  <div class="article-container">
    <div class="article-grid">
      
      <!-- Article -->
      <article class="article-content">
        
        <!-- Image principale -->
        @if($blog->image)
          <img src="{{ asset($blog->image) }}" alt="{{ $blog->post_title }}" style="width: 100%; height: 400px; object-fit: cover; border-radius: 1rem; margin-bottom: 2rem;">
        @endif
        
        <!-- Catégorie -->
        @if($blog->blogCategory)
          <div style="margin-bottom: 2rem;">
            <span class="category-badge">
              🏷️ {{ $blog->blogCategory->category_name }}
            </span>
          </div>
        @endif
        
        <!-- Contenu de l'article -->
        <div style="font-size: 1.1rem; line-height: 1.8; color: var(--nature-stone);">
          {!! $blog->long_descp !!}
        </div>
        
        <!-- Partage -->
        <div class="share-buttons">
          <h4 style="color: var(--forest-primary); margin: 0; flex: 1;">📤 Partager cet article</h4>
          <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="share-btn share-facebook" target="_blank">📘</a>
          <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->post_title) }}" class="share-btn share-twitter" target="_blank">🐦</a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" class="share-btn share-linkedin" target="_blank">💼</a>
          <a href="https://wa.me/?text={{ urlencode($blog->post_title . ' - ' . url()->current()) }}" class="share-btn share-whatsapp" target="_blank">💬</a>
        </div>
        
      </article>
      
      <!-- Sidebar -->
      <aside class="article-sidebar">
        
        <!-- À propos de cet article -->
        <div class="sidebar-widget">
          <h3 class="sidebar-widget-title">
            ℹ️ À propos
          </h3>
          <p style="color: var(--nature-stone); font-size: 0.95rem; line-height: 1.6; margin: 0;">
            Article publié le {{ $blog->created_at->format('d/m/Y') }} dans la catégorie 
            @if($blog->blogCategory)
              <strong style="color: var(--olive-primary);">{{ $blog->blogCategory->category_name }}</strong>
            @else
              <strong>Non classé</strong>
            @endif
          </p>
        </div>

        <!-- Articles récents -->
        <div class="sidebar-widget">
          <h3 class="sidebar-widget-title">
            ⏰ Articles Récents
          </h3>
          @php
            $recentPosts = \App\Models\BlogPost::where('id', '!=', $blog->id)
                                               ->latest()
                                               ->take(4)
                                               ->get();
          @endphp
          
          @if($recentPosts->count() > 0)
            @foreach($recentPosts as $recentPost)
              @php
                $linkParam = !empty($recentPost->post_slug) ? $recentPost->post_slug : $recentPost->id;
              @endphp
              <a href="{{ route('blog.details', $linkParam) }}" class="recent-post-item">
                <div class="recent-post-thumb">
                  @if($recentPost->image)
                    <img src="{{ asset($recentPost->image) }}" alt="{{ $recentPost->post_title }}">
                  @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">🏔️</div>
                  @endif
                </div>
                <div class="recent-post-content">
                  <h4>{{ Str::limit($recentPost->post_title, 40) }}</h4>
                  <div class="recent-post-date">📅 {{ $recentPost->created_at->format('d/m/Y') }}</div>
                </div>
              </a>
            @endforeach
          @else
            <p style="color: var(--nature-stone); font-style: italic;">Aucun autre article disponible</p>
          @endif
        </div>

        <!-- Catégories -->
        <div class="sidebar-widget">
          <h3 class="sidebar-widget-title">
            🏷️ Catégories
          </h3>
          @php
            $categories = \App\Models\BlogCategory::latest()->get();
          @endphp
          
          @if($categories->count() > 0)
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
          @else
            <p style="color: var(--nature-stone); font-style: italic;">Aucune catégorie disponible</p>
          @endif
        </div>

        <!-- Retour au blog -->
        <div class="sidebar-widget" style="text-align: center;">
          <a href="{{ route('blog.page') }}" style="display: inline-flex; align-items: center; gap: 0.75rem; background: linear-gradient(135deg, var(--olive-primary), var(--forest-primary)); color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(96, 108, 56, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            ← Retour au Blog
          </a>
        </div>

      </aside>
    </div>
  </div>
</div>

@else
<!-- État d'erreur -->
<div class="article-main">
  <div class="article-container">
    <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 1rem; box-shadow: 0 4px 15px rgba(40, 54, 24, 0.1);">
      <div style="font-size: 4rem; margin-bottom: 2rem;">❌</div>
      <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--forest-primary); margin-bottom: 1rem;">
        Article introuvable
      </h2>
      <p style="color: var(--nature-stone); margin-bottom: 2rem;">
        L'article que vous recherchez n'existe pas ou n'est plus disponible.
      </p>
      <a href="{{ route('blog.page') }}" style="display: inline-flex; align-items: center; gap: 0.75rem; background: linear-gradient(135deg, var(--olive-primary), var(--forest-primary)); color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
        ← Retour au Blog
      </a>
    </div>
  </div>
</div>
@endif

@endsection