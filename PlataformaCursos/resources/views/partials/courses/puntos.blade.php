<h6><b>{{ __("Puntos del curso") }}</b></h6>
<ul>
	<li><b>{{ __("Resultado") }} 1:</b> {{ $user->student->results->where('course_id', $course->id)->where('opportunity', 1)->where('answer', 1)->count() }} / {{ $course->lessons_count }}</li>
	<li><b>{{ __("Resultado") }} 2:</b> {{ $user->student->results->where('course_id', $course->id)->where('opportunity', 2)->where('answer', 1)->count() }} / {{ $course->lessons_count }}</li>
	<li><b>{{ __("Resultado") }} 3:</b> {{ $user->student->results->where('course_id', $course->id)->where('opportunity', 3)->where('answer', 1)->count() }} / {{ $course->lessons_count }}</li>
</ul>