<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>🏔️ Vérification Admin - Cerfaos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Vérification d'authentification admin Cerfaos"/>
        <meta name="author" content="cerfaos.fr"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico')}}">

        <!-- Admin CSS -->
        <link href="{{ asset('css/admin-reset.css')}}" rel="stylesheet" type="text/css" />

        <!-- Feather Icons -->
        <script src="https://unpkg.com/feather-icons"></script>

    </head>

    <body class="admin">
        <!-- Admin Auth Page -->
        <div class="admin-auth-page">
            
            <!-- Form Section -->
            <div class="admin-auth-form">
                <div class="admin-auth-form-content">
                    
                    <!-- Logo -->
                    <div class="admin-auth-logo">
                        <div class="admin-auth-logo-icon">
                            🏔️
                        </div>
                        <h1>Cerfaos</h1>
                        <p>Administration Outdoor</p>
                    </div>

                    <!-- Header -->
                    <div class="admin-auth-header">
                        <h2>🔐 Vérification</h2>
                        <p>Entrez le code reçu par email</p>
                    </div>
    
                    <!-- Alerts -->
                    @if (session('status'))
                        <div class="alert alert--success">
                            <i data-feather="check-circle"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert--danger">
                            <i data-feather="alert-circle"></i>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('custom.verification.verify') }}">
                        @csrf

                        @if (session('error'))
                            <div class="alert alert--danger">
                                <i data-feather="alert-circle"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="form-field">
                            <label for="code">
                                <i data-feather="shield"></i>
                                Code de vérification
                            </label>
                            <input type="text" 
                                   id="code" 
                                   name="code" 
                                   required 
                                   placeholder="123456"
                                   maxlength="6"
                                   pattern="[0-9]{6}"
                                   class="admin-verification-code-input">
                            @error('code')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="check"></i>
                            Vérifier
                        </button>
                    </form>
    
    
                    <!-- Footer -->
                    <div class="u-center u-mt-6">
                        <p class="u-text-muted">
                            Retour à la 
                            <a href="{{ route('login') }}" class="u-text-gold">connexion</a>
                        </p>
                    </div>
                    
                </div>
            </div>

            <!-- Illustration Section -->
            <div class="admin-auth-illustration">
                <div class="admin-auth-illustration-content">
                    <h3>🔐 Sécurité Admin</h3>
                    <p>Vérification en deux étapes pour protéger votre espace d'administration</p>
                    <div class="admin-auth-illustration-badge">
                        <span>🏔️</span>
                        <span>Cerfaos Admin</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Initialize Feather Icons -->
        <script>
            feather.replace();
        </script>
    </body>
</html>