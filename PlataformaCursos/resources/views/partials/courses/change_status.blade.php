@if($courses->where('course_id', $course->id)->where('situacion', 1)->count() == 1)
<div align="right">
	<a href="{{ route('admin.change_status', [$course->id, $user->student->id]) }}" class="btn" style="background-color: #70299b; color: white;">
		<i class="fa fa-bolt"></i> {{$texto}}
	</a>
</div>
<br><br>
@endif
