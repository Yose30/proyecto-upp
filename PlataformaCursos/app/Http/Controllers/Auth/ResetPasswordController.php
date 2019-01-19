<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Role;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
