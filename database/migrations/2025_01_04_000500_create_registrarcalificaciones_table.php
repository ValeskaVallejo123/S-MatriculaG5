<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrarcalificaciones', function (Blueprint $table) {

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
                ->constrained('periodos_academicos')
                ->onDelete('cascade');

            $table->decimal('nota', 5, 2)->nullable();

            $table->text('observacion')->nullable();

            $table->timestamps();

            // Evita duplicar calificaciones
            $table->unique([
                'profesor_id',
                'grado_id',
                'materia_id',
                'estudiante_id',
                'periodo_academico_id'
            ], 'registro_calificacion_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrarcalificaciones');
    }
};