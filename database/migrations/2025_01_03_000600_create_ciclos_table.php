<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ciclos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50); // Primer Ciclo, Segundo Ciclo...
            $table->string('seccion', 50); // A, B, C...
            $table->string('jornada', 20); // matutina, vespertina
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ciclos');
    }
};
