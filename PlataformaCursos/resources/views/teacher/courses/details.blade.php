<!-- Profesor -->
@extends('layouts.app')
@push('styles')
    <style type="text/css">
        .yellow {color: #ffc107;}
    </style>
@endpush
@section('jumbotron')
	@include('partials.courses.jumbotron')
@endsection

@section('content')
	@include('partials.courses.descripcion')
	@include('partials.courses.objetivo')
	<div class="container" align="center">
		<br>
		<div class="col-md-10">
			<div class="card">
				<div class="card-header" style="background-color: #70299b; color: white;">
					<h5 class="card-title">{{ __('Lecciones del curso') }}</h5>
				</div>
				<div class="card-body">
					<table class="table table-hover">
						<thead>
							<tr align="center">
								<th scope="col">N.</th>
					      		<th scope="col">{{ __("Titulo") }}</th>
					    	</tr>
						</thead>
						<tbody>
					  		@foreach($course->lessons as $lesson)
							<tr>
								<td align="center">{{ $lesson->prioridad }}</td>
								<td>
						    		<a 
						    			href="{{ route('teacher.courses.lesson', $lesson->id) }}" 
						    			style="text-decoration: none; color: black;"
						    		>
						    			{{ $lesson->titulo }}
						    		</a>
						    	</td>
							</tr>
							@endforeach
				  		</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<br>
	@include('partials.courses.reviews')
@endsection