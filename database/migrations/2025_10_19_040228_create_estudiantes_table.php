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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();

            // Campos usados en tu seeder
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();

            $table->date('fecha_nacimiento')->nullable();

            $table->string('dni')->unique();
            $table->enum('sexo', ['Masculino', 'Femenino'])->nullable();

            $table->string('grado')->nullable();     // ejemplo: "2°"
            $table->string('seccion')->nullable();   // ejemplo: "D"

            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
