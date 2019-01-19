@if(count(Auth::user()->unreadNotifications->where('type', 'App\Notifications\NewMessageChat')) > 0)
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <span class="badge" style="color: red;">{{count(Auth::user()->unreadNotifications->where('type', 'App\Notifications\NewMessageChat'))}}</span>{{ __("Mensajes") }} 
            <span class="caret"></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach (Auth::user()->unreadNotifications->where('type', 'App\Notifications\NewMessageChat') as $notification)
                    @if(auth()->user()->role_id == \App\Role::ADMINISTRADOR)        
                        <a class="dropdown-item" href="{{ route('conversations.chat_admin', $notification->data['conversation']['teacher_id']) }}">
                            <i>{{ $notification->data["user"]["name"] }}</i> 
                            <b>{{ $notification->data["message"]["message"] }}</b>
                        </a>
                    @endif
                    @if(auth()->user()->role_id == \App\Role::PROFESOR)
                        <a class="dropdown-item" href="{{ route('conversations.chat_teacher', $notification->data['user']['id']) }}">
                            <i>{{ $notification->data["user"]["name"] }}</i> 
                            <b>{{ $notification->data["message"]["message"] }}</b>
                        </a>
                    @endif
                    @if(auth()->user()->role_id == \App\Role::ESTUDIANTE)
                        <a class="dropdown-item" href="{{ route('conversations.chat_student', $notification->data['conversation']['teacher_id']) }}">
                            <i>{{ $notification->data["user"]["name"] }}</i> 
                            <b>{{ $notification->data["message"]["message"] }}</b>
                        </a>
                    @endif
            @endforeach
        </div>
    </li>
@else
    <a class="nav-link" href="{{ route('conversations.all_conversations') }}">
        <i class="fa fa-envelope-o" style="font-size:20px"></i> {{ __("Chats") }}
    </a>
@endif