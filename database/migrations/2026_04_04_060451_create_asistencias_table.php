<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('grado_id')->constrained('grados')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('profesor_id')->nullable()->constrained('profesores')->onDelete('set null');
            $table->date('fecha');
            $table->enum('estado', ['presente', 'ausente', 'tardanza', 'justificado']);
            $table->string('observacion', 255)->nullable();
            $table->timestamps();

            // Un estudiante no puede tener dos registros para la misma materia el mismo día
            $table->unique(['estudiante_id', 'materia_id', 'fecha'], 'asist_unica');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};