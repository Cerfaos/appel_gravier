<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Cerfaos</title>
    <meta name="description" content="Connectez-vous à votre compte Cerfaos">
    <meta name="author" content="Cerfaos">
    
    <!-- Outdoor Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-outdoor-cream-50 min-h-screen">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-20 text-6xl opacity-5">🏔️</div>
        <div class="absolute bottom-32 left-16 text-8xl opacity-5">🌲</div>
        <div class="absolute top-1/2 left-1/4 text-4xl opacity-5">🍃</div>
        <div class="absolute bottom-20 right-1/3 text-5xl opacity-5">🥾</div>
    </div>

    <div class="min-h-screen flex">
        <!-- Form Section -->
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-md">
                
                <!-- Logo -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-outdoor-olive-500 rounded-3xl text-white mb-4">
                        <span class="text-3xl">🌿</span>
                    </div>
                    <div class="font-display font-bold text-2xl text-outdoor-forest-600">Cerfaos</div>
                    <div class="text-outdoor-forest-400 font-medium">Outdoor Adventures</div>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-display font-bold text-outdoor-forest-600 mb-2">
                        Bon retour ! 🏔️
                    </h1>
                    <p class="text-outdoor-forest-400 text-lg">
                        Connectez-vous à votre espace aventurier
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-outdoor-olive-100 border border-outdoor-olive-200 rounded-xl text-outdoor-olive-700">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Error Messages -->
                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-200 rounded-xl text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-outdoor-forest-600 mb-2">
                            Adresse email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="w-full px-4 py-3 bg-white border border-outdoor-cream-300 rounded-xl text-outdoor-forest-600 placeholder-outdoor-forest-400 focus:outline-none focus:ring-2 focus:ring-outdoor-olive-400 focus:border-outdoor-olive-400 transition-all duration-300 @error('email') border-red-400 focus:ring-red-400 focus:border-red-400 @enderror"
                            value="{{ old('email') }}"
                            placeholder="votre@email.com"
                            required 
                            autocomplete="email"
                            autofocus
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-outdoor-forest-600 mb-2">
                            Mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full px-4 py-3 bg-white border border-outdoor-cream-300 rounded-xl text-outdoor-forest-600 placeholder-outdoor-forest-400 focus:outline-none focus:ring-2 focus:ring-outdoor-olive-400 focus:border-outdoor-olive-400 transition-all duration-300 @error('password') border-red-400 focus:ring-red-400 focus:border-red-400 @enderror"
                            placeholder="••••••••"
                            required 
                            autocomplete="current-password"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="remember_me" 
                                name="remember" 
                                class="w-4 h-4 text-outdoor-olive-600 bg-white border-outdoor-cream-300 rounded focus:ring-outdoor-olive-500 focus:ring-2"
                            >
                            <label for="remember_me" class="ml-2 block text-sm text-outdoor-forest-600">
                                Se souvenir de moi
                            </label>
                        </div>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-outdoor-olive-600 hover:text-outdoor-olive-700 font-medium transition-colors">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-outdoor-olive-500 hover:bg-outdoor-olive-600 text-white font-semibold py-3 px-6 rounded-xl shadow-outdoor-lg hover:shadow-outdoor-xl transform hover:scale-[1.02] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-outdoor-olive-400 focus:ring-offset-2">
                        🥾 Se connecter
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-8 text-center">
                    <p class="text-outdoor-forest-400">
                        Vous n'avez pas de compte ?
                        <a href="{{ route('register') }}" class="text-outdoor-olive-600 hover:text-outdoor-olive-700 font-semibold transition-colors ml-1">
                            Créer un compte
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Illustration Section -->
        <div class="hidden lg:block relative flex-1 bg-outdoor-sunset">
            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-olive-500/20 to-outdoor-earth-500/30"></div>
            
            <!-- Background Pattern -->
            <div class="absolute inset-0">
                <div class="absolute top-1/4 left-1/4 text-8xl opacity-10 text-white">🏔️</div>
                <div class="absolute bottom-1/3 right-1/4 text-6xl opacity-10 text-white">🌲</div>
                <div class="absolute top-1/2 right-1/3 text-5xl opacity-10 text-white">🏕️</div>
                <div class="absolute bottom-1/4 left-1/3 text-7xl opacity-10 text-white">🥾</div>
            </div>
            
            <div class="relative z-10 flex items-center justify-center h-full p-12">
                <div class="text-center text-white">
                    <h3 class="text-4xl font-display font-bold mb-6">
                        Votre aventure commence ici
                    </h3>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed max-w-md">
                        Rejoignez notre communauté d'aventuriers et découvrez les plus beaux espaces naturels.
                    </p>
                    <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full">
                        <span class="text-2xl">🌿</span>
                        <span class="font-semibold text-lg">Cerfaos Adventures</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            const form = document.querySelector('form');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.classList.add('ring-2', 'ring-outdoor-olive-400', 'border-outdoor-olive-400');
                });
                
                input.addEventListener('blur', function() {
                    if (!this.matches(':focus')) {
                        this.classList.remove('ring-2', 'ring-outdoor-olive-400', 'border-outdoor-olive-400');
                    }
                });
            });
            
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '⏳ Connexion...';
                submitBtn.disabled = true;
            });
        });
    </script>
</body>
</html>