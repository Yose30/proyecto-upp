<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCourseStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //Tabla pivote para la relacion muchos a muchos
    public function up()
    {
        //El nombre de la tabla tiene que ir separado por_ y ordenado por orden alfabetico, tiene que ir el nombre en singular de las dos tablas que se relacionaran
        Schema::create('course_student', function(Blueprint $table){
            //Cursos y los estudiantes que tiene cada uno
            $table->unsignedInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses');
            //Estudiantes y el curso o los cursos al que estan incritos
            $table->unsignedInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->enum('situacion', [
                \App\Course::CURSANDO, 
                \App\Course::CURSADA
            ])->default(\App\Course::CURSANDO);
            //Si el curso no a sido cursado, esta siendo cursado y ya esta cursado
            //Indica si el curso a sido completado o no
            $table->integer('avance')->default(0);
            $table->datetime('fecha_inscripcion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
