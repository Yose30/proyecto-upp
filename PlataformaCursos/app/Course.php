<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Student;
use App\Administrator;
use App\Teacher;
use App\Objective;
use App\Category;
use App\Lesson;
use App\Review;
use App\Result;
use App\Advance;

class Course extends Model
{
    //Estados del curso
    const PUBLICADO = 1;
    const PENDIENTE = 2;
    //Situación del curso
    const CURSANDO = 1;
    const CURSADA = 2;

    protected $fillable = ['id', 'administrator_id', 'teacher_id', 'nombre', 'estado', 'descripcion', 'objetivo', 'imagen', 'prioridad', 'tiempo'];

    protected $withCount = ['students', 'reviews', 'lessons', 'objectives']; 
    //Obtiene el numero de estudiantes inscritos al curso y el numero de valoraciones hechas

    protected static function boot () {
        parent::boot();
        //Mediante el evento creating se creara el slug mientras se este creando el curso, siempre y cuando no se este creando un usuario desde la consola
        static::saving(function(Course $course) {
            if( ! \App::runningInConsole() ) {
                $course->slug = str_slug($course->nombre, "-");
            }
        });
    }

    //Muchos a muchos
    //Un curso puede tener muchos estudiantes
    public function students(){
        return $this->belongsToMany(Student::class)->withPivot('situacion');
    }

    //1 a muchos (Inverso)
    //Un curso solo puede pertenecer a un administrador (Parte inversa)
    public function administrator(){
        return $this->belongsTo(Administrator::class);
    }

    //1 a muchos (Inverso)
    //Un curso solo puede pertenecer a un maestro (Parte inversa)
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    //1 a muchos
    //Un curso podra tener muchos objetivos
    public function objectives(){
    	return $this->hasMany(Objective::class);
    }

    //1 a muchos
    //Un curso puede tener muchas lecciones
    public function lessons(){
        return $this->hasMany(Lesson::class);
    }

    //1 a muchos
    //Un curso puede tener muchas valoraciones
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    
    //1 a muchos
    //Un curso puede tener muchos resultados
    public function results(){
        return $this->hasMany(Result::class);
    }

    //1 a muchos
    //Un curso puede tener muchos avances
    public function advances(){
        return $this->hasMany(Advance::class);
    }

    //Metodo para poder acceder a la imagen del curso
    public function pathAttachment(){
        return url("/images/courses/".$this->imagen);
    }

    //Para obtener el slug, en la busqueda
    public function getRouteKeyName(){
        return 'slug';
    }

    //Obtendra el average del valor que se pasara
    //Modificacion del valor de rating
    public function getRatingAttribute(){ 
        //Atributo perzsonalizado para devolver un valor nuevo, debe empezar con get y terminar con Attribute, en medio debe ir el nombre del atributo, y ese mismo nombre tiene que ir en la vista, si se agrega otra palabra debe ir separado por _
        return $this->reviews->avg('rating');
    }
}
