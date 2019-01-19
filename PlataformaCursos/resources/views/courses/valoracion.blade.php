@extends('layouts.app')
<style type="text/css">
    .yellow {color: #ffc107;}
</style>
@section('jumbotron')
    <div 
        class="jumbotron jumbotron-fluid" 
        style="background-color: #70299b; color: #ffffff;"
    >
        <div class="container" align="center">
            <h2>
                <i class="fa fa-university"></i> 
                <a 
                    style="text-decoration: none; color: white;" 
                    href="{{ route('courses.course_details', $course->slug) }}"
                > {{ $course->nombre }}
                </a>
            </h2>
        </div>
    </div>
@endsection
@section('content')
    <a 
      href="{{ route('courses.finished', $course->id) }}" 
      class="btn" 
      style="background-color: #70299b; color: white;"
    >
      {{ __("Resultados") }}
    </a>
	@can('review', $course)
		<div class="col-12 pt-0 mt-4 text-center">
            <h3>{{ __("Danos tu opinión") }}</h2><hr />
        </div>
        <div class="container-fluid">
            <form method="POST" action="{{ route('courses.add_review') }}" class="form-inline" id="rating_form">
                @csrf
                <div class="form-group mb-2">
                    <div class="col-12">
                        <ul id="list_rating" class="list-inline" style="font-size: 40px;">
                            <li class="list-inline-item" data-number="1"><i class="fa fa-star yellow"></i></li>
                            <li class="list-inline-item star" data-number="2"><i class="fa fa-star"></i></li>
                            <li class="list-inline-item star" data-number="3"><i class="fa fa-star"></i></li>
                            <li class="list-inline-item star" data-number="4"><i class="fa fa-star"></i></li>
                            <li class="list-inline-item star" data-number="5"><i class="fa fa-star"></i></li>
                        </ul>
                    </div>
                </div>
                <input type="hidden" name="rating_input" value="1" />
                <input type="hidden" name="course_id" value="{{ $course->id }}" />
                <div class="form-group mx-sm-3 mb-2">
                    <div class="comment" style="float: left;width: auto; height: auto;">
                        <textarea 
                            id="message"
                            name="message"
                            class="form-control"  
                            placeholder="{{ __("Escribe un comentario") }}" 
                            style="float:left;width: 400px;min-height: 75px;}">
                        </textarea>
                    </div>
                </div>
                <button type="submit" class="btn mb-2" style="background-color: #70299b; color: white;">
                    <i class="fa fa-space-shuttle"></i> {{ __("Valorar curso") }}
                </button>
            </form>
        </div>
	@endcan
    <br>
    @include('partials.courses.reviews')
@endsection

@push('scripts')
    <script>
        jQuery(document).ready(function() {
            const ratingSelector = jQuery('#list_rating');
            ratingSelector.find('li').on('click', function () {
                const number = $(this).data('number');
                $("#rating_form").find('input[name=rating_input]').val(number);
                ratingSelector.find('li i').removeClass('yellow').each(function(index){
                    if((index+1) <= number){
                        $(this).addClass('yellow');
                    }
                })
            })
        });
    </script>
@endpush