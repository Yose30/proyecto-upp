<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Course;
use App\User;

class Review extends Model
{
    //Para no tener problemas con la asignaciòn masiva
	protected $fillable = ['course_id', 'user_id', 'rating', 'comentario'];

	//1 a muchos (Inverso)
	//Una valoracion pertenece a un curso
	public function course(){
    	return $this->belongsTo(Course::class);
    }

    //1 a muchos (Inverso)
    //Una revision pertenecera aun solo usuario
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
