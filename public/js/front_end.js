
// Renders homepage
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
				productContainer+="<b class='text-center'>"
				if(products[product].average > 0) {
					productContainer+= "Rating: " + products[product].average + "/5<i class='fas fa-star'></i>"
				} else {
					productContainer+= "Not Rated"
				}
				productContainer+="</b>"
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

// Renders product details page
function detailedPage($id) {
	var ajax = new XMLHttpRequest();
	ajax.open('GET', 'api/product/' + $id);
	ajax.send();
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4 && ajax.status == 200) {
			var product = JSON.parse(ajax.responseText);
			// Name
			var productDetails = "<div class='container py-2'><div class='row'><div class='col-10 mx-auto text-center text-slanted my-5'>"
			productDetails += "<h1>" + product.product.name + "</h1></div></div>"

			// Image + Information
			productDetails += "<div class='row'><div class='col-10 mx-auto col-md-6 my-3'><img src=" + product.product.image + " class='img-fluid alt='productImage' /></div>"
			productDetails += "<div class='col-10 mx-auto col-md-6 my-3 text-center'><h2>SKU: " + product.product.sku + "</h2><div class='description'>" + product.product.description  + "</div></div></div>"

			// Price + Buttons
			productDetails += "<div class='row'><div class='col-10 mx-auto col-md6 mt-3 text-center'><h4>" + product.product.consumer_price + "€</h4>"
			if (product.product.consumer_price != product.product.post_tax_price) {
				productDetails += "<h5><s>" + product.product.post_tax_price + "€</s></h5>"
			}
			productDetails += "<button class='btn btn-outline-info mx-2 mt-2' onclick='initialProductsPage()'>Return</button>"
			productDetails += "<button class='btn btn-outline-warning mx-2 mt-2' onclick='newReview(" + product.product.id + ")'>Review</button>"

			// Review form
			productDetails += "</div></div><div id='reviewForm'></div>"
			productDetails += "<div id='reviews' class='mt-5'>"

			// Reviews start from newest first
			if (product.reviews.length > 1) {
				productDetails +="<div class='text-center'><h1>Average Rating: " + product.avg_rating + "/5<i class='fas fa-star'></i></h1>" + product.review_count + " Reviews</div>"
				for (let i = product.reviews.length-1; i>=0; i--) {
					productDetails += "<div class='card mt-3 p-2'><h4><span class='text-info'>" + product.reviews[i].name +"</span> rated it " + product.reviews[i].rating + "/5</h4><p>" + product.reviews[i].review + "</p></div>"
				}
			} else if (product.reviews.length == 1) {
				productDetails +="<div class='text-center'><h1>Average Rating: " + product.avg_rating + "/5<i class='fas fa-star'></i></h1>" + product.review_count + " Review</div>"
				productDetails += "<div class='card mt-3 p-2'><h4><span class='text-info'>" + product.reviews[0].name +"</span> rated it " + product.reviews[0].rating + "/5</h4><p>" + product.reviews[0].review + "</p></div>"
			}
			productDetails +="</div>"
			document.getElementById('productContainer').innerHTML = productDetails;
		}
	}
}

// Renders review form 
function newReview($id) {
	var reviewForm = "<form onsubmit='submitReview(" + $id + ")' method='post' id='review' class='card p-3 mt-3'><div class='form-group'>Name<input type='text' id='name' name='name' class='form-control' required></div>"
	reviewForm += "<div class='form-group'>Review<textarea id='reviewText' name='reviewText' class='form-control' required></textarea></div>"
	reviewForm += "<div class='form-group'>Rating<select class='form-control' id='rating'>"
	reviewForm += "<option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select></div>"
	reviewForm += "<div class='form-group mx-auto'><button type='submit' class='btn btn-outline-danger'>Submit Review</button></div></form>"
	if (document.getElementById('reviewForm').innerHTML.length > 0) {
		document.getElementById('reviewForm').innerHTML = ''
	} else {
		document.getElementById('reviewForm').innerHTML = reviewForm
	}
	var preventSubmit = document.getElementById('review')
	if (preventSubmit) {
		preventSubmit.addEventListener('submit', event=> {
			event.preventDefault();
		})
	}
}

// Sends post request with review data
function submitReview($id) {
	var name = document.getElementById('name').value
	var review = document.getElementById('reviewText').value
	var rating = document.getElementById('rating').value
	var data = JSON.stringify({
		"name" : name,
		"review" : review,
		"rating" : rating,
		"product_id" : $id
	})
	var ajax = new XMLHttpRequest();
	ajax.open('POST', 'api/product/review');
	ajax.setRequestHeader('Content-Type', 'application/json');
	ajax.send(data);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4 && ajax.status == 200) {
			detailedPage($id);
		}
	}
}