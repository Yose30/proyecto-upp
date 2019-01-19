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
	<hr>
	@if($course->estado == \App\Course::PENDIENTE)
		<div align="right">
			<a href="{{ route('lessons.create', $course->slug) }}" class="btn" style="background-color: #70299b; color: white;"><i class="fa fa-plus-circle"></i> {{ __("Nueva lección") }}</a> 
		</div>
		<br>
	@endif
	<h5><b>{{ __("Lecciones del curso") }}</b></h5>
	@include('partials.lessons.list_lessons')
	@include('partials.courses.reviews')
@endsection