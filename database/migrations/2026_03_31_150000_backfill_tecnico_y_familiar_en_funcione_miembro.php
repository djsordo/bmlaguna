<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class BackfillTecnicoYFamiliarEnFuncioneMiembro extends Migration
{
    /**
     * - Técnico: miembros con rol de oficial en algún equipo de la temporada actual.
     * - Familiar: miembros que ya tienen la función familiar en equipo_funcione_miembro (p. ej. responsables).
     *
     * Idempotente: no duplica filas en funcione_miembro.
     */
    public function up()
    {
        $temporadaActualId = DB::table('temporadas')->orderBy('temporada', 'desc')->value('id');

        $idTecnico = DB::table('funciones')->where('descripcion', 'tecnico')->value('id');
        if ($idTecnico && $temporadaActualId) {
            DB::statement(
                '
                INSERT INTO funcione_miembro (funcione_id, miembro_id, created_at, updated_at)
                SELECT DISTINCT ?, efm.miembro_id, NOW(), NOW()
                FROM equipo_funcione_miembro efm
                INNER JOIN equipos e ON e.id = efm.equipo_id
                INNER JOIN funciones f ON f.id = efm.funcione_id
                LEFT JOIN funcione_miembro fm
                    ON fm.miembro_id = efm.miembro_id
                   AND fm.funcione_id = ?
                WHERE e.temporada_id = ?
                  AND f.descripcion IN (\'delegado\', \'primer entrenador\', \'segundo entrenador\', \'entrenador\')
                  AND fm.id IS NULL
                ',
                [$idTecnico, $idTecnico, $temporadaActualId]
            );
        }

        $idFamiliar = DB::table('funciones')->where('descripcion', 'familiar')->value('id');
        if ($idFamiliar) {
            DB::statement(
                '
                INSERT INTO funcione_miembro (funcione_id, miembro_id, created_at, updated_at)
                SELECT DISTINCT ?, efm.miembro_id, NOW(), NOW()
                FROM equipo_funcione_miembro efm
                INNER JOIN funciones f ON f.id = efm.funcione_id
                LEFT JOIN funcione_miembro fm
                    ON fm.miembro_id = efm.miembro_id
                   AND fm.funcione_id = ?
                WHERE f.descripcion = \'familiar\'
                  AND fm.id IS NULL
                ',
                [$idFamiliar, $idFamiliar]
            );
        }
    }

    public function down()
    {
        // No-op
    }
}
