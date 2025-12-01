<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios_grado', function (Blueprint $table) {
            $table->id();

            // Relación con la tabla grados
            $table->foreignId('grado_id')->constrained('grados')->onDelete('cascade');

            // Jornada del horario: matutina o vespertina
            $table->enum('jornada', ['matutina','vespertina'])->default('matutina');

            // Estructura JSON que almacena todas las celdas:
            // ejemplo: { "lunes": { "07:00-08:00": {"materia_id":1,"profesor_id":2,"salon":"2B"} , ... }, ... }
            $table->json('horario')->nullable();

            $table->timestamps();

            $table->unique(['grado_id','jornada']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios_grado');
    }
};
