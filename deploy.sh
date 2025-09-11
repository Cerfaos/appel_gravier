#!/bin/bash

# Script de déploiement Cerfaos
echo "🚀 Déploiement Cerfaos - Démarrage"

# Vérifications locales
echo "📋 Vérification état local..."
if [ -n "$(git status --porcelain)" ]; then
    echo "❌ Erreur: Modifications locales non commitées"
    git status
    exit 1
fi

# Push local
echo "📤 Push vers GitHub..."
git push origin main

# Instructions serveur
echo ""
echo "🔧 Exécutez maintenant sur Hostinger :"
echo "cd public_html"
echo "git stash"
echo "git pull origin main"
echo "git stash pop"
echo "php artisan config:cache"
echo "php artisan view:cache"

echo ""
echo "✅ Script local terminé"
echo "🌐 Continuez sur le serveur avec les commandes ci-dessus"