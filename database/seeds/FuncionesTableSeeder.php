<?php

use Illuminate\Database\Seeder;

class FuncionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('funciones')->insert(['descripcion' => 'jugador']);
        DB::table('funciones')->insert(['descripcion' => 'entrenador']);
        DB::table('funciones')->insert(['descripcion' => 'delegado']);
        DB::table('funciones')->insert(['descripcion' => 'familiar']);
        if (! DB::table('funciones')->where('descripcion', 'primer entrenador')->exists()) {
            DB::table('funciones')->insert(['descripcion' => 'primer entrenador']);
        }
        if (! DB::table('funciones')->where('descripcion', 'segundo entrenador')->exists()) {
            DB::table('funciones')->insert(['descripcion' => 'segundo entrenador']);
        }
        if (! DB::table('funciones')->where('descripcion', 'tecnico')->exists()) {
            DB::table('funciones')->insert(['descripcion' => 'tecnico']);
        }
    }
}
