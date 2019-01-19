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

	.file-rounded {
      width:100px;
      height:100px;
      border-radius:150px;
	  }
	#curriculum{
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
		        <h6 align="center">{{ $user->teacher->profesion }}</h6>
		        <h6 align="left">{{ __("Clave") }}: {{ $user->clave }}</h6>
		      </div>
		    </div>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title" align="center">{{ __("Mi perfil") }}</h3>
					<hr>
					<form method="POST" 
			    		action="{{ route('profile.update_biography') }}" novalidate>
			    		@if($user->id)
							@method('PUT')
						@endif
						@csrf	
						<div class="form-group row">
			    			<label for="biografia" class="col-md-4 text-md-right">
			    				{{ __("Biografia") }}
			    			</label>	
			    			<div class="col-md-6">
			    				<textarea rows="8"  
					    			class="form-control{{ $errors->has('biografia') ? ' is-invalid' : '' }}" 
					    			required  
					    			id="biografia"
					    			name="biografia" >
					    			{{ old('biografia') ?: $user->teacher->biografia }}
					    		</textarea>
					    		@if ($errors->has('biografia'))
                                    <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('biografia') }}</strong>
	                                </span>
                                @endif
			    			</div>
			    		</div>
						<div align="center">
			    			<button type="submit" name="actualizar" class="btn btn-mod" >
					    		{{ __("Actualizar") }}
					    	</button>
			    		</div>	
					</form>	
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h3 class="card-title" align="center">{{ __("Curriculum") }}</h3>
					<hr>
					<div class="row">
						<div class="col-md-5" align="center">
							<form 
								method="POST" 
								action="{{ route('profile.update_curriculum') }}" 
								novalidate
								enctype="multipart/form-data">
								@csrf
								@method('PUT')
								<div class="form-group">
							    	<div id="estilo-image">
							    		<img
								            class="file-rounded"
								            src="{{ asset('images/curriculum.jpg') }}">
							    		<input type="file" name="curriculum" id="curriculum">
							    	</div>	
							    	<button type="submit" class="btn" style="background-color: #70299b; color: white;">
										<i class="fa fa-cloud-upload"></i> {{ __("Guardar") }}
								    </button>
								</div>
							</form>
							<label for="" class="col-form-label text-md-left" style="font-size: 10px;">
					  			<b>{{ __("Formato") }} : pdf</b>
					  			<br><b>{{ __("Tamaño max") }} : 3 MB</b>
					  		</label>
						</div>
						<div class="col-md-6" align="center">
							<br><br>
							@if($user->teacher->curriculum == null)
								<div class="alert alert-warning">
									<i class="fa fa-exclamation-circle"></i> {{ __("Aun no has subido tu curriculum") }}
								</div>
							@else
								<div class="alert alert-success">
								  <i class="fa fa-check"></i> {{ __("Tu curriculum ya ha sido subido") }}
								  <a href="{{ $user->teacher->public_url }}">{{ __("Ver") }}</a>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		    @include('partials.profile.email_password')
		</div>
	</div>
@endsection