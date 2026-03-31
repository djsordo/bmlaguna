<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

/**
 * Garantiza la fila "tecnico" en funciones (idempotente).
 * Útil si otra migración no llegó a ejecutarse en el servidor.
 */
class EnsureTecnicoFuncioneExists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! DB::table('funciones')->where('descripcion', 'tecnico')->exists()) {
            DB::table('funciones')->insert([
                'descripcion' => 'tecnico',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('funciones')->where('descripcion', 'tecnico')->delete();
    }
}
