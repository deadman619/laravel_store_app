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
				<h4>Price: {{ $product->base_price }}€</h4>
				<a href={{URL::previous()}} class='btn btn-outline-danger mx-2 mt-2'>Return</a>
			</div>
		</div>
	</div>
@endsection
