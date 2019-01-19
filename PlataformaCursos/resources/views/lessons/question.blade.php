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
			        href="{{ route('courses.course_details', $question->lesson->course->slug) }}"
			    > {{ $question->lesson->course->nombre }}
				</a>
			</h2>
		</div>
	</div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-3">
		<div class="card" align="center">
	  		<div class="card-header" style="background-color: #70299b; color: white;">
	    		<b>{{ __("Puntuación") }}</b>
	  		</div>
	  		<div class="card-body">
			    <p class="card-text">
			    	<i class="fa fa-flash" style="color: #70299b;"></i>
			    	{{ $puntuacion }}
			    </p>
	  		</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="card">
	  		<div class="card-header" style="background-color: #70299b; color: white;">
	    		<b>{{ __("Pregunta de la lección") }}:</b> 
	    		<a 
	    			href="{{ route('lessons.lesson', $question->lesson->id) }}" 
	    			style="text-decoration: none; color: white;"
	    		>
	    			{{ $question->lesson->titulo }}
				</a>
	  		</div>
	  		<div class="card-body">
				<form id="results">
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
			    	<input 
						type="hidden" 
						name="course_id" 
						value="{{ $question->lesson->course->id }}">
					<input 
						type="hidden" 
						name="lesson_id" 
						value="{{ $question->lesson->id }}">
					<input 
						type="hidden" 
						name="question_id" 
						value="{{ $question->id }}">
					@if($next_lesson != false)
						<input 
							type="hidden" 
							name="next_id" 
							value="{{ $next_lesson->id }}"
						>
					@else
						<input 
							type="hidden" 
							name="next_id" 
							value="0"
						>
					@endif
					<br>
					@if($verificar != 0)
						<div class="alert alert-warning">
							<i class="fa fa-exclamation-circle"></i> {{ __("Tu respuesta ya ha sido guardada") }}
						</div>
					@else
						<button 
							type="button" 
							class="btn" 
							style="background-color: #70299b; color: white;" 
							id="btn-comprobar">
							<i class="fa fa-check"></i> {{ __("Comprobar") }}
						</button>
					@endif
				</form>
				<div id="correcto" class="alert alert-success" style="display: none;">
					<i style="color: green;" class="fa fa-check"></i>
					{{ __(" Respuesta correcta") }}!!
				</div>
				<div id="incorrecto" class="alert alert-danger" style="display: none;">
					<i style="color: red;" class="fa fa-close"></i>
					{{ __(" Respuesta incorrecta") }}!!
				</div>
				<div style="display: none;" id="btn-continuar">
					@if($next_lesson != false)
						<a 
				          href="{{ route('lessons.lesson', $next_lesson->id) }}" 
				          type="button" 
				          class="btn" 
				          style="background-color: #70299b; color: white;"
				        >
				          {{ __("Continuar") }}
				        </a>
				    @else
				        <div class="alert alert-primary">
							<i class="fa fa-diamond"></i> {{ __("Lecciones concluidas...") }} <br>  
							<a 
					          href="{{ route('courses.valoracion', $question->lesson->course->id) }}" 
					          class="btn" 
					          style="background-color: #70299b; color: white;"
					        >
					          {{ __("Siguiente") }}
					        </a>
						</div> 
			        @endif
				</div>
	  		</div>
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
			    url: '{{ route('lessons.validate') }}',
			    type: 'POST',
			    headers: {
			        'x-csrf-token': $("meta[name=csrf-token]").attr('content')
			    },
			    data: {
			    	'course_id': $('input[name=course_id]').val(),
			    	'lesson_id': $('input[name=lesson_id]').val(),
			    	'next_id': $('input[name=next_id]').val(),
			    	'question_id': $('input[name=question_id]').val(),
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
			    	$('#btn-continuar').show();
			    }
			});
		});
	});
</script>
@endpush