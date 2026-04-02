<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class BackfillJugadoresEnFuncioneMiembroTemporadaActual extends Migration
{
    /**
     * Inserta en funcione_miembro la función "jugador" para los miembros que
     * figuran como jugadores de algún equipo en la temporada actual.
     *
     * Es idempotente: no duplica filas si ya existe el par (miembro_id, funcione_id).
     */
    public function up()
    {
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
            SELECT DISTINCT ?, efm.miembro_id, NOW(), NOW()
            FROM equipo_funcione_miembro efm
            INNER JOIN equipos e ON e.id = efm.equipo_id
            LEFT JOIN funcione_miembro fm
                ON fm.miembro_id = efm.miembro_id
               AND fm.funcione_id = ?
            WHERE e.temporada_id = ?
              AND efm.funcione_id = ?
              AND fm.id IS NULL
            ",
            [$jugadorId, $jugadorId, $temporadaActualId, $jugadorId]
        );
    }

    public function down()
    {
        // No-op: no podemos distinguir de forma segura qué filas fueron creadas por esta migración.
    }
}

