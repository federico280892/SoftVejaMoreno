if ("serviceWorker" in navigator) {
	navigator.serviceWorker
		.register("./sw.js")
		.then(() => console.log("ServiceWorker gestion registrado"))
		.catch(() => console.log("serviceWorker gestion no registrado"));
}
