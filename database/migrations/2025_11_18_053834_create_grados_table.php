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
            $table->integer('numero'); // 1-6 para primaria, 7-9 para secundaria
            $table->string('seccion')->nullable(); // A, B, C, etc.
            $table->year('anio_lectivo');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Índice único para evitar duplicados
            $table->unique(['nivel', 'numero', 'seccion', 'anio_lectivo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grados');
    }
};
