@extends('admin.admin_master_outdoor')

@section('admin')
<div class="page-content">
 <div class="container">

 <!-- start page title -->
 <div class="content">
 <div class="content-wrapper">
 <div class="page-header">
 <h4>Détails de la Catégorie</h4>

 <div class="page-actions">
 <ol class="breadcrumb">
 <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
 <li><a href="{{ route('all.blog.category') }}">Catégories</a></li>
 <li>{{ $category->category_name }}</li>
 </ol>
 </div>

 </div>
 </div>
 </div>
 <!-- end page title -->

 <div class="content">
 <div class="content-wrapper">
 <div class="card">
 <div>
 <div>
 <h5>{{ $category->category_name }}</h5>
 <div>
 <a href="{{ route('edit.blog.category', $category->id) }}" class="btn btn-info">
 <i data-feather="edit me-1"></i> Modifier
 </a>
 <a href="{{ route('all.blog.category') }}" class="btn btn-secondary">
 <i></i> Retour
 </a>
 </div>
 </div>
 </div>
 <div>
 
 <!-- Informations de la catégorie -->
 <div>
 <div>
 <div>
 <div>
 <h6>Informations Générales</h6>
 <table>
 <tr>
 <td><strong>Nom:</strong></td>
 <td>{{ $category->category_name }}</td>
 </tr>
 <tr>
 <td><strong>Slug:</strong></td>
 <td><code>{{ $category->category_slug }}</code></td>
 </tr>
 <tr>
 <td><strong>Créée le:</strong></td>
 <td>{{ $category->created_at->format('d/m/Y à H:i') }}</td>
 </tr>
 <tr>
 <td><strong>Modifiée le:</strong></td>
 <td>{{ $category->updated_at->format('d/m/Y à H:i') }}</td>
 </tr>
 </table>
 </div>
 </div>
 </div>
 <div>
 <div>
 <div>
 <h6>Statistiques</h6>
 <div>
 <div>
 <i></i>
 {{ $posts->count() }} article{{ $posts->count() > 1 ? 's' : '' }}
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>

 <!-- Liste des articles de cette catégorie -->
 <div class="card">
 <div>
 <h6>Articles de cette catégorie</h6>
 </div>
 <div>
 @if($posts->count() > 0)
 <div>
 <table>
 <thead>
 <tr>
 <th>Image</th>
 <th>Titre</th>
 <th>Date</th>
 <th>Actions</th>
 </tr>
 </thead>
 <tbody>
 @foreach($posts as $post)
 <tr>
 <td>
 @if($post->image)
 <img src="{{ asset($post->image) }}" 
 alt="{{ $post->post_title }}" 
 class="rounded" >
 @else
 <div 
 >
 <i></i>
 </div>
 @endif
 </td>
 <td>
 <h6>{{ Str::limit($post->post_title, 40) }}</h6>
 <small>{{ $post->post_slug }}</small>
 </td>
 <td>
 <small>
 {{ $post->created_at->format('d/m/Y') }}
 </small>
 </td>
 <td>
 <div class="btn-group" role="group">
 <a href="{{ url('/show/blog/post/' . $post->id) }}" 

 title="Voir détails">
 <i data-feather="eye"></i>
 </a>
 <a href="{{ route('edit.blog.post', $post->id) }}" 

 title="Modifier">
 <i data-feather="edit"></i>
 </a>
 </div>
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
 </div>
 @else
 <div>
 <i></i>
 <h6>Aucun article dans cette catégorie</h6>
 <p>Créez votre premier article dans cette catégorie.</p>
 <a href="{{ route('add.blog.post') }}" class="btn btn-primary">
 <i data-feather="plus me-1"></i> Ajouter un Article
 </a>
 </div>
 @endif
 </div>
 </div>

 </div>
 </div>
 </div>
 </div>

 </div>
</div>
@endsection