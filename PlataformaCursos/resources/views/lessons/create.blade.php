@extends('layouts.app')

@section('content')
	<div class="row justify-content-center">
		<div class="col-md-2">
			<a class="btn btn-outline-secondary" href="{{ route('courses.lessons', $course->slug) }}"><i class="fa fa-reply"></i> {{ __("Volver") }}</a>
		</div>
	    <div class="col-md-8">
			<div class="card">
			  	<div class="card-header" align="center" style="background-color: rgb(112, 41, 155); color: #ffffff">
			  		@if($lesson->id)
						{{ __("Modificar lección") }}
			  		@else
			  			{{ __("Crear lección") }}
			  		@endif
			  	</div>
			  	<div class="card-body"> 
		  			<form method="POST" action="{{ ! $lesson->id ? route('lessons.store') : route('lessons.update', ['slug' => $lesson->slug]) }}" novalidate>
	                    @if($lesson->id)
	                        @method('PUT')
	                    @endif
	                    @csrf
				  		<div class="form-group">
				    		<label for="">{{ __("Titulo de la lección") }}</label>
				    		<input
	                            name="titulo"
	                            id="titulo"
	                            class="form-control{{ $errors->has('titulo') ? ' is-invalid' : '' }}"
	                            value="{{ old('titulo') ?: $lesson->titulo }}"
	                            required
	                            autofocus
	                        />
	                        @if ($errors->has('titulo'))
	                            <span class="invalid-feedback">
	                                <strong>{{ $errors->first('titulo') }}</strong>
	                            </span>
	                        @endif
						</div>
				  		<div class="form-group">
						    <label for="">{{ __("Descripción") }}</label>
						    <textarea
	                            id="descripcion"
	                            class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}"
	                            name="descripcion"
	                            required
	                            rows="3"
	                        >{{ old('descripcion') ?: $lesson->descripcion }}</textarea>
	                        @if ($errors->has('descripcion'))
	                            <span class="invalid-feedback">
	                                <strong>{{ $errors->first('descripcion') }}</strong>
	                            </span>
	                        @endif
				  		</div>
				  		<div class="form-group">
				    		<label for="">{{ __("Link del video") }}</label>
				    		<input
	                            name="link_video"
	                            id="link_video"
	                            class="form-control{{ $errors->has('link_video') ? ' is-invalid' : '' }}"
	                            value="{{ old('link_video') ?: 'https://www.youtube.com/watch?v='.$lesson->link_video }}"
	                            required
	                            autofocus
	                        />
	                        <label style="font-size: 10px;">{{ __("El link del video debe de ser de YouTube") }}</label>
	                        @if ($errors->has('link_video'))
	                            <span class="invalid-feedback">
	                                <strong>{{ $errors->first('link_video') }}</strong>
	                            </span>
	                        @endif
						</div>
						<input type="hidden" name="course_id" value="{{ $course->id }}">
						<hr>
						<h5>{{ __("Preguntas de la lección") }}</h5>
						<div class="form-group row">
							<label for="question1" class="col-md-3">{{ __("Pregunta") }}  1</label>
							<div class="col-md-9">
								<input class="form-control{{ $errors->has('questions.0') ? ' is-invalid' : '' }}" name="questions[]" id="question1" value="{{ old('questions.0') ? old('questions.0') : ($lesson->questions->count() > 0 ? $lesson->questions[0]->question : '') }}" required>
								@if ($errors->has('questions.0'))
                                    <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('questions.0') }}</strong>
	                                </span>
                                @endif
							</div>
							@if($lesson->questions->count() > 0)
                                <input type="hidden" name="question_id0" value="{{ $lesson->questions[0]->id }}" />
                            @endif
						</div>
						<div class="form-group row">
							<label for="question2" class="col-md-3">{{ __("Pregunta") }} 2</label>
							<div class="col-md-9">
								<input class="form-control{{ $errors->has('questions.1') ? ' is-invalid' : '' }}" name="questions[]" id="question2" value="{{ old('questions.1') ? old('questions.1') : ($lesson->questions->count() > 0 ? $lesson->questions[1]->question : '') }}" required>
								@if ($errors->has('questions.1'))
                                    <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('questions.1') }}</strong>
	                                </span>
                                @endif
							</div>
							@if($lesson->questions->count() > 0)
                                <input type="hidden" name="question_id1" value="{{ $lesson->questions[1]->id }}" />
                            @endif
						</div>
						<div class="form-group row">
							<label for="question3" class="col-md-3">{{ __("Pregunta") }}  3</label>
							<div class="col-md-9">
								<input class="form-control{{ $errors->has('questions.2') ? ' is-invalid' : '' }}" name="questions[]" id="question3" value="{{ old('questions.2') ? old('questions.2') : ($lesson->questions->count() > 0 ? $lesson->questions[2]->question : '') }}" required>
								@if ($errors->has('questions.2'))
                                    <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('questions.2') }}</strong>
	                                </span>
                                @endif
							</div>
							@if($lesson->questions->count() > 0)
                                <input type="hidden" name="question_id2" value="{{ $lesson->questions[2]->id }}" />
                            @endif
						</div>
						<div class="form-group row">
							<label for="question4" class="col-md-3">{{ __("Pregunta") }}  4</label>
							<div class="col-md-9">
								<input class="form-control{{ $errors->has('questions.3') ? ' is-invalid' : '' }}" name="questions[]" id="question4" value="{{ old('questions.3') ? old('questions.3') : ($lesson->questions->count() > 0 ? $lesson->questions[3]->question : '') }}" required>
								@if ($errors->has('questions.3'))
                                    <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('questions.3') }}</strong>
	                                </span>
                                @endif
							</div>
							@if($lesson->questions->count() > 0)
                                <input type="hidden" name="question_id3" value="{{ $lesson->questions[3]->id }}" />
                            @endif
						</div>
				  		<div align="right">
				  			<button class="btn" type="submit" style="background-color: #70299b; color: white;"><i class="fa fa-check"></i> {{ __("Guardar") }}</button>
				  		</div>
					</form>
			  	</div>
			</div>
		</div>
	</div>
@endsection