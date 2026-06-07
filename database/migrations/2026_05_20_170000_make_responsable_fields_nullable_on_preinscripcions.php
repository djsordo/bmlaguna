<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeResponsableFieldsNullableOnPreinscripcions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preinscripcions', function (Blueprint $table) {
            $table->string('nombreR1')->nullable()->change();
            $table->string('apellido1R1')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preinscripcions', function (Blueprint $table) {
            $table->string('nombreR1')->nullable(false)->change();
            $table->string('apellido1R1')->nullable(false)->change();
        });
    }
}
