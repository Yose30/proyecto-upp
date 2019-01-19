<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Role;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/courses/all_courses';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //Sobreescribir metodo logout para cerrar sesion, y nos ubique en la vista login
    public function logout(){
        auth()->logout(); //Para poder cerrar sesión de la aplicación
        session()->flush(); //Limpiar todas las sesiones
        return redirect('/login');
    }

    public function redirectPath(){
        if(auth()->user()->role_id == Role::ESTUDIANTE){
            return '/courses/registered_courses';
        }
        if(auth()->user()->role_id == Role::PROFESOR){
            return '/teacher/courses/assigned';
        }
        if(auth()->user()->role_id == Role::ADMINISTRADOR){
            return '/admin/inicio';
        }
    }
}
