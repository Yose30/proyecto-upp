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
		        <h6 align="left">{{ __("Clave") }}: {{ $user->clave }}</h6>
		      </div>
		    </div>
		</div>
		<div class="col-md-9">
		    @include('partials.profile.email_password')
		</div>
	</div>
@endsection