<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>deei</title>
	</head>
	<body style="background-color: white; color: black;">
	    <h2>Hola! {{ $user_name }} {{ $lastName }}</h2>
		<p>{{ __("Muchas FELICIDADES, has concluido con exito todos los cursos.") }}.</p>
	    <b>{{ __("Gracias") }}!!</b>
	    <h3>{{ __("Attentamente") }}</h3>
	    <h3><b>deei</b></h3>
	</body>
</html>