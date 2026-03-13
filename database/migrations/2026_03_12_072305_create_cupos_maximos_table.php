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

        Schema::create('cupos_maximos', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('cupo_maximo');
            $table->string('jornada');
            $table->string('seccion');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupos_maximos');
    }
};
