<h5 align="center">{{ $user->student->carrera }}</h5>
<br>
<h6><b>{{ __("Objetivos") }}</b></h6>
<ul>
	@forelse($user->student->goals as $goal)
		<li>{{ $goal->meta }}</li>
	@empty
		<div class="alert alert-secondary" role="alert">
			<i class="fa fa-exclamation"></i> {{ _("El creativo aún no ha definido sus objetivos") }}
		</div>
	@endforelse
</ul>
<br>