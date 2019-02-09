@extends("admin_panel.admin")

@section('content')
	@if(count($products) > 0)
        <h3>Product List</h3>
        <form action="admin_panel/mass_delete/" method="get">
            <table class="table">
                @csrf
                <tr>
                    <th><button type="submit" class='btn btn-danger'">Delete Selected</button></th>
                    <th>Product Name</th>
                    <th>Price (* - individual discount)</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                @foreach($products as $product)
                <tr>
                    <td><input class='markedList' type="checkbox" name="markedList[]" value={{$product->id}}></td>
                    <td>{{$product->name}}</td>

                    @if($product->consumer_price != $product->post_tax_price)
                        <td>
                            <span class='text-success'>{{$product->consumer_price}}€</span>
                            <s>{{$product->post_tax_price}}€</s>
                            @if($product->individual_discount)
                            ({{$product->individual_discount}}% off)*
                            @else
                            ({{$tax->global_discount}}% off)
                            @endif
                        </td>
                    @else
                        <td>{{$product->consumer_price}}€</td>
                    @endif

                    @if($product->status)
                        <td>Visible</td>
                    @else
                        <td>Disabled</td>
                    @endif

                    <td><a href="/admin_panel/show/{{$product->id}}" class="btn btn-sm btn-success">View</a></td>
                    <td><a href="/admin_panel/edit/{{$product->id}}" class="btn btn-sm btn-warning">Edit</a></td>
                    <td><a href="/admin_panel/delete/{{$product->id}}" class='btn btn-sm btn-danger'>Delete</a></td>
                </tr>
                @endforeach
            </table>
        </form>
    @else 
        <h3>There are currently no products in the store.</h3>
    @endif
@endsection