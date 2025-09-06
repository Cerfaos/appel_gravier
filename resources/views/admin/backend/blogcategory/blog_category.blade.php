@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">🏷️</span>
      <div>
        <h1>Gestion des Catégories</h1>
        <p>Organiser et classer vos contenus blog</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('add.blog.category') }}" class="btn btn-primary u-flex u-items-center u-gap-2">
        <i data-feather="plus" style="width: 16px; height: 16px;"></i>
        Nouvelle Catégorie
      </a>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom: var(--cerfaos-space-6);">
    <a href="{{ route('dashboard') }}" class="breadcrumb__link">Dashboard</a>
    <span class="breadcrumb__separator">›</span>
    <span class="breadcrumb__current">Catégories</span>
  </div>

  <!-- Stats Overview -->
  <div class="grid grid-cols-4" style="margin-bottom: var(--cerfaos-space-8); gap: var(--cerfaos-space-6);">
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">🏷️</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-text-primary);">{{ $category->count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Catégories</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">📄</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-text-primary);">{{ \App\Models\BlogPost::count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Articles total</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">📈</div>
        <div>
          @php
            $averagePostsPerCategory = $category->count() > 0 ? round(\App\Models\BlogPost::count() / $category->count(), 1) : 0;
          @endphp
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-success);">{{ $averagePostsPerCategory }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Moy. par catégorie</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">⭐</div>
        <div>
          @php
            $topCategory = $category->map(function($cat) {
              return \App\Models\BlogPost::where('blog_category_id', $cat->id)->count();
            })->max();
          @endphp
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-warning);">{{ $topCategory ?? 0 }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Plus populaire</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Categories List -->
  <div class="card">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="list"></i>
        Liste des Catégories
      </h2>
    </div>
    <div class="card__content" style="padding: 0;">
      @if($category->count() > 0)
        <div style="overflow-x: auto;">
          <table class="table">
            <thead>
              <tr>
                <th>Catégorie</th>
                <th>Slug</th>
                <th>Articles</th>
                <th>Date création</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($category as $item)
              <tr>
                <td>
                  <div class="u-flex u-items-center u-gap-3">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--cerfaos-accent), var(--cerfaos-accent-hover)); border-radius: var(--cerfaos-radius-lg); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: var(--cerfaos-font-size-sm);">
                      {{ strtoupper(substr($item->category_name, 0, 2)) }}
                    </div>
                    <div>
                      <h6>{{ $item->category_name }}</h6>
                      <small class="u-text-muted">Catégorie blog</small>
                    </div>
                  </div>
                </td>
                <td>
                  <div style="font-family: monospace; background: var(--cerfaos-bg-subtle); padding: var(--cerfaos-space-2); border-radius: var(--cerfaos-radius-sm); font-size: var(--cerfaos-font-size-sm); color: var(--cerfaos-text-secondary);">
                    {{ $item->category_slug }}
                  </div>
                </td>
                <td>
                  @php
                    $articleCount = \App\Models\BlogPost::where('blog_category_id', $item->id)->count();
                  @endphp
                  @if($articleCount > 0)
                    <span class="badge badge--success">{{ $articleCount }} article{{ $articleCount > 1 ? 's' : '' }}</span>
                  @else
                    <span class="badge badge--muted">Aucun article</span>
                  @endif
                </td>
                <td>
                  <div class="u-flex u-flex-col">
                    <small>{{ $item->created_at->format('d/m/Y') }}</small>
                    <small class="u-text-muted">{{ $item->created_at->diffForHumans() }}</small>
                  </div>
                </td>
                <td>
                  <div class="u-flex u-gap-2">
                    <a href="{{ url('/show/blog/category/' . $item->id) }}" 
                       class="btn btn-sm btn-secondary"
                       title="Voir détails">
                      <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                    </a>
                    <a href="{{ route('edit.blog.category', $item->id) }}" 
                       class="btn btn-sm btn-secondary"
                       title="Modifier">
                      <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                    </a>
                    <a href="{{ route('delete.blog.category', $item->id) }}" 
                       class="btn btn-sm btn-danger"
                       title="Supprimer"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible et supprimera tous les articles associés.')">
                      <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                    </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div style="padding: var(--cerfaos-space-12); text-align: center;">
          <div style="font-size: 4rem; margin-bottom: var(--cerfaos-space-4);">🏷️</div>
          <h5 style="color: var(--cerfaos-text-primary); margin-bottom: var(--cerfaos-space-2);">Aucune catégorie trouvée</h5>
          <p class="u-text-muted" style="margin-bottom: var(--cerfaos-space-6);">Commencez par ajouter votre première catégorie pour organiser vos articles.</p>
          <a href="{{ route('add.blog.category') }}" class="btn btn-primary u-flex u-items-center u-gap-2" style="display: inline-flex;">
            <i data-feather="plus" style="width: 16px; height: 16px;"></i> 
            Ajouter une Catégorie
          </a>
        </div>
      @endif
    </div>
  </div>

</div>
@endsection