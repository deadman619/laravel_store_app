<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Admin Panel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                @include('admin_panel/partials/sidebar')
            </div>
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">Logged in as: {{Auth::user()->name}} </div>
                        <main class="container mt-5">
            
                            <!-- Displays warning and success messages at the top of the container-->
                            @include('admin_panel/partials/messages')

                            <!-- Main content -->
                            @yield('content')
                        </main>
                </div>
            </div>
        </div>
    </div>

    <!-- CK Editor module for fancier descriptions -->
    <script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script>
        if(document.getElementsByTagName('textarea').length > 0){
            CKEDITOR.replace( 'article-ckeditor' );
        }
    </script>
</body>
</html>
