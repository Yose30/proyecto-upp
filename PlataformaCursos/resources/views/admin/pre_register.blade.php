@extends('layouts.app')

@section('content')
	<div class="card">
	  	<div class="card-header" align="center"><b>{{ __("Creativos pre-registrados") }}</b></div>
	  	<div class="card-body">
	    	<table class="table table-hover">
		    	<thead>
		     		<tr>
				        <th scope="col">{{ __('Nombre') }}</th>
				        <th scope="col">{{ __("Correo") }}</th>
				        <th scope="col">{{ __('Fecha de registro') }}</th>
				        <th scope="col">{{ __("Eliminar") }}</th>
				        <th scope="col"></th>
		      		</tr>
		    	</thead>
		    	<tbody>
          			@forelse($registers as $register)
						<tr>
							<td>{{ $register->name }} {{ $register->lastName }}</td>
							<td>{{ $register->email }}</td>
							<td>{{ $register->created_at->format('d/m/Y') }}</td>
							<td>
					            <form action="{{ route('admin.delete_student', $register->id) }}" method="POST">
						          	@csrf
						          	@method('delete')
						          	<button class="btn btn-danger" type="submit">
						            	<i class="fa fa-trash" style="color: white;"></i>
						          	</button>
						      	</form>
							</td>
							<td>
								<button class="btn btn-primary" onclick="mostrar('{{$register->name}}', '{{$register->lastName}}', '{{$register->carrera}}', '{{$register->email}}', '{{$register->domicilio}}', '{{$register->telefono}}', '{{$register->created_at->format('d/m/Y')}}')">
									<i class="fa fa-exclamation-circle"></i> {{ __("Información") }}
								</button>
							</td>
						</tr>
          			@empty
						<tr>
                            <td colspan="4">
                            	<div class="alert alert-dark" role="alert" align="center">
									<i class="fa fa-exclamation"></i> {{ __("No hay creativos registrados") }}
								</div>
                            </td>
                        </tr>
          			@endforelse
		    	</tbody>
		  	</table>
		  	<div class="row justify-content-center">
		        {{ $registers->links() }}
		    </div>
	  	</div>
	</div>
	@include('partials.students.information')
@endsection

@push('scripts')
	<script>
		function mostrar(nombre, apellidos, carrera, email, domicilio, telefono, fecha){
			$('#fecha').html(fecha);
			$('#nombre').html(nombre+" "+apellidos);
			$('#carrera').html(carrera);
			$('#email').html(email);
			$('#domicilio').html(domicilio);
			$('#telefono').html(telefono);

			let $form = $("<form id='formstudent'></form>");
            $form.append(`<input type="hidden" name="nameu" value="${nombre}" />`);
            $form.append(`<input type="hidden" name="lastName" value="${apellidos}" />`);
            $form.append(`<input type="hidden" name="carrera" value="${carrera}" />`);
            $form.append(`<input type="hidden" name="email" value="${email}" />`);
            $form.append(`<input type="hidden" name="domicilio" value="${domicilio}" />`);
            $form.append(`<input type="hidden" name="telefono" value="${telefono}" />`);
            $('#modal-inf').find('#modal-form').html($form);
			$('#modal-inf').modal('show');
		}

		jQuery(document).ready(function(){
			jQuery(document).on("click", "#btn-aprobar", function(e){
				jQuery.ajax({
				    url: '{{ route('admin.approve_student') }}',
				    type: 'POST',
				    headers: {
				        'x-csrf-token': $("meta[name=csrf-token]").attr('content')
				    },
				    data: {
				    	info: $("#formstudent").serialize()
				    },
				    success: (res) => {
                        if(res.res) {
                            console.log('Correcto');
                            $('#modal-inf').find('#btn-aprobar').hide();
                            $('#modal-inf').find('#btn-eliminar').hide();
                            $('#modal-inf').find('#respuesta').html('<div class="alert alert-success"><i class="fa fa-check"></i> {{ __("Aprobado correctamente") }}</div>');

                        } else {
                           	console.log('Incorrecto');
                           	$('#modal-inf').find('#respuesta').html('<div class="alert alert-danger"><i class="fa fa-close"></i> {{ __("Los datos no pudieron guardarse") }}</div>');
                        }
                    }
				});
			});
		});
	</script>
@endpush