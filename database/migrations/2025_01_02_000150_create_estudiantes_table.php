<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('estudiantes');

        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();

            // Identidad
            $table->string('nombre1');
            $table->string('nombre2')->nullable();
            $table->string('apellido1');
            $table->string('apellido2')->nullable();
            $table->string('dni', 13)->unique();

            // Datos personales
            $table->date('fecha_nacimiento');

            // Se usa solo 'sexo' para evitar duplicidad con 'genero'
            // Si necesitas lógica de género diferente al sexo biológico,
            // descomenta el campo 'genero' y documenta su propósito.
            $table->enum('sexo', ['masculino', 'femenino'])->nullable();
            // $table->string('genero')->nullable();

            // Información académica
            $table->string('grado');
            $table->string('seccion');

            // Estado del estudiante (activo/inactivo)
            // Necesario porque otros módulos del sistema lo usan
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            // Contacto
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono', 15)->nullable();

            // Foto
            $table->string('foto')->nullable();

            // Observaciones
            $table->text('observaciones')->nullable();

            // Relación con Padre
            $table->unsignedBigInteger('padre_id')->nullable();
            $table->foreign('padre_id')
                  ->references('id')
                  ->on('padres')
                  ->nullOnDelete();

            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('estudiantes');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
