<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        @if(\App\User::navigation() != 'guest')
            <a class="navbar-brand" href="#">deei</a>
        @else
            <a class="navbar-brand" href="{{ url('/') }}">deei</a>
        @endif
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto"></ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @include('partials.navigations.'.\App\User::navigation())
            </ul>
        </div>    
    </div>
</nav>