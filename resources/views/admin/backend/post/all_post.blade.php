@extends('admin.admin_master_outdoor')

@section('admin')

<div class="main__container">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="u-flex u-items-center u-gap-4">
      <span style="font-size: 2rem;">📰</span>
      <div>
        <h1>Gestion des Articles</h1>
        <p>Administrer et organiser vos contenus blog</p>
      </div>
    </div>
    <div class="u-flex u-items-center u-gap-4">
      <a href="{{ route('add.blog.post') }}" class="btn btn-primary u-flex u-items-center u-gap-2">
        <i data-feather="plus" style="width: 16px; height: 16px;"></i>
        Nouvel Article
      </a>
    </div>
  </div>

  <!-- Stats Overview -->
  <div class="grid grid-cols-4" style="margin-bottom: var(--cerfaos-space-8); gap: var(--cerfaos-space-6);">
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">📄</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-text-primary);">{{ $post->count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Articles</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">🏷️</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-text-primary);">{{ \App\Models\BlogCategory::count() }}</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Catégories</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">👁️</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-text-primary);">12.5K</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Vues totales</div>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card__content u-flex u-items-center u-gap-4">
        <div style="font-size: 2rem;">📈</div>
        <div>
          <div style="font-size: var(--cerfaos-font-size-2xl); font-weight: 700; color: var(--cerfaos-success);">+8.2%</div>
          <div class="u-text-muted" style="font-size: var(--cerfaos-font-size-sm);">Croissance</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Articles List -->
  <div class="card">
    <div class="card__header">
      <h2 class="card__title">
        <i data-feather="file-text"></i>
        Liste des Articles
      </h2>
    </div>
    <div class="card__content" style="padding: 0;">
      @if($post->count() > 0)
        <div style="overflow-x: auto;">
          <table class="table">
                                <thead>
                                    <tr>
                                        <th>Article</th>
                                        <th>Catégorie</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($post as $item)
                                    <tr>
                                        <td>
                                            <div class="u-flex u-items-center u-gap-3">
                                                @if($item->image)
                                                    <img src="{{ asset($item->image) }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: var(--cerfaos-radius-md);"
                                                         alt="Vignette - {{ $item->post_title }}">
                                                @else
                                                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--cerfaos-accent), var(--cerfaos-accent-hover)); border-radius: var(--cerfaos-radius-md); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                                        📰
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6>{{ Str::limit($item->post_title, 30) }}</h6>
                                                    <div class="u-flex u-items-center u-gap-2">
                                                        <small class="u-text-muted">#{{ $item->id }}</small>
                                                        <small class="u-text-muted">{{ $item->post_slug }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($item->blogCategory)
                                                <span>{{ $item->blogCategory->category_name }}</span>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->short_description)
                                                <small>{{ Str::limit($item->short_description, 60, '...') }}</small>
                                            @else
                                                <small>{{ Str::limit($item->long_descp, 60, '...') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                {{ $item->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="u-flex u-gap-2">
                                                <a href="{{ url('/show/blog/post/' . $item->id) }}" 
                                                   class="btn btn-sm btn-secondary"
                                                   title="Voir détails">
                                                    <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                                </a>
                                                <a href="{{ route('edit.blog.post', $item->id) }}" 
                                                   class="btn btn-sm btn-secondary"
                                                   title="Modifier">
                                                    <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                                </a>
                                                <a href="{{ route('delete.blog.post', $item->id) }}" 
                                                   class="btn btn-sm btn-danger"
                                                   title="Supprimer"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')">
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
          <div style="font-size: 4rem; margin-bottom: var(--cerfaos-space-4);">📄</div>
          <h5 style="color: var(--cerfaos-text-primary); margin-bottom: var(--cerfaos-space-2);">Aucun article trouvé</h5>
          <p class="u-text-muted" style="margin-bottom: var(--cerfaos-space-6);">Commencez par ajouter votre premier article.</p>
          <a href="{{ route('add.blog.post') }}" class="btn btn-primary u-flex u-items-center u-gap-2" style="display: inline-flex;">
            <i data-feather="plus" style="width: 16px; height: 16px;"></i> 
            Ajouter un Article
          </a>
        </div>
      @endif
    </div>
  </div>

</div>
@endsection