<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('secciones', function (Blueprint $table) {
            $table->id();

            // Definición limpia de columnas
            $table->string('grado', 20);
            $table->string('nombre', 10);
            $table->unsignedSmallInteger('capacidad')->default(30);

            $table->timestamps();

            // Mantenemos la restricción única para evitar duplicados como "1er Grado - A" dos veces
            $table->unique(['grado', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('secciones');
    }
};