<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Goal;
use App\Course;
use App\Result;
use App\Advance;

class Student extends Model
{
    protected $fillable = [
        'id','user_id', 'cuatrimestre', 'carrera', 'domicilio', 'telefono'
    ];
    protected $appends = ['courses_formatted'];
    
    //1 a 1 (Inverso)
	//Un usuario solo puede ser estudiante, (no puede tener otro rol)
	public function user(){
    	return $this->belongsTo(User::class);
    }

    //1 a muchos
    //Un estudiante puede tener muchas metas
    public function goals(){
        return $this->hasMany(Goal::class);
    }

    //Muchos a muchos
    //Un estudiante puede estar en varios cursos
    public function courses(){
        return $this->belongsToMany(Course::class)->withPivot('situacion');
    }

    //1 a muchos
    //Un estudiante puede tener muchos resultados
    public function results(){
        return $this->hasMany(Result::class);
    }

    //1 a muchos
    //Un estudiante puede tener muchos avances
    public function advances(){
        return $this->hasMany(Advance::class);
    }

    public function getCoursesFormattedAttribute(){
        return $this->courses->pluck('nombre')->implode('<br /> ');
    }
}
