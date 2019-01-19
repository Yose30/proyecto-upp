<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Tabla para los roles de Maestro(Administrador) y Estudiante
        Schema::create('roles', function(Blueprint $table){
            $table->increments('id');
            $table->string('nombre')->comment('Rol del usuario');
            $table->timestamps();
        });

        //Tabla para registro de usuarios
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->default(\App\Role::ESTUDIANTE); 
            //El rol por defecto sera ESTUDIANTE
            $table->foreign('role_id')->references('id')->on('roles'); 
            //Relación a la tabla roles
            $table->string('name');
            $table->string('lastName')->nullable();
            $table->string('email', 50)->unique();
            $table->string('clave', 50)->unique();
            $table->string('password');
            $table->string('view_password');
            $table->string('image')->default('deei-image.jpg'); 
            //Foto de perfil que tendra cada usuario, puede o no poner la imagen
            $table->string('slug');
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->rememberToken();
            $table->timestamps();
            //Para borrar el usuario pero solo de manera logica y no fisica
            $table->softDeletes();
        });

        Schema::create('administrators', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('administrators');
    }
}
