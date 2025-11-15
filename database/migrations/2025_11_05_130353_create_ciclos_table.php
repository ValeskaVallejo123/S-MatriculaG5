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
        Schema::create('ciclos', callback: function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50); // Primer Ciclo, Segundo Ciclo, etc
            $table->string('seccion', 100);
            $table->string('jornada', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclos');
    }
};