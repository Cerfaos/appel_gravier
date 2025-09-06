@extends('admin.admin_master_outdoor')
@section('admin')

<div class="page-content">
    <div class="container">
        
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h4>🏕️ Mon Campement Personnel</h4>
            </div>
            <div>
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li>Profil</li>
                </ol>
            </div>
        </div>
 
 
        <div class="content">
            <div class="content-wrapper">
                <div>
                    <div>
                        
                        <!-- Carte d'identité Aventurier -->
                        <div class="card u-mt-4">
                            <div class="card__body">
                                <div class="u-flex u-gap-6">
                                    <div class="profile-avatar">
                                        <img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" 
                                             alt="photo aventurier" 
                                             class="profile-avatar__image">
                                        <span class="profile-avatar__badge">🥾</span>
                                    </div>
                                    
                                    <div class="profile-info">
                                        <div class="u-flex u-gap-4">
                                            <h4 class="profile-info__name">{{ $profileData->name }}</h4>
                                            <span class="badge badge--gold">
                                                <i data-feather="compass"></i>
                                                Explorateur Actif
                                            </span>
                                        </div>
                                        <p class="profile-info__email">📧 {{ $profileData->email }}</p>
                                        <div>
                                            <span class="profile-info__member">
                                                <i data-feather="map-pin"></i>
                                                Membre depuis l'expédition de {{ Auth::user()->created_at->format('Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
 
 
 
                        <!-- Formulaire de profil -->
                        <div class="card u-mt-4">
                            <div class="card__header">
                                <div class="u-flex u-gap-4">
                                    <div>
                                        <i data-feather="user" style="color: var(--c-gold);"></i>
                                    </div>
                                    <div>
                                        <h5>Carnet d'Identité</h5>
                                        <p class="u-text-muted">Configurez votre profil d'aventurier outdoor</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card__body">
 
 <form action="{{ route('profile.store') }}" method="post" enctype="multipart/form-data">
 @csrf
 
                                <div class="u-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--sp-4);">
                                    
                                    <div class="form-field">
                                        <label>
                                            <span>🏷️</span> Nom de l'Aventurier
                                        </label>
                                        <div>
                                            <input type="text" name="name" value="{{ $profileData->name }}" placeholder="Votre nom d'aventurier">
                                        </div>
                                    </div>
                                    
                                    <div class="form-field">
                                        <label>
                                            <span>📧</span> Pigeon Voyageur (Email)
                                        </label>
                                        <div>
                                            <input type="email" name="email" value="{{ $profileData->email }}" placeholder="communication@aventure.com">
                                        </div>
                                    </div>
                                    
                                    <div class="form-field">
                                        <label>
                                            <span>📱</span> Signal de Détresse
                                        </label>
                                        <div>
                                            <input type="text" name="phone" value="{{ $profileData->phone }}" placeholder="Numéro d'urgence outdoor">
                                        </div>
                                    </div>
 
                                    <div class="form-field">
                                        <label>
                                            <span>🗺️</span> Camp de Base
                                        </label>
                                        <div>
                                            <textarea name="address" placeholder="Adresse de votre camp de base...">{{ $profileData->address }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-field">
                                        <label>
                                            <span>📸</span> Portrait d'Expédition
                                        </label>
                                        <div>
                                            <input type="file" name="photo" id="image" accept="image/*">
                                            <small class="help">
                                                <i data-feather="info"></i> Choisissez votre meilleure photo d'aventure
                                            </small>
                                        </div>
                                    </div>
 
                                    <div class="form-field">
                                        <div class="profile-preview">
                                            <img id="showImage" 
                                                 src="{{ (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" 
                                                 alt="portrait aventurier" 
                                                 class="profile-preview__image">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-feather="save"></i>
                                        Mettre à Jour le Campement
                                    </button>
                                </div>
 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Formulaire de sécurité -->
            <div class="card u-mt-4">
                <div class="card__header">
                    <div class="u-flex u-gap-4">
                        <div>
                            <i data-feather="shield" style="color: var(--c-gold);"></i>
                        </div>
                        <div>
                            <h5>Sécurité du Refuge</h5>
                            <p class="u-text-muted">Modifiez votre mot de passe</p>
                        </div>
                    </div>
                </div>
                <div class="card__body">
 
                    <form action="{{ route('admin.password.update') }}" method="post">
                        @csrf
                        <div class="u-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--sp-4);">
                            
                            <div class="form-field">
                                <label>
                                    <span>🔒</span> Code d'Accès Actuel
                                </label>
                                <div>
                                    <input type="password" name="old_password" id="old_password" placeholder="Votre code secret actuel">
                                    @error('old_password')
                                    <div class="error-message">
                                        <i data-feather="alert-triangle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-field">
                                <label>
                                    <span>🗝️</span> Nouveau Code de Sécurité
                                </label>
                                <div>
                                    <input type="password" name="new_password" id="new_password" placeholder="Créez un nouveau code fort">
                                    @error('new_password')
                                    <div class="error-message">
                                        <i data-feather="alert-triangle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-field">
                                <label>
                                    <span>🔐</span> Confirmation du Code
                                </label>
                                <div>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Répétez le nouveau code">
                                </div>
                            </div>
 
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="shield"></i>
                                Sécuriser le Refuge
                            </button>
                            
                            <div class="help">
                                <i data-feather="info"></i> 
                                Utilisez un code fort avec lettres, chiffres et symboles
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 
 
 
 
 
 
 
</div>
</div>

<script type="text/javascript">
 
 $(document).ready(function(){
 $('#image').change(function(e){
 var reader = new FileReader();
 reader.onload = function(e){
 $('#showImage').attr('src', e.target.result);
 }
 reader.readAsDataURL(e.target.files['0']);
 });
 });
</script>


@endsection