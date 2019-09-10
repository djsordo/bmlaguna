<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiembrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miembros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido1');
            $table->string('apellido2');
            $table->date('f_nacimiento');
            $table->unsignedInteger('genero_id');
            $table->string('nif');
            $table->unsignedinteger('madre_id');
            $table->unsignedinteger('padre_id');
            $table->string('domicilio');
            $table->string('localidad');
            $table->string('provincia');
            $table->integer('c_postal');
            $table->integer('dorsal');
            $table->boolean('socio');
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
        Schema::dropIfExists('miembros');
    }
}
