<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Opcional: deshabilitar FK para recrear tabla
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
            $table->enum('sexo', ['masculino', 'femenino'])->nullable();
            $table->string('genero')->nullable(); // si lo necesitas para otra lógica

            // Información académica
            $table->string('grado');
            $table->string('seccion');

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
            $table->foreign('padre_id')->references('id')->on('padres')->nullOnDelete();

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
