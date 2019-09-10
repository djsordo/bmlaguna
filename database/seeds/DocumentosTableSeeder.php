<?php

use Illuminate\Database\Seeder;

class DocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('funciones')->insert(['descripcion' => 'foto']);
        DB::table('funciones')->insert(['descripcion' => 'DNI frontal']);
        DB::table('funciones')->insert(['descripcion' => 'DNI posterior']);
        DB::table('funciones')->insert(['descripcion' => 'Certificado médico']);
    }
}
