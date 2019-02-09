function initialProductsPage() {
	var ajax = new XMLHttpRequest();
	ajax.open('GET', 'api/products');
	ajax.send();
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4 && ajax.status == 200) {
			var products = JSON.parse(ajax.responseText);
			var productContainer = "<div class='container'><div class='row card-group'>";
			for(product in products) {

				// Card + Image
				productContainer+="<div class='col-9 col-md-6 col-lg-4 my-3 mx-auto'>"
				productContainer+="<div onclick=detailedPage(" + products[product].id + ") class='product-link'>"
				productContainer+="<div class='card my-3'><div class='img-container p-4'>"
				productContainer+="<img src=" + products[product].image + " alt='productImage' class='card-img-top'/></div>"

				// Card Footer
				productContainer+="<div class='card-footer'>"
				productContainer+="<p class='d-flex justify-content-between'>" + products[product].name + "<span>SKU:" + products[product].sku + "</span></p>"
				productContainer+="<h5 class='font-italic mb-0 d-flex justify-content-end'>" + products[product].consumer_price + "€ "
				if (products[product].consumer_price != products[product].post_tax_price) {
					productContainer+= "<s class='ml-2'>" + products[product].post_tax_price + "€</s>"
				}

				// Closers
				productContainer+="</h5></div></div></div></div>";
			}
			productContainer+="</div></div>"
			document.getElementById('productContainer').innerHTML = productContainer;
		}
	}
}
initialProductsPage();

function detailedPage($id) {
	var ajax = new XMLHttpRequest();
	ajax.open('GET', 'api/product/' + $id);
	ajax.send();
	ajax.onreadystatechange = function() {
	if(ajax.readyState == 4 && ajax.status == 200) {
		console.log("???????")
		var product = JSON.parse(ajax.responseText);
		// Name
		var productDetails = "<div class='container py-2'><div class='row'><div class='col-10 mx-auto text-center text-slanted my-5'>"
		productDetails += "<h1>" + product.name + "</h1></div></div>"

		// Image + Information
		productDetails += "<div class='row'><div class='col-10 mx-auto col-md-6 my-3'><img src=" + product.image + " class='img-fluid alt='productImage' /></div>"
		productDetails += "<div class='col-10 mx-auto col-md-6 my-3 text-center'><h2>SKU: " + product.sku + "</h2><div class='description'>" + product.description  + "</div></div></div>"

		// Price + Buttons
		productDetails += "<div class='row'><div class='col-10 mx-auto col-md6 mt-3 text-center'><h4>" + product.consumer_price + "€</h4>"
		if (product.consumer_price != product.post_tax_price) {
			productDetails += "<h5><s>" + product.post_tax_price + "€</s></h5>"
		}
		productDetails += "<button class='btn btn-outline-info mx-2 mt-2' onclick='initialProductsPage()'>Return</button>"
		productDetails += "</div></div>"
		document.getElementById('productContainer').innerHTML = productDetails;
	}
	}
}
//detailedPage(1)