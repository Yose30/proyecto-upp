<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Course;
use App\Lesson;
use App\Student;

class Result extends Model
{
    //Resultados que podra tener el estudiante
    const CORRECTO = 1;
    const INCORRECTO = 2;

    //1 a muchos (Inverso)
    //Un resultado solo puede pertenecer a un curso (Parte inversa)
    public function course(){
        return $this->belongsTo(Course::class);
    }

    //1 a muchos (Inverso)
    //Un resultado solo puede pertenecer a una leccion (Parte inversa)
    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }

    //1 a muchos (Inverso)
    //Un resultado solo puede pertenecer a un estudiante (Parte inversa)
    public function student(){
        return $this->belongsTo(Student::class);
    }
}
