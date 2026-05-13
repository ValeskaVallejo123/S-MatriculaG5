<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('periodos_academicos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_periodo', 100);

            $table->enum('tipo', ['clases', 'vacaciones', 'examenes']);

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            // Estado del periodo académico
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodos_academicos');
    }
};
