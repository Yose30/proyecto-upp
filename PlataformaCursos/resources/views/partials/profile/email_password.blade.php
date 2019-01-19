<div class="card">
    <div class="card-body" align="center">
    	<h4 align="center" class="card-title">{{ __("Cuenta") }}</h4>
    	@if($user->confirmed == false)
			<div class="alert alert-warning">
				<i class="fa fa-exclamation-circle"></i> {{ __("Confirma tu correo electrónico") }}
			</div>
		@endif
    	<hr/>
    	<!-- START Actualizar correo -->
    	<form method="POST" action="{{ route('profile.update_email', ['slug' => $user->slug]) }}" novalidate>
			@csrf
			@method('PUT')
			<div class="form-group row">
    			<label for="email" class="col-md-4 text-md-right">
    				{{ ("Correo") }}
    			</label> 
    			<div class="col-md-6">
    				<input 
		    			id="email"
		    			name="email"
		    			type="email" 
		    			class="form-control{{ $errors->has('email') ? ' is-invalid' : ''}}"  
		    			value="{{ old('email') ?: $user->email }}" 
		    			required
		    			autofocus 
		    		/>
					@if($errors->has('email'))
						<span class="invalid-feedback">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
    			</div>
    		</div>
	    	<button type="submit" class="btn btn-mod">
	    		{{ ("Cambiar correo") }}
	    	</button>
		</form>	
		<!-- END -->
		<hr />
		<form method="POST" action="{{ route('profile.update_password') }}" novalidate>
			@csrf
			@method('PUT')

			<div class="form-group row">
				<label for="password" class="col-md-4 text-md-right">
    				{{ ("Contraseña") }}
    			</label>
    			<div class="col-md-6">
    				<input 
    					id="password" 
						name="password" 
						type="password" 
						class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
						required 
					/>
					@if($errors->has('password'))
						<span class="invalid-feedback">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
	    		</div>
			</div>
			<div class="form-group row">
				<label for="password-confirm" class="col-md-4 text-md-right">
    				{{ ("Confirma la Contraseña") }}
    			</label>
    			<div class="col-md-6">
    				<input 
    					id="password-confirm" 
						name="password_confirmation" 
						type="password" 
						class="form-control" 
						required 
					/>
	    		</div>
			</div>
			<button type="submit" class="btn btn-mod">
	    		{{ ("Cambiar contraseña") }}
	    	</button>
		</form>
    </div>
</div>