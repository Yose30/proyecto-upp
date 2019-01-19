<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Conversation;

class Message extends Model
{
    protected $fillable = ['message', 'user_id', 'conversation_id'];

    //1 a muchos
    //Un mensaje solo podra pertenecer a un usuario
    public function user(){
        return $this->belongsTo(User::class);
    }

    //1 a muchos (Inversa)
    //Un mensaje solo podra pertenecer a una conversación
    public function conversation(){
        return $this->belongsTo(Conversation::class);
    }
}
