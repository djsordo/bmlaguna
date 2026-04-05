<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceUserIdWithTecnicoIdInInformesFtt extends Migration
{
    /**
     * Sustituye user_id por tecnico_id (miembro con rol técnico de club).
     * Idempotente para migrate:fresh tras editar la migración de creación.
     */
    public function up()
    {
        if (! Schema::hasTable('informes_fisico_tecnico_tacticos')) {
            return;
        }

        if (Schema::hasColumn('informes_fisico_tecnico_tacticos', 'user_id')) {
            Schema::table('informes_fisico_tecnico_tacticos', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
            Schema::table('informes_fisico_tecnico_tacticos', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }

        if (! Schema::hasColumn('informes_fisico_tecnico_tacticos', 'tecnico_id')) {
            Schema::table('informes_fisico_tecnico_tacticos', function (Blueprint $table) {
                $table->unsignedInteger('tecnico_id')->nullable()->after('texto');
                $table->foreign('tecnico_id')->references('id')->on('miembros')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        if (! Schema::hasTable('informes_fisico_tecnico_tacticos')) {
            return;
        }

        if (Schema::hasColumn('informes_fisico_tecnico_tacticos', 'tecnico_id')) {
            Schema::table('informes_fisico_tecnico_tacticos', function (Blueprint $table) {
                $table->dropForeign(['tecnico_id']);
            });
            Schema::table('informes_fisico_tecnico_tacticos', function (Blueprint $table) {
                $table->dropColumn('tecnico_id');
            });
        }

        if (! Schema::hasColumn('informes_fisico_tecnico_tacticos', 'user_id')) {
            Schema::table('informes_fisico_tecnico_tacticos', function (Blueprint $table) {
                $table->unsignedInteger('user_id')->nullable()->after('texto');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }
}
