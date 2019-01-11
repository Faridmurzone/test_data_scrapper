
var page = require("webpage").create();
// Para version final descomentar esto
// page.open(url, function(status) {
page.open("https://www.falabella.com.ar/falabella-ar/category/cat10122/Cafeteras-express", function(status) {
        console.log("Status: " + status);
        if(status === "success") {
                console.log("Página: " + page.title);
        }

		var producto = page.evaluate(function() {
		return fbra_browseProductListConfig.state.searchItemList.resultList[0].title;
		});
		console.log("Producto " + producto);
		var marca = page.evaluate(function() {
		return fbra_browseProductListConfig.state.searchItemList.resultList[0].brand;
		});
		console.log("La marca es " + marca);
        var precio = page.evaluate(function() {
        return fbra_browseProductListConfig.state.searchItemList.resultList[0].prices[0].originalPrice;
        });
        console.log("El precio es " + precio);

        phantom.exit();
});



title = fbra_browseProductListConfig.state.searchItemList.resultList[0].title;
marca = fbra_browseProductListConfig.state.searchItemList.resultList[0].brand;
precio_lista = fbra_browseProductListConfig.state.searchItemList.resultList[0].prices[0].originalPrice;