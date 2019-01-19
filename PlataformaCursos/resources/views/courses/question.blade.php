@extends('layouts.app')

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
			        href="{{ route('courses.course_details', $lesson->course->slug) }}"
			    > {{ $lesson->course->nombre }}
				</a>
			</h2>
		</div> 
	</div>
@endsection

@section('content')
<a 
  href="{{ route('courses.finished', $lesson->course->id) }}" 
  class="btn" 
  style="background-color: #70299b; color: white;"
>
  {{ __("Resultados") }}
</a>
<hr>
<div class="card" align="left">
	<div class="card-header" style="background-color: #70299b; color: white;">
		<b>{{ __("Pregunta de la lección") }}:</b> 
		<a 
			href="{{ route('lessons.lesson', $lesson->id) }}" 
			style="text-decoration: none; color: white;"
		>
			{{ $lesson->titulo }}
		</a>
	</div>
	<div class="card-body">
		<form>
			@csrf
			@foreach($lesson->questions->where('id', $lesson->questions->random()->id) as $question)
				<b>¿{{ $question->question }}?</b>
				@foreach($question->answers as $answer)
					@if($answer->type == 1)
						<div class="custom-control custom-radio">
							<input 
						  		type="radio" 
						  		value="1" 
								id="answer_{{$answer->id}}"  
								name="answer" 
								class="custom-control-input"
							>
						  	<label 
						  		class="custom-control-label" 
						  		for="answer_{{$answer->id}}"
						  	>
						  		{{ $answer->answer }}
						  	</label>
						</div>
					@else
						<div class="custom-control custom-radio">
							<input 
						  		type="radio" 
						  		value="2" 
								id="answer_{{$answer->id}}"  
								name="answer" 
								class="custom-control-input"
							>
						  	<label 
						  		class="custom-control-label" 
						  		for="answer_{{$answer->id}}"
						  	>
						  		{{ $answer->answer }}
						  	</label>
						</div>
					@endif
				@endforeach	
			@endforeach
			<input type="hidden" name="course_id" value="{{ $lesson->course->id }}">
			<input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
			<input type="hidden" name="question_id" value="{{ $question->id }}">
			<input type="hidden" name="opportunity" value="{{ $opportunity }}">
			<br>
			@if($verificar != 0)
				<div class="alert alert-warning">
					<i class="fa fa-exclamation-circle"></i> {{ __("Tu respuesta ya ha sido guardada") }}                  
					@include('partials.courses.next_question')
				</div>
			@else
				<button 
					type="button" 
					class="btn" 
					style="background-color: #70299b; color: white;" 
					id="btn-comprobar">
					{{ __("Comprobar") }}
				</button>
			@endif
		</form>
		<div id="correcto" class="alert alert-success" style="display: none;">
			<i style="color: green;" class="fa fa-check"></i>
			{{ __(" Respuesta correcta") }}!!
			@include('partials.courses.next_question')
		</div>
		<div id="incorrecto" class="alert alert-danger" style="display: none;">
			<i style="color: red;" class="fa fa-close"></i>
			{{ __(" Respuesta incorrecta") }}!!
			@include('partials.courses.next_question')
		</div>
	</div>
</div>
@endsection

@push('scripts')
<!-- <script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
<script> 
	jQuery(document).ready(function(){
		jQuery(document).on("click", "#btn-comprobar", function(e){
			jQuery.ajax({
			    url: '{{ route('courses.validate') }}',
			    type: 'POST',
			    headers: {
			        'x-csrf-token': $("meta[name=csrf-token]").attr('content')
			    },
			    data: {
			    	'course_id': $('input[name=course_id]').val(),
			    	'lesson_id': $('input[name=lesson_id]').val(),
			    	'question_id': $('input[name=question_id]').val(),
			    	'opportunity': $('input[name=opportunity]').val(),
			        'answer': $('input:radio[name=answer]:checked').val()
			    }, 
			    success: function(data){
			    	if(data.message == 1){
			    		console.log(data);
			    		$('#correcto').show();
			    	}
			    	else{
			    		console.log(data);
			    		$('#incorrecto').show();
			    	}
			    	$('#btn-comprobar').hide();
			    }
			});
		});
	});
</script>
@endpush