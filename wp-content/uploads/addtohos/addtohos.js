
    const CACHE_NAME = 'addtohos-cache-v1';
    
    self.addEventListener('install', event => {
      event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
          return cache.addAll([
            '/',
            'http://localhost:8000/wp-content/uploads/addtohos/addtohos-manifest.json'
          ]);
        })
      );
      self.skipWaiting();
    });
    
    self.addEventListener('fetch', event => {
      event.respondWith(
        caches.match(event.request).then(response => {
          return response || fetch(event.request);
        })
      );
    });
    