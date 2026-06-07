<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class EnsurePagosPreinscripcionSchema extends Migration
{
    public function up()
    {
        if (Schema::hasTable('pagos')) {
            Schema::table('pagos', function (Blueprint $table) {
                if (! Schema::hasColumn('pagos', 'f_vencimiento')) {
                    $table->date('f_vencimiento')->nullable()->after('f_pago');
                }
            });

            DB::statement('ALTER TABLE pagos MODIFY f_pago DATE NULL');
        }

        if (Schema::hasTable('tipospagos') && ! Schema::hasColumn('tipospagos', 'modalidad')) {
            Schema::table('tipospagos', function (Blueprint $table) {
                $table->unsignedTinyInteger('modalidad')->nullable()->after('descripcion');
            });
        }

        if (! Schema::hasTable('tipospagos')) {
            return;
        }

        $tipos = [
            1 => ['Inscripción Total'],
            2 => ['2 Plazos 1ª Cuota', '2 Plazos 2ª Cuota'],
            3 => ['3 Plazos 1ª Cuota', '3 Plazos 2ª Cuota', '3 Plazos 3ª Cuota'],
        ];

        foreach ($tipos as $modalidad => $descripciones) {
            foreach ($descripciones as $descripcion) {
                $exists = DB::table('tipospagos')->where('descripcion', $descripcion)->exists();
                if (! $exists) {
                    DB::table('tipospagos')->insert([
                        'descripcion' => $descripcion,
                        'modalidad' => $modalidad,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::table('tipospagos')
                        ->where('descripcion', $descripcion)
                        ->whereNull('modalidad')
                        ->update(['modalidad' => $modalidad]);
                }
            }
        }
    }

    public function down()
    {
        // Sin reversión: datos de tipospagos pueden estar en uso.
    }
}
