<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'deei') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    @yield('css')
</head>
<body style="background-color: #ffffff">
    @include('partials.navigation')
    @yield('jumbotron')
    <div id="app">
        <main class="container py-4">
            @if(session('message'))
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="alert alert-{{ session('message')[0] }}">
                            <h4 class="alert-heading">
                                <i class="fa fa-exclamation"></i> {{ __("Mensaje") }}
                            </h4>
                            <p>{{ session('message')[1] }}</p>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    @stack('scripts')
    @yield('js')
</body>
</html>
