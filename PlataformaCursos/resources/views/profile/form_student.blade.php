@extends('layouts.app')

@push('styles')
<style type="text/css">
    .img-rounded {
	    width:150px;
	    height:150px;
	    border-radius:150px;
	}
	.btn-mod {
		background-color: #70299b; color: white;
	}
	.edit > a i {background-color: transparent; color: #70299b; font-size: 18px;}

	#estilo-image{
		width: 150px;
		font-size: 20px;
		color: #70299b;
		position: relative;
	}
	#image{
		left: 0; top: 0; right: 0; bottom: 0; width: 100%; height: 100%; position: absolute; opacity: 0;
	}
</style>
@endpush

@section('content')
	<div class="row">
		<div class="col-md-3">
			<div class="card">
		      <div class="card-body" align="center">
		      	@include('partials.profile.profile_picture')
		        <h5 class="card-title">{{ $user->name }} {{ $user->lastName }}</h5>
		        <hr />
			    <h6 align="center">{{ $user->student->carrera }}</h6>
			    <hr />
		        <h6 align="left">{{ __("Clave") }}: {{ $user->clave }}</h6>
		      </div>
		    </div>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title" align="center">{{ __("Mi perfil") }}</h3>
					<hr>
			        <h6 align="left"><b>{{ __("Domicilio") }}:</b> {{ $user->student->domicilio }}</h6>
			        <h6 align="left"><b>{{ __("Teléfono") }}:</b> {{ $user->student->telefono }}</h6>
				</div>
			</div>
			<div class="card">
			    <div class="card-body">
			    	<h4 class="card-title" align="center">{{ __("Objetivos personales") }}</h4>
					<hr />
					<!-- START Actualizar datos -->
			    	<form method="POST" 
			    		action="{{ $user->student->goals->count() == 0 ? route('profile.store', ['slug' => $user->slug]) : route('profile.update', ['slug' => $user->slug]) }}" novalidate>
			    		@if($user->student->goals->count() > 0)
							@method('PUT')
						@endif
						@csrf	
						<div class="form-group row">
			    			<label for="meta1" class="col-md-4 text-md-right">
			    				{{ __("Objetivo 1") }}
			    			</label>	
			    			<div class="col-md-6">
			    				<input 
					    			class="form-control{{ $errors->has('goals.0') ? ' is-invalid' : '' }}" 
					    			id="meta1"
					    			name="goals[]" 
					    			value= "{{ old('goals.0') ? old('goals.0') : ($user->student->goals->count() > 0 ? $user->student->goals[0]->meta : '') }}" >
					    		</input>
					    		@if ($errors->has('goals.0'))
                                    <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('goals.0') }}</strong>
	                                </span>
                                @endif
			    			</div>
			    			@if($user->student->goals->count() > 0)
                                <input type="hidden" name="meta_id0" value="{{ $user->student->goals[0]->id }}" />
                            @endif
			    		</div>

			    		<div class="form-group row">
			    			<label for="meta2" class="col-md-4 text-md-right">
			    				{{ __("Objetivo 2") }}
			    			</label>	
			    			<div class="col-md-6">
			    				<input 
					    			class="form-control{{ $errors->has('goals.1') ? ' is-invalid' : '' }}" 
					    			id="meta2"
					    			name="goals[]" 
					    			value= "{{ old('goals.1') ? old('goals.1') : ($user->student->goals->count() > 0 ? $user->student->goals[1]->meta : '') }}" >
					    		</input>
					    		@if ($errors->has('goals.1'))
                                    <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('goals.1') }}</strong>
	                                </span>
                                @endif
			    			</div>
			    			@if($user->student->goals->count() > 1)
                                <input type="hidden" name="meta_id1" value="{{ $user->student->goals[1]->id }}" />
                            @endif
			    		</div>
			    		<div align="center">
			    			<button type="submit" name="actualizar" class="btn btn-mod" >
					    		{{ __("Actualizar") }}
					    	</button>
			    		</div>	
					</form>	
					<!-- END -->
			    </div>
		    </div>
		    @include('partials.profile.email_password')
		</div>
	</div>
@endsection