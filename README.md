# 🚴‍♂️ Cerfaos - Plateforme d'Aventures Outdoor

![Laravel](https://img.shields.io/badge/Laravel-12.24.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4.1-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.1.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## 📋 Description

**Cerfaos** est une plateforme web dédiée aux aventures outdoor, spécialisée dans le **vélo gravel** et les **itinéraires GPS**. L'application permet aux utilisateurs de découvrir, partager et télécharger des parcours outdoor avec une interface moderne et intuitive.

### 🎯 Mission

Créer une communauté d'aventuriers partageant la passion du vélo gravel et de l'exploration de nouveaux territoires, en mettant à disposition des outils professionnels pour la planification d'itinéraires.

## ✨ Fonctionnalités Principales

### 🗺️ Gestion d'Itinéraires GPS

- **Import de fichiers GPX** avec analyse automatique
- **Calcul automatique** des statistiques (distance, dénivelé, durée)
- **Visualisation interactive** avec cartes Leaflet
- **Galerie d'images** pour chaque itinéraire
- **Profils d'altitude** et métriques détaillées
- **Téléchargement des tracés GPX**

### 📝 Système de Contenu

- **Articles de blog** liés aux itinéraires
- **Gestion des médias** avec upload d'images
- **SEO optimisé** (meta-tags, slugs, og:image)
- **Système de publication** (brouillon/publié)
- **Gestion des catégories et tags**

### 👤 Interface Utilisateur

- **Design outdoor moderne** avec palette de couleurs naturelles
- **Interface responsive** adaptée à tous les écrans
- **Animations fluides** et microinteractions
- **Navigation intuitive** avec breadcrumbs
- **Système de témoignages** avec slider automatique

### ⚙️ Administration

- **Panel d'administration** complet et sécurisé
- **Gestion des utilisateurs** avec rôles
- **Interface de création d'itinéraires** avec drag & drop
- **Statistiques et analytics** intégrées
- **Système de modération** du contenu

## 🛠️ Stack Technique

### Backend

- **Framework** : Laravel 12.24.0
- **PHP** : 8.4.1
- **Base de données** : MySQL 8.0
- **Tests** : Pest 3.8.2
- **Code quality** : Laravel Pint 1.24.0

### Frontend

- **CSS Framework** : Tailwind CSS 3.1.0
- **JavaScript** : Alpine.js 3.4.2
- **Maps** : Leaflet 1.9.4
- **File Upload** : Dropzone 6.0.0
- **Build Tool** : Vite 7.0.4

### Architecture

- **MVC Pattern** avec Laravel
- **Services Layer** pour la logique métier
- **Repository Pattern** pour les données
- **Event-Driven** architecture
- **RESTful API** pour les interactions

## 📊 Structure de la Base de Données

### Tables Principales

```sql
-- Itinéraires avec données GPS
itineraries (id, title, slug, description, gpx_file_path, distance_km, 
            elevation_gain_m, difficulty_level, estimated_duration_minutes)

-- Points GPS des tracés
gpx_points (id, itinerary_id, latitude, longitude, elevation, point_order)

-- Images des itinéraires
itinerary_images (id, itinerary_id, image_path, is_featured, order_position)

-- Articles de blog
articles (id, title, slug, content, category, tags, status, published_at)

-- Témoignages utilisateurs
reviews (id, name, position, image, message)

-- Configuration du site
sliders (id, title, description, image, link)
features (id, title, description, icon)
```

## 🚀 Installation

### Prérequis

- PHP 8.4+
- Composer
- Node.js 18+
- MySQL 8.0+
- Git

### Installation Standard

```bash
# Cloner le projet
git clone [repository-url] cerfaos
cd cerfaos

# Installation des dépendances PHP
composer install

# Installation des dépendances Node.js
npm install

# Configuration de l'environnement
cp .env.example .env
php artisan key:generate

# Configuration de la base de données
php artisan migrate --seed

# Build des assets
npm run build

# Lancer le serveur de développement
php artisan serve
```

### Script de Développement Rapide

```bash
# Utilisation du script intégré
./dev.sh
```

## 🗂️ Architecture du Projet

```text
app/
├── Console/Commands/          # Commandes Artisan personnalisées
├── Http/
│   ├── Controllers/
│   │   ├── Backend/          # Controllers d'administration
│   │   ├── Api/              # API endpoints
│   │   └── Auth/             # Authentification
│   ├── Requests/             # Form requests validation
│   └── Middleware/           # Middlewares personnalisés
├── Models/                   # Modèles Eloquent
├── Services/                 # Services métier
│   ├── GpxParserService.php  # Analyse des fichiers GPX
│   └── ItineraryStatisticsService.php
└── View/Components/          # Composants Blade

resources/
├── views/
│   ├── home/                 # Interface publique
│   ├── admin/                # Panel d'administration
│   └── components/           # Composants réutilisables
├── css/                      # Styles personnalisés
└── js/                       # JavaScript custom

public/
├── frontend/assets/          # Assets frontend
├── backend/assets/           # Assets admin
└── upload/                   # Fichiers uploadés
```

## 🔧 Configuration

### Variables d'Environnement

```env
# Application
APP_NAME="Cerfaos"
APP_ENV=production
APP_URL=https://votre-domaine.com

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cerfaos
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Mail
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

### Commandes Artisan Personnalisées

```bash
# Test d'import GPX
php artisan test:gpx-import

# Création de test d'itinéraire
php artisan test:itinerary-creation

# Mise à jour des durées estimées
php artisan itinerary:update-durations
```

## 🎨 Thème et Design

### Palette de Couleurs Outdoor

```css
/* Couleurs principales */
--outdoor-olive: #606c38    /* Navigation, boutons primaires */
--outdoor-forest: #283618   /* Textes, headers */
--outdoor-cream: #fefae0    /* Backgrounds, cartes */
--outdoor-ochre: #dda15e    /* Links, accents */
--outdoor-earth: #bc6c25    /* Boutons secondaires */
```

### Composants UI

- **Cards** avec shadow outdoor personnalisées
- **Boutons** avec animations subtiles
- **Navigation** sticky avec transitions
- **Modals** avec backdrop blur
- **Forms** avec validation en temps réel

## 🧪 Tests

### Lancer les Tests

```bash
# Tous les tests
php artisan test

# Tests spécifiques
php artisan test --filter=ItineraryTest
php artisan test tests/Feature/ItineraryImageUploadTest.php

# Tests avec couverture
php artisan test --coverage
```

### Types de Tests

- **Feature Tests** : Tests d'intégration complets
- **Unit Tests** : Tests unitaires des services
- **Browser Tests** : Tests end-to-end (prévu)

## 📈 Performance

### Optimisations Implémentées

- **Eager Loading** pour éviter N+1 queries
- **Image Optimization** avec thumbnails automatiques
- **Cache** pour les données statiques
- **Lazy Loading** des images
- **CDN Ready** pour les assets

### Monitoring

- **Laravel Telescope** (développement)
- **Query Monitoring** intégré
- **Error Tracking** avec logs structurés

## 🔐 Sécurité

### Mesures de Sécurité

- **Authentication** avec Laravel Sanctum
- **Authorization** via policies Laravel
- **CSRF Protection** activée
- **XSS Protection** avec Blade templating
- **File Upload** sécurisé avec validation
- **SQL Injection** protection via Eloquent ORM

## 🚀 Déploiement

### Production Checklist

- [ ] Configuration `.env` de production
- [ ] Optimisation des assets (`npm run build`)
- [ ] Cache des configurations (`php artisan config:cache`)
- [ ] Cache des routes (`php artisan route:cache`)
- [ ] Migration de la base de données
- [ ] Configuration du serveur web
- [ ] Certificats SSL
- [ ] Monitoring et logs

### Serveurs Supportés

- **Apache** 2.4+ avec mod_rewrite
- **Nginx** 1.18+
- **PHP-FPM** recommendé
- **MySQL** 8.0+ ou **MariaDB** 10.4+

## 🤝 Contribution

### Guide de Contribution

1. **Fork** le projet
2. **Créer** une branche feature (`git checkout -b feature/amazing-feature`)
3. **Commit** les changements (`git commit -m 'Add amazing feature'`)
4. **Push** sur la branche (`git push origin feature/amazing-feature`)
5. **Ouvrir** une Pull Request

### Standards de Code

- **PSR-12** pour le PHP
- **Laravel conventions** respectées
- **Tests** obligatoires pour les nouvelles fonctionnalités
- **Documentation** mise à jour

## 📚 Documentation

### Ressources Utiles

- [Documentation Laravel 12](https://laravel.com/docs/12.x)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Leaflet Documentation](https://leafletjs.com/)

### API Documentation

L'API documentation est disponible via les routes `/api/*` avec des endpoints pour :

- **GPX Analysis** : `POST /api/gpx/analyze`
- **Itineraries** : Endpoints CRUD pour les itinéraires
- **Statistics** : Métriques et analytics

## 📞 Support

### Contacts

- **Développeur** : [Votre nom]
- **Email** : votre-email@domain.com
- **Issues** : <https://github.com/votre-repo/issues>

### FAQ

**Q : Comment importer un fichier GPX ?**
R : Utilisez l'interface d'administration, section "Ajouter un itinéraire".

**Q : Format d'images supportées ?**
R : JPG, PNG, WebP jusqu'à 10MB.

**Q : Comment personnaliser le thème ?**
R : Modifiez les variables CSS dans `tailwind.config.js`.

## 📄 Licence

Ce projet est sous licence **MIT**. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

🚴‍♂️ Fait avec ❤️ pour les aventuriers outdoor
