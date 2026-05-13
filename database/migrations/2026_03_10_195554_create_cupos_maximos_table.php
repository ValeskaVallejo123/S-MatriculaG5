<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cupos_maximos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->unsignedSmallInteger('cupo_maximo');
            $table->enum('jornada', ['Matutina', 'Vespertina'])->nullable();
            $table->enum('seccion', ['A', 'B', 'C', 'D'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cupos_maximos');
    }
};
