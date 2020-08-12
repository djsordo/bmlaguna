<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreinscripcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preinscripcions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nif')->nullable();
            $table->date('f_nacimiento');
            $table->unsignedInteger('genero_id');
            $table->string('nombre');
            $table->string('apellido1');
            $table->string('apellido2')->nullable();
            $table->string('centroEducativo')->nullable();
            $table->string('domicilio');
            $table->string('localidad');
            $table->string('provincia');
            $table->integer('c_postal');
            $table->string('nombreR1');
            $table->string('apellido1R1');
            $table->string('apellido2R1')->nullable();
            $table->string('nombreR2')->nullable();
            $table->string('apellido1R2')->nullable();
            $table->string('apellido2R2')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email');
            $table->unsignedInteger('miembro_id')->nullable();
            $table->unsignedInteger('temporada_id');
            $table->string('estado');
            $table->date('f_preinscripcion');
            $table->date('f_pago')->nullable();
            $table->unsignedInteger('nPreinscripcion');
            $table->string('socio', 1)->nullable();
            $table->string('nRecibo')->nullable();
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
        Schema::dropIfExists('preinscripcions');
    }
}
