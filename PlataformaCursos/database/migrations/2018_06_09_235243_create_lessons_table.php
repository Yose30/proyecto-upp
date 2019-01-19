<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            //Curso al que pertenecera la leccion
            $table->string('titulo', 100)->unique(); //Titulo de la leccion
            $table->text('descripcion'); //Descripcion de la leccion
            //Link del video a mostrar en cada una de las lecciones
            $table->string('link_video', 150)->unique();
            $table->integer('prioridad')->nullable(); //establecer orden de las lecciones
            $table->string('slug');
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
        Schema::dropIfExists('lessons');
    }
}
