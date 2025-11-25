<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Deshabilitar temporalmente foreign keys
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('estudiantes');

        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre1', 50);
            $table->string('nombre2', 50)->nullable();
            $table->string('apellido1', 50);
            $table->string('apellido2', 50)->nullable();
            $table->string('dni', 13)->nullable()->unique();
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['masculino', 'femenino']);
            $table->string('email', 100)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->text('direccion')->nullable();
            $table->string('grado', 50);
            $table->string('seccion', 1);
            $table->enum('estado', ['activo', 'inactivo', 'retirado'])->default('activo');
            $table->text('observaciones')->nullable();
            $table->string('nombre_padre', 100)->nullable();
            $table->string('telefono_padre', 15)->nullable();
            $table->string('email_padre', 100)->nullable();
            $table->string('foto')->nullable();
            $table->string('dni_doc')->nullable();
            $table->unsignedBigInteger('padre_id')->nullable();
            $table->string('genero')->nullable();
            $table->timestamps();

            // Si tienes relación con tabla padres, descomenta esto:
            // $table->foreign('padre_id')->references('id')->on('padres')->onDelete('set null');
        });

        // Rehabilitar foreign keys
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('estudiantes');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
