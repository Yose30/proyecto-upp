<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>deei</title>
	</head>
	<body style="background-color: white; color: black;">
	    <h2>Hola! {{ $student_name }} {{ $student_lastName }}</h2>
		<p>{{ __("Ya puedes acceder al curso") }} <b>{{ $course_name }}</b> {{ __("a cargo del formador") }} {{ $teacher_name }} {{ $teacher_lastname }}.</p>
		<p>{{ __("Puedes acceder a través de este link") }} <a href="{{ url('/courses/'.$slug) }}">{{ __("Aqui") }}</a></p>
	    <b>{{ __("Gracias") }}!!</b>
	    <h3>{{ __("Attentamente") }}</h3>
	    <h3><b>deei</b></h3>
	</body>
</html>