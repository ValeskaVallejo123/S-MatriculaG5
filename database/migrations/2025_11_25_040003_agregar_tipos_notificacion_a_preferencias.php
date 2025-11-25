<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notificacion_preferencias', function (Blueprint $table) {
            // Nuevos tipos de notificación para estudiantes y profesores
            $table->boolean('notificacion_nueva_materia')->default(true);
            $table->boolean('notificacion_calificaciones')->default(true);
            $table->boolean('notificacion_observaciones')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('notificacion_preferencias', function (Blueprint $table) {
            $table->dropColumn([
                'notificacion_nueva_materia',
                'notificacion_calificaciones',
                'notificacion_observaciones'
            ]);
        });
    }
};
