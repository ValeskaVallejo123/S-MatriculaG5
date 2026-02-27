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

            // 1️⃣ Canales disponibles
            $table->boolean('correo')->default(true);
            $table->boolean('mensaje_interno')->default(true);
            $table->boolean('alerta_visual')->default(true);

            // 2️⃣ Notificaciones generales
            $table->boolean('notificacion_horario')->default(true);
            $table->boolean('notificacion_administrativa')->default(true);

            // 3️⃣ Estudiantes
            $table->boolean('notificacion_nueva_materia')->default(true);
            $table->boolean('notificacion_calificaciones')->default(true);
            $table->boolean('notificacion_observaciones')->default(true);

            // 4️⃣ Padres
            $table->boolean('notificacion_conducta')->default(true);
            $table->boolean('notificacion_tareas')->default(true);
            $table->boolean('notificacion_eventos')->default(true);
            $table->boolean('notificacion_matricula')->default(true);

            // 5️⃣ Profesores
            $table->boolean('notificacion_estudiante_matricula')->default(true);
            $table->boolean('notificacion_recordatorio_docente')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacion_preferencias');
    }
};
