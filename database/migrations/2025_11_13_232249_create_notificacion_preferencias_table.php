<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notificacion_preferencias', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');

    // Canales
    $table->boolean('correo')->default(true);
    $table->boolean('mensaje_interno')->default(true);
    $table->boolean('alerta_visual')->default(true);

    // Tipos de notificación que aplican a ambos
    $table->boolean('notificacion_horario')->default(true); // cambios de horario
    $table->boolean('notificacion_administrativa')->default(true); // avisos y recordatorios importantes

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('notificacion_preferencias');
    }
};
