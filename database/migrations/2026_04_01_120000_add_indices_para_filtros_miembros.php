<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndicesParaFiltrosMiembros extends Migration
{
    public function up()
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->index('temporada_id', 'equipos_temporada_id_idx');
        });

        Schema::table('equipo_funcione_miembro', function (Blueprint $table) {
            $table->index(['miembro_id', 'equipo_id'], 'efm_miembro_equipo_idx');
            $table->index(['miembro_id', 'funcione_id'], 'efm_miembro_funcion_idx');
            $table->index(['equipo_id', 'funcione_id'], 'efm_equipo_funcion_idx');
        });

        Schema::table('funcione_miembro', function (Blueprint $table) {
            $table->index(['miembro_id', 'funcione_id'], 'fm_miembro_funcion_idx');
            $table->index('funcione_id', 'fm_funcion_id_idx');
        });
    }

    public function down()
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropIndex('equipos_temporada_id_idx');
        });

        Schema::table('equipo_funcione_miembro', function (Blueprint $table) {
            $table->dropIndex('efm_miembro_equipo_idx');
            $table->dropIndex('efm_miembro_funcion_idx');
            $table->dropIndex('efm_equipo_funcion_idx');
        });

        Schema::table('funcione_miembro', function (Blueprint $table) {
            $table->dropIndex('fm_miembro_funcion_idx');
            $table->dropIndex('fm_funcion_id_idx');
        });
    }
}

