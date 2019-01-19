<a
    href="#"
    data-target="#appModal"
    data-id="{{$id}}"
    data-nombre="{{$name}}"
    data-lastname="{{$lastName}}"
    data-profesion="{{$teacher['profesion']}}"
    data-biografia="{{$teacher['biografia']}}"
    class="btn btn-secondary btnInfTeacher"
>
    <i class="fa fa-info-circle"></i> {{ __("Datos") }}
</a>
@if($deleted_at != NULL)
    <a href="{{ route('profile.restore_user', $id) }}" class="btn btn-danger" style="color: white;">
        <i class="fa fa-close"></i> {{ __("Restaurar") }}
    </a>
@else
    <a 
        href="{{ route('profile.profile', [0, $slug]) }}" 
        class="btn"
        style="background-color: #70299b; color: white;" 
    >
        <i class="fa fa-user-circle"></i> {{ __("Perfil") }}
    </a>
@endif