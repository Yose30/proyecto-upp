@extends('layouts.app')
@push('styles')
	<style type="text/css">
		.file-rounded {
	    	width:100px;
	      	height:100px;
	      	border-radius:150px;
	  	}
	  	#estilo-file{
	    	width: 150px;
	    	font-size: 20px;
		    color: #70299b;
		    position: relative;
	  	} 
	  	#imagen{
	    	left: 0; top: 0; right: 0; bottom: 0; width: 100%; height: 100%; position: absolute; opacity: 0;
	  	}
	</style>
@endpush
@section('content')
	@if($course->id)
		<div align="right">
			<a class="btn btn-outline-secondary" href="{{ route('courses.lessons', $course->slug) }}"><i class="fa fa-reply"></i> {{ __("Volver") }}</a>
		</div>
		<br>
	@endif
	<div class="row justify-content-center">
	    <div class="col-md-9">
			<div class="card">
			  	<div class="card-header" align="center" style="background-color: rgb(112, 41, 155); color: #ffffff">
			  		@if($course->id)
						{{ __("Modificar curso") }}
			  		@else
			  			{{ __("Crear curso") }}
			  		@endif
			  	</div>
			  	<div class="card-body">
		  			<form method="POST" action="{{ ! $course->id ? route('courses.store') : route('courses.update', ['slug' => $course->slug]) }}" novalidate enctype="multipart/form-data">
	                    @if($course->id)
	                        @method('PUT')
	                    @endif
	                    @csrf
				  		<div class="form-group">
				    		<label for="">{{ __("Nombre del curso") }}</label>
				    		<input
	                            name="nombre"
	                            id="nombre"
	                            class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
	                            value="{{ old('nombre') ?: $course->nombre }}"
	                            required
	                            autofocus
	                        />
	                        @if ($errors->has('nombre'))
	                            <span class="invalid-feedback">
	                                <strong>{{ $errors->first('nombre') }}</strong>
	                            </span>
	                        @endif
						</div>
				  		@if($course->id)
							@if($course->teacher_id != NULL)
								<div class="form-group row">
								    <label for="" class="col-md-3 col-form-label text-md-left">{{ __("Profesor") }}</label>
								    <div class="col-md-9">
							    		<select name="user_id" id="user_id" class="form-control">
			                                @foreach($users as $user)
			                                    <option {{ (int) old('user_id') === $user->id || $course->teacher->user->id === $user->id ? 'selected' : '' }} value="{{ $user->id }}">
			                                        {{ $user->name }} {{ $user->lastName }}
			                                    </option>
			                                @endforeach
			                            </select>
							    	</div>
						  		</div>
						  	@else
						  		<div class="form-group row">
								    <label for="" class="col-md-3 col-form-label text-md-left">{{ __("Profesor") }}</label>
								    <div class="col-md-9">
							    		<select name="user_id" id="user_id" class="form-control">
			                                @forelse($users as $user)
			                                    <option value="{{ $user->id }}">
			                                        {{ $user->name }} {{ $user->lastName }}
			                                    </option>
			                                @empty
			                                	<option value="0">
			                                        {{ __("No hay profesores aún") }}
			                                    </option>
			                                @endforelse
			                            </select>
							    	</div>
						  		</div>
							@endif
				  		@endif
				  		<div class="form-group">
						    <label for="">{{ __("Descripción") }}</label>
						    <textarea
	                            id="descripcion"
	                            class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}"
	                            name="descripcion"
	                            required
	                            rows="3"
	                        >{{ old('descripcion') ?: $course->descripcion }}</textarea>
	                        @if ($errors->has('descripcion'))
	                            <span class="invalid-feedback">
	                                <strong>{{ $errors->first('descripcion') }}</strong>
	                            </span>
	                        @endif
				  		</div>
				  		<div class="form-group">
	                        <label for="objetivo">{{ __("Objetivo del curso") }}</label>
	                        <textarea
	                            id="objetivo"
	                            class="form-control{{ $errors->has('objetivo') ? ' is-invalid' : '' }}"
	                            name="objetivo"
	                            required
	                            rows="3"
	                        >{{ old('objetivo') ?: $course->objetivo }}</textarea>
	                        @if ($errors->has('objetivo'))
	                            <span class="invalid-feedback">
	                                <strong>{{ $errors->first('objetivo') }}</strong>
	                            </span>
	                        @endif
	                    </div>
	                    <div class="form-group row">
				    		<label for="" class="col-md-5 col-form-label text-md-left">{{ __("Prioridad") }}</label>
				    		<div class="col-md-5">
				    			<input
		                            name="prioridad"
		                            id="prioridad"
		                            class="form-control{{ $errors->has('prioridad') ? ' is-invalid' : '' }}"
		                            value="{{ old('prioridad') ?: $course->prioridad }}"
		                            required
		                            autofocus
		                        />
		                        @if ($errors->has('prioridad'))
		                            <span class="invalid-feedback">
		                                <strong>{{ $errors->first('prioridad') }}</strong>
		                            </span>
		                        @endif
				    		</div>
						</div>
	                    <div class="form-group row">
				    		<label for="" class="col-md-5 col-form-label text-md-left">{{ __("Duración del curso (Semanas)") }}</label>
				    		<div class="col-md-5">
				    			<input
		                            name="tiempo"
		                            id="tiempo"
		                            class="form-control{{ $errors->has('tiempo') ? ' is-invalid' : '' }}"
		                            value="{{ old('tiempo') ?: $course->tiempo }}"
		                            required
		                            autofocus
		                        />
		                        @if ($errors->has('tiempo'))
		                            <span class="invalid-feedback">
		                                <strong>{{ $errors->first('tiempo') }}</strong>
		                            </span>
		                        @endif
				    		</div>
						</div>
				    	<div class="form-group row">
					  		<label for="" class="col-md-4 col-form-label text-md-left">
					  			{{ __("Imagen del curso") }}
					  			<br><b>{{ __("Formato") }} : jpg, png, y jpeg</b>
					  		</label>
						    <div class="col-md-8">
		                        <div id="estilo-file">
						    		<img
							            class="file-rounded"
							            src="{{ asset('images/upload-image.png') }}">
						    		<input type="file" name="imagen" class="custom-file-input{{ $errors->has('imagen') ? ' is-invalid' : ''}}" id="imagen" required>
						    	</div>
					        </div> 
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