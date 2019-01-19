<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lesson;
use App\Answer;
use App\Result;

class Question extends Model
{
    protected $fillable = ['question', 'lesson_id'];
    protected $withCount = ['answers'];
    //1 a muchos (Inverso)
    //Una pregunta solo puede pertenecer a una leccion
    public function lesson(){
    	return $this->belongsTo(Lesson::class);
    }

    //1 a muchos
    //Una pregunta puede tener muchas respuestas
    public function answers(){
    	return $this->hasMany(Answer::class);
    }

    protected static function boot () {
        parent::boot();
        static::saved(function(Question $question){
            if(! \App::runningInConsole()){
                if(request('answers')){
                    foreach (request('answers') as $key => $answer_input) {
                        Answer::updateOrCreate(['id' => request('answer_id'.$key)], [
                            'question_id' => $question->id,
                            'answer' => $answer_input,
                            'type' => \App\Result::INCORRECTO
                        ]);
                    }
                }
            }
        });
    }
}
