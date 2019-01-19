<!-- ADMINISTRADOR -->
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
			        href="{{ route('courses.lessons', $course->slug) }}"
			    > {{ $course->nombre }}
				</a>
			</h2>
		</div>
	</div>
@endsection

@section('content')
	<div>
		<h4>{{ __("Creativos incritos") }}</h4>
		<hr>
	  	<table class="table table-hover">
	    	<thead>
	     		<tr align="center">
			        <th scope="col"></th>
			        <th scope="col">{{ __('Nombre') }}</th>
			        <th scope="col">{{ __('Correo') }}</th>
			        <th scope="col">{{ __('Avance') }}</th>
			        <th scope="col">{{ __('Fecha de inscripción') }}</th>
			        <th scope="col"></th>
	      		</tr>
	    	</thead>
	    	<tbody>
	    		@foreach($users as $user)	
	    			@foreach($course_advance->where('student_id', $user->student->id) as $student)
		        		<tr align="center">
		          			<td>
					            <img 
					              style="width:35px; height:35px; border-radius:150px;" 
					              class="img-rounded"
					              src="{{ $user->pathAttachment() }}" alt="{{ $user->name }}"
					            >
		          			</td>
		          			<td>
					            @if($user->deleted_at == NULL)
									<a href="{{ route('profile.profile', [$course->id, $user->slug]) }}" style="text-decoration: none; color: black;">
						            	{{ $user->name }} {{ $user->lastName }}
						            </a>
					            @else
									{{ $user->name }} {{ $user->lastName }}
					            @endif
		          			</td>
		          			<td>{{ $user->email }}</td>
		          			<td>{{ $student->avance }} %</td>
							<td>{{ $student->fecha_inscripcion }}</td>
		          			<td>
		          				@if($user->deleted_at != NULL)
						            <a class="btn btn-danger" type="button" style="color: white;">
						              <i class="fa fa-close"></i> {{ __("Dado de baja") }}
						            </a>
						        @endif
		          			</td>
		        		</tr>
		        	@endforeach
	      		@endforeach
	    	</tbody>
	  	</table>
	  	<div class="row justify-content-center">
	        {{ $users->links() }}
	    </div>
	</div>
@endsection