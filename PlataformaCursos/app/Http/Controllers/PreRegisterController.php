<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PreRegister;
use App\Notifications\NewPreRegister;
use App\User;
use App\Role;

//Clase para realizar el pre-registro
class PreRegisterController extends Controller
{

    public function store(Request $request){
        //Validación de los campos del pre-registro
    	$this->validate(request(), [
    		'name' => 'max:50|required|string',
    		'lastName' => 'min:8|max:50|required|string',
    		'email' => 'required|email|unique:users',
    		'domicilio' => 'required|max:100|string',
            'carrera' => 'required|max:50|string',
    		'telefono' => 'required|numeric|max:9999999999|min:1000000' 
    	]);
        //Variable para hacer la comprobació
        $gmail = 'gmail.com';
        //Comprueba que el email ingresado sea de gmail
        if (strpos($request->input('email'), $gmail) == false) {
            //Retorna un mensaje de error en el correo
            return back()->with('message', ['danger', __("El correo electrónico debe ser de Gmail")]);
        }
        //Si todo fue bien con la validación, continua con lo siguiente
        try{
            \DB::beginTransaction();
            //Creación del pre-registro
            $pre_register = PreRegister::create($request->all());
            //Envio notificaciones a los administradores del pre-registro
            $users = User::where('role_id', Role::ADMINISTRADOR)->get();
            foreach ($users as $user) {
                $user->notify(new NewPreRegister($pre_register));
            } 
            $success = true;
        }
        catch(\Exception $exception){
            \DB::rollBack();
                $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            //Retorna un mensaje de exito
            return back()->with('message', ['primary', __("Muchas gracias por registrarte, te haremos llegar un correo en caso de ser aceptado")]);
        }
        //Retorna un mensaje de fallo
        return back()->with('message', ['danger', __("Ha ocurrido un error, vuelve a intentarlo por favor")]);
    }
}
