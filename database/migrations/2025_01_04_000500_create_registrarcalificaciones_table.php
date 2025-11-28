<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registro_calificaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profesor_id')->constrained('profesores')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');

            // Dejamos el periodo obligatorio para evitar problemas con unique
            $table->foreignId('periodo_academico_id')->constrained('periodos_academicos')->onDelete('cascade');

            $table->decimal('nota', 5, 2)->nullable();
            $table->text('observacion')->nullable();

            $table->timestamps();

            // Único por profesor, curso, materia, estudiante y periodo
            $table->unique(
                ['profesor_id','curso_id','materia_id','estudiante_id','periodo_academico_id'],
                'registro_calificaciones_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_calificaciones');
    }
};
