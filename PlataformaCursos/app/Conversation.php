<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Message;
use App\Teacher;
use App\User;

class Conversation extends Model
{
    protected $fillable = ['id', 'user_id', 'teacher_id'];
    //1 a muchos
    //Una conversación puede tener muchos mensajes
    public function messages(){
        return $this->hasMany(Message::class);
    }

    //1 a muchos (Inverso)
    //Una conversaciòn solo puede pertenecer a un profesor
    public function teacher(){
    	return $this->belongsTo(Teacher::class);
    }

    //1 a muchos (Inverso)
    //Una conversaciòn solo puede pertenecer a un usuario
    public function user(){
        return $this->belongsTo(User::class);
    }
}
