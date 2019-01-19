<style>
    .jumbotron {background-color: #70299b}
</style>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <div class="text-white text-center d-flex align-items-center">
            <div class="col-7 text-left">
                <h2>{{ $course->nombre }}</h2>
                @if(auth()->user()->role_id == \App\Role::ESTUDIANTE)
                    <h5>{{ __("Formador") }}:
                        @cannot('inscribe', $course)
                            <a href="{{ route('profile.profile', [$course->id, $course->teacher->user->slug]) }}" style="text-decoration: none; color: white;">
                                <b>{{ $course->teacher->user->name }} {{ $course->teacher->user->lastName }}</b>
                            </a>
                        @else
                            <b>{{ $course->teacher->user->name }} {{ $course->teacher->user->lastName }}</b>
                        @endcannot
                    </h5>
                @endif
                @if(auth()->user()->role_id == \App\Role::ADMINISTRADOR)
                    <h5>{{ __("Creado por") }}: <b>{{ $course->administrator->user->name }} {{ $course->administrator->user->lastName }}</b></h5>
                    <h5>{{ __("Fecha de creación") }}: <b>{{ $course->updated_at->format('d/m/Y') }}</b></h5>
                    <h5>{{ __("Estado") }}: 
                        <b>
                            @if($course->estado == \App\Course::PUBLICADO)
                                {{ __("PUBLICADO") }}
                            @else
                                {{ __("PENDIENTE") }}
                            @endif
                        </b>
                    </h5>
                    <h5>{{ __("Formador") }}: 
                        @if($course->teacher_id == NULL)
                            <b>{{ __("NO DEFINIDO") }}</b>
                        @else
                            <a href="{{ route('profile.profile', [0, $course->teacher->user->slug]) }}" style="text-decoration: none; color: white;"><b>{{ $course->teacher->user->name }} {{ $course->teacher->user->lastName }}</b></a>
                        @endif
                    </h5>
                    <h5>{{ __("Prioridad") }}: 
                        <b>
                            @if($course->prioridad == NULL)
                                {{ __("NO DEFINIDO") }}
                            @else
                                {{ $course->prioridad }}
                            @endif
                        </b>
                    </h5>
                @endif
                @if(auth()->user()->role_id == \App\Role::ADMINISTRADOR)
                    @if($course->students_count > 0)
                        <h6><a style="text-decoration: none; color: white;" href="{{ route('courses.enrolled_students', $course->id) }}">{{ __("Creativos inscritos") }}: <b>{{ $course->students_count }}</b></a></h6>
                    @else
                        <h6>{{ __("Creativos inscritos") }}: <b>{{ $course->students_count }}</b></h6>
                    @endif
                @else
                    @if(auth()->user()->role_id == \App\Role::PROFESOR)
                        @if($num_cursando > 0)
                            <h6><a style="text-decoration: none; color: white;" href="{{ route('teacher.courses.enrolled_students', $course->id) }}">{{ __("Creativos cursando") }}: <b>{{ $num_cursando }}</b></a></h6>
                        @else
                            <h6>{{ __("Creativos cursando") }}: <b>{{ $num_cursando }}</b></h6>
                        @endif
                    @endif
                    @if(auth()->user()->role_id == \App\Role::ESTUDIANTE)
                        <h6>{{ __("Creativos cursando") }}:<b> {{ $num_cursando }}</b></h6>
                    @endif
                @endif
                <h6>{{ __("Tiempo del curso") }}: <b>{{ $course->tiempo }} {{ __("semana") }}(s)</b></h6>
                @if($course->estado != \App\Course::PENDIENTE)
                    <!--Añadir parcial para mostrar rating-->
                    @include('partials.courses.rating', ['rating' => $course->rating])
                @endif
                <br> 
            </div>
            <div class="col-5">
                @if(auth()->user()->role_id == \App\Role::ADMINISTRADOR)
                     @if($course->estado == \App\Course::PENDIENTE)
                        <div align="right">
                            <div class="row">
                                <div class="col-md-5">
                                    <a href="{{ route('admin.updateEstado', $course->id) }}" class="btn btn-success"><i class="fa fa-check"></i> {{ __("Publicar") }}</a>
                                </div>
                                <div class="col-md-5">
                                    <a href="{{ route('courses.edit', $course->id) }}" class="btn" style="background-color: transparent; color: white;">
                                        <i class="fa fa-pencil"></i>
                                    </a>  
                                </div>
                                @if($course->students_count == 0)
                                    <div class="col-md-2">
                                        <button class="btn" type="button" style="background-color: transparent; color: white;" data-toggle="modal" data-target="#exampleModal">
                                          <i class="fa fa-trash" style="color: white;"></i>
                                        </button> 
                                        @include('partials.courses.confirm_delete')
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        @if($course->students_count == 0)
                            <div align="right">
                                <div class="row">
                                    <div class="col-md-5">
                                        <a href="{{ route('admin.updateEstado', $course->id) }}" class="btn btn-danger"><i class="fa fa-close"></i> {{ __("Dar de baja") }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif 
                    @endif
                @endif
                <br />
                <img class="img-fluid" src="{{ $course->pathAttachment() }}" />
                <hr />
                @if(auth()->user()->role_id == \App\Role::ESTUDIANTE)
                    @include('partials.courses.course_advance')
                    @cannot('inscribe', $course)
                        @if($course_advance->avance == 100)
                            <a 
                                href="{{ route('courses.finished', $course->id) }}" 
                                class="btn" 
                                style="background-color: #70299b; color: white;"
                            >
                                {{ __("Ver resultados") }}
                            </a>
                        @endif
                    @endcannot
                @endif
            </div>
        </div> 
    </div>
</div>