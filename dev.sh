#!/bin/bash

echo "🚀 Démarrage de l'environnement de développement Cerfaos"
echo "=================================================="

# Vérifier si les dépendances sont installées
if [ ! -d "node_modules" ]; then
    echo "📦 Installation des dépendances Node.js..."
    npm install
fi

# Construire les assets
echo "🔨 Construction des assets..."
npm run build

# Démarrer le serveur Laravel
echo "🌐 Démarrage du serveur Laravel sur http://localhost:8000"
echo "🧪 Page de test des styles: http://localhost:8000/test-styles"
echo "🏠 Page d'accueil: http://localhost:8000"
echo ""
echo "💡 Pour le développement en temps réel, utilisez: npm run dev"
echo "🛑 Appuyez sur Ctrl+C pour arrêter le serveur"
echo ""

php artisan serve
