@extends("admin_panel.admin")

@section('content')
	<h2>Current tax rate is {{$tax->tax_rate}}, it is
		@if($tax->enabled) enabled
		@else disabled
		@endif
	</h2>
    <form method='post' action='/admin_panel/taxes/update'>
        @csrf

        <div class="form-group">
            <input type="text" name="name" class='form-control' placeholder='Name' value={{$tax->name}}>
        </div>
        <div class="form-group">
            <input type="text" name="tax_rate" class='form-control' placeholder='Tax Rate' value={{$tax->tax_rate}}>
        </div>
        <div class="form-group">
            <input type="text" name="global_discount" class='form-control' placeholder='Global discount' value={{$tax->tax_rate}}>
        </div>
        <div>
        	@if(($tax->enabled))
            <h3>Enable Globally:<input name='enable' type="checkbox" value=1 checked></h3>
            @else
            <h3>Enable Globally:<input name='enable' type="checkbox" value=1></h3>
            @endif
        </div>
         <div class="form-group">
            <button type='submit' class='btn btn-warning'>Set Tax</button>
        </div>

    </form>
@endsection