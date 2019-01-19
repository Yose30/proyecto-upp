@extends('layouts.app')

@section('jumbotron')

@endsection

@section('content')
	<div class="row justify-content-center">
		<div class="col-md-2">
			<a class="btn btn-outline-secondary" href="{{ route('lessons.details', $question->lesson->id) }}"><i class="fa fa-reply"></i> {{ __("Volver") }}</a>
		</div>
		<div class="col-md-8">
			<div class="card">
			  	<div class="card-header" align="center" style="background-color: rgb(112, 41, 155); color: #ffffff">
			  		@if($question->answers->count() > 0)
						{{ __("Modificar respuestas de la pregunta") }}: <b>{{ $question->question }}</b>
			  		@else
			  			{{ __("Agregar respuestas de la pregunta") }}: <b>{{ $question->question }}</b>
			  		@endif
			  	</div>
			  	<div class="card-body">
			  		<form method="POST" action="{{ $question->answers->count() == 0 ? route('lessons.answers_store') : route('lessons.answers_update', $question->id) }}" novalidate>
			  			@if($question->answers->count() > 0)
							 @method('PUT')
			  			@endif
	                    @csrf
				  		<div class="form-group row">
							<label for="answer1" class="col-md-4 text-md-right">
			    				{{ __("Respuesta") }} 1
			    			</label>	
			    			<div class="col-md-6">
			    				<input 
					    			class="form-control{{ $errors->has('answers.0') ? ' is-invalid' : '' }}" 
					    			id="answer1"
					    			name="answers[]" 
					    			value= "{{ old('answers.0') ? old('answers.0') : ($question->answers->count() > 0 ? $question->answers[0]->answer : '') }}" >
					    		</input>
					    		@if ($errors->has('answers.0'))
                                    <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('answers.0') }}</strong>
	                                </span>
                                @endif
			    			</div>
			    			@if($question->answers->count() > 0)
                                <input type="hidden" name="answer_id0" value="{{ $question->answers[0]->id }}" />
                            @endif
						</div>
						<div class="form-group row">
							<label for="answer2" class="col-md-4 text-md-right">
			    				{{ __("Respuesta") }} 2
			    			</label>	
			    			<div class="col-md-6">
			    				<input 
					    			class="form-control{{ $errors->has('answers.1') ? ' is-invalid' : '' }}" 
					    			id="answer2"
					    			name="answers[]" 
					    			value= "{{ old('answers.1') ? old('answers.1') : ($question->answers->count() > 0 ? $question->answers[1]->answer : '') }}" >
					    		</input>
					    		@if ($errors->has('answers.1'))
                                    <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('answers.1') }}</strong>
	                                </span>
                                @endif
			    			</div>
			    			@if($question->answers->count() > 0)
                                <input type="hidden" name="answer_id1" value="{{ $question->answers[1]->id }}" />
                            @endif
						</div>
						<div class="form-group row">
							<label for="answer3" class="col-md-4 text-md-right">
			    				{{ __("Respuesta") }} 3
			    			</label>	
			    			<div class="col-md-6">
			    				<input 
					    			class="form-control{{ $errors->has('answers.2') ? ' is-invalid' : '' }}" 
					    			id="answer3"
					    			name="answers[]" 
					    			value= "{{ old('answers.2') ? old('answers.2') : ($question->answers->count() > 0 ? $question->answers[2]->answer : '') }}" >
					    		</input>
					    		@if ($errors->has('answers.2'))
                                    <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('answers.2') }}</strong>
	                                </span>
                                @endif
			    			</div>
			    			@if($question->answers->count() > 0)
                                <input type="hidden" name="answer_id2" value="{{ $question->answers[2]->id }}" />
                            @endif
						</div>
						<div class="form-group row">
						    <label for="type" class="col-md-4 col-form-label text-md-right">¿{{ __("Cual sera tu respuesta correcta") }}?</label>
						    <div class="col-md-6">
						        <select class="form-control" name="type" id="type">
						            <option value="0" {{ old('type') == 0 ? 'selected' : '' }}>Respuesta 1</option>
						            <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>Respuesta 2</option>
						            <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>Respuesta 3</option>
						        </select>
						    </div>
						    @if($question->answers->count() > 0)
						    	<h6 class="col-md-4 text-md-right"><b>{{ __("Respuesta correcta") }}</b></h6>
						    	<h6 class="col-md-6">{{ $correcta->answer }}</h6>
						    @endif
						</div>
						<input type="hidden" name="question_id" value="{{ $question->id }}" />
				  		<div align="right">
				  			<button class="btn" type="submit" style="background-color: #70299b; color: white;"><i class="fa fa-check"></i> {{ __("Guardar") }}</button>
				  		</div>
				  	</form>
			  	</div>
			</div>
			<div>
				<br>
				<table class="table table-hover">
					<thead>
						<tr align="center">
							<th scope="col">{{ __("Pregunta") }}</th>
							<th scope="col">{{ __("¿Respuestas creadas?") }}</th>
				    	</tr>
					</thead>
					<tbody>
						@foreach($questions as $q)
							<tr>
								<td>
									<a href="{{ route('lessons.answers', $q->id) }}" style="text-decoration: none; color: black;">{{ $q->question }}</a>
								</td>
								<td align="center">
									@if($q->answers->count() > 0)
										<i class="fa fa-check" style="color: green; font-size: 20px;"></i>
									@else
										<i class="fa fa-close" style="color: red; font-size: 20px;"></i>
									@endif
								</td>
						    </tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection