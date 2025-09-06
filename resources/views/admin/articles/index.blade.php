@extends('admin.admin_master_outdoor')

@section('admin')
<div class="page-content">
 <div class="container">

 <!-- Page Header -->
 <div class="page-header">
 <div class="page-title">
 <h1>Gestion des Articles</h1>
 </div>
 <div class="breadcrumb">
 <a href="{{ route('dashboard') }}">Dashboard</a>
 <span>›</span>
 <span>Articles</span>
 </div>
 </div>

 <div class="content">
 <div class="card">
 <div>
 <div>
 <div>
 <i data-feather="file-text"></i>
 Tous les Articles ({{ $articles->total() }})
 </div>
 <div>
 <a href="{{ route('admin.add.article') }}" class="btn btn-primary">
 <i data-feather="plus"></i> Nouvel Article
 </a>
 </div>
 </div>
 </div>

 <!-- Filtres -->
 <div>
 <form method="GET" action="{{ route('admin.all.articles') }}" class="filters-form">
 <div class="filters-grid">
 <div class="filter-group">
 <label>Recherche</label>
 <input type="text" 
 name="search" 
 
 placeholder="Titre, contenu..."
 value="{{ request('search') }}">
 </div>
 <div class="filter-group">
 <label>Statut</label>
 <select name="status">
 <option value="">Tous</option>
 <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>
 Brouillon
 </option>
 <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>
 Publié
 </option>
 <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>
 Archivé
 </option>
 </select>
 </div>
 <div class="filter-group">
 <label>Catégorie</label>
 <select name="category">
 <option value="">Toutes</option>
 <option value="aventure" {{ request('category') === 'aventure' ? 'selected' : '' }}>
 Aventure
 </option>
 <option value="technique" {{ request('category') === 'technique' ? 'selected' : '' }}>
 Technique
 </option>
 <option value="recit" {{ request('category') === 'recit' ? 'selected' : '' }}>
 Récit
 </option>
 <option value="guide" {{ request('category') === 'guide' ? 'selected' : '' }}>
 Guide
 </option>
 </select>
 </div>
 <div class="filter-group">
 <label>&nbsp;</label>
 <div class="filter-actions">
 <button type="submit" class="btn btn-primary">
 <i data-feather="search"></i> Filtrer
 </button>
 <a href="{{ route('admin.all.articles') }}" class="btn btn-secondary">
 <i data-feather="x"></i> Effacer
 </a>
 </div>
 </div>
 </div>
 </form>
 </div>

 <div>
 @if($articles->count() > 0)
 <div>
 <table class="table">
 <thead>
 <tr>
 <th>Article</th>
 <th>Itinéraire</th>
 <th>Catégorie</th>
 <th>Statut</th>
 <th>Statistiques</th>
 <th>Date</th>
 <th>Actions</th>
 </tr>
 </thead>
 <tbody>
 @foreach($articles as $article)
 <tr>
 <td>
 <div class="article-info">
 @if($article->featured_image)
 <img src="{{ asset('storage/' . $article->featured_image) }}" 
 alt="{{ $article->title }}" 
 class="article-thumbnail">
 @else
 <div class="article-placeholder">
 <i data-feather="file-text"></i>
 </div>
 @endif
 <div class="article-details">
 <h6>
 <a href="{{ route('admin.show.article', $article->id) }}">
 {{ Str::limit($article->title, 50) }}
 </a>
 </h6>
 <p class="article-excerpt">
 {{ Str::limit($article->excerpt, 60) }}
 </p>
 </div>
 </div>
 </td>
 <td>
 @if($article->itinerary)
 <a href="{{ route('admin.show.itinerary', $article->itinerary->id) }}" 
 class="itinerary-link">
 <i data-feather="map"></i>
 {{ Str::limit($article->itinerary->title, 30) }}
 </a>
 @else
 <span>-</span>
 @endif
 </td>
 <td>
 <span class="badge badge-{{ $article->category === 'aventure' ? 'success' : 
 ($article->category === 'technique' ? 'info' : 
 ($article->category === 'recit' ? 'warning' : 'primary')) }}">
 {{ $article->category_label }}
 </span>
 </td>
 <td>
 @if($article->status === 'published')
 <span>
 <i data-feather="eye"></i> Publié
 </span>
 @elseif($article->status === 'draft')
 <span>
 <i data-feather="edit"></i> Brouillon
 </span>
 @else
 <span>
 <i data-feather="archive"></i> Archivé
 </span>
 @endif
 </td>
 <td>
 <div class="stats">
 <div class="stat-item">
 <i data-feather="clock"></i>
 <span>{{ $article->reading_time }}</span>
 </div>
 <div class="stat-item">
 <i data-feather="eye"></i>
 <span>{{ $article->views_count }} vues</span>
 </div>
 </div>
 </td>
 <td>
 <div class="date-info">
 @if($article->published_at)
 <div>Publié le</div>
 <strong>{{ $article->published_at->format('d/m/Y') }}</strong>
 @else
 <div>Créé le</div>
 <strong>{{ $article->created_at->format('d/m/Y') }}</strong>
 @endif
 </div>
 </td>
 <td>
 <div class="actions">
 <a href="{{ route('admin.show.article', $article->id) }}" 
>
 <i data-feather="eye"></i>
 </a>
 <a href="{{ route('admin.edit.article', $article->id) }}" 
>
 <i data-feather="edit"></i>
 </a>
 @if($article->status === 'published')
 <form action="{{ route('admin.unpublish.article', $article->id) }}" 
 method="POST" 
 >
 @csrf
 <button type="submit" 

 onclick="return confirm('Dépublier cet article ?')">
 <i data-feather="eye-off"></i>
 </button>
 </form>
 @else
 <form action="{{ route('admin.publish.article', $article->id) }}" 
 method="POST" 
 >
 @csrf
 <button type="submit" 

 onclick="return confirm('Publier cet article ?')">
 <i data-feather="eye"></i>
 </button>
 </form>
 @endif
 <form action="{{ route('admin.archive.article', $article->id) }}" 
 method="POST" 
 >
 @csrf
 <button type="submit" 

 onclick="return confirm('Archiver cet article ?')">
 <i data-feather="archive"></i>
 </button>
 </form>
 <a href="{{ route('admin.delete.article', $article->id) }}" 

 onclick="return confirm('Supprimer définitivement cet article ?')">
 <i data-feather="trash-2"></i>
 </a>
 </div>
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
 </div>

 <!-- Pagination -->
 <div class="pagination-container">
 <div class="pagination-info">
 Affichage de {{ $articles->firstItem() ?? 0 }} à {{ $articles->lastItem() ?? 0 }}
 sur {{ $articles->total() }} résultats
 </div>
 <div class="pagination-links">
 {{ $articles->links() }}
 </div>
 </div>

 @else
 <!-- État vide -->
 <div class="empty-state">
 <div class="empty-icon">
 <i data-feather="file-text"></i>
 </div>
 <h3>Aucun article trouvé</h3>
 <p>
 @if(request()->hasAny(['search', 'status', 'category']))
 Aucun article ne correspond à vos critères de recherche.
 @else
 Vous n'avez pas encore créé d'articles.
 @endif
 </p>
 <div class="empty-actions">
 @if(request()->hasAny(['search', 'status', 'category']))
 <a href="{{ route('admin.all.articles') }}" class="btn btn-secondary">
 <i data-feather="x"></i> Effacer les filtres
 </a>
 @endif
 <a href="{{ route('admin.add.article') }}" class="btn btn-primary">
 <i data-feather="plus"></i> Créer un article
 </a>
 </div>
 </div>
 @endif
 </div>
 </div>
 </div>
 </div>
</div>
@endsection