<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class BackfillJugadorEnMiembrosConPreinscripcion extends Migration
{
    /**
     * Marca como jugador de club a miembros con preinscripción en la temporada
     * activa que aún no tienen la función en funcione_miembro.
     */
    public function up()
    {
        if (! Schema::hasTable('preinscripcions') || ! Schema::hasTable('funcione_miembro')) {
            return;
        }

        $temporadaActualId = DB::table('temporadas')->orderBy('temporada', 'desc')->value('id');
        if (! $temporadaActualId) {
            return;
        }

        $jugadorId = DB::table('funciones')->where('descripcion', 'jugador')->value('id');
        if (! $jugadorId) {
            return;
        }

        DB::statement(
            "
            INSERT INTO funcione_miembro (funcione_id, miembro_id, created_at, updated_at)
            SELECT DISTINCT ?, p.miembro_id, NOW(), NOW()
            FROM preinscripcions p
            LEFT JOIN funcione_miembro fm
                ON fm.miembro_id = p.miembro_id
               AND fm.funcione_id = ?
            WHERE p.miembro_id IS NOT NULL
              AND p.temporada_id = ?
              AND fm.id IS NULL
            ",
            [$jugadorId, $jugadorId, $temporadaActualId]
        );
    }

    public function down()
    {
        // No-op: no podemos distinguir de forma segura qué filas fueron creadas por esta migración.
    }
}
