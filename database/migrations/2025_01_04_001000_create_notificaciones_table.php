<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');

    // Datos base
    $table->string('titulo');
    $table->text('mensaje');

    // Tipo de notificación
    $table->string('tipo')->nullable();

    // Polimórfica opcional
    $table->unsignedBigInteger('relacion_id')->nullable();
    $table->string('relacion_tipo')->nullable();

    $table->boolean('leida')->default(false);
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};




