<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grados', function (Blueprint $table) {
            $table->id();

            $table->enum('nivel', ['primaria', 'secundaria']);

            // grado (1-9)
            $table->integer('numero');

            // Sección del grado
            $table->enum('seccion', ['A','B','C','D'])->nullable();

            // Año lectivo (ej: 2025)
            $table->year('anio_lectivo');

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });

        // índice único para evitar duplicados
        Schema::table('grados', function (Blueprint $table) {
            $table->unique(['nivel', 'numero', 'seccion', 'anio_lectivo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grados');
    }
};
