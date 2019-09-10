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
    }
}
