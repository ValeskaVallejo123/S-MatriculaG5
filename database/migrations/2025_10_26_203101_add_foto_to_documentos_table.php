<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Solo agregar la columna si no existe
        if (!Schema::hasColumn('documentos', 'foto')) {
            Schema::table('documentos', function (Blueprint $table) {
                $table->string('foto')->nullable()->after('nombre_estudiante');
            });
        }
    }

    public function down(): void
    {
        // Solo eliminar si existe
        if (Schema::hasColumn('documentos', 'foto')) {
            Schema::table('documentos', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }
    }
};
