<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();

            // Relación con estudiante
            $table->foreignId('estudiante_id')
                  ->constrained('estudiantes')
                  ->onDelete('cascade');

            // Estado de la solicitud
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])
                  ->default('pendiente');

            // Motivo de rechazo o mensaje adicional (opcional)
            $table->text('motivo')->nullable();

            // Notificación al estudiante o padre
            $table->boolean('notificar')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
