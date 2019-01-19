<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>deei</title>
	</head>
	<body style="background-color: white; color: black;">
	    <h2>Hola! {{ $teacher_name }} {{ $teacher_lastname }}</h2>
		<p>{{ __("El curso") }} <b>{{ $course_name }}</b> {{ __("le ha sido asignado, y ya se encuentra disponible en la plataforma") }}.</p>
		<p>{{ __("Puede acceder a través de este link") }} <a href="{{ url('/teacher/courses/assigned') }}">{{ __("Aqui") }}</a></p>
	    <h3>{{ __("Gracias") }}!!</h3>
	    <h3>{{ __("Attentamente") }}</h3>
	    <h3><b>deei</b></h3>
	</body>
</html>