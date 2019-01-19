<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Course;
use App\Lesson;
use App\Student;

class Advance extends Model
{
    //1 a muchos (Inverso)
    //Un avance solo puede pertenecer a un curso (Parte inversa)
    public function course(){
        return $this->belongsTo(Course::class);
    }

    //1 a muchos (Inverso)
    //Un avance solo puede pertenecer a una leccion (Parte inversa)
    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }

    //1 a muchos (Inverso)
    //Un avance solo puede pertenecer a un estudiante (Parte inversa)
    public function student(){
        return $this->belongsTo(Student::class);
    }
}
