# 🚀 Déploiement Hostinger via SSH

## Étape 1: Connexion SSH

Ouvrez votre terminal et exécutez :

```bash
ssh u729830088@185.224.137.62
```

## Étape 2: Navigation vers le répertoire du site

```bash
cd domains/cerfaos.org/public_html
```

## Étape 3: Vérification de l'état actuel

```bash
git status
```

## Étape 4: Sauvegarde du fichier .env

```bash
git stash
```

## Étape 5: Récupération des dernières modifications

```bash
git pull origin main
```

## Étape 6: Restauration du .env

```bash
git stash pop
git checkout --ours .env
git stash drop
```

## Étape 7: Nettoyage des caches Laravel

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Étape 8: Upload du fichier CSS (car ignoré par git)

**Le fichier `public/css/mobile-responsive-enhanced.css` n'est PAS dans git car le dossier `public/css` est ignoré.**

Vous avez 2 options:

### Option A: Copier-coller le contenu directement

1. Sur le serveur Hostinger, créez le fichier:
```bash
nano public/css/mobile-responsive-enhanced.css
```

2. Copiez le contenu depuis votre fichier local:
```bash
# Sur votre Mac local, dans un AUTRE terminal:
cat /Users/didiergrossetete/Desktop/Laravel/cerfaos/public/css/mobile-responsive-enhanced.css
```

3. Collez le contenu dans nano, puis sauvegardez (Ctrl+O, Enter, Ctrl+X)

### Option B: Upload via SCP (depuis votre Mac)

```bash
# Sur votre Mac local:
scp /Users/didiergrossetete/Desktop/Laravel/cerfaos/public/css/mobile-responsive-enhanced.css u729830088@185.224.137.62:~/domains/cerfaos.org/public_html/public/css/
```

## Étape 9: Upload vidéo mobile (si pas déjà fait)

Vérifiez si la vidéo mobile existe:

```bash
ls -lh upload/video/video_092025_mobile.mp4
```

Si elle n'existe pas, uploadez-la via SCP depuis votre Mac:

```bash
# Sur votre Mac local:
scp /Users/didiergrossetete/Desktop/Laravel/cerfaos/upload/video/video_092025_mobile.mp4 u729830088@185.224.137.62:~/domains/cerfaos.org/public_html/upload/video/
```

## Étape 10: Supprimer l'ancien fichier CSS

```bash
rm public/css/mobile-no-animations.css
```

## Étape 11: Vérification finale

```bash
# Vérifier que le nouveau CSS existe
ls -lh public/css/mobile-responsive-enhanced.css

# Vérifier que l'ancien CSS est supprimé
ls -lh public/css/mobile-no-animations.css

# Devrait dire "No such file"
```

## ✅ Checklist Post-Déploiement

Sur votre téléphone:

1. **Vider le cache du navigateur:**
   - Safari: Réglages → Safari → Effacer historique et données
   - Chrome: Paramètres → Confidentialité → Effacer données navigation

2. **Tester en mode navigation privée**

3. **Vérifier que le CSS se charge:**
   - Ouvrir: https://cerfaos.org/css/mobile-responsive-enhanced.css
   - Devrait afficher le contenu CSS

4. **Tester le site mobile:**
   - Ouvrir: https://cerfaos.org
   - Vérifier que les styles sont appliqués
   - Vérifier que la vidéo se charge

## 🔧 En cas de problème

Si les styles ne s'affichent toujours pas:

```bash
# Sur le serveur Hostinger:
php artisan config:cache
php artisan view:cache
chmod -R 755 storage bootstrap/cache
```

## 📋 Résumé des Fichiers Modifiés

✅ **Automatiquement déployés via `git pull`:**
- resources/views/components/sortie-card.blade.php
- resources/views/home/body/home_master.blade.php
- resources/views/home/homelayout/slider.blade.php

⚠️ **À uploader manuellement (ignorés par git):**
- public/css/mobile-responsive-enhanced.css (9.7KB)
- upload/video/video_092025_mobile.mp4 (22MB)

❌ **À supprimer:**
- public/css/mobile-no-animations.css
