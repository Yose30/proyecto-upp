<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ Auth::user()->name }} <span class="caret"></span>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('profile.edit', ['slug' => Auth::user()->slug]) }}"><i class="fa fa-user-circle-o"></i>  {{ __('Perfil') }}</a>
        <!-- <a class="dropdown-item" href=""><i class="fa fa-cogs"></i>  {{ __('Cuenta') }}</a> -->
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out"></i>  
            {{ __('Cerrar sesión') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</li>
                