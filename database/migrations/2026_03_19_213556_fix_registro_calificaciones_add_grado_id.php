<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * La tabla registro_calificaciones fue creada con curso_id (columna antigua).
     * La recreamos con grado_id para que el sistema use la tabla grados correctamente.
     * La tabla estaba vacía al momento de esta migración.
     */
    public function up(): void
    {
        Schema::dropIfExists('registro_calificaciones');

        Schema::create('registro_calificaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profesor_id')
                ->constrained('profesores')
                ->onDelete('cascade');

            $table->foreignId('grado_id')
                ->constrained('grados')
                ->onDelete('cascade');

            $table->foreignId('materia_id')
                ->constrained('materias')
                ->onDelete('cascade');

            $table->foreignId('estudiante_id')
                ->constrained('estudiantes')
                ->onDelete('cascade');

            $table->foreignId('periodo_academico_id')
                ->nullable()
                ->constrained('periodos_academicos')
                ->onDelete('set null');

            $table->decimal('nota', 5, 2)->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();

            $table->unique(
                ['profesor_id', 'grado_id', 'materia_id', 'estudiante_id', 'periodo_academico_id'],
                'registro_cal_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_calificaciones');
    }
};
