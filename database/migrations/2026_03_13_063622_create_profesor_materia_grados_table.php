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
        Schema::create('profesor_materia_grados', function (Blueprint $table) {
    $table->id();
    $table->foreignId('grado_id')->constrained('grados')->onDelete('cascade');
    $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
    $table->foreignId('profesor_id')->nullable()->constrained('users')->onDelete('set null');
    $table->string('section')->nullable();
    $table->integer('horas_semanales')->default(4);
    $table->timestamps();

    $table->unique(['grado_id', 'materia_id'], 'prof_mat_grad_unique');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesor_materia_grados');
    }
};