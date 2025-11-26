<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crear la tabla solo si no existe
        if (!Schema::hasTable('observacions')) {
            Schema::create('observacions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('estudiante_id'); // FK hacia estudiantes
                $table->unsignedBigInteger('profesor_id');   // FK hacia profesores
                $table->text('descripcion');
                $table->enum('tipo', ['positivo', 'negativo'])->default('negativo');
                $table->timestamps();

                // Claves foráneas
                $table->foreign('estudiante_id')
                    ->references('id')
                    ->on('estudiantes')
                    ->onDelete('cascade');

                $table->foreign('profesor_id')
                    ->references('id')
                    ->on('profesores')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('observacions');
    }
};
