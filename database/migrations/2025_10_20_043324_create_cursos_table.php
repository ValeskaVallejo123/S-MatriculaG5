<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id(); // ID del curso
            $table->string('nombre'); // Nombre del curso
            $table->integer('cupo_maximo')->default(0); // Cupo máximo permitido
            $table->string('jornada')->nullable(); // Jornada del curso (matutina, vespertina)
            $table->string('seccion')->nullable(); // Sección del curso (A, B, C...)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
