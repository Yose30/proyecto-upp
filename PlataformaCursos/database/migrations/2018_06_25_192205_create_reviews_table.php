<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Tabla para poder hacer una valoracion al curso
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses');
            //Curso al que correspondera la valoracion
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users'); 
            //El usuario que hizo la valoración
            $table->integer('rating'); //El raiting que el usuario dara al curso
            $table->text('comentario')->nullable(); //Comentario hacia el curso
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
        Schema::dropIfExists('reviews');
    }
}
