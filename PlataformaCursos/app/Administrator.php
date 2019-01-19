<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Course;
use App\User;

class Administrator extends Model
{
    //1 a muchos
    //Un administrador puede tener muchos cursos
    public function courses(){
        return $this->hasMany(Course::class);
    }

    //1 a 1 (Inverso)
	//Un usuario solo puede ser administrador, (no puede tener otro rol)
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
