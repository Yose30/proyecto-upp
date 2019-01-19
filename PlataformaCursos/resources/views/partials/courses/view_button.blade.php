@if(($user->student->results->where('course_id', $course->id)->where('opportunity', $num_opp)->where('answer', 1)->count() * (100 / $course->lessons_count)) > 80)
	@include('partials.courses.change_status', ['texto' => $texto1])
@endif