<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->text('descripcion')->nullable();
            $table->enum('nivel', ['primaria', 'secundaria']); // primaria: 1-6, secundaria: 7-9
            $table->enum('area', [
                'Matemáticas', 
                'Español', 
                'Ciencias Naturales', 
                'Ciencias Sociales', 
                'Educación Física',
                'Educación Artística',
                'Inglés',
                'Informática',
            
            ])->default('Matemáticas');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};