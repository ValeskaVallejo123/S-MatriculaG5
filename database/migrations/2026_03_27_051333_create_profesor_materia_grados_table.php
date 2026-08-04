<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('profesor_materia_grados')) {
            Schema::create('profesor_materia_grados', function (Blueprint $table) {
                $table->id();
                $table->foreignId('profesor_id')->constrained('profesores')->onDelete('cascade');
                $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
                $table->foreignId('grado_id')->constrained('grados')->onDelete('cascade');
                $table->integer('horas_semanales')->default(4);
                $table->timestamps();
                $table->unique(['profesor_id', 'materia_id', 'grado_id']);
            });
        }
    }
    public function down(): void
    {
        Schema::dropIfExists('profesor_materia_grados');
    }
};