<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformesFisicoTecnicoTacticosTable extends Migration
{
    /**
     * Informe físico-técnico-táctico: un registro por jugador y temporada.
     */
    public function up()
    {
        Schema::create('informes_fisico_tecnico_tacticos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('miembro_id');
            $table->unsignedInteger('temporada_id');
            $table->unsignedInteger('categoria_id')->nullable();
            $table->longText('texto')->nullable();
            $table->unsignedInteger('tecnico_id')->nullable();
            $table->timestamps();

            $table->unique(['miembro_id', 'temporada_id']);

            $table->foreign('miembro_id')->references('id')->on('miembros')->onDelete('cascade');
            $table->foreign('temporada_id')->references('id')->on('temporadas')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->foreign('tecnico_id')->references('id')->on('miembros')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('informes_fisico_tecnico_tacticos');
    }
}
