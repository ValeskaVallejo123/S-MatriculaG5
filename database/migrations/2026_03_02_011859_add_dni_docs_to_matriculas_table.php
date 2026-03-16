<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            // Documentos DNI que faltan en la migración original
            if (!Schema::hasColumn('matriculas', 'foto_dni_estudiante')) {
                $table->string('foto_dni_estudiante')->nullable()->after('constancia_conducta');
            }
            if (!Schema::hasColumn('matriculas', 'foto_dni_padre')) {
                $table->string('foto_dni_padre')->nullable()->after('foto_dni_estudiante');
            }
        });
    }

    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropColumn(['foto_dni_estudiante', 'foto_dni_padre']);
        });
    }
};