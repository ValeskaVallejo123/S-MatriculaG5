<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crear la tabla documentos si no existe
        if (!Schema::hasTable('documentos')) {
            Schema::create('documentos', function (Blueprint $table) {
                $table->id();
                $table->string('nombre_estudiante');
                $table->string('foto')->nullable(); // columna inicial incluida
                $table->string('acta_nacimiento')->nullable();
                $table->string('calificaciones')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
