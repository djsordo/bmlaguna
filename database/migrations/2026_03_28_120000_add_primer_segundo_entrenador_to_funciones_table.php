<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddPrimerSegundoEntrenadorToFuncionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! DB::table('funciones')->where('descripcion', 'primer entrenador')->exists()) {
            DB::table('funciones')->insert([
                'descripcion' => 'primer entrenador',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        if (! DB::table('funciones')->where('descripcion', 'segundo entrenador')->exists()) {
            DB::table('funciones')->insert([
                'descripcion' => 'segundo entrenador',
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
        DB::table('funciones')->where('descripcion', 'primer entrenador')->delete();
        DB::table('funciones')->where('descripcion', 'segundo entrenador')->delete();
    }
}
