<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    //Roles
    const ADMINISTRADOR = 1;
    const PROFESOR = 2;
    const ESTUDIANTE =3;

    //1 a 1
    //Un rol solo va a pertenecer a un solo usuario
    public function user(){
    	return $this->hasOne(User::class);
    } 
}
