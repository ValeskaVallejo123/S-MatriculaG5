<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();

            // Relación con profesores
            $table->foreignId('profesor_id')
                  ->constrained('profesores')
                  ->onDelete('cascade');

            // Relación correcta con materias
            $table->foreignId('materia_id')
                  ->constrained('materias')
                  ->onDelete('cascade');

            // Sección del grupo
            $table->enum('seccion', ['A','B','C','D','E','F']);

            // Día de la semana
            $table->enum('dia', ['Lunes','Martes','Miércoles','Jueves','Viernes']);

            // Horas
            $table->time('hora_inicio');
            $table->time('hora_fin');

            // Aula (opcional)
            $table->string('salon')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
