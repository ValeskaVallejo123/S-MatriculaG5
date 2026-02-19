<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grado_materia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grado_id')->constrained()->onDelete('cascade');
            $table->foreignId('materia_id')->constrained()->onDelete('cascade');
            $table->foreignId('profesor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('horas_semanales')->default(0);
            $table->timestamps();
            
            // Un grado no puede tener la misma materia dos veces
            $table->unique(['grado_id', 'materia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grado_materia');
    }
};