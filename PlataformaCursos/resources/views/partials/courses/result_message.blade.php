@if($results->where('opportunity', $number)->count() == $course->lessons_count)
	@if(((100 / $course->lessons_count) * ($correctas->where('opportunity', $number)->count())) < 80)
		<div class="alert alert-danger">
			<i class="fa fa-frown-o"></i> 
			<b>{{ __("Resultado") }} {{ $number }}: {{ ((100 / $course->lessons_count) * ($correctas->where('opportunity', $number)->count())) }}% {{ __("de") }} 100%</b>
			<br>
			{{ $message }}
		</div>
	@else
		<div class="alert alert-success">
			<i class="fa fa-flag"></i> {{ __("Felicidades, has contestado correctamente las preguntas.") }}
		</div>
		@if($estado_course->situacion == 1)
			<p>{{ __("Presiona el boton") }} <b>{{ __("Concluido") }}</b> {{ __("para notificar. Gracias") }}</p>
			<a href="{{ route('courses.send_notification', $course->slug) }}" class="btn btn-success"><i class="fa fa-check"></i> {{ __("Concluido") }}</a>
		@endif
    @endif
@endif
