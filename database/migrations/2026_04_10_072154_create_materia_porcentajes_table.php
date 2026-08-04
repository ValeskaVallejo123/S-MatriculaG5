<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('materia_porcentajes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
        $table->foreignId('periodo_id')->constrained('periodos_academicos')->onDelete('cascade');
        $table->foreignId('profesor_id')->constrained('profesores')->onDelete('cascade');
        $table->decimal('porcentaje_tarea', 5, 2)->default(20);
        $table->decimal('porcentaje_parcial', 5, 2)->default(30);
        $table->decimal('porcentaje_final', 5, 2)->default(50);
        $table->timestamps();

        $table->unique(['materia_id', 'periodo_id', 'profesor_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('materia_porcentajes');
}
};