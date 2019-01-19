<li>
	<a class="nav-link" href="{{ route('admin.inicio') }}">
		<i class="fa fa-cubes" style="font-size:20px"></i> {{ __("Cursos") }}
	</a>
</li>

<li>
	<a class="nav-link" href="{{ url('/'.Config::get('chatter.routes.home')) }}"><i class="fa fa-comments-o" style="font-size:20px"></i> {{ __("Foro") }}</a>
</li> 
@include('partials.navigations.chats')
<li>
	<a class="nav-link" href="{{ route('admin.users') }}">
		<i class="fa fa-group" style="font-size:20px"></i> {{ __("Usuarios") }}
	</a>
</li>
@if(count(Auth::user()->unreadNotifications->where('type', 'App\Notifications\CourseConcluded')) > 0)
	<li class="nav-item dropdown">
	    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
	        <span class="badge" style="color: red;">{{count(Auth::user()->unreadNotifications->where('type', 'App\Notifications\CourseConcluded'))}}</span><i class="fa fa-trophy"></i> {{ __("Concluidos") }} 
	        <span class="caret"></span>
	    </a>
	    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	        @foreach (Auth::user()->unreadNotifications->where('type', 'App\Notifications\CourseConcluded') as $notification)
	                <a class="dropdown-item" href="{{ route('profile.profile', [0, $notification->data['user']['slug']]) }}">
	                    <i>
	                    	{{ $notification->data["user"]["name"] }} {{ $notification->data["user"]["lastName"] }}
	                    	<p style="font-size: 10px;">{{ $notification->data["course"]["nombre"] }}</p>
	                    </i>
	                </a>
	        @endforeach
	    </div>
	</li>
@endif
<!-- PRUEBA -->
<!-- <li> 
	@if(count(Auth::user()->unreadNotifications->where('type', 'App\Notifications\NewPreRegister')) > 0)
	    <a class="nav-link" href="{{ route('admin.pre_register') }}">
			<span class="badge" style="color: red;">{{count(Auth::user()->unreadNotifications->where('type', 'App\Notifications\NewPreRegister'))}}</span> {{ __("Pre-registros") }}
		</a>
	@else
	    <a class="nav-link" href="{{ route('admin.pre_register') }}">
			<i class="fa fa-bell-o" style="font-size:20px"></i> {{ __("Pre-registros") }}
		</a>
	@endif
</li> -->
<li>
	<a class="nav-link" href="{{ route('admin.pre_register') }}">
		<span class="notif-count" style="color: red;">0</span> {{ __("Pre-registros") }}
	</a>
</li>
@include('partials.navigations.logged')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//js.pusher.com/3.1/pusher.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
