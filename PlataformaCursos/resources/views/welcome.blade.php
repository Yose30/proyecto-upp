<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>deei</title>
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/inicio/main.css') }}"> <!--Diseño personal CSS-->
    </head>
    <body class="index">
        <div id="page-wrapper">
            <!-- Header -->
            <header id="header" class="alt">
                <h1 id="logo"><a href="{{ url('/') }}"><span>deei</span></a></h1>
                <nav id="nav">
                    <ul>
                        @include('partials.navigations.'.\App\User::navigation())
                    </ul>
                </nav>
            </header>
            <!-- Banner -->
            <section id="banner">
                <div class="inner">
                    <header><h2>deei</h2></header>
                </div>
            </section>
            <!-- Footer -->
            @include('partials.footer')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/inicio/jquery.min.js') }}"></script>
        <script src="{{ asset('js/inicio/jquery.dropotron.min.js') }}"></script>
        <script src="{{ asset('js/inicio/jquery.scrolly.min.js') }}"></script>
        <script src="{{ asset('js/inicio/jquery.scrollgress.min.js') }}"></script>
        <script src="{{ asset('js/inicio/skel.min.js') }}"></script>
        <script src="{{ asset('js/inicio/util.js') }}"></script>
        <script src="{{ asset('js/inicio/main.js') }}"></script>
    </body>
</html>