<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profesor_materia_grados', function (Blueprint $table) {
            $table->id();

            // Profesor
            $table->foreignId('profesor_id')
                  ->constrained('profesores')
                  ->onDelete('cascade');

            // Materia
            $table->foreignId('materia_id')
                  ->constrained('materias')
                  ->onDelete('cascade');

            // Grado
            $table->foreignId('grado_id')
                  ->constrained('grados')
                  ->onDelete('cascade');

            // Sección (A, B, C…)
            $table->string('seccion', 5);

            // Para evitar duplicados
            $table->unique(
                ['profesor_id', 'materia_id', 'grado_id', 'seccion'],
                'profesor_materia_grados_unique'
            );

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profesor_materia_grados');
    }
};
