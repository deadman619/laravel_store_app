@extends("admin_panel.admin")

@section('content')
	<h2>Current set tax is <span class='text-success'>{{$tax->name}}</span> with the rate of {{$tax->tax_rate}}%, it is
		@if($tax->enabled) <span class='text-success'>enabled.</span>
		@else <span class='text-danger'>disabled.</span>
		@endif
        Global discount is
        @if($tax->global_discount) <span class='text-success'>set to {{$tax->global_discount}}%.</span>
        @else <span class='text-danger'>not set.</span>
        @endif
	</h2>
    <form method='post' action='/admin_panel/taxes/update'>
        @csrf

        <div class="form-group">
            Name of your tax plan:
            <input type="text" name="name" class='form-control' placeholder='Name' value={{$tax->name}}>
        </div>
        <div class="form-group">
            Tax rate:
            <input type="text" name="tax_rate" class='form-control' placeholder='Tax Rate' value={{$tax->tax_rate}}>
        </div>
        <div class="form-group">
            Global discount (leave blank to disable):
            <input type="text" name="global_discount" class='form-control' placeholder='Global Discount' value={{$tax->global_discount}}>
        </div>
        <div>
        	@if(($tax->enabled))
            <h3>Enable Tax Rate Globally:<input name='enable' type="checkbox" value=1 checked></h3>
            @else
            <h3>Enable Tax Rate Globally:<input name='enable' type="checkbox" value=1></h3>
            @endif
        </div>
         <div class="form-group">
            <button type='submit' class='btn btn-warning'>Set Tax</button>
        </div>

    </form>
@endsection