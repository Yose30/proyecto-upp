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
	@include('partials.lessons.table_lessons')
	@include('partials.courses.reviews')
@endsection