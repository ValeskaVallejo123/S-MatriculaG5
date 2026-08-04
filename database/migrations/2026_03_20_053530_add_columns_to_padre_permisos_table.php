<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('padre_permisos', function (Blueprint $table) {
            if (!Schema::hasColumn('padre_permisos', 'padre_id')) {
                $table->foreignId('padre_id')->constrained('padres')->onDelete('cascade');
            }
            if (!Schema::hasColumn('padre_permisos', 'estudiante_id')) {
                $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            }
            if (!Schema::hasColumn('padre_permisos', 'ver_calificaciones')) {
                $table->boolean('ver_calificaciones')->default(false);
            }
            if (!Schema::hasColumn('padre_permisos', 'ver_asistencias')) {
                $table->boolean('ver_asistencias')->default(false);
            }
            if (!Schema::hasColumn('padre_permisos', 'ver_comportamiento')) {
                $table->boolean('ver_comportamiento')->default(false);
            }
            if (!Schema::hasColumn('padre_permisos', 'ver_tareas')) {
                $table->boolean('ver_tareas')->default(false);
            }
            if (!Schema::hasColumn('padre_permisos', 'descargar_boletas')) {
                $table->boolean('descargar_boletas')->default(false);
            }
            if (!Schema::hasColumn('padre_permisos', 'recibir_notificaciones')) {
                $table->boolean('recibir_notificaciones')->default(false);
            }
            if (!Schema::hasColumn('padre_permisos', 'comunicarse_profesores')) {
                $table->boolean('comunicarse_profesores')->default(false);
            }
            if (!Schema::hasColumn('padre_permisos', 'autorizar_salidas')) {
                $table->boolean('autorizar_salidas')->default(false);
            }
            if (!Schema::hasColumn('padre_permisos', 'subir_documentos_matricula')) {
                $table->boolean('subir_documentos_matricula')->default(false);
            }
            if (!Schema::hasColumn('padre_permisos', 'modificar_datos_contacto')) {
                $table->boolean('modificar_datos_contacto')->default(false);
            }
            if (!Schema::hasColumn('padre_permisos', 'notas_adicionales')) {
                $table->text('notas_adicionales')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('padre_permisos', function (Blueprint $table) {
            $table->dropForeign(['padre_id']);
            $table->dropForeign(['estudiante_id']);
            $table->dropColumn([
                'padre_id', 'estudiante_id',
                'ver_calificaciones', 'ver_asistencias', 'ver_comportamiento',
                'ver_tareas', 'descargar_boletas', 'recibir_notificaciones',
                'comunicarse_profesores', 'autorizar_salidas',
                'subir_documentos_matricula', 'modificar_datos_contacto',
                'notas_adicionales',
            ]);
        });
    }
};