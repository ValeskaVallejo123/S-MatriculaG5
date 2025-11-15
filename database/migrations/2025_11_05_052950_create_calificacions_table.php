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
            $table->string('nombre_alumno');
            $table->decimal('primer_parcial', 5, 2)->nullable();
            $table->decimal('segundo_parcial', 5, 2)->nullable();
            $table->decimal('tercer_parcial', 5, 2)->nullable();
            $table->decimal('cuarto_parcial', 5, 2)->nullable();
            $table->decimal('recuperacion', 5, 2)->nullable();
            $table->decimal('nota_final', 5, 2)->nullable();
            $table->timestamps();
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