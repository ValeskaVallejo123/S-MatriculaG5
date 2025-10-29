<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('profesor_id');
            $table->text('descripcion');
            $table->enum('tipo', ['positivo', 'negativo'])->default('negativo');
            $table->timestamps();

            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->foreign('profesor_id')->references('id')->on('profesores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observaciones');
    }
};

