@if($next_lesson != false)
	<a 
	  href="{{ route('courses.question', [$next_lesson->id, $opportunity]) }}" 
	  class="btn" 
	  style="background-color: #70299b; color: white;"
	>
	  {{ __("Siguiente") }}
	</a>
@endif