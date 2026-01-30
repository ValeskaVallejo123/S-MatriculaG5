<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('padre_id')->constrained('padres')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');

            // Información de la Matrícula
            $table->string('codigo_matricula', 20)->unique();
            $table->year('anio_lectivo');
            $table->date('fecha_matricula');

            // Documentos
            $table->string('foto_estudiante')->nullable();
            $table->string('acta_nacimiento')->nullable();
            $table->string('certificado_estudios')->nullable();
            $table->string('constancia_conducta')->nullable();
            $table->string('foto_dni_estudiante')->nullable();
            $table->string('foto_dni_padre')->nullable();

            // Estado de la Matrícula
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'cancelada'])->default('pendiente');
            $table->text('motivo_rechazo')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
