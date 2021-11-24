const staticCacheName = "stock-static-v500";
const dynamicCache = "stock-dynamic-v500";
const assets = ["./", "./stock.html", "./fallback.html", "../../fonts/NexaLight_0.otf"];

//cache size limit option
const limitCacheSize = (name, size) => {
	caches.open(name).then((cache) => {
		cache.keys().then((keys) => {
			if (keys.length > size) {
				cache.delete(keys[0]).then(limitCacheSize(name, size));
			}
		});
	});
};

self.addEventListener("install", (evt) => {
	//console.log("Serviceworker has been installed");
	evt.waitUntil(
		caches.open(staticCacheName).then((cache) => {
			console.log("Caching all assets");
			cache.addAll(assets);
		})
	);
});

//activate serviceWorker
self.addEventListener("activate", (evt) => {
	//console.log("serviceworker activado");
	evt.waitUntil(
		caches.keys().then((keys) => {
			return Promise.all(keys.filter((key) => key !== staticCacheName && key !== dynamicCache).map((key) => caches.delete(key)));
		})
	);
});

//fetch event
self.addEventListener("fetch", (evt) => {
	//console.log('fecth event', evt);
	evt.respondWith(
		caches
			.match(evt.request)
			.then((cacheRes) => {
				return (
					cacheRes ||
					fetch(evt.request).then((fetchRes) => {
						return caches.open(dynamicCache).then((caches) => {
							caches.put(evt.request.url, fetchRes.clone());
							limitCacheSize(dynamicCache, 5);
							return fetchRes;
						});
					})
				);
			})
			.catch(() => {
				if (evt.request.url.indexOf(".html") > -1) {
					return caches.match("./fallback.html");
				}
			})
	);
});
