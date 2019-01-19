@extends('layouts.app')
@push('styles')
    <style type="text/css">
        .yellow {color: #ffc107;}
    </style>
@endpush
@section('content')   
    @if($all_courses->count() == 0)
        <br><br><br><br><br>
        <div class="alert alert-info" align="center" style="font-size: 22px;">
            <i class="fa fa-cogs"></i>
            {{ __("Nos encontramos realizando mantenimiento") }}
        </div>
    @else
        @if($course_inscribe == null)
            <div class="alert alert-success" align="center">
                <i class="fa fa-diamond"></i>
                {{ __("FELICIDADES!! Has concluido todos los cursos") }}
            </div>
        @else
            <h1>{{ __("Curso actual") }}</h1>
            <div class="col-md-3" style="display: flex;">
                @foreach($all_courses->where('id', $course_inscribe->course_id) as $course)
                    @include('partials.courses.card_course')   
                @endforeach
            </div>
        @endif
        <hr/><h2>{{ __("Todos los cursos") }}</h2> 
        <div class="row">
            @foreach($all_courses as $course)
                <div class="col-md-3" style="display: flex;">
                    <!--Tiene acceso al curso solo por estar dentro de la vista home-->
                    @include('partials.courses.card_course')
                </div>
            @endforeach
        </div>
    @endif
@endsection
