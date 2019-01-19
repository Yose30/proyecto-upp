<div class="card">
	<div class="card-body">
   		<h6><b>{{ __("Biografía") }}</b></h6>
   		@if($user->teacher->biografia != null)
			<p>{{ $user->teacher->biografia }}</p>
		@else
			<div class="alert alert-secondary" role="alert">
				<i class="fa fa-exclamation"></i> {{ _("El formador aún no ha escrito su biografía") }}
			</div>
		@endif
  	</div>
</div>
@if($user->teacher->curriculum != null)
	<br>
	<a href="{{ $user->teacher->public_url }}" class="btn btn-primary"><i class="fa fa-book"></i> {{ __("Ver curriculum") }}</a>
	<br>
@endif