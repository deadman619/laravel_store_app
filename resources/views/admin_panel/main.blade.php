@extends("layouts.admin")

@section('content')
	@if(count($products) > 0)
        <h3>Product List</h3>
        <a href="/create" class='btn btn-primary my-3'>Add New Product</a>
        <table class="table">
            <tr>
                <th>Product Name</th>
                <th></th>
                <th></th>
            </tr>
            @foreach($products as $product)
            <tr>
                <td>{{$product->name}}</td>
                <td><a href="edit/{{$product->id}}" class="btn btn-warning">Edit</a></td>
                <td><a href="delete/{{$product->id}}" class='btn btn-danger'>Delete</a></td>
            </tr>
            @endforeach
        </table>
    @else 
        <h3>There are currently no products in the store.</h3>
        <a href="/create" class='btn btn-primary my-3'>Create One Now!</a>
    @endif
@endsection