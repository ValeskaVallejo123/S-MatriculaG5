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
        Schema::create('padre_permisos', function (Blueprint $table) {
            $table->id();

            // Relación con el padre
            $table->unsignedBigInteger('padre_id');

            // Relación con el estudiante
            $table->unsignedBigInteger('estudiante_id');

            // ===============================
            // PERMISOS REALES DEL PADRE
            // ===============================
            $table->boolean('ver_calificaciones')->default(false);
            $table->boolean('ver_asistencias')->default(false);
            $table->boolean('ver_comportamiento')->default(false);
            $table->boolean('ver_tareas')->default(false);
            $table->boolean('descargar_boletas')->default(false);
            $table->boolean('recibir_notificaciones')->default(false);
            $table->boolean('comunicarse_profesores')->default(false);
            $table->boolean('autorizar_salidas')->default(false);
            $table->boolean('subir_documentos_matricula')->default(false);

            // Notas u observaciones extra
            $table->text('notas_adicionales')->nullable();

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('padre_id')
                ->references('id')->on('padres')
                ->onDelete('cascade');

            $table->foreign('estudiante_id')
                ->references('id')->on('estudiantes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('padre_permisos');
    }
};
