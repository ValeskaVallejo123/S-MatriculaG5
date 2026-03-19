<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            // Solo agrega si no existe — evita el error de columna duplicada
            if (!Schema::hasColumn('matriculas', 'seccion_id')) {
                $table->unsignedBigInteger('seccion_id')->nullable()->after('estudiante_id');
                $table->foreign('seccion_id')
                      ->references('id')
                      ->on('seccion')
                      ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            if (Schema::hasColumn('matriculas', 'seccion_id')) {
                $table->dropForeign(['seccion_id']);
                $table->dropColumn('seccion_id');
            }
        });
    }
};