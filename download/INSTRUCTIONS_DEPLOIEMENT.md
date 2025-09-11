# Instructions de déploiement - Correction erreur 500 cerfaos.fr

## Problème identifié
L'erreur 500 est causée par une migration Laravel défaillante qui essaie de créer des index spatiaux MySQL invalides.

## Fichiers à déployer via FTP

### 1. Fichier .env (RACINE du serveur)
- Remplacer le fichier `.env` à la racine par celui fourni
- **IMPORTANT**: Contient les bonnes credentials DB de production

### 2. Fichier index.php (RACINE du serveur) 
- Remplacer l'index.php à la racine par celui fourni
- Corrige les chemins pour la production

### 3. Fichier .htaccess (RACINE du serveur)
- S'assurer que le .htaccess est présent à la racine

### 4. Migration corrigée
- Remplacer le fichier `database/migrations/2025_01_15_000001_add_performance_indexes.php` 
- **CRITIQUE**: Cette migration était cassée et empêchait le site de fonctionner

## Actions à effectuer sur le serveur

### 1. Nettoyer les migrations en échec
```bash
php artisan migrate:rollback --step=1
```

### 2. Relancer les migrations avec la version corrigée
```bash
php artisan migrate --force
```

### 3. Vider le cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 4. Optimiser pour la production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Structure des frontends
- **public_html/** : Frontend principal (assets CSS/JS)
- **public/frontend/** : Symlink vers ../frontend/ (assets alternatifs)

## Vérifications post-déploiement
1. Vérifier que cerfaos.fr se charge sans erreur 500
2. Tester la connexion à la base de données
3. Vérifier que les assets CSS/JS se chargent correctement
4. Tester quelques pages principales

## Remarques importantes
- La migration a été corrigée : remplacement des index spatiaux par des index composites standards
- Configuration .env adaptée pour la production (DB_HOST=localhost, DEBUG=false)
- Index.php configuré pour l'environnement serveur