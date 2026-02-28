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

            $table->string('nombre', 100);
            $table->string('apellido', 100);

            // Email no unique para evitar conflictos con NULL
            $table->string('email', 255)->nullable();

            $table->string('telefono', 15)->nullable();
            $table->string('dni', 13)->unique();

            $table->date('fecha_nacimiento');
            $table->string('direccion', 200)->nullable();

            $table->string('especialidad');
            $table->decimal('salario', 10, 2)->nullable();

            $table->enum('tipo_contrato', ['tiempo_completo', 'medio_tiempo', 'por_horas'])
                  ->default('tiempo_completo');

            $table->date('fecha_ingreso');

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profesores');
    }
};
