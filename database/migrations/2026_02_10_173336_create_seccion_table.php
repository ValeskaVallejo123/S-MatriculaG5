<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seccion', function (Blueprint $table) {
            $table->id();

            // Grado al que pertenece la sección (ej: '1er Grado', '2do Grado'...)
            $table->string('grado', 20)->after('id');

            // Nombre/letra de la sección (ej: 'A', 'B', 'C')
            $table->string('nombre', 10);

            // Alias para compatibilidad con las vistas (letra = nombre)
            // Se usa ->virtualAs() para que sea un alias sin columna extra
            // Si prefieres columna real, cambia a: $table->string('letra', 10);
            $table->string('letra', 10)->virtualAs('nombre');

            // Capacidad máxima de alumnos
            $table->unsignedSmallInteger('capacidad')->default(30);

            $table->timestamps();

            // Evitar secciones duplicadas: mismo grado + misma letra
            $table->unique(['grado', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('secciones');
    }
};