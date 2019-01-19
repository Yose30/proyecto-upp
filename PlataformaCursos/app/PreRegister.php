<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreRegister extends Model
{
    protected $fillable = [
        'id','name', 'lastName', 'email', 'cuatrimestre', 'carrera', 'domicilio', 'telefono'
    ];
}
