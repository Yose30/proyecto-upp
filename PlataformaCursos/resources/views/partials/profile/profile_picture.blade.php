<!-- START Actualizar foto de perfil -->
<form 
	method="POST" 
	action="{{ route('profile.update_image', ['slug' => $user->slug]) }}" 
	novalidate
	enctype="multipart/form-data">
	@csrf
	@method('PUT')
	<div class="form-group">
    	<div id="estilo-image">
    		<img
	            class="img-rounded"
	            src="{{ $user->pathAttachment() }}" alt="{{ $user->name }}"
	        >
    		<input type="file" name="image" class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : ''}}" id="image">
    	</div>	
    	<label for="" class="col-form-label text-md-left" style="font-size: 10px;">
  			<br><b>{{ __("Formato") }} : jpg, png, y jpeg</b>
  		</label>
    	<button type="submit" class="btn" style="background-color: #70299b; color: white;">
			{{ __("Guardar") }}
	    </button>
	</div>
</form>
<!-- END -->