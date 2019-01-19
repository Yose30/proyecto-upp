<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Course;
use App\Conversation;

class Teacher extends Model
{
    //1 a muchos
    //Un maestro puede tener muchos cursos
    public function courses(){
        return $this->hasMany(Course::class);
    }
    
    //1 a 1 (Inverso)
	//Un usuario solo puede ser teacher, (no puede tener otro rol)
	public function user(){
    	return $this->belongsTo(User::class);
    }

    //1 a muchos
    //Un profesor puede tener muchas conversaciones
    public function conversations(){
        return $this->hasMany(Conversation::class);
    }

}
