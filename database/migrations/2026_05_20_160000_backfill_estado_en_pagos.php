<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class BackfillEstadoEnPagos extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('pagos')) {
            return;
        }

        if (! Schema::hasColumn('pagos', 'estado')) {
            Schema::table('pagos', function (Blueprint $table) {
                $table->string('estado', 50)->nullable()->after('nRecibo');
            });
        }

        DB::table('pagos')
            ->whereNotNull('f_pago')
            ->where('f_pago', '!=', '')
            ->where(function ($q) {
                $q->whereNull('estado')->orWhere('estado', '');
            })
            ->update(['estado' => 'Pagado']);

        DB::table('pagos')
            ->where(function ($q) {
                $q->whereNull('f_pago')->orWhere('f_pago', '');
            })
            ->where(function ($q) {
                $q->whereNull('estado')->orWhere('estado', '');
            })
            ->update(['estado' => 'Pendiente']);
    }

    public function down()
    {
        // Sin reversión.
    }
}
