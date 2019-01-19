@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="row" align="right">
        <div class="col-md-10">
            @if($resultado1)
                <a href="{{ route('admin.mantenimiento', 2) }}" class="btn btn-info"><i class="fa fa-cogs"></i> {{ __("Dar mantenimiento") }}</a>
            @endif
            @if($resultado2)
                <!-- <a href="{{ route('admin.mantenimiento', 1) }}" class="btn btn-secondary"><i class="fa fa-cogs"></i> {{ __("Concluir mantenimiento") }}</a> -->
                <div align="center">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-circle"></i> {{ __("Cursos en mantenimiento") }}
                    </div>
                </div>
            @endif
        </div>
        <!-- @if($curso == NULL || $curso->students->count() == 0)
            <div class="col-md-2"> 
                <a href="{{ route('courses.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> {{ __("Nuevo curso") }}</a>
            </div>
        @endif -->
        <div class="col-md-2"> 
            <a href="{{ route('courses.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> {{ __("Nuevo curso") }}</a>
        </div>
    </div>
    <br>

    <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="all_courses-tab" data-toggle="tab" href="#all_courses" role="tab" aria-controls="all_courses" aria-selected="true">{{ __("Cursos") }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="altas-tab" data-toggle="tab" href="#altas" role="tab" aria-controls="altas" aria-selected="false">{{ __("Estado de cursos") }}</a>
        </li>
    </ul> -->
    <!-- <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="all_courses" role="tabpanel" aria-labelledby="all_courses-tab"> -->
            <div class="card">
                <div class="card-body">
                    <table
                        class="table table-bordered table-hover nowrap"
                        cellspacing="0"
                        id="courses-table"
                        style="width:100%"
                    >
                        <thead> 
                            <tr>
                                <th>{{ __("ID") }}</th>
                                <th>{{ __("Nombre") }}</th>
                                <th>{{ __("Prioridad") }}</th>
                                <th>{{ __("Detalles") }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        <!-- </div> -->
        <!-- <div class="tab-pane fade" id="altas" role="tabpanel" aria-labelledby="altas-tab">
            <courses-list
                :labels="{{ json_encode([
                    'nombre' => __("Nombre"),
                    'estado' => __("Estado"),
                    'activate_deactivate' => __(""),
                    'topost' => __("Publicar"),
                    'unsubscribe' => __("Dar de baja")
                ]) }}"
                route="{{ route('admin.courses_json') }}"
            >
            </courses-list>
        </div> -->
    <!-- </div> -->

@endsection
@push('scripts')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        let dt1;
        jQuery(document).ready(function() {
            dt1 = jQuery("#courses-table").DataTable({
                responsive: true,
                pageLength: 5,
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.courses') }}',
                language: {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible",
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
                    {data: 'id', visible: true},
                    {data: 'nombre'},
                    {data: 'prioridad'},
                    {data: 'information'}
                ]
            }) 
        })
    </script>
@endpush