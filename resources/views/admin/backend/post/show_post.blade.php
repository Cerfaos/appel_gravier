@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">👁️</span>
      <div>
        <h1>Détails de l'Article</h1>
        <p>{{ Str::limit($post->post_title, 80) }}</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('edit.blog.post', $post->id) }}" class="btn btn-primary u-flex u-items-center u-gap-2">
        <i data-feather="edit" style="width: 16px; height: 16px;"></i>
        Modifier
      </a>
      <a href="{{ route('all.blog.post') }}" class="btn btn-secondary u-flex u-items-center u-gap-2">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        Retour
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <a href="{{ route('all.blog.post') }}" class="breadcrumb__link">Articles</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">{{ Str::limit($post->post_title, 30) }}</span>
  </div>

  <div class="u-grid" style="grid-template-columns: 2fr 1fr; gap: var(--cerfaos-space-8);">
    
    <!-- Contenu principal -->
    <div>
      
      <!-- Image de l'article -->
      @if($post->image)
      <div class="card" style="margin-bottom: var(--cerfaos-space-6);">
        <div class="card__content" style="padding: 0;">
          <img src="{{ asset($post->image) }}" 
            alt="{{ $post->post_title }}" 
            style="width: 100%; height: 300px; object-fit: cover; border-radius: var(--cerfaos-radius-md);">
        </div>
      </div>
      @endif

      <!-- Contenu de l'article -->
      <div class="card">
        <div class="card__header">
          <h2 class="card__title">
            <i data-feather="file-text"></i>
            Contenu de l'article
          </h2>
        </div>
        <div class="card__content">
          <div class="article-content">
            {!! $post->long_descp !!}
          </div>
        </div>
      </div>

    </div>

    <!-- Sidebar avec informations -->
    <div>
      
      <!-- Informations générales -->
      <div class="card" style="margin-bottom: var(--cerfaos-space-6);">
        <div class="card__header">
          <h3 class="card__title u-flex u-items-center u-gap-2">
            <span>📋</span>
            Informations Générales
          </h3>
        </div>
        <div class="card__content u-space-y-4">
          <div>
            <div class="u-text-sm u-text-muted u-mb-1">Titre:</div>
            <div class="u-font-medium">{{ $post->post_title }}</div>
          </div>
          <div>
            <div class="u-text-sm u-text-muted u-mb-1">Slug:</div>
            <div class="u-text-sm" style="font-family: monospace; background: var(--cerfaos-bg-subtle); padding: var(--cerfaos-space-2); border-radius: var(--cerfaos-radius-sm); word-break: break-all;">{{ $post->post_slug }}</div>
          </div>
          <div>
            <div class="u-text-sm u-text-muted u-mb-1">Catégorie:</div>
            @if($post->blogCategory)
            <span class="badge badge--primary">{{ $post->blogCategory->category_name }}</span>
            @else
            <span class="badge badge--muted">Aucune catégorie</span>
            @endif
          </div>
          @if($post->short_description)
          <div>
            <div class="u-text-sm u-text-muted u-mb-1">Description courte:</div>
            <div class="u-text-sm">{{ $post->short_description }}</div>
          </div>
          @endif
        </div>
      </div>

      <!-- Dates -->
      <div class="card" style="margin-bottom: var(--cerfaos-space-6);">
        <div class="card__header">
          <h3 class="card__title u-flex u-items-center u-gap-2">
            <span>📅</span>
            Dates
          </h3>
        </div>
        <div class="card__content u-space-y-3">
          <div class="u-flex u-justify-between u-items-center">
            <span class="u-text-sm u-text-muted">Créé le:</span>
            <span class="badge badge--secondary">{{ $post->created_at->format('d/m/Y à H:i') }}</span>
          </div>
          <div class="u-flex u-justify-between u-items-center">
            <span class="u-text-sm u-text-muted">Modifié le:</span>
            <span class="badge badge--info">{{ $post->updated_at->format('d/m/Y à H:i') }}</span>
          </div>
          <div class="u-flex u-justify-between u-items-center">
            <span class="u-text-sm u-text-muted">Il y a:</span>
            <span class="u-text-sm">{{ $post->created_at->diffForHumans() }}</span>
          </div>
        </div>
      </div>

      <!-- Actions rapides -->
      <div class="card">
        <div class="card__header">
          <h3 class="card__title u-flex u-items-center u-gap-2">
            <span>⚡</span>
            Actions rapides
          </h3>
        </div>
        <div class="card__content u-space-y-3">
          <a href="{{ route('edit.blog.post', $post->id) }}" class="btn btn-primary btn--block u-flex u-items-center u-justify-center u-gap-2">
            <i data-feather="edit" style="width: 16px; height: 16px;"></i>
            Modifier cet article
          </a>
          @if($post->blogCategory)
          <a href="{{ url('/show/blog/category/' . $post->blogCategory->id) }}" class="btn btn-secondary btn--block u-flex u-items-center u-justify-center u-gap-2">
            <i data-feather="folder" style="width: 16px; height: 16px;"></i>
            Voir la catégorie
          </a>
          @endif
          <a href="{{ route('add.blog.post') }}" class="btn btn-outline btn--block u-flex u-items-center u-justify-center u-gap-2">
            <i data-feather="plus" style="width: 16px; height: 16px;"></i>
            Nouvel article
          </a>
        </div>
      </div>

    </div>
  </div>

</div>

<style>
.article-content {
  font-size: var(--cerfaos-font-size-base) !important;
  line-height: 1.7 !important;
  color: var(--cerfaos-text-primary) !important;
}

.article-content p {
  margin-bottom: var(--cerfaos-space-4) !important;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
  color: var(--cerfaos-text-primary) !important;
  font-weight: 600 !important;
  margin-top: var(--cerfaos-space-6) !important;
  margin-bottom: var(--cerfaos-space-3) !important;
}

.article-content img {
  max-width: 100% !important;
  height: auto !important;
  border-radius: var(--cerfaos-radius-md) !important;
  margin: var(--cerfaos-space-4) 0 !important;
}

.article-content ul,
.article-content ol {
  margin-bottom: var(--cerfaos-space-4) !important;
  padding-left: var(--cerfaos-space-6) !important;
}

.article-content li {
  margin-bottom: var(--cerfaos-space-2) !important;
}

.article-content blockquote {
  border-left: 4px solid var(--cerfaos-accent) !important;
  padding-left: var(--cerfaos-space-4) !important;
  margin: var(--cerfaos-space-4) 0 !important;
  font-style: italic !important;
  color: var(--cerfaos-text-muted) !important;
}

.article-content code {
  background: var(--cerfaos-bg-subtle) !important;
  padding: var(--cerfaos-space-1) var(--cerfaos-space-2) !important;
  border-radius: var(--cerfaos-radius-sm) !important;
  font-family: monospace !important;
  font-size: 0.9em !important;
}

.article-content pre {
  background: var(--cerfaos-bg-subtle) !important;
  padding: var(--cerfaos-space-4) !important;
  border-radius: var(--cerfaos-radius-md) !important;
  overflow-x: auto !important;
  margin: var(--cerfaos-space-4) 0 !important;
}

.article-content table {
  width: 100% !important;
  border-collapse: collapse !important;
  margin: var(--cerfaos-space-4) 0 !important;
}

.article-content table th,
.article-content table td {
  padding: var(--cerfaos-space-3) !important;
  border: 1px solid var(--cerfaos-border) !important;
  text-align: left !important;
}

.article-content table th {
  background: var(--cerfaos-bg-subtle) !important;
  font-weight: 600 !important;
}
</style>

@endsection