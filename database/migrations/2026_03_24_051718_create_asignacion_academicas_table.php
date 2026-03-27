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
    Schema::create('asignaciones_academicas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // El Docente
        $table->foreignId('seccion_id')->constrained('secciones')->onDelete('cascade');
        $table->foreignId('asignatura_id')->constrained('asignaturas')->onDelete('cascade');
        $table->string('periodo_lectivo'); // Ejemplo: "2026"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_academicas');
    }
};
