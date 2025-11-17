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
             $table->string('nombre1');
            $table->string('nombre2')->nullable();
            $table->string('apellido1');
            $table->string('apellido2')->nullable();
            $table->string('apellido');
            $table->string('dni');
            $table->date('fecha_nacimiento');
            $table->string('sexo');
            $table->string('grado');
            $table->string('seccion');
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->enum('estado', ['pendiente', 'activo', 'inactivo'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('padre_id')->nullable();
            $table->string('genero')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
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