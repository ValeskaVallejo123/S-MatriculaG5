<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique()->nullable();
            $table->string('telefono')->nullable();
            $table->string('dni')->unique();
            $table->date('fecha_nacimiento');
            $table->string('direccion')->nullable();
            $table->string('grado');
            $table->string('seccion');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->text('observaciones')->nullable();

            // Campos agregados para subir documentos
            $table->unsignedBigInteger('padre_id')->nullable();
            $table->string('genero')->nullable();
            $table->string('foto')->nullable();

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
