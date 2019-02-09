@extends("admin_panel.admin")

@section('content')
	<h2>Currently no tax settings are set</h2>
    <form method='post' action='/admin_panel/taxes/create'>
        @csrf

        <div class="form-group">
            Name of your tax plan:
            <input type="text" name="name" class='form-control' placeholder='Name'>
        </div>
        <div class="form-group">
            Tax rate:
            <input type="text" name="tax_rate" class='form-control' placeholder='Tax Rate'>
        </div>
        <div class="form-group">
            Global discount (leave blank to disable):
            <input type="text" name="global_discount" class='form-control' placeholder='Global Discount'>
        </div>
        <div>
            <h3>Enable Tax Rate Globally:<input name='enable' type="checkbox" value=1></h3>
        </div>
         <div class="form-group">
            <button type='submit' class='btn btn-warning'>Set Tax</button>
        </div>

    </form>
@endsection