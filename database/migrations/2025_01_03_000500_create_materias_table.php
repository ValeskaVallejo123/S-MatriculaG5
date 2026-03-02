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

            $table->string('nombre', 100);
            $table->string('codigo', 20)->unique();

            $table->text('descripcion')->nullable();

            $table->enum('nivel', ['primaria', 'secundaria']);

            // Lista cerrada de áreas, pero sin default
            $table->enum('area', [
                'Español',
                'Matemáticas',
                'Ciencias Naturales',
                'Ciencias Sociales',
                'Inglés',
                'Educación Artística',
                'Educación Física',
                'Tecnología',
                'Formación Cívica y Ética'
            ]);

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
