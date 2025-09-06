<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription - Cerfaos</title>
    <meta name="description" content="Créez votre compte Cerfaos">
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
        <div class="absolute top-16 left-20 text-7xl opacity-5">🌲</div>
        <div class="absolute bottom-32 right-16 text-6xl opacity-5">🏔️</div>
        <div class="absolute top-1/3 right-1/4 text-4xl opacity-5">🏕️</div>
        <div class="absolute bottom-20 left-1/3 text-5xl opacity-5">🧗</div>
    </div>

    <div class="min-h-screen flex">
        <!-- Illustration Section -->
        <div class="hidden lg:block relative flex-1 bg-outdoor-sunset">
            <div class="absolute inset-0 bg-gradient-to-br from-outdoor-earth-500/20 to-outdoor-olive-500/30"></div>
            
            <!-- Background Pattern -->
            <div class="absolute inset-0">
                <div class="absolute top-1/4 right-1/4 text-8xl opacity-10 text-white">🌿</div>
                <div class="absolute bottom-1/3 left-1/4 text-6xl opacity-10 text-white">🏔️</div>
                <div class="absolute top-1/2 left-1/3 text-5xl opacity-10 text-white">🥾</div>
                <div class="absolute bottom-1/4 right-1/3 text-7xl opacity-10 text-white">🌲</div>
            </div>
            
            <div class="relative z-10 flex items-center justify-center h-full p-12">
                <div class="text-center text-white max-w-lg">
                    <h3 class="text-4xl font-display font-bold mb-6">
                        Rejoignez l'aventure
                    </h3>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        Découvrez une communauté passionnée d'outdoor et vivez des expériences inoubliables en pleine nature.
                    </p>
                    
                    <!-- Features list -->
                    <div class="text-left space-y-4 mb-8">
                        <div class="flex items-center text-white/90">
                            <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm">✓</span>
                            </div>
                            <span>Activités outdoor guidées</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm">✓</span>
                            </div>
                            <span>Communauté d'aventuriers</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm">✓</span>
                            </div>
                            <span>Équipement professionnel</span>
                        </div>
                    </div>
                    
                    <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full">
                        <span class="text-2xl">🏕️</span>
                        <span class="font-semibold text-lg">Cerfaos Adventures</span>
                    </div>
                </div>
            </div>
        </div>

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
                        Créer un compte 🏔️
                    </h1>
                    <p class="text-outdoor-forest-400 text-lg">
                        Rejoignez notre communauté d'aventuriers
                    </p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-200 rounded-xl text-red-700">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center text-sm">
                                    <span class="text-red-500 mr-2">•</span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-outdoor-forest-600 mb-2">
                            Nom complet
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="w-full px-4 py-3 bg-white border border-outdoor-cream-300 rounded-xl text-outdoor-forest-600 placeholder-outdoor-forest-400 focus:outline-none focus:ring-2 focus:ring-outdoor-olive-400 focus:border-outdoor-olive-400 transition-all duration-300 @error('name') border-red-400 focus:ring-red-400 focus:border-red-400 @enderror"
                            value="{{ old('name') }}"
                            placeholder="Jean Dupont"
                            required 
                            autocomplete="name"
                            autofocus
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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
                            placeholder="jean.dupont@email.com"
                            required 
                            autocomplete="email"
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
                            autocomplete="new-password"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-outdoor-forest-400">
                            Minimum 8 caractères recommandés
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-outdoor-forest-600 mb-2">
                            Confirmer le mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="w-full px-4 py-3 bg-white border border-outdoor-cream-300 rounded-xl text-outdoor-forest-600 placeholder-outdoor-forest-400 focus:outline-none focus:ring-2 focus:ring-outdoor-olive-400 focus:border-outdoor-olive-400 transition-all duration-300 @error('password_confirmation') border-red-400 focus:ring-red-400 focus:border-red-400 @enderror"
                            placeholder="••••••••"
                            required 
                            autocomplete="new-password"
                        >
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <input 
                            type="checkbox" 
                            id="terms" 
                            name="terms" 
                            class="w-4 h-4 mt-1 text-outdoor-olive-600 bg-white border-outdoor-cream-300 rounded focus:ring-outdoor-olive-500 focus:ring-2"
                            required
                        >
                        <label for="terms" class="ml-3 text-sm text-outdoor-forest-600 leading-relaxed">
                            J'accepte les <a href="#" class="text-outdoor-olive-600 hover:text-outdoor-olive-700 font-medium transition-colors">conditions d'utilisation</a> 
                            et la <a href="#" class="text-outdoor-olive-600 hover:text-outdoor-olive-700 font-medium transition-colors">politique de confidentialité</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-outdoor-olive-500 hover:bg-outdoor-olive-600 text-white font-semibold py-3 px-6 rounded-xl shadow-outdoor-lg hover:shadow-outdoor-xl transform hover:scale-[1.02] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-outdoor-olive-400 focus:ring-offset-2">
                        🏕️ Créer mon compte
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-8 text-center">
                    <p class="text-outdoor-forest-400">
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}" class="text-outdoor-olive-600 hover:text-outdoor-olive-700 font-semibold transition-colors ml-1">
                            Se connecter
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            // Input focus animations
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
            
            // Password confirmation validation
            function validatePasswordMatch() {
                const errorId = 'password-match-error';
                const existingError = document.getElementById(errorId);
                
                if (confirmPasswordInput.value && passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.classList.add('border-red-400', 'focus:ring-red-400', 'focus:border-red-400');
                    confirmPasswordInput.classList.remove('border-outdoor-cream-300', 'focus:ring-outdoor-olive-400', 'focus:border-outdoor-olive-400');
                    
                    if (!existingError) {
                        const errorP = document.createElement('p');
                        errorP.id = errorId;
                        errorP.className = 'mt-2 text-sm text-red-600';
                        errorP.textContent = 'Les mots de passe ne correspondent pas.';
                        confirmPasswordInput.parentNode.appendChild(errorP);
                    }
                } else {
                    confirmPasswordInput.classList.remove('border-red-400', 'focus:ring-red-400', 'focus:border-red-400');
                    confirmPasswordInput.classList.add('border-outdoor-cream-300', 'focus:ring-outdoor-olive-400', 'focus:border-outdoor-olive-400');
                    
                    if (existingError) {
                        existingError.remove();
                    }
                }
            }
            
            passwordInput.addEventListener('input', validatePasswordMatch);
            confirmPasswordInput.addEventListener('input', validatePasswordMatch);
            
            // Form submission
            form.addEventListener('submit', function(e) {
                const termsCheckbox = document.getElementById('terms');
                if (!termsCheckbox.checked) {
                    e.preventDefault();
                    alert('Veuillez accepter les conditions d\'utilisation pour continuer.');
                    return;
                }
                
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '⏳ Création du compte...';
                submitBtn.disabled = true;
            });
        });
    </script>
</body>
</html>