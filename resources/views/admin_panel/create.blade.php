@extends("layouts.admin")

@section('content')
	<h2>New Product</h2>
    {!! Form::open(['action' => 'ProductController@store', 'method' => 'POST']) !!}

        <div class="form-group">
            {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{ Form::text('base_price', '', ['class' => 'form-control', 'placeholder' => 'Base Price'])}}
        </div>
        <div class="form-group">
            {{ Form::text('special_price', '', ['class' => 'form-control', 'placeholder' => 'Special Price'])}}
        </div>
        <div class="form-group">
            {{ Form::text('image', '', ['class' => 'form-control', 'placeholder' => 'Image'])}}
        </div>
        <div class="form-group">
            {{ Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
        {{ Form::submit('Submit', ['class' => 'btn btn-primary'])}}

    {!! Form::close() !!}
@endsection