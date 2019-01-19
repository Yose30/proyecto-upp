<div class="card">
    <img 
      class="card-img-top" 
      src="{{ $course->pathAttachment() }}" 
      alt="{{ $course->nombre }}"
    > <!--Traera la imagen que esta guardada en la base de datos-->
    <div class="card-body">
      @if(auth()->user()->role_id == \App\Role::ESTUDIANTE)
       @include('partials.courses.course_state', ['type_id' => auth()->user()->student->id])
      @endif
      @if(auth()->user()->role_id == \App\Role::ADMINISTRADOR && $user->role_id == \App\Role::ESTUDIANTE)
        @include('partials.courses.course_state', ['type_id' => $user->student->id])
      @endif
      @if(auth()->user()->role_id == \App\Role::ADMINISTRADOR)
        <h5 class="card-title"><a href="{{ route('courses.lessons', $course->slug) }}" style="text-decoration: none; color: black;">{{ $course->nombre }}</a></h5>
      @else
        <h5 class="card-title">{{ $course->nombre }}</h5>
      @endif
    </div>
    <div class="card-footer" style="background-color: white;">
      <div class="row justify-content-center">
        <!--Añadir parcial para mostrar rating-->
        @include('partials.courses.rating', ['rating' => $course->rating])
      </div>
      @if(auth()->user()->role_id == \App\Role::ESTUDIANTE)
        <a 
          href="{{ route('courses.course_details', $course->slug) }}" 
          class="btn" 
          style="background-color: #70299b; color: white;"
        >
          {{ __("Detalles") }}
        </a>
      @endif
      @if(auth()->user()->role_id == \App\Role::PROFESOR)
        <a 
          href="{{ route('teacher.courses.details', $course->slug) }}" 
          class="btn" 
          style="background-color: #70299b; color: white;"
        >
          {{ __("Detalles") }}
        </a>
      @endif
      @if(auth()->user()->role_id == \App\Role::ADMINISTRADOR)
        @if($user->role_id == \App\Role::PROFESOR)
          <h6><b>{{ __("Inscritos") }}</b>: {{ $course->students_count }}</h6>
        @endif
      @endif
    </div>
  </div>