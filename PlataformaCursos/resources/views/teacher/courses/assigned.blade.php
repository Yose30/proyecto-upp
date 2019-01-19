<!-- Profesor -->
@extends('layouts.app')
@push('styles')
    <style type="text/css">
        .yellow {color: #ffc107;}
    </style>
@endpush
@section('content')
	@if($resultado)
		<br><br><br><br><br>
        <div class="alert alert-info" align="center" style="font-size: 22px;">
            <i class="fa fa-cogs"></i>
            {{ __("Nos encontramos realizando mantenimiento") }}
        </div>
	@else
		<h1>{{ __("Cursos asignados") }}</h1>
		<div class="row">
			@forelse($courses as $course)
				<div class="col-md-3" style="display: flex;"> 
					@include('partials.courses.card_course')
				</div>
			@empty
				<div class="col-md-12">
					<div class="alert alert-dark" align="center">
			            <i class="fa fa-exclamation-triangle"></i>
			            {{ __("Aun no tienes cursos asignados") }}
			        </div>
				</div>
			@endforelse
		</div>
	@endif
@endsection