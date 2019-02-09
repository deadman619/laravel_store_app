@extends("admin_panel.admin")

@section('content')
    <div class='container py-2'>
		<div class='row'>
			<div class="col-10 mx-auto text-center text-slanted my-5">
				<h1>{{ $product->name }}</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-10 mx-auto col-md-6 my-3">
				<img src={{ $product->image}} class='img-fluid' alt="productImage"/>	
			</div>
			<div class="col-10 mx-auto col-md-6 my-3 text-center">
				{!! $product->description !!}
			</div>
		</div>
		<div class="row">
			<div class="col-10 mx-auto col-md6 mt-3 text-center">
				@if($product->consumer_price != $product->post_tax_price)
					<h4>Price: <span class='text-success'>{{ $product->consumer_price }}€</span><s>{{ $product->post_tax_price }}€</s></h4>
				@else 
					<h4>Price: {{ $product->consumer_price }}€</h4>
				@endif
				<a href={{URL::previous()}} class='btn btn-outline-danger mx-2 mt-2'>Return</a>
				<a href='/admin_panel/edit/{{ $product->id }}' class='btn btn-outline-info mx-2 mt-2'>Edit</a>
			</div>
		</div>
	</div>
@endsection
