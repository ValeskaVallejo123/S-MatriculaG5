<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('padre_permisos', function (Blueprint $table) {
            $table->foreignId('padre_id')->constrained('padres')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->boolean('ver_calificaciones')->default(false);
            $table->boolean('ver_asistencias')->default(false);
            $table->boolean('ver_comportamiento')->default(false);
            $table->boolean('ver_tareas')->default(false);
            $table->boolean('descargar_boletas')->default(false);
            $table->boolean('recibir_notificaciones')->default(false);
            $table->boolean('comunicarse_profesores')->default(false);
            $table->boolean('autorizar_salidas')->default(false);
            $table->boolean('subir_documentos_matricula')->default(false);
            $table->boolean('modificar_datos_contacto')->default(false);
            $table->text('notas_adicionales')->nullable();
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