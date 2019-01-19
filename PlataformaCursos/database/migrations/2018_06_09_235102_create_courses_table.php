<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('administrator_id');
            $table->foreign('administrator_id')->references('id')->on('administrators');
            $table->unsignedInteger('teacher_id')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers');
            //Relacion con la tabla teacher, para saber quien publico el curso
            $table->string('nombre', 100)->unique(); //Titulo del curso
            $table->text('descripcion'); //descripcion del curso
            $table->text('objetivo'); //¿Cual sera el objetivo del curso?
            $table->string('slug');
            $table->string('imagen')->nullable(); 
            //Imagen que se mostrara en el curso
            $table->integer('prioridad')->unique(); //establecer orden de los cursos
            $table->enum('estado', [\App\Course::PUBLICADO, \App\Course::PENDIENTE])->default(\App\Course::PENDIENTE);
            $table->integer('tiempo'); //Tiempo que estara definido para el curso
            //Indica si el curso ya ha sido publicado o no
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
