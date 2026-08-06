<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('periodo_id')->constrained('periodos_academicos')->onDelete('cascade');

            // Notas parciales
            $table->decimal('primer_parcial', 5, 2)->nullable();
            $table->decimal('segundo_parcial', 5, 2)->nullable();
            $table->decimal('tercer_parcial', 5, 2)->nullable();

            // Promedio
            $table->decimal('promedio_parciales', 5, 2)->nullable();

            // Recuperación
            $table->decimal('recuperacion', 5, 2)->nullable();

            // Nota final (única nota que debería quedar)
            $table->decimal('nota_final', 5, 2)->nullable();

            // Observación
            $table->text('observacion')->nullable();

            $table->timestamps();

            // Evitar notas duplicadas
            $table->unique(['estudiante_id', 'materia_id', 'periodo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
