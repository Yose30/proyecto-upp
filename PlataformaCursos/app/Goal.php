<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Student;

class Goal extends Model
{
	protected $fillable = ['meta', 'student_id'];
    //1 a muchos (Inverso)
	//Una meta solo puede pertenecer a un usuario
    public function student(){
    	return $this->belongsTo(Student::class);
    }
}
