# Script de déploiement Cerfaos
  echo "🚀 Déploiement Cerfaos - Démarrage"

  # Vérifications locales
  echo "📋 Vérification état local..."
  if [ -n "$(git status --porcelain)" ]; then
      echo "❌ Erreur: Modifications locales non commitées"
      git status
      exit 1
  fi

  # Build des assets en local
  echo "🏗️  Build des assets..."
  npm run build

  # Push local
  echo "📤 Push vers GitHub..."
  git push origin main

  # Déploiement serveur automatique
  echo "🔧 Déploiement sur serveur..."
  git stash 2>/dev/null
  git pull origin main
  git stash pop 2>/dev/null

  # Gestion des assets
  echo "📦 Copie des assets..."
  cp -r build/* public/build/ 2>/dev/null || echo "Assets déjà en place"
  rm -f public/hot

  # Cache Laravel
  echo "🧹 Nettoyage cache..."
  php artisan config:clear
  php artisan view:clear
  php artisan cache:clear

  echo "✅ Déploiement terminé !"
  echo "🌐 Site mis à jour sur https://cerfaos.fr"