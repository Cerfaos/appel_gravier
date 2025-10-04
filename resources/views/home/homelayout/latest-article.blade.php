<!-- SECTION DERNIER ARTICLE - Pleine largeur avec image de fond -->
@if($latestBlogPosts && $latestBlogPosts->isNotEmpty())
@php
    $latestArticle = $latestBlogPosts->first();
@endphp
<section class="relative min-h-[60vh] md:min-h-[70vh] text-white overflow-hidden">
    <!-- Image de fond de l'article -->
    @if($latestArticle->post_image)
        <div class="absolute inset-0 w-full h-full bg-no-repeat will-change-transform"
             style="background-image: url('{{ asset($latestArticle->post_image) }}');
                    background-size: cover;
                    background-position: center center;
                    background-attachment: scroll;">
        </div>
    @endif

    <!-- Overlay gradient pour lisibilité -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>

    <!-- Contenu -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full min-h-[60vh] md:min-h-[70vh] flex items-center">
        <div class="max-w-2xl">
            <!-- Badge catégorie -->
            @if($latestArticle->blogCategory)
            <span class="inline-block px-4 py-2 bg-outdoor-olive-500/90 backdrop-blur-sm text-white rounded-full text-sm font-semibold mb-4">
                {{ $latestArticle->blogCategory->category_name }}
            </span>
            @endif

            <!-- Surtitre -->
            <p class="text-outdoor-sand-200 text-sm md:text-base uppercase tracking-wider mb-3">
                Dernier Article
            </p>

            <!-- Titre de l'article -->
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 text-white">
                {{ $latestArticle->post_title }}
            </h2>

            <!-- Description courte -->
            @if($latestArticle->short_description)
            <p class="text-lg md:text-xl text-white/90 mb-8 leading-relaxed">
                {{ Str::limit($latestArticle->short_description, 150) }}
            </p>
            @endif

            <!-- Métadonnées -->
            <div class="flex flex-wrap items-center gap-4 text-white/80 text-sm mb-8">
                @if($latestArticle->created_at)
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $latestArticle->created_at->format('d M Y') }}</span>
                </div>
                @endif
            </div>

            <!-- CTA Button -->
            <a href="{{ url('blog/details/'.$latestArticle->id) }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-white text-outdoor-forest-700 rounded-lg font-semibold shadow-xl hover:bg-outdoor-sand-100 hover:scale-105 transition-all duration-300 group">
                <span>Lire l'article</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif
