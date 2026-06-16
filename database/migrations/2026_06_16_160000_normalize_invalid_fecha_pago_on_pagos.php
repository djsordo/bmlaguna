<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NormalizeInvalidFechaPagoOnPagos extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('pagos') || ! Schema::hasColumn('pagos', 'f_pago')) {
            return;
        }

        DB::table('pagos')
            ->where('f_pago', '0000-00-00')
            ->update(['f_pago' => null]);
    }

    public function down()
    {
        // Sin reversión.
    }
}
