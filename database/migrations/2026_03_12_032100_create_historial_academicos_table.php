<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historial_academicos', function (Blueprint $table) {
            $table->id();

            // Relación con la tabla 'estudiantes'
            $table->foreignId('estudiante_id')
                ->constrained('estudiantes')
                ->onDelete('cascade');

            // Relación corregida con la tabla 'cursos'
            $table->foreignId('curso_id')
                ->constrained('cursos')
                ->onDelete('cascade');

            $table->year('anio');                    // Año escolar
            $table->string('periodo');               // I Parcial, II Parcial, etc.
            $table->decimal('nota', 5, 2);           // Calificación (ej. 85.50)
            $table->string('resultado');             // Aprobado o Reprobado

            $table->timestamps();                    // Fecha de registro
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_academicos');
    }
};
