<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Course;
use App\Question;
use App\Result;
use App\Advance;
use App\File;

class Lesson extends Model
{
    //Constantes para indicar si la lección a sido terminada o no
    const PENDIENTE = 1;
    const CONCLUIDO = 2;

    protected $fillable = ['id', 'titulo', 'link_video', 'prioridad', 'descripcion', 'course_id'];
    protected $withCount = ['questions'];

    //1 a muchos (Inverso)
    //Una leccion solo puede pertencer a un curso
    public function course(){
    	return $this->belongsTo(Course::class);
    }

    //1 a muchos
    //UNa leccion puede tener muchas preguntas
    public function questions(){
        return $this->hasMany(Question::class);
    }

    //1 a muchos
    //Una leccion puede tener muchos resultados
    public function results(){
        return $this->hasMany(Result::class);
    }

    //1 a muchos
    //Una leccion puede tener muchos avances
    public function advances(){
        return $this->hasMany(Advance::class);
    }

    //1 a muchos
    //Una lección puede tener muchos archivos
    public function files(){
        return $this->hasMany(File::class);
    }

    //Para obtener el slug, en la busqueda
    public function getRouteKeyName(){
        return 'slug';
    }

    protected static function boot () {
        parent::boot();
        static::saving(function(Lesson $lesson) {
            if( ! \App::runningInConsole() ) {
                $lesson->slug = str_slug($lesson->titulo, "-");
            }
        });
        static::saved(function(Lesson $lesson){
            if(! \App::runningInConsole()){
                if(request('questions')){
                    foreach (request('questions') as $key => $question_input) {
                        Question::updateOrCreate(['id' => request('question_id'.$key)], ['lesson_id' => $lesson->id,
                            'question' => $question_input
                        ]);
                    }
                }
            }
        });
    }
}
