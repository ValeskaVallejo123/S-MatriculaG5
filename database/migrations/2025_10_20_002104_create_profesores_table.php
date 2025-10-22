<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profesores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique()->nullable();
            $table->string('telefono')->nullable();
            $table->string('dni')->unique();
            $table->date('fecha_nacimiento');
            $table->string('direccion')->nullable();
            $table->string('especialidad'); // Matemáticas, Español, etc.
            $table->decimal('salario', 10, 2)->nullable();
            $table->enum('tipo_contrato', ['tiempo_completo', 'medio_tiempo', 'por_horas'])->default('tiempo_completo');
            $table->date('fecha_ingreso');
            $table->enum('estado', ['activo', 'inactivo', 'licencia'])->default('activo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profesores');
    }
};
