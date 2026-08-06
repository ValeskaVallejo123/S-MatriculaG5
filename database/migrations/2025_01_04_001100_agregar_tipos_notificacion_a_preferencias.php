<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notificacion_preferencias', function (Blueprint $table) {
            if (!Schema::hasColumn('notificacion_preferencias', 'notificacion_nueva_materia')) {
                $table->boolean('notificacion_nueva_materia')->default(true);
            }
            if (!Schema::hasColumn('notificacion_preferencias', 'notificacion_calificaciones')) {
                $table->boolean('notificacion_calificaciones')->default(true);
            }
            if (!Schema::hasColumn('notificacion_preferencias', 'notificacion_observaciones')) {
                $table->boolean('notificacion_observaciones')->default(true);
            }
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

