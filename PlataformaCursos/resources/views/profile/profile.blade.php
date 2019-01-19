@extends('layouts.app')

@push('styles')
	<style type="text/css">
	    .img-rounded {
		    width:150px;
		    height:150px;
		    border-radius:150px;
		}
	</style>
@endpush

@section('content')
	<div class="row">
		<div class="col-md-3">
			<div class="card">
		      	<div class="card-body" align="center">
					<img
			            class="img-rounded"
			            src="{{ $user->pathAttachment() }}" alt="{{ $user->name }}"
			        > 
			        <br><br><h6>{{ $user->email }}</h6>
			        <h6>Clave: {{ $user->clave }}</h6>
		      	</div>
		    </div> 
		    @if(auth()->user()->role_id == \App\Role::PROFESOR)
				<br>
				<div align="center">
					<a class="btn btn-outline-secondary" href="{{ route('teacher.courses.enrolled_students', $course->id) }}"><i class="fa fa-reply"></i> {{ __("Volver") }}</a>
				</div>
		    @endif 
		    @if(auth()->user()->role_id == \App\Role::ADMINISTRADOR)
	      		@if($user->role_id == \App\Role::PROFESOR)
	      			@if($courses->count() == 0)
						<br><br>
						<div align="right">
							<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#exampleModal">
			                  <i class="fa fa-close" style="color: white;"></i> {{ __("Dar de baja formador") }}
			                </button>
						</div>
					@endif
				@else
					<br><br>
					<div align="right">
						<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#exampleModal">
		                  <i class="fa fa-close" style="color: white;"></i> {{ __("Dar de baja creativo") }}
		                </button>
					</div>
	      		@endif
	      		@include('partials.profile.confirm_delete')
		    @endif
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<h3 align="center">{{ $user->name }} {{ $user->lastName }}</h3>
					<hr />
					@if(auth()->user()->role_id == \App\Role::ESTUDIANTE)
						<h5 align="center">{{ $user->teacher->profesion }}</h5><br>
						<h6><b>{{ __("Curso") }}</b></h6>
						<a 
							style="text-decoration: none; color: black;" 
							href="{{ route('courses.course_details', $course->slug) }}"
						>
							{{ $course->nombre }}
						</a><br><br>
						@include('partials.teachers.datos')
						<br>
			            <a  
			              class="btn btn-primary" 
			              href="{{ route('conversations.chat_student', $user->teacher->id) }}"
			            >
			              <i class="fa fa-commenting-o"></i> {{ __("Enviar mensaje") }}
			            </a>
			        @endif
					@if(auth()->user()->role_id == \App\Role::PROFESOR)
						@include('partials.students.datos')
						<h6><b>{{ __("Avance del curso") }}</b>: {{ $avance_course->avance }} %</h6>
						@include('partials.courses.puntos')
						<a  
			              class="btn btn-primary" 
			              href="{{ route('conversations.chat_teacher', $user->id) }}"
			            >
			              <i class="fa fa-commenting-o"></i> {{ ("Enviar mensaje") }}
			            </a>
			            <br><br><br>
						<div align="right">
							<button class="btn btn-danger btnBaja" type="button" data-toggle="modal" data-target="#exampleModal1" data-id="{{$user->id}}">
			                  <i class="fa fa-close" style="color: white;"></i> {{ __("Solicitar baja") }}
			                </button>
						</div>
						@include('partials.profile.request_low')
					@endif
					@if(auth()->user()->role_id == \App\Role::ADMINISTRADOR)
						@if($user->role_id == \App\Role::ESTUDIANTE)
							@include('partials.students.datos')
							<h6><b>{{ __("Cursos") }}</b></h6>
							@foreach($courses as $my_course)
								@foreach($all_courses->where('id', $my_course->course_id) as $course)
									<div style="display: flex;">
										@include('partials.courses.card_course')
					 					@include('partials.courses.course_information') 
									</div>
									<br><br> 
								@endforeach
							@endforeach
						@else
							<h5 align="center">{{ $user->teacher->profesion }}</h5>
							<br>
				            <div align="right">
				            	<a  
					            	class="btn btn-primary" 
					              	href="{{ route('conversations.chat_admin', $user->teacher->id) }}"
					            >
					              	<i class="fa fa-commenting-o"></i> {{ __("Enviar mensaje") }}
					            </a>
				            </div>
				            <br>
							@include('partials.teachers.datos')
							<br><h6><b>{{ __("Cursos") }}</b></h6>
					 		@forelse($courses as $course)
								<div class="col-md-5" style="display: flex;">
									@include('partials.courses.card_course')
								</div>
							@empty
								<div class="alert alert-secondary" role="alert">
									<i class="fa fa-exclamation"></i> {{ _("El formador aún no tiene cursos asignados") }}
								</div>
							@endforelse
						@endif
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		let modal = jQuery("#exampleModal1");
		jQuery(document).ready(function() {
			jQuery(document).on("click", '.btnBaja', function (e) {
                e.preventDefault();
                const id = jQuery(this).data('id');
                modal.find('#modalAction').text('{{ __("Enviar") }}').show();
                let $form = $("<form id='requestLow'></form>");
                $form.append(`<input type="hidden" name="user_id" value="${id}" />`);
                $form.append(`<p>{{ __("Porfavor escriba las razones para dar de baja a este usuario") }}</p>`);
                $form.append(`<textarea class="form-control" name="message"></textarea>`);
                modal.find('.modal-body').html($form);
                modal.modal();
            });
		})

		jQuery(document).on("click", "#modalAction", function (e) {
            jQuery.ajax({
                url: '{{ route('teacher.send_email_low') }}',
                type: 'POST',
                headers: {
                    'x-csrf-token': $("meta[name=csrf-token]").attr('content')
                },
                data: {
                    info: $("#requestLow").serialize()
                },
                success: (res) => {
                    if(res.res) { 
                        modal.find('#modalAction').hide();
                        modal.find('.modal-body').html('<div class="alert alert-success">{{ __("Enviado correctamente") }}</div>');
                    } else {
                        modal.find('.modal-body').html('<div class="alert alert-danger">{{ __("Ha ocurrido un error enviando el correo") }}</div>');
                    }
                } 
            })
        })
	</script>
@endpush

