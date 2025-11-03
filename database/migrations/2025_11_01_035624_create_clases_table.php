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
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            
            // Campos de la clase/asignatura
            $table->string('nombre', 100);
            $table->string('codigo', 10)->unique()->comment('Código de la asignatura, ej: MAT101');
            $table->unsignedTinyInteger('creditos')->default(3);
            $table->text('temario_resumen')->nullable(); // Campo adicional para la clase

            // Relación con PlanEstudio (Clase pertenece a un Plan)
            $table->foreignId('plan_estudio_id')
                  ->constrained('plan_estudios') 
                  ->onDelete('cascade'); // Si se elimina el plan, las clases se eliminan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};