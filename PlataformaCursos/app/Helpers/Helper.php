<?php

namespace App\Helpers;

class Helper{
	public static function uploadFile($key, $path){	
		//Key es el campo en la BD, y path la ubicación donde queremos guardar
		//Esto va a subir el archivo y lo va a guardar
		request()->file($key)->store($path);
		//retornara el archivo que a guardado
		return request()->file($key)->hashName();
	} 
}