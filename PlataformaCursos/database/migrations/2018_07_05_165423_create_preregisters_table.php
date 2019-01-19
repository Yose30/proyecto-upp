<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreregistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastName')->nullable();
            $table->string('carrera');
            $table->string('email', 50)->unique();
            $table->string('domicilio');
            $table->string('telefono');
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
        Schema::dropIfExists('preregisters');
    }
}
