<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>deei</title>
	</head>
	<body style="background-color: white; color: black;">
	    <h2>{{ __("Hola") }}! {{ $user_name }} {{ $last_name }}, {{ __("Bienvenido") }}(a) a deei</h2>
		<p>{{ __("Los siguientes datos son tu clave y contraseña para poder acceder a nuestra plataforma.") }}</p>
		<h3>{{ __("Clave") }}: {{ $clave }}</h3>
		<h3>{{ __("Contraseña") }}: {{ $password }}</h3>	
		<p>{{ __("Puedes acceder a través de este link") }} <a href="{{ url('/login/') }}">{{ __("Aqui") }}</a></p>
	    <hr />
	    <h3>{{ __("Gracias") }}!!</h3>
	    <h3>{{ __("Attentamente") }}</h3>
	    <h3><b>deei</b></h3>
	</body>
</html>