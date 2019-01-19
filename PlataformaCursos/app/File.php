<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Lesson;

class File extends Model
{
	protected $guarded = [];
 
    public function getSizeInKbAttribute(){
        return number_format($this->size / 1024, 1);
    }
    //1 a muchos (Inverso)
    //Un archivo solo puede pertenecer a un usuario (Parte inversa)
    public function user(){
        return $this->belongsTo(User::class);
    }

	//1 a muchos (Inverso)
	//Un archivo solo puede pertenecer a una leccion
	public function lesson(){
		return $this->belongsTo(Lesson::class);
	}    
}
