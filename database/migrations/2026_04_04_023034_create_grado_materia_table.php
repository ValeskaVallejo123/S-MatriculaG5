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
            $table->foreignId('profesor_id')->nullable()->constrained('profesores')->onDelete('set null');
            $table->integer('horas_semanales')->default(4);
            $table->timestamps();

            $table->unique(['grado_id', 'materia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grado_materia');
    }
};