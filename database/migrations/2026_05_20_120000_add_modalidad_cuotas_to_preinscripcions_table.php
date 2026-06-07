<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModalidadCuotasToPreinscripcionsTable extends Migration
{
    public function up()
    {
        Schema::table('preinscripcions', function (Blueprint $table) {
            $table->unsignedTinyInteger('modalidad_cuotas')->nullable()->after('importePago');
        });
    }

    public function down()
    {
        Schema::table('preinscripcions', function (Blueprint $table) {
            $table->dropColumn('modalidad_cuotas');
        });
    }
}
