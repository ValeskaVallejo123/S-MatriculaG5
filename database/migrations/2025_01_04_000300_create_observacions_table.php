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

        $table->foreignId('estudiante_id')
              ->constrained('estudiantes')
              ->onDelete('cascade');

        $table->foreignId('profesor_id')
              ->nullable()
              ->constrained('profesores')
              ->onDelete('set null');

        $table->string('tipo')->default('academica');
        $table->text('descripcion');

        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('observaciones');
    }
};
