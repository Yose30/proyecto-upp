<?php

namespace App\Policies;

use App\User;
use App\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    //Funcion para saber si el usuario se puede inscribir a este curso
    public function inscribe(User $user, Course $course){
        //Se podra inscribir si no esta vinculado al curso
        return ! $course->students->contains($user->student->id);
        //Comprueba si en la relacion que se tiene de muchos a muchos alguno de los estudiantes tiene el id student, que es el usuario actual
    }

    //Funcion para que el usuario pueda escribir una valoracion siempre que no haya escrito una anteriormente y que este inscrito en el curso
    public function review(User $user, Course $course){
        return ! $course->reviews->contains('user_id', $user->id);
        //Si no a hecho alguna valoracion el estudiante, podra hacerlo
    }
    
}
