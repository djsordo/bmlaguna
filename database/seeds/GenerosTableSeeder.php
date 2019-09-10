<?php

use Illuminate\Database\Seeder;

class GenerosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('generos')->insert(['descripcion' => 'masculino']);
        DB::table('generos')->insert(['descripcion' => 'femenino']);
        DB::table('generos')->insert(['descripcion' => 'mixto']);
    }
}
