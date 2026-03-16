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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();

            // Relación con estudiantes
            $table->unsignedBigInteger('estudiante_id');

            // Estado de la solicitud
            $table->enum('estado', ['aprobada', 'rechazada', 'pendiente'])->default('pendiente');

            // Notificación
            $table->boolean('notificar')->default(false);

            $table->timestamps();

            // Clave foránea
            $table->foreign('estudiante_id')
                ->references('id')
                ->on('estudiantes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes'); // corregido, antes decía 'solicituds'
    }
};

