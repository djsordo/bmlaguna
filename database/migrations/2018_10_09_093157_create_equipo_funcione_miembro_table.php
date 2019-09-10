<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipoFuncioneMiembroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_funcione_miembro', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('funcione_id');
            $table->unsignedInteger('miembro_id');
            $table->unsignedInteger('equipo_id');

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
        Schema::dropIfExists('equipo_funcione_miembro');
    }
}
