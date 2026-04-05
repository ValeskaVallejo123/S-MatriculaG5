<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            // Quién registró la calificación
            $table->foreignId('profesor_id')
                  ->nullable()
                  ->after('periodo_id')
                  ->constrained('profesores')
                  ->onDelete('set null');

            // Grado como texto (igual que en la tabla estudiantes)
            $table->string('grado_nombre', 50)
                  ->nullable()
                  ->after('profesor_id');

            // Sección como texto
            $table->string('seccion', 10)
                  ->nullable()
                  ->after('grado_nombre');

            // Referencia al grado (tabla grados, para filtros)
            $table->foreignId('grado_id')
                  ->nullable()
                  ->after('seccion')
                  ->constrained('grados')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            $table->dropForeign(['profesor_id']);
            $table->dropForeign(['grado_id']);
            $table->dropColumn(['profesor_id', 'grado_nombre', 'seccion', 'grado_id']);
        });
    }
};
