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

            // Relaciones obligatorias
            $table->foreignId('padre_id')->constrained('padres')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');

            // Usuario que aprueba/rechaza (admin o superadmin)
            $table->foreignId('usuario_decision_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Información de la Matrícula
            $table->string('codigo_matricula', 20)->unique();
            $table->year('anio_lectivo');
            $table->date('fecha_matricula');

            // Documentos (opcionales)
            $table->string('foto_estudiante')->nullable();
            $table->string('acta_nacimiento')->nullable();
            $table->string('certificado_estudios')->nullable();
            $table->string('constancia_conducta')->nullable();

            // Estado de la Matrícula
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'cancelada'])
                  ->default('pendiente');

            // Justificación si fue rechazada o cancelada
            $table->text('motivo_rechazo')->nullable();
            $table->text('observaciones')->nullable();

            // Fecha en que se aprobó/rechazó
            $table->timestamp('fecha_confirmacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
