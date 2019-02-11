@extends("admin_panel.admin")

@section('content')
	<h2>Editing Product ID:{{$product->id}}</h2>
    <form method='post' action='/admin_panel/update/{{$product->id}}' enctype='multipart/form-data'>
        @csrf

        <div class="form-group">
            Product name:
            <input type="text" name="name" class='form-control' value={{$product->name}}>
        </div>
        <div class="form-group">
            Stock keeping unit number:
            <input type="text" name="sku" class='form-control' value={{$product->sku}}>
        </div>
        <div class="form-group">
            Base price:
            <input type="text" name="base_price" class='form-control' value={{$product->base_price}}>
        </div>
        <div class="form-group">
            Discount (leave blank for none):
            <input type="text" name="individual_discount" class='form-control' value={{$product->individual_discount}}>
        </div>
        <div class="form-group">
            Product image: <span class='text-danger'>Typing in anything to this field or uploading a file will overwrite your current image</span>
            <input type="text" name="image" class='form-control' placeholder='Image URL'>
            <input type="file" name="upload_image">
        </div>
        <div class="form-group">
            Detailed description of the product:
            <textarea id='article-ckeditor' class="form-control" name='description' rows="20" placeholder='Description'>{{$product->description}}</textarea>
        </div>
        <div>
        	<!-- If checkbox is unchecked, the hidden value will be used to overwrite the previous one -->
        	<input type="hidden" name='status' value=0>
        	@if($product->status)
            	<h3>Visible in products page:<input name='status' type="checkbox" value=1 checked></h3>
            @else
            	<h3>Visible in products page:<input name='status' type="checkbox" value=1></h3>
            @endif
        </div>
         <div class="form-group">
         	<input type="hidden" name='method' value='update'>
            <button type='submit' class='btn btn-warning'>Update Product</button>
        </div>

    </form>
@endsection