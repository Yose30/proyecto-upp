<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Course;

class Objective extends Model
{
    //1 a muchos (Inverso)
    //Un objetivo solo puede pertenecer a un curso
    public function course(){
        return $this->belongsTo(Course::class);
    }
}
