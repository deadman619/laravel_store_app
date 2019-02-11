@extends("admin_panel.admin")

@section('content')
	<h2>New Product</h2>
    <form method='post' action='/admin_panel'>
        @csrf

        <div class="form-group">
            Product name:
            <input type="text" name="name" class='form-control' placeholder='Name'>
        </div>
        <div class="form-group">
            Stock keeping unit number:
            <input type="text" name="sku" class='form-control' placeholder='Stock Keeping Unit'>
        </div>
        <div class="form-group">
            Base price:
            <input type="text" name="base_price" class='form-control' placeholder='Base Price'>
        </div>
        <div class="form-group">
            Discount (leave blank for none):
            <input type="text" name="individual_discount" class='form-control' placeholder='Discount (i.e. 20 for 20% off)'>
        </div>
        <div class="form-group">
            Link to product image:
            <input type="text" name="image" class='form-control' placeholder='Image URL'>
        </div>
        <div class="form-group">
            Detailed description of the product:
            <textarea id='article-ckeditor' class="form-control" name='description' rows="20" placeholder='Description'>Product Description Goes Here</textarea>
        </div>
        <div>
            <h3>Visible in products page:<input name='status' type="checkbox" value=1></h3>
        </div>
         <div class="form-group">
            <button type='submit' class='btn btn-warning'>Create Product</button>
        </div>

    </form>
@endsection