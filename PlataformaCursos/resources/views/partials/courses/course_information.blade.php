<div class="card" style="width: 35rem;">
  	<div class="card-body">
    	<h6 class="card-title"><b>{{ __("Avance") }}</b>: {{ $my_course->avance }}%</h6>
    	<h6 class="card-title"><b>{{ __("Fecha de inscripción") }}</b>: {{ $my_course->fecha_inscripcion }}</h6>
    	<h6 class="card-title"><b>{{ __("N. de lecciones") }}</b>: {{ $course->lessons_count }}</h6>
    	@include('partials.courses.puntos')
		<br><br>
		@if(($course->prioridad + 1) <= $all_courses->count())
			@include('partials.courses.view_button', ['num_opp' => 1, 'texto1' => 'Incribir al siguiente curso'])
			@include('partials.courses.view_button', ['num_opp' => 2, 'texto1' => 'Incribir al siguiente curso'])
			@include('partials.courses.view_button', ['num_opp' => 3, 'texto1' => 'Incribir al siguiente curso'])
		@else
			@include('partials.courses.view_button', ['num_opp' => 1, 'texto1' => 'Finalizar'])
			@include('partials.courses.view_button', ['num_opp' => 2, 'texto1' => 'Finalizar'])
			@include('partials.courses.view_button', ['num_opp' => 3, 'texto1' => 'Finalizar'])
		@endif
		@if(($user->student->results->where('course_id', $course->id)->where('opportunity', 3)->where('answer', 2)->count() * (100 / $course->lessons_count)) > 20)
			<div align="right">
				<a href="{{ route('admin.restart_progress', [$course->id, $user->student->id]) }}" class="btn" style="background-color: #70299b; color: white;">
					<i class="fa fa-bolt"></i> {{ __("Reiniciar avance") }}
				</a>
			</div>
		@endif
  </div>
</div> 