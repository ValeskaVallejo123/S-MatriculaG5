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
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();

            // Nuevos campos según el modelo
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('periodo_id');

            // Campos que ya existían
            $table->string('nombre_alumno');

            // Notas parciales (ya existían)
            $table->decimal('primer_parcial', 5, 2)->nullable();
            $table->decimal('segundo_parcial', 5, 2)->nullable();
            $table->decimal('tercer_parcial', 5, 2)->nullable();
            $table->decimal('cuarto_parcial', 5, 2)->nullable();
            $table->decimal('recuperacion', 5, 2)->nullable();
            $table->decimal('nota_final', 5, 2)->nullable();

            // Campos del modelo
            $table->decimal('nota', 5, 2)->nullable();
            $table->text('observacion')->nullable();

            $table->timestamps();

            // Relaciones
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade');
            $table->foreign('periodo_id')->references('id')->on('periodos_academicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
