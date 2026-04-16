<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            if (!Schema::hasColumn('documentos', 'tarjeta_identidad_padre')) {
                $table->string('tarjeta_identidad_padre')->nullable()->after('calificaciones');
            }
            if (!Schema::hasColumn('documentos', 'constancia_medica')) {
                $table->string('constancia_medica')->nullable()->after('tarjeta_identidad_padre');
            }
        });
    }

    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropColumn(['tarjeta_identidad_padre', 'constancia_medica']);
        });
    }
};
