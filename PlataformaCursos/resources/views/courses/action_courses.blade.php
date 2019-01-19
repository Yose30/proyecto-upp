@extends('layouts.app')

@section('content')
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
@endsection