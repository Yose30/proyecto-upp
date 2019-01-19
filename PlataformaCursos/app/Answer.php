<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;

class Answer extends Model
{
    protected $fillable = ['question_id', 'answer', 'type'];

    //1 a muchos (Inverso)
    //Una respuesta solo puede pertenecer a una pregunta
    public function question(){
    	return $this->belongsTo(Question::class);
    }
}
