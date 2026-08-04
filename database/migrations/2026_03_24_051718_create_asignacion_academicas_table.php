<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('asignaciones_academicas')) {
            Schema::create('asignaciones_academicas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('seccion_id')->constrained('secciones')->onDelete('cascade');
                $table->foreignId('asignatura_id')->constrained('materias')->onDelete('cascade');
                $table->string('periodo_lectivo');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones_academicas');
    }
};