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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            // Campos obligatorios del formulario
            $table->string('titulo', 255);
            $table->date('fecha_inicio');
            $table->date('fecha_fin'); // FullCalendar usa el día después
            $table->string('tipo', 50); // 'clase', 'examen', 'festivo', etc.

            // Campos opcionales del formulario
            $table->text('descripcion')->nullable();

            // Campos derivados/Calculados (para FullCalendar)
            $table->string('color', 7); // Color hexadecimal, e.g., #3788d8
            $table->boolean('todo_el_dia')->default(true); // Siempre true en tu JS

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};