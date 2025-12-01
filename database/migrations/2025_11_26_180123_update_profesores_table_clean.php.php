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
        Schema::table('profesores', function (Blueprint $table) {

            // Agregar columnas si NO existen
            if (!Schema::hasColumn('profesores', 'genero')) {
                $table->string('genero')->nullable()->after('fecha_nacimiento');
            }

            if (!Schema::hasColumn('profesores', 'nivel_academico')) {
                $table->enum('nivel_academico', ['bachillerato','licenciatura','maestria','doctorado'])
                      ->nullable()
                      ->after('especialidad');
            }

            if (!Schema::hasColumn('profesores', 'fecha_contratacion')) {
                $table->date('fecha_contratacion')->nullable()->after('nivel_academico');
            }

            // Solo renombrar fecha_ingreso si existe y fecha_contratacion NO existe
            if (Schema::hasColumn('profesores', 'fecha_ingreso') && !Schema::hasColumn('profesores', 'fecha_contratacion')) {
                $table->renameColumn('fecha_ingreso', 'fecha_contratacion');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profesores', function (Blueprint $table) {

            if (Schema::hasColumn('profesores', 'genero')) {
                $table->dropColumn('genero');
            }

            if (Schema::hasColumn('profesores', 'nivel_academico')) {
                $table->dropColumn('nivel_academico');
            }

            // Solo renombrar de vuelta si fecha_ingreso NO existe y fecha_contratacion sí
            if (Schema::hasColumn('profesores', 'fecha_contratacion') && !Schema::hasColumn('profesores', 'fecha_ingreso')) {
                 $table->renameColumn('fecha_contratacion', 'fecha_ingreso');
            }
            });
    }
};
