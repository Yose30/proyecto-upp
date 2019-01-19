@extends('layouts.app')

@section('content')
	<div class="container" align="center">
		<div class="col-md-12">
			<div class="card" align="center">
			  <div class="card-body">
			    <h4 class="card-title">
			    	<a 
				        style="text-decoration: none; color: black;" 
				        href="{{ route('courses.course_details', $course->slug) }}"
				    >{{ $course->nombre }}</a>
				  </h4>
			    <h6 class="card-subtitle mb-2 text-muted">{{ __("Lecciones concluidas") }}</h6><br>
			    @include('partials.courses.result_message', ['number' => 1, 'message' => '']) 
			    @include('partials.courses.result_message', ['number' => 2, 'message' => 'Tienes otra oportunidad más. Si obtienes menos del 80% tu avance será reanudado.'])
			    @include('partials.courses.result_message', ['number' => 3, 'message' => 'Lo sentimos, tu avance será reanudado.'])
			    <hr>
			    @include('partials.courses.course_lessons') 
			  </div> 
			</div>
		</div>
	</div>
@endsection