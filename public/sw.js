// self.addEventListener("install", event => {
//     event.waitUntil(
//       caches.open("v1").then(cache => {
//         return cache.addAll([
//           "/manifest.json",
//           "/css/app.css",
//           "/js/app.js",
//           "/icons/icon-192.png",
//           "/icons/icon-512.png"
//           // Add more static files as needed
//         ]);
//       })
//     );
//   });
  
//   self.addEventListener("fetch", event => {
//     event.respondWith(
//       caches.match(event.request).then(response => {
//         return response || fetch(event.request);
//       })
//     );
//   });
  
const filesToCache = [
    "/manifest.json",
    // "/css/app.css",
    // "/js/app.js",
    "/icons/icon-192.png",
    "/icons/icon-512.png"
  ];
  
  self.addEventListener("install", event => {
    event.waitUntil(
      caches.open("v1").then(async cache => {
        for (const file of filesToCache) {
          try {
            await cache.add(file);
            console.log(`✅ Cached: ${file}`);
          } catch (err) {
            console.warn(`❌ Failed to cache: ${file}`, err);
          }
        }
      })
    );
  });
  
  self.addEventListener("fetch", event => {
    event.respondWith(
      caches.match(event.request).then(response => {
        return response || fetch(event.request);
      })
    );
  });
  