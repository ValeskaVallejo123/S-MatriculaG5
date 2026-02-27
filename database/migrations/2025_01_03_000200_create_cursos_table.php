<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 150);

            $table->unsignedInteger('cupo_maximo')->default(0);

            $table->enum('jornada', ['matutina', 'vespertina'])->nullable();
            $table->enum('seccion', ['A','B','C','D'])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
