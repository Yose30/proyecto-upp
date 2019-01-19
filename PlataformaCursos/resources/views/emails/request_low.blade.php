<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>deei</title>
	</head>
	<body style="background-color: white; color: black;">
		<h3>{{ __("Solicitud de baja de la plataforma") }} deei</h3>
	    <h2><b>{{ __("Mensaje") }}</b></h2>
		<p>{{ $message }}</p>
		<h3>{{ __("Creativo") }}: <a href="{{ url('profile/0/'.$student_slug) }}">{{ $student_name }}</a></h3>	
	    <hr />
	    <b>{{ __("Gracias") }}</b>
	    <h3>{{ __("Attentamente") }}</h3>
	    <h3><b>{{ $profesor }}</b></h3>
	</body>
</html>