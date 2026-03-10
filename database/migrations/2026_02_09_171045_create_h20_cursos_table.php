<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('_h20_cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Séptimo, Octavo, Noveno
            $table->integer('cupo_maximo')->default(30);
            $table->string('seccion')->nullable(); // A, B, etc.
            $table->string('nivel')->default('Secundaria');
            $table->year('anio_lectivo')->default(date('Y'));
            $table->boolean('activo')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_h20_cursos');
    }
};
