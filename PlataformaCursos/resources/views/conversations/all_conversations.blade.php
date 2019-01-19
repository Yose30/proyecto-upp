@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
		<div class="card">
			<div class="card-header" align="center" style="background-color: rgb(112, 41, 155); color: #ffffff">{{ __("Conversaciones") }}</div>
		  	<div class="card-body">
		  		<ul class="list-group list-group-flush">
			  		@if(auth()->user()->role_id == \App\Role::ADMINISTRADOR)		
				  		@include('partials.conversations.admin')
					@endif
					@if(auth()->user()->role_id == \App\Role::PROFESOR)
						@include('partials.conversations.teacher')
					@endif
					@if(auth()->user()->role_id == \App\Role::ESTUDIANTE)
						@include('partials.conversations.student')	
					@endif
			  	</ul>
		  	</div>
		</div>
	</div>
</div>
@endsection