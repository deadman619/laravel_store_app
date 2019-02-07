@extends('layouts.app')

@section("content")
	<div class="container">
		<div class="row card-group">
		@foreach($products as $product)
		<div class="col-9 mx-auto col-md-6 col-lg-3 my-3 d-flex align-items-center">
			<a href='/products/{{ $product->id }}' class='product-link'>
			  	<div class='card my-3'>
					<div class="img-container p-4">
						<img src={{ $product->image}} alt="productImage" class='card-img-top' />
					</div>
			        <div class="card-footer d-flex justify-content-between">
						<p class='align-self-center mb-0'>
							{{ $product->name }}
						</p>
						<h5 class='font-italic mb-0'>
							{{ $product->base_price }}<span class='ml-1'>€</span>
						</h5>
					</div>
			  	</div>
		  	</a>
		</div>    
		@endforeach
		</div>
	</div>
	<div class="pager mt-5">
	  {{$products->links()}}
	</div>
      
@endsection