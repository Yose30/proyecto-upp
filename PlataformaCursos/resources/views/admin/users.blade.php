@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endpush
@section('content')
    @include('partials.teachers.new_teacher')
    <div align="right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#new_teacher">
            <i class="fa fa-user-plus"></i> {{ __("Nuevo formador") }}
        </button>
    </div>
    <nav>
	  	<div class="nav nav-tabs" id="nav-tab" role="tablist">
	    	<a class="nav-item nav-link active" id="nav-students-tab" data-toggle="tab" href="#nav-students" role="tab" aria-controls="nav-students" aria-selected="true">{{ __("Creativos activos") }}</a>
            <a class="nav-item nav-link" id="nav-students_in-tab" data-toggle="tab" href="#nav-students_in" role="tab" aria-controls="nav-students_in" aria-selected="true">{{ __("Creativos inactivos") }}</a>
	    	<a class="nav-item nav-link" id="nav-teachers-tab" data-toggle="tab" href="#nav-teachers" role="tab" aria-controls="nav-teachers" aria-selected="false">{{ __("Formadores") }}</a>
	  </div>
	</nav>
	<div class="tab-content" id="nav-tabContent">
	  	<div class="tab-pane fade show active" id="nav-students" role="tabpanel" aria-labelledby="nav-students-tab">
	  		@include('partials.users.table_user', ['type_user' => 'students'])
	  	</div>
        <div class="tab-pane fade" id="nav-students_in" role="tabpanel" aria-labelledby="nav-students_in-tab">
            <h6><b>{{ __("AVISO") }}</b>: {{ __("Si da de baja definitiva al creativo, ya no podrá activarlo después") }}</h6>
            @include('partials.users.table_user', ['type_user' => 'students_inactive'])
        </div>
	  	<div class="tab-pane fade" id="nav-teachers" role="tabpanel" aria-labelledby="nav-teachers-tab">
	  		@include('partials.users.table_user', ['type_user' => 'teachers'])
	  	</div>
	</div>
    @include('partials.users.inf-for-admin')
@endsection
@push('scripts')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        let dt1;
        let dt2;
        let dt3;
        let modal = jQuery("#appModal");
        jQuery(document).ready(function() {
            dt1 = jQuery("#students-table").DataTable({
                pageLength: 5,
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.students') }}',
                language: {
                	"sProcessing":     "Procesando...",
				    "sLengthMenu":     "Mostrar _MENU_ registros",
				    "sZeroRecords":    "No se encontraron resultados",
				    "sEmptyTable":     "Ningún dato disponible en esta tabla",
				    "sInfo":           "Registro _START_ de _END_",
				    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				    "sInfoPostFix":    "",
				    "sSearch":         "Buscar:",
				    "sUrl":            "",
				    "sInfoThousands":  ",",
				    "sLoadingRecords": "Cargando...",
				    "oPaginate": {
				        "sFirst":    "Primero",
				        "sLast":     "Último",
				        "sNext":     "Siguiente",
				        "sPrevious": "Anterior"
				    },
                },
                columns: [
                    {data: 'id', visible: false},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'information'}
                ]
            }) 

            jQuery(document).on("click", '.btnInformation', function (e) {
                e.preventDefault();
                const id = jQuery(this).data('id');
                const nombre = jQuery(this).data('nombre');
                const lastname = jQuery(this).data('lastname');
                const cuatrimestre = jQuery(this).data('cuatrimestre');
                const carrera = jQuery(this).data('carrera');
                const domicilio = jQuery(this).data('domicilio');
                const telefono = jQuery(this).data('telefono');
                modal.find('.modal-title').text('{{ __("Datos personales") }}');
                let $contenido = $("<div id='infStudent'></div>");
                $contenido.append(`<h6><b>Nombre</b>: ${nombre} ${lastname}</h6>`);
                $contenido.append(`<h6><b>Carrera</b>: ${carrera}</h6>`);
                $contenido.append(`<h6><b>Domicilio</b>: ${domicilio}</h6>`);
                $contenido.append(`<h6><b>Telefono</b>: ${telefono}</h6>`);
                modal.find('.modal-body').html($contenido);
                modal.modal();
            }); 

            dt2 = jQuery("#students_inactive-table").DataTable({
                pageLength: 5,
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.students_inactive') }}',
                language: {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Registro _START_ de _END_",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                },
                columns: [
                    {data: 'id', visible: false},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'information'}
                ]
            })

            dt3 = jQuery("#teachers-table").DataTable({
                pageLength: 5,
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.teachers') }}',
                language: {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Registro _START_ de _END_",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                },
                columns: [
                    {data: 'id', visible: false},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'information'}
                ]
            }) 

            jQuery(document).on("click", '.btnInfTeacher', function (e) {
                e.preventDefault();
                const id = jQuery(this).data('id');
                const nombre = jQuery(this).data('nombre');
                const lastname = jQuery(this).data('lastname');
                const profesion = jQuery(this).data('profesion');
                const biografia = jQuery(this).data('biografia');
                modal.find('.modal-title').text('{{ __("Datos personales") }}');
                let $contenido = $("<div id='infStudent'></div>");
                $contenido.append(`<h6><b>Nombre</b>: ${nombre} ${lastname}</h6>`);
                $contenido.append(`<h6><b>Profesión</b>: ${profesion}</h6>`);
                $contenido.append(`<h6><b>Biografia</b>: ${biografia}</h6>`);
                modal.find('.modal-body').html($contenido);
                modal.modal();
            });
            
            jQuery(document).on("click", "#btn-guardar", function(e){
                jQuery.ajax({
                    url: '{{ route('teacher.store') }}',
                    type: 'POST',
                    headers: {
                        'x-csrf-token': $("meta[name=csrf-token]").attr('content')
                    },
                    data: {
                        'nameu': $('input[name=nameu]').val(),
                        'lastname': $('input[name=lastname]').val(),
                        'email': $('input[name=email]').val(),
                        'profesion': $('input[name=profesion]').val(),
                    },
                    success: (res) => {
                        if(res.res){
                            $("#form_new_teacher")[0].reset();
                            $('#res-validate').hide();
                            $('#res-correcta').show();
                        }
                        else{
                            $('#res-correcta').hide();
                            $('#res-validate').show();
                        }
                    },
                });
            });
        })
    </script>
@endpush