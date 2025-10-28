<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD
return new class extends Migration {
    public function up(): void
=======
return new class extends Migration
{

public function up(): void
>>>>>>> cesia-dev
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('dni')->unique(); // Formato: 0000-0000-00000
            $table->date('fecha_nacimiento');
            $table->string('sexo'); // Masculino / Femenino
            $table->string('grado'); // Primero a Noveno
            $table->string('seccion'); // 1, 2, 3, 4 o Única
            $table->string('direccion')->nullable();

            // Opcionales
            $table->string('email')->unique()->nullable();
            $table->string('telefono')->nullable();

            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->text('observaciones')->nullable();

<<<<<<< HEAD
            // Campos agregados para subir documentos
            $table->unsignedBigInteger('padre_id')->nullable();
            $table->string('genero')->nullable();
            $table->string('foto')->nullable();

=======
>>>>>>> cesia-dev
            $table->timestamps();

            // Relación con la tabla padres
            $table->foreign('padre_id')
                ->references('id')
                ->on('padres')
                ->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
