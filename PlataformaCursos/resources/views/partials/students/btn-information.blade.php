<a
    href="#"
    data-target="#appModal"
    data-id="{{$id}}"
    data-nombre="{{$name}}"
    data-lastname="{{$lastName}}"
    data-carrera="{{$student['carrera']}}"
    data-domicilio="{{$student['domicilio']}}"
    data-telefono="{{$student['telefono']}}"
    class="btn btn-secondary btnInformation"
>
    <i class="fa fa-info-circle"></i> {{ __("Datos") }}
</a>

<a 
    href="{{ route('profile.profile', [0, $slug]) }}" 
    class="btn"
    style="background-color: #70299b; color: white;" 
>
    <i class="fa fa-user-circle"></i> {{ __("Perfil") }}
</a>