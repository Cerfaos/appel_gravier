// Cerfaos PWA Service Worker
// Version: 1.0.0

const CACHE_NAME = 'cerfaos-pwa-v1';
const DATA_CACHE_NAME = 'cerfaos-data-cache-v1';

// Ressources à mettre en cache pour le fonctionnement offline
const STATIC_CACHE_URLS = [
  '/',
  '/offline.html',
  '/frontend/assets/css/aos.css',
  '/frontend/assets/css/animate.min.css',
  '/frontend/assets/js/aos.js',
  '/css/frontend-modern.css',
  '/frontend/assets/images/favicon-32x32.png',
  '/frontend/assets/images/apple-touch-icon.png',
];

// URLs API à mettre en cache pour une expérience hors ligne
const API_CACHE_URLS = [
  '/itineraires',
  '/sorties',
  '/ppg'
];

// Installation du Service Worker
self.addEventListener('install', (event) => {
  console.log('[SW] Installation en cours...');
  
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('[SW] Mise en cache des ressources statiques');
        return cache.addAll(STATIC_CACHE_URLS);
      })
      .catch((error) => {
        console.error('[SW] Erreur lors de la mise en cache:', error);
      })
  );
  
  // Forcer l'activation immédiate
  self.skipWaiting();
});

// Activation du Service Worker
self.addEventListener('activate', (event) => {
  console.log('[SW] Activation en cours...');
  
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          // Supprimer les anciens caches
          if (cacheName !== CACHE_NAME && cacheName !== DATA_CACHE_NAME) {
            console.log('[SW] Suppression de l\'ancien cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  
  // Prendre le contrôle de tous les clients
  self.clients.claim();
});

// Intercéption des requêtes réseau
self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);
  
  // Gestion spécifique des API calls
  if (request.url.includes('/api/') || API_CACHE_URLS.some(apiUrl => request.url.includes(apiUrl))) {
    event.respondWith(
      caches.open(DATA_CACHE_NAME)
        .then((cache) => {
          return fetch(request)
            .then((response) => {
              // Si la requête réussit, mettre en cache et retourner
              if (response.status === 200) {
                cache.put(request, response.clone());
              }
              return response;
            })
            .catch(() => {
              // Si offline, retourner depuis le cache
              return cache.match(request);
            });
        })
    );
    return;
  }
  
  // Stratégie Cache First pour les ressources statiques
  if (request.destination === 'style' || 
      request.destination === 'script' || 
      request.destination === 'image' ||
      request.destination === 'font') {
    
    event.respondWith(
      caches.match(request)
        .then((cachedResponse) => {
          if (cachedResponse) {
            return cachedResponse;
          }
          
          return fetch(request)
            .then((response) => {
              // Si la réponse est valide, la mettre en cache
              if (response.status === 200) {
                const responseClone = response.clone();
                caches.open(CACHE_NAME)
                  .then((cache) => {
                    cache.put(request, responseClone);
                  });
              }
              return response;
            });
        })
    );
    return;
  }
  
  // Stratégie Network First pour les pages HTML
  if (request.destination === 'document') {
    event.respondWith(
      fetch(request)
        .then((response) => {
          // Mettre en cache les pages visitées
          if (response.status === 200) {
            const responseClone = response.clone();
            caches.open(CACHE_NAME)
              .then((cache) => {
                cache.put(request, responseClone);
              });
          }
          return response;
        })
        .catch(() => {
          // Si offline, essayer de servir depuis le cache
          return caches.match(request)
            .then((cachedResponse) => {
              if (cachedResponse) {
                return cachedResponse;
              }
              // Si aucune page en cache, servir la page offline
              return caches.match('/offline.html');
            });
        })
    );
    return;
  }
  
  // Pour toutes les autres requêtes, stratégie réseau standard
  event.respondWith(fetch(request));
});

// Gestion des notifications push (optionnel pour le futur)
self.addEventListener('push', (event) => {
  if (event.data) {
    const data = event.data.json();
    const options = {
      body: data.body,
      icon: '/frontend/assets/images/favicon-32x32.png',
      badge: '/frontend/assets/images/favicon-16x16.png',
      vibrate: [100, 50, 100],
      data: {
        url: data.url || '/'
      },
      actions: [
        {
          action: 'explore',
          title: 'Explorer',
          icon: '/pwa/action-explore.png'
        },
        {
          action: 'later',
          title: 'Plus tard',
          icon: '/pwa/action-later.png'
        }
      ]
    };
    
    event.waitUntil(
      self.registration.showNotification(data.title || 'Cerfaos', options)
    );
  }
});

// Gestion des clics sur notifications
self.addEventListener('notificationclick', (event) => {
  event.notification.close();
  
  if (event.action === 'explore') {
    event.waitUntil(
      clients.openWindow(event.notification.data.url || '/')
    );
  }
  // L'action 'later' ferme simplement la notification
});

// Background sync pour les actions hors ligne (optionnel)
self.addEventListener('sync', (event) => {
  if (event.tag === 'background-sync') {
    event.waitUntil(
      // Ici on pourrait synchroniser les données quand la connexion revient
      console.log('[SW] Synchronisation en arrière-plan')
    );
  }
});

// Gestion des erreurs
self.addEventListener('error', (event) => {
  console.error('[SW] Erreur:', event.error);
});

self.addEventListener('unhandledrejection', (event) => {
  console.error('[SW] Promesse rejetée:', event.reason);
  event.preventDefault();
});