<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMiembrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('miembros', function (Blueprint $table) {
            $table->renameColumn('padre_id', 'responsable1_id');
            $table->renameColumn('madre_id', 'responsable2_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('miembros', function (Blueprint $table) {
            $table->renameColumn('responsable1_id', 'padre_id');
            $table->renameColumn('responsable2_id', 'madre_id');
        });
    }
}
