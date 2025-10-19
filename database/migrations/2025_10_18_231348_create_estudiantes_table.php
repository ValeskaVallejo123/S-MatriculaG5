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
            $table->date('fecha_nacimiento')->nullable();
            $table->string('genero')->nullable();
            $table->string('grado')->nullable();
            $table->unsignedBigInteger('padre_id'); // relación con padre
            $table->string('foto')->nullable(); // para foto del estudiante
            $table->timestamps();

            // Clave foránea
            $table->foreign('padre_id')->references('id')->on('padres')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};


