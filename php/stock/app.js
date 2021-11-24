if ("serviceWorker" in navigator) {
	navigator.serviceWorker
		.register("./swStock.js")
		.then(() => console.log("ServiceWorker stock registrado"))
		.catch(() => console.log("serviceWorker stock no registrado"));
}
