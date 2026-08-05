<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profesor_materia', function (Blueprint $table) {
            $table->id();
            
            // Relación con el Profesor
            $table->foreignId('profesor_id')
                  ->constrained('profesores')
                  ->onDelete('cascade');

            // Relación con la Materia
            $table->foreignId('materia_id')
                  ->constrained('materias')
                  ->onDelete('cascade');

            // NUEVO: Relación con el Grado (Necesario para la vista)
            $table->foreignId('grado_id')
                  ->constrained('grados')
                  ->onDelete('cascade');

            // NUEVO: Campo sección (Ej: 'A', 'B')
            $table->string('seccion', 10);

            $table->timestamps();

            // Ajuste del índice único para permitir que un profesor 
            // tenga la misma materia en diferentes grados/secciones
            $table->unique(['profesor_id', 'materia_id', 'grado_id', 'seccion'], 'profesor_materia_grado_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profesor_materia');
    }
};