@can('inscribe', $user, $course)
	<!-- Se puede inscribir porque no esta inscrito a este curso -->
	<a href="{{ route('student.inscribe', ['slug' => $course->slug]) }}" class="btn" 
		style="background-color: white; color: #70299b;">
		<i class="fa fa-bolt"></i> {{ __("Inscribir al siguiente curso") }}
	</a>
@else
	<!-- `No se puede inscribir porque ya esta inscrito -->
	<a class="btn" style="background-color: white; color: #70299b;">
		<i class="fa fa-bolt"></i> {{ __("Inscrito") }}
	</a>
@endcan 