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
        Schema::create('eventos_academicos', function (Blueprint $table) {
            $table->id();
            
            // Información básica del evento
            $table->string('titulo', 255);
            $table->text('descripcion')->nullable();
            
            // Fechas
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            
            // Tipo de evento
            $table->enum('tipo', [
                'clase',
                'examen',
                'festivo',
                'evento',
                'vacaciones',
                'prematricula',
                'matricula'
            ])->default('evento');
            
            // Color para el calendario (hexadecimal)
            $table->string('color', 7)->default('#3788d8');
            
            // Si es evento de todo el día
            $table->boolean('todo_el_dia')->default(true);
            
            // Timestamps automáticos
            $table->timestamps();
            
            // Índices para mejorar rendimiento
            $table->index('tipo');
            $table->index('fecha_inicio');
            $table->index('fecha_fin');
            $table->index(['fecha_inicio', 'fecha_fin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos_academicos');
    }
};